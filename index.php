<?php

// We do not want anything to be sent to the client except a valid JSON response so buffer all output.
ob_start("ob_gzhandler");

// Enable autoloading of classes.
function my_autoloader($class) {
    include 'classes/' . $class . '.php';
}
spl_autoload_register('my_autoloader');

$uri = Functions::splitCall($_SERVER['REQUEST_URI']);
$default_uri = "/Page/Welcome";
if($uri == "") $uri = $default_uri;

function load_class(string $link)
{
    $path = Functions::splitCall($link);
    if(count($path) < 2) throw new Exception("URI must at least contain 2 elements.");
    $class = $path[0];
    $class_link = implode('/', array_slice($path, 1));
    if(!class_exists($class)) throw new Exception("Class `" . $class . "` can not be found.");
    $ifaces = class_implements($class);
    if(!isset($ifaces['iWebpage'])) throw new Exception("Class `" . $class . "` does not implement the iWebpage interface.");
    $obj = $class::loadByUI($class_link);
    if(!is_object($obj) || !is_a($obj, $class)) throw new Exception($class . "::loadByUI() did not return an instance of `" . $class . "`.");
    return $obj;
}
$page = load_class($uri);

$navigation = new Navigation();

ob_clean();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content="online shop for bags, shoes and clothes">
<meta name="keywords" content="bags, shoes, clothes">
<meta name="author" content="Martijn Goedhart">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="scripts/js/jquery-3.5.1.js"></script>
<script src="scripts/js/main.js"></script>
<link rel="stylesheet" href="styles/main.css">
<title>La Roux Of - <?php echo $page->getTitle(); ?></title>
</head>
<body>
<header>
<h1>Welcome to La Roux Of</h1>
</header>
<nav>
<?php
foreach($navigation-getNavigation() as $nav)
{
	if($nav->getLink() == $page->getLink())
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
<section class="<?php echo $page->getCategory(); ?>">
<h2><?php echo $page->getTitle(); ?></h2>
<?php
echo $page->toHTML();
if($page->isDynamicLoadable())
{
	echo"<div class=\"button\"><p>load more</p></div>";
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
ob_end_flush();
?>
