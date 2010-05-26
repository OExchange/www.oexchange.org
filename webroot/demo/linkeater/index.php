<?php

if (isset($_GET["demo"])) $demo = $_GET["demo"];
else $demo = false;

$page_title = "LinkEater: An Example OExchange Target";
require_once("../../pagetop-demo.inc.php");
?>
    <script type="text/javascript" src="/tools/badge/jquery.oexchange.js"></script>
    <script type="text/javascript">
    $(document).ready(
        function() {
            $('.oexchange-sharepoint').oexchange_save();
        }
    );
    </script>
    <div style="position:relative;margin-top:-25px;">
        <div style="padding-bottom: 30px;">
            <div class="grid_2 alpha">
                <h3 style="padding:7px 0;margin:0;line-height:32px;font-weight:normal;color:#dd00fb;">Linkeater</h3>
            </div>
            <div class="grid_10 omega right gry">
                <div style="padding:15px 0 0;">Home <span class="pipe">|</span> Interesting <span class="pipe">|</span> Most Recent <span class="pipe">|</span> Community <span class="pipe">|</span> Profile <span class="pipe">|</span> Sign-out</div>
            </div>
            <div class="clear"></div>
        </div>
        
        <div class="banner-linkeater"></div>
	    <div class="grid_8 suffix_1 alpha">
            <p>
        		Linkeater is a service that can accept URLs via OExchange.  It doesn't do much with them, but hey, its just an example.  Imagine its a social network, a news submission service, a translation tool, whatever.      
        	</p>	
          
        	<h3>Sending Links to Linkeater</h3>
        	<p>
        		It can accept links at a standard <a href="/spec/#offer">Offer</a> endpoint:
        	</p>
        	<pre>http://www.oexchange.org/demo/linkeater/offer.php</pre>	
        	<p style="padding:10px 0 30px 0;">
        		<a class="oexchange-btn" href="offer.php?url=http://www.example.com" title="Send it a URL!">Send it a URL!</a>.
        	</p>	     
        	<h3>Discovering LinkEater</h3>
        	<p>
        		Any tool that can perform <a href="/spec/#discovery">Discovery</a> can figure out how to send content to LinkEater:
        		<ul>
        			<li>There's a <a href="oexchange.xrd">Target XRD document</a>, which describes the service</li>
        			<li>OExchange.org has a <a href="/.well-known/host-meta">/.well-known/host-meta</a>, so LinkEater is discoverable from there</li>
        			<li>All the pages on OExchange.org also have a meta tag that identifies the service</li> 
        		</ul>
				You can see whats discoverable from the <a href="/tools/discoveryharness/?h=www.oexchange.org&x=http%3A%2F%2Fwww.oexchange.org%2Fdemo%2Flinkeater%2Foexchange.xrd&cmd=hm">Discovery Harness</a>, too.
        	</p>
        </div>
        
<? 
	if ($demo) {
?>	
		<div class="grid_3 omega">          
		    <p style="padding:20px 0;">
		        <a class="oexchange-btn oexchange-sharepoint" href="#" onclick="return false;" title="Save this Service"><span>Save this Service</span></a>
		    </p>
		</div>
<? 
	}
?>	
		<div class="clear"></div>
<? 
	if ($demo) {
?>	
        <div id="tt1" class="tt" style="position:absolute;top:140px;right:-20px;display:none;">
            <div class="tt-x" title="Close" onclick="$('#tt1').fadeOut();"></div>
            <div class="tt-inner">
                Because LinkEater supports OExchange, it can be dynamically added as a preferred sharing service.<br/><br/>
                Add it here, then check out <a href="/demo/blog/">the blog</a> to see LinkEater as a new option!
            </div>
            <div class="tt-tick" style="left:215px;"></div>
        </div>
        <script type="text/javascript">setTimeout("$('#tt1').fadeIn();",1000)</script>
<? 
	}
?>	
    </div>
    <div style="margin-top:40px;border-top:2px solid #ccc;padding:20px 0;color:#666;">A service called "Linkeater", for demo purposes.</div>
	
