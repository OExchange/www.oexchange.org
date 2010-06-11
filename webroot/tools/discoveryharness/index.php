<?

$page_title = "OExchange Discovery Test Harness";
$nav = "tools";
include '../../pagetop-main.inc.php';
include '../../lib-oexchange/OExchangeDiscoverer.php';
include_once '../../lib-oexchange/utils.php';

function printTarget($target) {
    echo '<table class="dtbl">';
    echo '<thead><tr><th>Property</th><th>Value</th><th>&nbsp;</th></tr></thead><tbody>';
	echo "<tr><td>ID/URL:</td></td><td>" . htmlspecialchars($target->id) . "</td><td>&nbsp;</td></tr>";
	echo "<tr><td>Name:</td><td>" . htmlspecialchars($target->name) . "</td><td>&nbsp;</td></tr>";
	echo "<tr><td>Prompt:</td><td>" . $target->prompt . "</td><td>&nbsp;</td></tr>";
	echo "<tr><td>Title:</td><td>" . htmlspecialchars($target->title) . "</td><td>&nbsp;</td></tr>";
	echo "<tr><td>Endpoint:</td><td>" . htmlspecialchars($target->endpoint) . "</td><td>&nbsp;</td></tr>";
	echo "<tr><td>Vendor:</td><td>" . htmlspecialchars($target->vendor) . "</td><td>&nbsp;</td></tr>";
	echo "<tr><td>Icon:</td><td>" . htmlspecialchars($target->icon) . "</td><td><img src=\"" . htmlspecialchars($target->icon) . "\"/></td></tr>";
	echo "<tr><td>Icon32:</td><td>" . htmlspecialchars($target->icon32) . "</td><td><img src=\"" . htmlspecialchars($target->icon32) . "\"/></td></tr>";
	echo "</tbody></table>";
}

$hostname = getDfltArg("h", "www.oexchange.org");
$xrdUrl = getDfltArg("x", "http://www.oexchange.org/demo/linkeater/oexchange.xrd");
$cmd = getDfltArg("cmd", "none");	

?>
    
    <h2 class="pagetitle">Discovery Test Harness</h2>
    <div class="bannertext">
        Test a service for <a href="/spec/#discovery">OExchange Discovery</a> compliance
    </div>

    <hr/>
    
	<p>
		<i>If you need help setting up discovery support, check the <a href="/guide/#services">Quick Start Guide</a> or the <a href="/tools/discoverygen">Discovery File Generator</a>.  If you want to test Offer support instead, use <a href="/tools/sourceharness">this tool</a>.</i>
	</p>

	<h3>Host Discovery</h2>
	<p>
		Does a host have <a target="_blank" href="/spec/#discovery-host">host-meta discovery</a> set up, so that anyone can locate the service on that host automatically?
	</p>
	<p>
	<form action="/tools/discoveryharness/" method="POST">
		<p>Hostname (e.g. www.example.com):</p>
        <p><input name="h" type="text" size="80" value="<?= $hostname ?>" /></p>
		<p><input class="btn" type="submit" value="Check Host" /></p>
        <input name="cmd" type="hidden" value="hm" />
	</form>
	</p>
	
<?
	if ($cmd == "hm") {
		?>
        <hr/>
        
		<h3>Discovery Results:</h3>
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
				We DID locate <code>http://<?= $hostname?>/.well-known/host-meta</code>, here's what was in it:	
			</p>
			<?	
			
			foreach($targetXrdUrls as $targetXrdUrl) {
				?>
				<p><b>Referenced Target XRD:&nbsp;</b><code><?= $targetXrdUrl ?></code></p>
				<p>
					Target details (from inspecting this XRD):
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
		<p>Target XRD (e.g. http://www.example.com/oexchange.xrd):</p>
        <p><input name="x" type="text" size="80" value="<?= $xrdUrl ?>" /></p>		
		<p><input class="btn" type="submit" value="Check Target XRD" /></p>
        <input name="cmd" type="hidden" value="txrd" />
	</form>
	</p>
    
<?
	if ($cmd == "txrd") {
		?>
        <hr/>
        
		<h3>XRD Lookup Results:</h3>
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
include '../../pagebottom.inc.php';
?>
