<?php
$page_title = "OExchange Send-To Example";
$nav = "demo";
require_once("../../header.php");
?>

    <h2 class="pagetitle">OExchange Send-To</h2>
    <div class="bannertext">
        <a href="sendto.php?url=http://www.oexchange.org">OExchange Send-To</a> is a simple web-based example that uses <a href="http://www.oexchange.org">OExchange</a> to enable "send to" operations for a link.
    </div>

    <hr/>
    
	<p>
		The <a href="sendto.php?url=http://www.oexchange.org">sendto.php</a> endpoint is a regular <a href="http://www.oexchange.org/spec/#offer-endpoint">OExchange-Offer</a> endpoint, to which you can pass a <code>URL</code> parameter to send an URL to a service.
	</p>
	
	<h3>What it Does</h3>
	<ul>
		<li>Hit it normally to present some basic sharing options</li>
		<li>Enter a URL or host name to automatically share content to a service that the demo doesn't already know about</li>
		<li>Enter your email address and automatically see the sharing options you prefer</li>
		<li>Enter a TO email address to determine a set of services common to you as well as another user</li>
	</ul>
	
	<h3>How it Actually Works</h3>
		
	<h5>Entering Service URLs</h5> 
	<p>
		You can enter any URL or hostname, and the service will try to figure out if it can share a link to that host, using the <a href="http://www.oexchange.org/spec/#discovery-host">OExchange Host Discovery</a> flow.  
		If you enter an URL, it will also try to look up an <a href="http://www-local.oexchange.org/spec/#discovery-targetxrd">OExchange XRD</a> document at that URL.  
		If it can't find one, or if you just enter a host, it will try to look for the host's host-meta XRD and locate OExchange endpoints from there.  
	</p>
	<p>
		If the tool determines that the entered service supports OExchange, it will let you send the link to it.
	</p>
	<p>
		For example, www.oexchange.org supports OExchange Discovery for its demo target, LinkEater.  You can use www.oexchange.org to test the discovery flow.
	</p>

	<h5>Entering Email Addresses</h5> 
	<p>
		You can enter your email address and the tool will use WebFinger to look up a personal XRD.  
		If that XRD has preferred OExchange services listed in it, it will show you those options first.  This is the <a href="http://www.oexchange.org/spec/#discovery-personal">OExchange Personal Discovery</a> flow.
	</p>
	<p>
		For an example of email addresses that support OExchange preferred service discovery via WebFinger, take a look at <a href="http://webfingerclient-dclinton.appspot.com/lookup?identifier=will%40willmeyer.com&format=web">Will's</a>. 
	</p>
	
	<h5>Entering TO email addresses</h5> 
	<p>
		You can enter comma-separated TO email addresses and the tool will use WebFinger to look up services that you and those other users use in common, and suggest those for sharing.
	</p>
	
<?
require_once("../../footer.php");
?>
