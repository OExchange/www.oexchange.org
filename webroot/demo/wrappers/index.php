<?php
$page_title = "OExchange Demo Wrappers";
$nav = "demo";
require_once("../../pagetop-main.inc.php");
?>

    <h2 class="pagetitle">OExchange Demo Wrappers</h2>
    <div class="bannertext">
        Example wrappers for popular services
    </div>

    <hr/>
    
	<p>
		To show how simple it is to become a fully discoverable OExchange host, and how many services already have Offer-compatible endpoints, here are a few simple demo sites that wrap popular services with a discovery compatibility layer.  
	</p>
    <p>
        <em>These aren't for production use, just demo purposes.</em>.
    </p>
    
    <br/>
	
    <div class="grid_2 alpha center"><a target="_blank" href="http://oexchange-twitter.appspot.com">Twitter<br/><img src="<?= $CFG_IMAGEBASE_URL ?>/twitter_138x104.jpg" border="0" alt="Twitter" class="thumb" /></a></div>
    <div class="grid_2 center"><a target="_blank" href="http://oexchange-facebook.appspot.com">Facebook<br/><img src="<?= $CFG_IMAGEBASE_URL ?>/facebook_138x104.jpg" border="0" alt="Facebook" class="thumb" /></a></div>
    <div class="grid_2 center"><a target="_blank" href="http://oexchange-digg.appspot.com">Digg<br/><img src="<?= $CFG_IMAGEBASE_URL ?>/digg_138x104.jpg" border="0" alt="Digg" class="thumb" /></a></div>
    <div class="grid_2 center"><a target="_blank" href="http://oexchange-delicious.appspot.com">Delicious<br/><img src="<?= $CFG_IMAGEBASE_URL ?>/delicious_138x104.jpg" border="0" alt="Delicious" class="thumb" /></a></div>
    <div class="grid_2 omega center"><a target="_blank" href="http://oexchange-buzz.appspot.com">Google Buzz<br/><img src="<?= $CFG_IMAGEBASE_URL ?>/buzz_138x104.jpg" border="0" alt="Google Buzz" class="thumb" /></a></div>
    
    <div class="clear"></div>
	
<?
require_once("../../pagebottom.inc.php");
?>
