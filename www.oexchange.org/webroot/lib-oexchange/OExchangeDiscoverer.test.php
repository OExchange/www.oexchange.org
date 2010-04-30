<?php

require_once("OExchangeDiscoverer.php");

$oex = new OExchangeDiscoverer();

echo "<h2>getTargetInfoFromXrd</h2>";
$target = $oex->getTargetInfoFromXrd("http://www.oexchange.org/demo/linkeater/oexchange.xrd");
printTarget($target);

echo "<h2>getTargetsOnHost</h2>";
$results = $oex->getTargetsOnHost("www.oexchange.org");
printTargetsAndXrdUrls($results);

echo "<h2>getTargetsForUser</h2>";
$targets = $oex->getTargetsForUser("will@willmeyer.com");
printTargets($targets);

function printTargets($targets) {
	foreach($targets as $target) {
		printTarget($target);
	}
}

function printTargetsAndXrdUrls($results) {
	foreach($results as $result) {
		echo "&nbsp;&nbsp;XRD: " . htmlspecialchars($result["xrd"]) . "<br/>";
		printTarget($result["target"]);
	}
}

function printTarget($target) {
	echo "&nbsp;&nbsp;ID: " . htmlspecialchars($target->id) . "<br/>";
	echo "&nbsp;&nbsp;Name: " . htmlspecialchars($target->name) . "<br/>";
	echo "&nbsp;&nbsp;Prompt: " . $target->prompt . "<br/>";
	echo "&nbsp;&nbsp;Title: " . htmlspecialchars($target->title) . "<br/>";
	echo "&nbsp;&nbsp;Endpoint: " . htmlspecialchars($target->endpoint) . "<br/>";
	echo "&nbsp;&nbsp;Vendor: " . htmlspecialchars($target->vendor) . "<br/>";
	echo "&nbsp;&nbsp;Icon: " . htmlspecialchars($target->icon) . "<br/>";
}

?>