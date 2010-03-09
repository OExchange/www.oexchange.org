<?
$url = $_GET["url"];
$ctype = $_GET["ctype"];
$title = $_GET["title"];
$description = $_GET["description"];

require_once("../../lib-oexchange/OExchangeDiscoverer.php");
require_once("../../header.php");

if (!isset($url)) {
	error("Missing URL (the only required parameter).");
} else {
?>
<h2>Hey, thanks for that!</h2>
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

} else if ($ctype == 'flash') {
	echo "swfurl: " . (isset($_GET["swfurl"]) ? $_GET["swfurl"] : "-not provided-") . "<br/>";

} else if ($ctype == 'iframe') {
	echo "iframeurl: " . (isset($_GET["iframeurl"]) ? $_GET["iframeurl"] : "-not provided-") . "<br/>";
}
echo "</p>";
?>
<h3>WTF?</h3>
<p>
	This is just an example <a href="http://www.oexchange.org/spec">Target</a> site, to which you can send a link.  You didn't expect me to do anything useful with it, did you?   
</p>	

<?
	include("../../footer.php");
}

function error($msg) {
	echo "<p>Sorry, something wasn't right.</p>";
	echo $msg;
}
?>