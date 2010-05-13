<?

$page_title = "OExchange Discovery Test Harness";
$nav = "tools";
include '../../header.php';
include '../../lib-oexchange/OExchangeDiscoverer.php';
include_once '../../lib-oexchange/utils.php';

function printTarget($target) {
	echo "&nbsp;&nbsp;<b>ID/URL:</b> " . htmlspecialchars($target->id) . "<br/>";
	echo "&nbsp;&nbsp;<b>Name:</b> " . htmlspecialchars($target->name) . "<br/>";
	echo "&nbsp;&nbsp;<b>Prompt:</b> " . $target->prompt . "<br/>";
	echo "&nbsp;&nbsp;<b>Title:</b> " . htmlspecialchars($target->title) . "<br/>";
	echo "&nbsp;&nbsp;<b>Endpoint:</b> " . htmlspecialchars($target->endpoint) . "<br/>";
	echo "&nbsp;&nbsp;<b>Vendor:</b> " . htmlspecialchars($target->vendor) . "<br/>";
	echo "&nbsp;&nbsp;<b>Icon:</b> " . htmlspecialchars($target->icon) . "<br/>";
	echo "&nbsp;&nbsp;<b>Icon32:</b> " . htmlspecialchars($target->icon32) . "<br/>";
	echo "<br/>";
	echo "&nbsp;&nbsp;<img src=\"" . htmlspecialchars($target->icon) . "\"/>";
	echo "&nbsp;&nbsp;<img src=\"" . htmlspecialchars($target->icon32) . "\"/>";
	echo "<br/>";
}

$hostname = getDfltArg("h", "www.oexchange.org");
$xrdUrl = getDfltArg("x", "http://www.oexchange.org/demo/linkeater/oexchange.xrd");
$cmd = getDfltArg("cmd", "none");	

?>
    
    <h2 class="pagetitle mb10">Discovery Test Harness</h2>
    <div class="bannertext">
        Test a service for <a href="/spec/#discovery">OExchange Discovery</a> compliance
    </div>
    
    <hr/>
    
	<p>
		<i>If you need help setting up discovery support, check the <a href="/guide/#services">Quick Start Guide</a> or the <a href="/tools/discoverygen">Discovery File Generator</a>.  If you want to test Offer support instead, use <a href="/tools/sourceharness">this tool</a>.</i>
	</p>

	<h3>Host Discovery</h2>
	<p>
		Does a host have <a target="_blank" href="/spec/#discovery-host">host-meta discovery</a> set up so, that anyone can locate the service on that host automatically?
	</p>
	<p>
	<form action="/tools/discoveryharness/" method="POST">
		Hostname (e.g. www.example.com):&nbsp;<input name="h" type="text" size="60" value="<?= $hostname ?>" />
		<input name="cmd" type="hidden" value="hm" />
		<input type="submit" value="Check Host" />
	</form>
	</p>
	<br/>
<?
	if ($cmd == "hm") {
		?>
		<h5>Discovery Results:</h5>
		<?	
		$disc = new OExchangeDiscoverer();
		$targetXrdUrls = $disc->getTargetXrdUrlsOnHost($hostname);
		if (sizeof($targetXrdUrls) == 0) {
			?>
			<p>
				No target XRD URLs were found.  Are you sure there is a resource at <a href="<?= $hostname?>/.well-known/host-meta"><?= $hostname?>/.well-known/host-meta</a> with at least one <code>resident-target</code> relation?  
			</p>
			<p>
				If you need help generating one, try <a href="/tools/discoverygen">this tool</a>. 
			</p>
			<?	
		} else {
			?>
			<p>
				We DID locate http://<?= $hostname?>/.well-known/host-meta, here's what was in it:	
			</p>
			<?	
			
			foreach($targetXrdUrls as $targetXrdUrl) {
				?>
				<p>
				<b>Referenced Target XRD:</b> <?= $targetXrdUrl ?>
				</p>
				<p>
					&nbsp;&nbsp;Target details (from inspecting this XRD):
				</p>
				<?	
				$target = $disc->getTargetInfoFromXrd($targetXrdUrl);
				if (isset($target)) {
					?>
					<p>
					<?
					printTarget($target);
					?>
					</p>
					<p>
					Want to use the test harness to check sending links to this Target?  <a href="/tools/sourceharness/?target=<?=$target->endpoint ?>">Go there now</a>.	
					</p>
					<?
				} else {
					?>
					<p>
						ERROR looking up details; the target XRD was not found or not valid.  If you need help generating one, try <a href="/tools/discoverygen">this tool</a>.
					</p>
					<?
				}
			}
		}
	}

?>
    
    <hr/>

	<h3>Target XRD Inspection</h2>
	<p>
		Inspect a <a target="_blank" href="/spec/#discovery-targetxrd">Target XRD</a> directly.
	</p>
	<p>
	<form action="/tools/discoveryharness/" method="POST">
		Target XRD (e.g. http://www.example.com/oexchange.xrd):&nbsp;<input name="x" type="text" size="60" value="<?= $xrdUrl ?>" />
		<input name="cmd" type="hidden" value="txrd" />
		<p><input type="submit" value="Check Target XRD" /></p>
	</form>
	</p>
	<br/>
<?
	if ($cmd == "txrd") {
		?>
		<h5>XRD Lookup Results:</h5>
		<?	
		$disc = new OExchangeDiscoverer();
		$target = $disc->getTargetInfoFromXrd($xrdUrl);
		if (isset($target)) {
			?>
			<p>
			<?	
			printTarget($target);
			?>
			<p>
			<?	
		} else {
			?>
			<p>
				<b>ERROR</b> looking up details; the target XRD was not found or not valid.  If you need help generating one, try <a href="/tools/discoverygen">this tool</a>.
			</p>
			<?
		}
	}
?>




<?
include '../../footer.php';
?>
