<?php

namespace LaRouxOf;

use PDO;

abstract class baseWebpage implements iWebpage, iOutput
{
	abstract protected function getContent(): string;

	protected ?PDO $connection = null;
	private ?InternalException $error = null;
	private ?string $_title = null;
	private ?string $_link = null;
	private array $_nav = [];
	private ?string $_category = null;
	private ?bool $_dynamic = null;
	private ?string $_content = null;
	private ?object $_navigation = null;

	public function render(): void
	{
		try {
			$this->_title = $this->getTitle();
			$this->_link = $this->getLink();
			$this->_category = $this->getCategory();
			$this->_dynamic = $this->isDynamicLoadable();
			$this->_content = $this->getContent();
			if($this->connection === null) throw new InternalException(InternalException::I_UNKNOWN, 'Database connection not set.');
			$nav = new Navigation($this->connection);
			$this->_nav = $nav->getNavigation();
		}
		catch(InternalException $e)
		{
			$this->error = $e;
		}
	}

	final public function output(): void
	{
		if($this->error === null) $this->outputPage();
		else $this->outputError();
	}

	private function outputError(): void
	{
		echo 'ERROR<br/>';
		echo $this->error->getMessage();
		return;
	}

	private function outputPage(): void
	{
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content="online shop for bags, shoes and clothes">
<meta name="keywords" content="bags, shoes, clothes">
<meta name="author" content="Martijn Goedhart">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="/scripts/js/jquery-3.5.1.js"></script>
<script src="/scripts/js/main.js"></script>
<script>
var page_link = '<?php echo $this->_link ?>';
</script>
<link rel="stylesheet" href="/styles/main.css">
<title>La Roux Of - <?php echo $this->_title; ?></title>
</head>
<body>
<header>
<h1>Welcome to La Roux Of</h1>
</header>
<nav>
<?php
foreach($this->_nav as $nav)
{
	if($nav->getLink() == $this->_link)
	{
		echo "<h4 class=\"current\"><a href=\"" . $nav->getLink() . "\">" . $nav->getTitle() . "</a></h4>";
	}
	else
	{
		echo "<h4><a href=\"" . $nav->getLink() . "\">" . $nav->getTitle() . "</a></h4>";
	}
}
?>
</nav>
<section class="<?php echo $this->_category; ?>">
<h2><?php echo $this->_title; ?></h2>
<?php
echo $this->_content;
if($this->_dynamic)
{
	echo "<div class=\"button\"><p>load more</p></div>";
}
?>
</section>
<aside>
</aside>
<footer>
<p>Webdesign copyright &copy; 2020 La Roux Of</p>
</footer>
</body>
</html>
<?php
		return;
	}
}

?>