<?
$url = $_GET["url"];
$ctype = $_GET["ctype"];
$title = $_GET["title"];
$description = $_GET["description"];

$page_title = "LinkEater Example OExchange Target";
require_once("../../header-subdemo.php");
require_once("../../lib-oexchange/OExchangeDiscoverer.php");

if (!isset($url)) {
	error("Missing URL (the only required parameter).");
} else {
?>
<div class="funny-monster right"></div>

<h2>Yum!</h2>
<h3>Here's what you gave me...</h3>
<p>
URL: <?= $url?><br/>
Title: <? echo (isset($title) ? $title : "-not provided-") ?><br/>
Description: <? echo (isset($description) ? $description : "-not provided-") ?><br/>
</p>

<h4>Type-specific information:</h4>
<p>
<?
if (!isset($ctype)) {
	echo "ctype: -not provided- (defaulting to 'link')<br/>";
	$ctype = "link";
} else {	
	echo "ctype: " . $ctype . "<br/>";
} 
if ($ctype == 'link') {
	echo "tags: " . (isset($_GET["tags"]) ? $_GET["tags"] : "-not provided-") . "<br/>";
} else if ($ctype == 'image') {
	echo "imageurl: " . (isset($_GET["imageurl"]) ? $_GET["imageurl"] : "-not provided-") . "<br/>";
	echo "height: " . (isset($_GET["height"]) ? $_GET["height"] : "-not provided-") . "<br/>";
	echo "width: " . (isset($_GET["width"]) ? $_GET["width"] : "-not provided-") . "<br/>";
} else if ($ctype == 'flash') {
	echo "swfurl: " . (isset($_GET["swfurl"]) ? $_GET["swfurl"] : "-not provided-") . "<br/>";
	echo "height: " . (isset($_GET["height"]) ? $_GET["height"] : "-not provided-") . "<br/>";
	echo "width: " . (isset($_GET["width"]) ? $_GET["width"] : "-not provided-") . "<br/>";
	echo "screenshot: " . (isset($_GET["screenshot"]) ? $_GET["screenshot"] : "-not provided-") . "<br/>";

} else if ($ctype == 'iframe') {
	echo "iframeurl: " . (isset($_GET["iframeurl"]) ? $_GET["iframeurl"] : "-not provided-") . "<br/>";
	echo "height: " . (isset($_GET["height"]) ? $_GET["height"] : "-not provided-") . "<br/>";
	echo "width: " . (isset($_GET["width"]) ? $_GET["width"] : "-not provided-") . "<br/>";
	echo "screenshot: " . (isset($_GET["screenshot"]) ? $_GET["screenshot"] : "-not provided-") . "<br/>";
}
echo "</p>";
?>

<br/>

<h3>WTF?</h3>
<p>
	This is a simple example OExchange Target, to which you can send a link.  You didn't expect me to do anything useful with it, did you?  [<a href="/demo/linkeater">back to LinkEater</a>]   
</p>	

<?
	include("../../footer.php");
}

function error($msg) {
	echo "<p>Sorry, something wasn't right.</p>";
	echo $msg;
}
?>