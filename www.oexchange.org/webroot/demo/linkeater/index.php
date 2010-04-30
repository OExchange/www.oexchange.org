<?php

$page_title = "LinkEater OExchange Demo Target";
require_once("../../header-subdemo.php");
?>
    <div class="banner-linkeater"></div>
	<p>
		LinkEater is a simple example of a service that accepts links via OExchange.    
	</p>
	<ul>
		<li>Links are accepted via <a href="offer.php?url=http://www.willmeyer.com">the Offer endpoint</a></li>
		<li>The metadata for this Target is in <a href="oexchange.xrd">it&apos;s XRD document</a>, which can also be obtained via <a href="../../../.well-known/host-meta">&lt;host&gt;.well-known/host-meta</a></li>
	</ul>
	</p>
	<p>
		Have fun...
	</p>
    <br/>
	
<?
	require_once("../../footer.php");
?>
