<?php

$page_title = "LinkEater Example OExchange Target";
require_once("../../header.php");
?>
	<h2>LinkEater</h2>
	<p>
		LinkEater is a simple example service that accepts links via OExchange.  
	</p>
	<ul>
		<li>Links are accepted via <a href="offer.php?url=http://www.willmeyer.com">the Offer endpoint</a></li>
		<li>The metadata for this Target is in <a href="oexchange.xrd">it&apos;s XRD document</a>, which can also be obtained via <a href="../../../.well-known/host-meta">.well-known/host-meta</li>
	</p>
	
<?
	require_once("../../footer.php");
?>
