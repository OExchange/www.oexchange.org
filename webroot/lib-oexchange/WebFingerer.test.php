<?

require_once("WebFingerer.php");

$wf = new Webfingerer();

echo "<h2>getUserXrdUrl</h2>";
echo "will@willmeyer.com<br/>";
echo $wf->getUserXrdUrl("will@willmeyer.com") . "<br/><br/>";
echo "charlie@ecece.com<br/>";
echo $wf->getUserXrdUrl("charlie@ecece.com") . "<br/><br/>";
echo "willmeyer@gmail.com<br/>";
echo $wf->getUserXrdUrl("willmeyer@gmail.com") . "<br/><br/>";

echo "<h2>getUserLinks</h2>";
echo "will@willmeyer.com<br/>";
echo "<br/>" . printLinks($wf->getUserLinks("will@willmeyer.com")) . "<br/>";
echo "charlie@ecece.com<br/>";
echo "<br/>" . printLinks($wf->getUserLinks("charlie@ecece.com")) . "<br/>";
echo "willmeyer@gmail.com<br/>";
echo "<br/>" . printLinks($wf->getUserLinks("willmeyer@gmail.com")) . "<br/>";


function printLinks($links) {
	foreach($links as $link) {
		echo "&nbsp;&nbsp;Link: <br/>";
		foreach($link as $name => $val) {
			echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $name . ": " . $val . "<br/>";
		}
	}
}

?>