<?

$page_title = "OExchange Web Intents Link Sharing Harness";
$nav = "tools";
include '../../pagetop-main.inc.php';
include '../../lib-oexchange/OExchangeDiscoverer.php';
include_once '../../lib-oexchange/utils.php';

?>

	<script src="http://webintents.org/webintents.js"></script>
	<script src = "/lib/utils.js" > </script>
    
    <h2 class="pagetitle">WebIntents Link-Sharing Harness</h2>
    <div class="bannertext">
        A tool that initiates <a href="http://webintents.org/share">Share</a> intents
    </div>

    <hr/>
    
	<p>
		Go ahead, initiate a <a href="http://webintents.org/share">Share activity</a> to send a link to a service.
	</p>

	<p>
		As long as you have some <a href="proxy-registrar.php">registered</a> services (intent handlers), you should see a share occur.  
	</p>
	<p>
		<a href="/tools/webintents">Confused?</a>
	</p>

	<script>
		attachEventListener(window, "load", function() {
		    var shareLink = document.getElementById("shareLink");
		    attachEventListener(shareLink, "click", function() {
				var url = document.getElementById("url").value;
		        var intent = new Intent();
		        intent.action = "http://webintents.org/share";
		        intent.type = "text/uri-list";
		        intent.data = [url];
		        window.navigator.startActivity(intent);
		        return false;
		    },
		    false);
		});
	</script>

    <input size="50" id="url" name="url" type="url" value="http://www.oexchange.org" /> 
    <button id="shareLink" >Share a URL</button >

<?
include '../../pagebottom.inc.php';
?>