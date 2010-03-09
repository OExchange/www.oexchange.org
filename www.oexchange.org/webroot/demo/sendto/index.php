<?php

require_once("pagestart.inc.php");
?>
	<div id="contentpage">
	<h2>OExchange Send-To</h2>
	<p>
		A <a href="sendto.php">simple service</a> that uses OExchange to enable Send-To type operations.
	</p>
	<p>
		The <a href="sendto.php">sendto.php</a> URL is a regular OExchange-Offer endpoint, to which you can pass a <code>URL</code> parameter to send an URL to a service.
	</p>
	<h5>Entering service URLs</h5> 
	<p>
		You can enter any URL or hostname, and the service will try to figure out if it can share a link to that host.  
		If you enter an URL, it tries to look up an OExchange XRD document at that URL.  
		If it can't find one, or if you just enter a host, it will try to look for the host's host-meta XRD and locate OExchange endpoints from there.
	</p>
	<p>
		If the tool determines that the entered service supports OExchange, it will let you send the link to it.
	</p>
	<h5>Entering your email address</h5> 
	<p>
		You can enter an email address and the tool will use WebFinger to look up a personal XRD.  
		If that XRD has preferred OExchange services listed in it, it will show you those options first.
	</p>
	
	<h5>Entering TO email addresses</h5> 
	<p>
		You can enter comma-separated TO email addresses and the tool will use WebFinger to look up services that you and those other users use in common, and suggest those for sharing.
	</p>
	
	</div>	
<?
require_once("footer.inc.php");
require_once("pageend.inc.php");
?>
