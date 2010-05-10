<?

$page_title = "OExchange Discovery Resource Generator";
include '../../header.php';
include '../../lib-oexchange/OExchangeGenerator.php';
include '../../lib-oexchange/utils.php';

$hostname = getDfltArg("h", "www.example.com");
$url = getDfltArg("u", "http://www.example.com/coolservice");
$vendor = getDfltArg("v", "Examples Inc");
$title = getDfltArg("t", "A cool service that accepts URLs");
$name = getDfltArg("n", "CoolService");
$prompt = getDfltArg("p", "Share to CoolService");
$offer = getDfltArg("o", "http://www.example.com/coolservice/offer.php");
$icon = getDfltArg("i", "http://www.example.com/assets/icon.png");
$icon32 = getDfltArg("i32", "http://www.example.com/assets/icon32.png");	

$cmd = getDfltArg("cmd", "none");	

?>

    <h1>Discovery Resource Generator</h1>
    <p>
		<i>For tools to be able to <a target="_blank" href="/spec/#discovery-host">discover a service automatically</a>, the host needs a <code>/.well-known/host-meta</code> resource that points to a XRD file describing the target itself.  Use this tool to generate these two files, then put them on your host to make it discoverable.</i>  
	</p>
	
<?
	if ($cmd == "none") {
?>
	<h2>About Your Service</h2>
	<form action="" method="POST">
		Hostname:<br/>&nbsp;&nbsp;&nbsp;<input name="h" type="text" size="60" value="<?= $hostname ?>" /></input><br/><br/>
		Primary site URL:<br/>&nbsp;&nbsp;&nbsp;<input name="u" type="text" size="60" value="<?= $url ?>" /></input><br/><br/>
		Service name:<br/>&nbsp;&nbsp;&nbsp;<input name="n" type="text" size="60" value="<?= $name ?>" /></input><br/><br/>
		Service title:<br/>&nbsp;&nbsp;&nbsp;<input name="t" type="text" size="60" value="<?= $title ?>" /></input><br/><br/>
		Vendor Name:<br/>&nbsp;&nbsp;&nbsp;<input name="v" type="text" size="60" value="<?= $vendor ?>" /></input><br/><br/>
		User prompt:<br/>&nbsp;&nbsp;&nbsp;<input name="p" type="text" size="60" value="<?= $prompt ?>" /></input><br/><br/>
		Offer endpoint URL: (such that &lt;endpoint&gt;?url=&lt;url&gt; works)<br/>&nbsp;&nbsp;&nbsp;<input name="o" type="text" size="60" value="<?= $offer ?>" /></input><br/><br/>
		16x16 icon (png) URL:<br/>&nbsp;&nbsp;&nbsp;<input name="i" type="text" size="60" value="<?= $icon ?>" /></input><br/><br/>
		32x32 icon (png) URL:<br/>&nbsp;&nbsp;&nbsp;<input name="i32" type="text" size="60" value="<?= $icon32 ?>" /></input><br/>
		<input name="cmd" type="hidden" value="gen" /></input>
		<br/><br/>
		<input type="submit" value="Generate Resources" /></input>
    </form>
<?
	} else if ($cmd == "gen") {
		$gen = new OExchangeGenerator();
		$hostMeta = $gen->generateHostMeta($hostname, $url);
		$targetXrd = $gen->generateTargetXrd($url, $vendor, $title, $name, $prompt, $offer, $icon, $icon32);
?>
	<h2>Your Resources</h2>

	<h3>Your Target XRD File:</h3>
	<p>
		The Target XRD describes everything about a Target service, including its name and how it accepts URLs.  This file can be located anywhere, though usually it will live under the service's main path.   From what you told us, in your case that would be:
	</p>
	<p>
		<code><?= $url ?>/oexchange.xrd</code>
	</p>
	<p>
		For your service, the XRD file should look like this:
	</p>
	<p>
	<textarea rows="22" cols="120"><?= $targetXrd ?></textarea>
	</p>
	<p>
		You can read more about the details of the Target XRD <a target="_blank" href="/spec/#discovery-targetxrd">in the spec</a>. 
	</p>
	<p>
		<form action="dl.php" method="POST">
			<input name="h" type="hidden" value="<?= $hostname ?>" /></input>
			<input name="u" type="hidden" value="<?= $url ?>" /></input>
			<input name="n" type="hidden" value="<?= $name ?>" /></input>
			<input name="t" type="hidden" value="<?= $title ?>" /></input>
			<input name="v" type="hidden" value="<?= $vendor ?>" /></input>
			<input name="p" type="hidden" value="<?= $prompt ?>" /></input>
			<input name="o" type="hidden" value="<?= $offer ?>" /></input>
			<input name="i" type="hidden" value="<?= $icon ?>" /></input>
			<input name="i32" type="hidden" value="<?= $icon32 ?>" /></input>
			<input name="file" type="hidden" value="txrd" /></input>
			<input type="submit" value="Download the File" /></input>
		</form>
	</p>
	<br/>
	<br/>
	
	<h3>Your Host-Meta File:</h3>
	<p>
		The host that serves your service needs to have a "host-meta" resource.  This is an XML text file located in a well-defined location.  In your case, it should be at:
	</p>
	<p>
		<code>http://<?= $hostname ?>/.well-known/host-meta</code>  
	</p>
	<p>
		This file should contain a link to the target XRD file.  For your service, assuming you use the XRD file above, it should look like this:
	</p>	
	<p>
	<textarea rows="7" cols="120"><?= $hostMeta ?></textarea>
	</p>
	<p>
		If you already have a host-meta resource on your host, then you'll need to add this <code>Link</code> element to it.  If you don't have one, you can just copy this file completely.  Read more about the host-meta resource <a target="_blank" href="/spec/#discovery-hostmeta">in the spec</a>. 
	</p>
	<p>
		<form action="dl.php" method="POST">
			<input name="h" type="hidden" value="<?= $hostname ?>" /></input>
			<input name="u" type="hidden" value="<?= $url ?>" /></input>
			<input name="file" type="hidden" value="hm" /></input>
			<input type="submit" value="Download the File" /></input>
		</form>
	</p>			  
	<br/>
	<br/>

	<h3>In-page meta tags:</h3>
	<p>
		Optionally, you can indicate on HTML pages that there is a related target service available.  This provides a hint to browsers and other page-level tools that there is a target, without having to attempt host discovery in every case.  For your target, the tag that you would place in your HTML pages would look like this:
	</p>
	<pre>&lt;link rel="http://oexchange.org/spec/0.8/rel/related-target" type="application/xrd+xml" href="<?= $url ?>/oexchange.xrd"/&gt;</pre>
	</p>
	<p>
		You can read more about this page-level tag <a target="_blank" href="/spec/#discovery-page">in the spec</a>.
	</p>

	<h3>What now?</h3>
	<p>
		Stick these files on your host as explained above, then try it out with the <a href="/tools/discoveryharness">Discovery Test Harness</a>.
	</p>
		
	<h3>Generate another?</h3>
		<form id="back" action="/tools/discoverygen" method="GET">
		<input type="submit" value="Back to service details " /></input>
		</form>
<?
	}
?>

<?
include '../../footer.php';
?>