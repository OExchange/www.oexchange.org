<?php

$page_title = "SuperSendTo Example OExchange Browser Extension";
require_once("../../header.php");
?>
    <h2 class="pagetitle mb10">SuperSendTo</h2>
    <div class="bannertext">
        SuperSendTo is a FireFox browser extension that uses OExchange to enable you to send links to any OExchange service on the web.  
    </div>
    
    <hr/>
        
	<p>
		<b>NOTE</b>: This is a functional extension, though its designed as a technology demo for power users familiar with the goals of OExchange.  Caveats apply -- I wouldn't recommend using this in your primary user profile.
	</p>	
	<p style="padding:20px 0;"><a class="btn" href="oeff-0.8-ff.xpi">Download It Here</a></p>
    <p><em>(If you had a previous version installed...please uninstall it, restart Firefox, clear your cache, then download the latest version)</em></p>
    
    <hr/>
    
	<h3>Things to Try</h3>
    <ul>
        <li>By default, it'll come configured with a few popular services on the web (using demo servers that fully support OExchange on behalf of the live services in question).  You can send content to them from the OExchange logo in the URL bar, the context menu, or the tools menu.</li>
        <li>Browse to some page on www.oexchange.org.  If you have been there several times before, you'll get a proactive prompt to add the LinkEater service thats hosted there.  If you haven't been there before, you can add the service from OExchange logo in the URL bar.  Whenever the extension detects that the site you are on can support links, it will present you with this option.</li>
        <li>You can also enter hostnames directly.  From the Options page (accessible from the tools menu, the context menu, or the URL bar button), enter http://oexchange-delicious.appspot.com.  The extension will automatically determine that that host can accept links, and you can add it as a SendTo option.</li>
        <li>If your webfingerable email address is set up with preferred services, you can enter that as well.</li>
    </ul>
	
    <hr/>
    
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
	<p>
		You can also request that the plugin look for services on the current page, through the URL bar icon.  The service must support OExchange-Discovery for this to work, but it doesn't need to have its pages tagged.
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
