<?php
$page_title = "OExchange and Web Intents";
$nav = "tools";
include '../../pagetop-main.inc.php';
?>
	<h2>OExchange and Web Intents</h2>

	<p>
		<a target="_blank" href="http://webintents.org">Web Intents</a> is an open specification being developed by several in the user-agent community with support from us.  From the webintents.org site:
	</p>
	<p><i>	
		 "Web Intents is a framework for client-side service discovery and inter-application communication. Services register their intention to be able to handle an action on the user's behalf. Applications request to start an Action of a certain verb (share, edit, view, pick etc.) and the system will find the appropriate Services for the user to use based on the user's preference". 
	</i></p>
	
	<h3>How do they fit together?</h3>
	
	<p>
		There is not direct specification-level interoperability, as Web Intents and OExchange tackle somewhat different problems in very different ways (Web Intents would be a browser/js-based solution, and includes additional actions and strong typing).  An interop guide will be included here as the Web Intents spec develops.
	</p>
	<p>	  
		However, OExchange services can easily be front-ended with Web Intents support.  The following concept tools demonstrate this.
	</p>
		
    <div class="grid_5 alpha">
        <h3 class="bigger mb5"><a href="proxy-registrar.php">OExchange Proxy Registrar</a></h3>
        <p>
			A registration service that can register any OExchange Target to handle Share Intents, via a proxy.  
		</p>
    </div>
    <div class="grid_5 omega">
        <h3 class="bigger mb5"><a href="initiator.php">Share Intent Harness</a></h3>
        <p>
        Allows you to initiate Share Intents, which you can then watch be handled by any registered services.
        </p>
    </div>
    <div class="clear"></div>
    
    <br/>


<?php
include '../../pagebottom.inc.php';
?>
