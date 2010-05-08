<?php

$page_title = "SuperSendTo Example OExchange Browser Extension";
require_once("../../header.php");
?>
	<h2>SuperSendTo</h2>
	<p>
		SuperSendTo is a FireFox browser extension that uses OExchange to enable you to send links to any OExchange service on the web.  
	</p>
	<p>
		<b>NOTE</b>: This is a functional extension, though its designed as a technology demo for power users familiar with the goals of OExchange.  Caveats apply.
	</p>	
	<ul>
		<li>It enables context menu, tools menu, and url-bar controls for sending the current page to any configured service</li>
		<li>It locates and automatically enables services as you browse the web</li>
	</ul>	
	<p>
		<a href="oeff-0.8-ff.xpi">Download It Here</a>
	</p>
	
	<h3>The Details</h3>

	<a name="normal"></a>
	<h4>Adding Services as you Browse</h4>
	<p>
		The extension monitors the pages you visit for the OExchange Discovery page tags, and triggers automatically adding discovered services in the background.  
		This means the services that will appear in the menus are the services you already visit, whether or not the tool knows about them beforehand.  This uses the <a href="/spec/#discovery-page">OExchange Page Discovery</a> protocol. 
	</p>
	<p>
		For example, all of the pages on OExchange.org are tagged with the LinkEater sample Target, in something like this:
		<pre>&lt;link 
   rel="http://oexchange.org/spec/0.8/rel/related-target"
   type="application/xrd+xml" href="http://www.oexchange.org/demo/linkeater/oexchange.xrd"/&gt;</pre> 
	</p>

	<a name="add-service"></a>
	<h4>Adding Services by URL</h4>
	<p>
		From the Options pane, you can add any OExchange-compatible service to SuperSendTo by entering the hostname of the service.  For example, enter <code>http://www.oexchange.org</code> to discover and add the LinkEater service.  The host must implement the <a href="/spec/#discovery-host">OExchange Host Discovery</a> protocol in order to be located.   
	</p>

	<a name="personalize"></a>
	<h4>Looking Up Personalized Services</h4>
	<p>
		From the Options pane, you can look up any preferred services you already use, as long as you have enabled them in your WebFinger profile.  
		Just provide your email address, and the tool will look them up.  This uses the <a href="/spec/#discovery-personal">OExchange Personal Discovery</a> protocol, looking for preferred services in your personal XRD, located via WebFinger.   
	</p>
	
<?
	require_once("../../footer.php");
?>
