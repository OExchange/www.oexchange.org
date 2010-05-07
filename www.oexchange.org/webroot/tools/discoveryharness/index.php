<?

$page_title = "OExchange Discovery Test Harness";
include '../../header.php';
include '../../lib-oexchange/OExchangeDiscoverer.php';

function getDfltArg($name, $dflt) {
	if (isset($_GET[$name])) return $_GET[$name];
	else if (isset($_POST[$name])) return $_POST[$name];
	else return $dflt;
}

function printTarget($target) {
	echo "&nbsp;&nbsp;ID: " . htmlspecialchars($target->id) . "<br/>";
	echo "&nbsp;&nbsp;Name: " . htmlspecialchars($target->name) . "<br/>";
	echo "&nbsp;&nbsp;Prompt: " . $target->prompt . "<br/>";
	echo "&nbsp;&nbsp;Title: " . htmlspecialchars($target->title) . "<br/>";
	echo "&nbsp;&nbsp;Endpoint: " . htmlspecialchars($target->endpoint) . "<br/>";
	echo "&nbsp;&nbsp;Vendor: " . htmlspecialchars($target->vendor) . "<br/>";
	echo "&nbsp;&nbsp;Icon: " . htmlspecialchars($target->icon) . "<br/>";
	echo "&nbsp;&nbsp;Icon32: " . htmlspecialchars($target->icon32) . "<br/>";
}

$hostname = getDfltArg("h", "www.oexchange.org");
$xrdUrl = getDfltArg("x", "http://www.oexchange.org/demo/linkeater/oexchange.xrd");
$cmd = getDfltArg("cmd", "none");	

?>

    <h1>Discovery Test Harness</h1>
    <p>
		<i>Test a service for <a href="/spec/#discovery">OExchange Discovery</a> compliance.</i>  
	</p>
	<p>
		<i>If you need help setting up discovery support, check the <a href="/guide/#services">Quick Start Guide</a> or the <a href="/tools/discoverygen">Discovery File Generator</a>.  If you want to test Offer support instead, use <a href="/tools/sourceharness">this tool</a>.</i>
	</p>

	<h2>Host Discovery</h2>
	<p>
		Does a host have <a target="_blank" href="/spec/#discovery-host">host-meta discovery</a> set up so, that anyone can locate the service on that host automatically?
	</p>
	<p>
	<form action="" method="POST">
		Hostname (e.g. www.example.com):&nbsp;<input name="h" type="text" size="60" value="<?= $hostname ?>" /></input>
		<input name="cmd" type="hidden" value="hm" /></input>
		<input type="submit" value="Check Host" /></input>
	</form>
	</p>
	<br/>
<?
	if ($cmd == "hm") {
		?>
		<h5>Discovery Results</h5>
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
				We DID find a <code>host-meta</code>, here's what was in it...	
			</p>
			<?	
			
			foreach($targetXrdUrls as $targetXrdUrl) {
				?>
				<h6>Target: <?= $targetXrdUrl ?></h6>
				<p>
					Loaded from <?= $targetXrdUrl?> (from your host's host-meta file)...
				</p>
				<p>
					Target details (after we inspected the XRD):
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
					Want to use the source harness to test this Target?  <a href="/tools/sourceharness/?target=<?=$target->endpoint ?>">Go there now</a>.	
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

	<h2>Target XRD Inspection</h2>
	<p>
		Inspect a <a target="_blank" href="/spec/#discovery-targetxrd">Target XRD</a> directly.
	</p>
	<p>
	<form action="" method="POST">
		Target XRD (e.g. http://www.example.com/oexchange.xrd):&nbsp;<input name="x" type="text" size="60" value="<?= $xrdUrl ?>" /></input>
		<input name="cmd" type="hidden" value="txrd" /></input>
		<input type="submit" value="Check Target XRD" /></input>
	</form>
	</p>
	<br/>
<?
	if ($cmd == "txrd") {
		?>
		<h5>XRD Lookup Results</h5>
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
				ERROR looking up details; the target XRD was not found or not valid.  If you need help generating one, try <a href="/tools/discoverygen">this tool</a>.
			</p>
			<?
		}
	}
?>




<?
include '../../footer.php';
?>
