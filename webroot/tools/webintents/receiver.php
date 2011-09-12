<?

$page_title = "OExchange Discovery Test Harness";
$nav = "tools";
include '../../pagetop-main.inc.php';
include '../../lib-oexchange/OExchangeDiscoverer.php';
include_once '../../lib-oexchange/utils.php';

?>

	<script src="http://examples.webintents.org/lib/webintents.js"></script>
    
    <h2 class="pagetitle">WebIntents Service</h2>
    <div class="bannertext">
        A service that can accept a Share <a href="http://www.webintents.org">Web Intent</a>
    </div>

    <hr/>
    
	<p>
		This is a service that registers its support for the <a href="http://webintents.org/share">WebIntents Share intent</a>, and can hand off to OExchange services.
	</p>

	<p>
		When the page is loaded the browser (actually the JS lib from the WebIntents effort in this case) registers it.
	</p>

	<p>
		Use the <a href="sender.php">link sender</a> to see it handle a share.
	</p>

	<intent 
		action="http://webintents.org/share" 
		type="text/uri-list" 
		href="receiver-handler.php" 
		disposition="window"
		title="LinkEater (via OExchange proxy)" />

<?
include '../../pagebottom.inc.php';
?>
