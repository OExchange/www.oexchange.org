<?

$page_title = "WebIntents OExchange Proxy Registrar";
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

$xrdUrl = getDfltArg("x", "http://www.oexchange.org/demo/linkeater/oexchange.xrd");
$cmd = getDfltArg("cmd", "none");	

?>

	<script src="http://examples.webintents.org/lib/webintents.js"></script>
    
    <h2 class="pagetitle">WebIntents Proxy Registrar</h2>
    <div class="bannertext">
        Registers OExchange services as <a href="http://www.webintents.org">Share Intent Intent</a> handlers
    </div>

    <hr/>
    
<?php
    if ($cmd == "reg") {
		
		// Going to register the provider defined by a specific XRD
		
		// Look it up, get info
		$disc = new OExchangeDiscoverer();
		$target = $disc->getTargetInfoFromXrd($xrdUrl);
		if (isset($target)) {
			?>
			<h2>OExchange Target Found</h2>
			<p>
				We found an OExchange Target descriptor at <?php echo $xrdUrl ?>:<br/>
			<?php	
			printTarget($target);
			?>
			</p>
				
			<?php	
			
			// Whats the right intent?
			$action = "http://webintents.org/share";
			$type = "text/uri-list";
			$disposition = "text/uri-list";
			$title = $target->prompt . " (via " . $target->name . ")";
			$href = "proxy.php?offerpoint=" . urlencode($target->endpoint);
			
			// Intent markup...
			$intentTag = '<intent';
			$intentTag .= ' action="' . $action . '"';
			$intentTag .= ' type="' . $type . '"';
			$intentTag .= ' href="' . $href . '"';
			$intentTag .= ' disposition="' . $disposition . '"';
			$intentTag .= ' title="' . $title . '"';
			$intentTag .= '/>';
			
			?>
			<h2>Target Registered!</h2>
			<p>
				The "<?php echo $target->name; ?>" target has been registered using the following intent tag:
			</p>
			<?php
			echo "<pre>";
			echo htmlspecialchars($intentTag);
			echo "</pre>";
			echo $intentTag;
			?>
			<p>
				Check out the <a href="sender.php">sender tool</a> to share to it...
			</p>
			<?php   
		} else {
			?>
			<p>
				<b>ERROR</b> looking up details; the target XRD was not found or not valid.  If you need help generating one, try <a href="/tools/discoverygen">this tool</a>.
			</p>
			<?
		}
		?>
		<br/>
		<br/>
		<strong>Want to register another?</strong>
		<?php
	} else {
	
?>
	<p>
		This service creates Intent tags that correspond to the info provided in an OExchange Target's <a href="/spec/#discovery-targetxrd">discovery file</a>.  You can specify any OExchange Target XRD here and we will register a proxy service for that Target.  
		This allows any OExchange-compliant service to immediately handle Share intents.
	</p>
	<p>
		Confused?  <a href="/tools/webintents">Learn more.</a>
	</p>
	
	<h2>Choose your OExchange Target</h2>
<?php
	}
?>
<p>
	Enter the <a href="/spec/#discovery-targetxrd">Target XRD</a> for the Target you'd like to register as a <i>Share</i> Web Intent handler. 
</p>

<p>
<form action="proxy-registrar.php" method="POST">
	<p>XRD (e.g. http://www.example.com/oexchange.xrd):</p>
    <p><input name="x" type="text" size="80" value="<?= $xrdUrl ?>" /></p>		
	<p><input class="btn" type="submit" value="Register Target" /></p>
    <input name="cmd" type="hidden" value="reg" />
</form>
</p>

<?php
include '../../pagebottom.inc.php';
?>
