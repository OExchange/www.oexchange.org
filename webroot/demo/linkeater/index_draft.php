<?php

$page_title = "LinkEater, An Example OExchange Target";
require_once("../../header-subdemo.php");
?>
    <div style="position:relative;">
        <div class="banner-linkeater"></div>
	    <div class="grid_8 suffix_1 alpha">
            <p>
        		LinkEater is a simple example of a service that accepts URLs via OExchange.  It doesn't do much with them, but hey, you get the idea.  Imagine its a social network, a news submission service, a translation tool, whatever.      
        	</p>
          
        	<h4>Sending Links to LinkEater</h4>
        	<p>
        		Links are accepted via a standard OExchange Offer endpoint, at:
        	</p>
        	<pre>http://www.oexchange.org/demo/linkeater/offer.php</pre>	
        	<p>
        		Try <a href="offer.php?url=http://www.example.com">sending it a URL</a>.
        	</p>	
        	<h4>Automatic Discovery</h4>
        	<p>
        		LinkEater is fully discoverable; any tool that understands OExchange Discovery can figure out how to send links to LinkEater automagically.
        		<ul>
        			<li>The service has a <a href="oexchange.xrd">Target XRD document</a>, which includes all of its details</li>
        			<li>You can discover the service from just the hostname, since it also has a <a href="../../../.well-known/host-meta">/.well-known/host-meta</a> document</li>
        			<li>You can discover the service from any page on this site, because they all have related-target page meta tags</li> 
        		</ul>
        	</p>
        </div>
        <div class="grid_3 omega">          
            <p style="padding:20px 0;">
                <a class="btn" style="background:#f1228e;" href="#" onclick="return false;">Save this Sharepoint</a>
            </p>
        </div>
        <div class="clear"></div>
        
        <div id="tt1" class="tt" style="position:absolute;top:100px;right:-20px;">
            <div class="tt-x" title="Close" onclick="$('#tt1').fadeOut();"></div>
            <div class="tt-inner">
                Because LinkEater supports OExchange, it can be saved as a favorite way to share.<br/><br/>
                Then, when a user encounters OExchange-enabled sharing elsewhere, <a href="/demo/blog">such as on a blog</a>, LinkEater will be presented as a personalized option.
            </div>
            <div class="tt-tick" style="left:205px;"></div>
        </div>
    </div>
	
<?
	require_once("../../footer.php");
?>
