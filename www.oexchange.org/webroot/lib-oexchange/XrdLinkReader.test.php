<?

require_once("XrdLinkReader.php");

$xrd = new XrdLinkReader();
echo "<h2>http://gmail.com/.well-known/host-meta</h2>";
printLinks($xrd->getLinksFromUrl("http://gmail.com/.well-known/host-meta"));
echo "<h2>http://www.oexchange.org/demo/linkeater/oexchange.xrd</h2>";
printLinks($xrd->getLinksFromUrl("http://www.oexchange.org/demo/linkeater/oexchange.xrd"));
echo "<h2>http://www.willmeyer.com/.well-known/host-meta</h2>";
printLinks($xrd->getLinksFromUrl("http://www.willmeyer.com/.well-known/host-meta"));

function printLinks($links) {
	foreach($links as $link) {
		echo "&nbsp;&nbsp;Link: <br/>";
		foreach($link as $name => $val) {
			echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $name . ": " . $val . "<br/>";
		}
	}
}

?>