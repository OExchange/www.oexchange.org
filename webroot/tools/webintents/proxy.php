<?

include_once '../../lib-oexchange/utils.php';

$offerUrl = getDfltArg("offerpoint", "");

if ($offerUrl == "") {

	$page_title = "OExchange Web Intents Proxy Service";
	$nav = "tools";
	include '../../pagetop-main.inc.php';
	?>   

	<h2 class="pagetitle">WebIntents OExchange Proxy Service</h2>
	<div class="bannertext">
	    A service that handles Share <a href="http://www.webintents.org">Web Intents</a> on behalf of OExchange targets
	</div>

	<hr/>

	<p>
		You shouldn't be hitting this directly, check the <a href="index.php">Web Intents home</a> instead.
	</p>

	<?php
	// TODO add GA tracking to this page in this case
	include '../../pagebottom.inc.php';

} else {
	?>
	
	<script src="http://examples.webintents.org/lib/webintents.js"></script>
	<script src="http://examples.webintents.org/lib/events.js"></script>
	<script src="http://examples.webintents.org/lib/common.js"></script>
	<script>
    	attachEventListener(window, "load", function(e) {
			if (intent.data) {
				var url = intent.data;
				var offerUrl = "<?php echo $offerUrl; ?>?url=" + url;
				window.location.href = offerUrl;
			} else {
				alert("WTF, bad intent!");
			}
			intent.postResult("Thanks, your link has been shared!");
		});
	</script>
	<?php
	// TODO add GA tracking to this page in this case
}
?>

