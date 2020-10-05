<?php

namespace LaRouxOf;

use PDO;

class Admin implements iOutput
{
	private ?PDO $connection = null;
	private ?array $path = null;
	private ?string $call = null;
	private ?string $admin_obj = null;
	private ?string $admin_obj_name = null;
	private string $fields_json = '';

	function __construct(PDO $connection, string $call, array $path)
	{
		$this->connection = $connection;
		$this->path = $path;
		$this->call = $call;
	}

	public static function getAdminSections(): array
	{
		return array(
			'Pages' => '/Admin/Page',
			'Galleries' => '/Admin/Gallery',
			'Items' => '/Admin/Item',
			'Settings' => '/Admin/Settings',
		);
	}

	protected function getLink(): string
	{
		return '/Admin/' . $this->admin_obj_name;
	}

	public static function loadClass(PDO $connection, string $call)
	{
		// Split the URI into seperate path items and check that the call is really an API call.
		if(($path = Functions::splitCall($call)) == null) throw new InternalException(0, "wrong formatted request URI");
		if(count($path) == 0) $path[] = 'Page';
		if(count($path) > 1) throw new InternalException(InternalException::I_ARGUMENTS, "URI must at least contain 2 elements.");
		return new self($connection, $call, $path);
	}

	public function render(): void
	{
		$this->admin_obj = Functions::loadAdminClass($this->connection, $this->path[0]);
		$this->admin_obj_name = $this->admin_obj::getName();

		$def = $this->admin_obj::getAdminFields()->getDefinition();
		$this->fields_json = $this->admin_obj::getAdminFields();

		$this->js_format = "";
		$this->filter = "";

		foreach($def as $field)
		{
			$name = $field['name'];
			$type = $field['type'] & AdminDefinition::MASK_DATA_TYPE;
			$options = $field['type'] & ~AdminDefinition::MASK_OPTIONS;
		}
		$this->filter = print_r($this->admin_obj::loadEditRecords($this->connection), true);
    }

	final public function output(): void
	{
?>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="Martijn Goedhart">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/scripts/js/main.js"></script>
<script src="/scripts/js/admin.js"></script>
<link rel="stylesheet" href="/styles/main.css">
<link rel="stylesheet" href="/styles/admin.css">
<title>La Roux Of - </title>
<script>
$(document).ready(function(){
	var object = '<?php echo $this->admin_obj_name; ?>';
	var fields = <?php echo $this->fields_json; ?>;
	$("article").click(function(ev) {
		//alert("hoi");
		$("article > p.long-description").addClass("nodisplay");
		$(this).children("p.long-description").removeClass("nodisplay");
	});

	loadRecords(object);
});
</script>
</head>
<body>
<header>
<h1>Admin Section</h1>
</header>
<nav>
<?php
foreach(self::getAdminSections() as $title => $link)
{
	if($link == $this->getLink())
	{
		echo "<h4 class=\"current\"><a href=\"" . $link . "\">" . $title . "</a></h4>";
	}
	else
	{
		echo "<h4><a href=\"" . $link . "\">" . $title . "</a></h4>";
	}
}
?>
</nav>
<section>
<?php echo $this->filter; ?>
</section>
</body>
</html>
<?php
	}
}
?>