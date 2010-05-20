<?
require_once("../../lib-oexchange/OExchangeDiscoverer.php");

$nav = "tools";
$cmd = $_REQUEST["cmd"];

function outputMatchesJson($callback, $matches) {
	if (isset($callback)) {
		echo $callback . "(";
	}
	echo "{";
	echo "\"matches\": ";
	//echo $matches->toJson();
	echo json_encode($matches);
	echo "}";
	if (isset($callback)) {
		echo ")";
	}
}

function outputTargetsJson($callback, $targets) {
	if (isset($callback)) {
		echo $callback . "(";
	}
	echo "{";
	echo "\"targets\": " . "[";
	$num = sizeof($targets);
	for ($i = 0; $i < $num; $i++) {
		$target = $targets[$i];
		echo json_encode($target);
		if ($i < ($num-1)) echo ", ";
	}
	echo "]";
	echo "}";
	if (isset($callback)) {
		echo ")";
	}
}

function outputTargetsAndXrdsJson($callback, $results) {
	if (isset($callback)) {
		echo $callback . "(";
	}
	echo "{";
	echo "\"targets\": " . "[";
	$num = sizeof($results);
	for ($i = 0; $i < $num; $i++) {
		$target = $results[$i]["target"];
		$xrd = $results[$i]["xrd"];
		echo "{";
		echo "\"target\": ";
		echo json_encode($target);
		echo ", \"xrd\": ";
		echo json_encode($xrd);
		echo "}";
		if ($i < ($num-1)) echo ", ";
	}
	echo "]";
	echo "}";
	if (isset($callback)) {
		echo ")";
	}
}

function outputTargetJson($callback, $target) {
	if (isset($callback)) {
		echo $callback . "(";
	}
	if ($target == null) {
		echo "{}";
	} else {
		echo json_encode($target);
	}
	if (isset($callback)) {
		echo ")";
	}
}

if ($cmd == "getUserTargets") {
	header("Content-Type: application/json", true);
	$email = $_REQUEST["email"];
	if (isset($_REQUEST["jsonpcb"])) {
		$callback = $_REQUEST["jsonpcb"];
	}
	$oex = new OExchangeDiscoverer();
	$targets = $oex->getTargetsForUser($email);
	
	// Output
	outputTargetsJson($callback, $targets);
} else if ($cmd == "getHostTargets") {
	header("Content-Type: application/json", true);
	$host = $_REQUEST["host"];
	if (isset($_REQUEST["jsonpcb"])) {
		$callback = $_REQUEST["jsonpcb"];
	}
	$oex = new OExchangeDiscoverer();
	$results = $oex->getTargetsOnHost($host);
	
	// Output
	outputTargetsAndXrdsJson($callback, $results);
} else if ($cmd == "getTargetDetail") {
	header("Content-Type: application/json", true);
	$xrdUrl = $_REQUEST["xrd"];
	if (isset($_REQUEST["jsonpcb"])) {
		$callback = $_REQUEST["jsonpcb"];
	}
	$oex = new OExchangeDiscoverer();
	$target = $oex->getTargetInfoFromXrd($xrdUrl);

	// Output
	outputTargetJson($callback, $target);
} else if ($cmd == "getCommonUserTargets") {
	header("Content-Type: application/json", true);
	$fromEmail = $_REQUEST["from"];
	$toEmailList = $_REQUEST["to"];
	if (isset($_REQUEST["jsonpcb"])) {
		$callback = $_REQUEST["jsonpcb"];
	}
	$toEmails = explode(",", $toEmailList);
	$oex = new OExchangeDiscoverer();
	$matches = $oex->getCommonUserTargets($fromEmail, $toEmails);

	// Output
	outputMatchesJson($callback, $matches);
} else {
	if (isset($cmd)) {
		header("HTTP/1.0 404 Not Found", true, true);
	} else {
		$page_title = "OExchange Demo Utility API";
		include ("../../header.php");
		?>
		<div id="contentpage">
            <h2 class="pagetitle">Demo Utility API</h2>
            <div class="bannertext">
                A simple GET/JSON-based API for various OExchange operations
            </div>

            <hr/>
            
            
			<h2>Using the API</h2>
			<p>
				All calls are made against the api.php endpoint with HTTP GETs.  All responses are JSON.  Certain arguments are common to all calls.  They are:
			</p>
			<ul>
				<li><code>cmd</code> The name of the method call to execute, described below.</li>
				<li><code>jsonpcb</code> The name of a callback function to use to form a JSONP response.</li>	
			</ul>
            
            <br/>
            
			<h2>Method Detail</h2>
			<p>
				Each method requires specific parameters.
			</p>
			
			<a name="getUserTargets"></a>
			<h4>getUserTargets</h4>
			<p>
				Gets the set of available OExchange Targets preferred by a particular user.  
				This looks up their XRD via WebFinger, looks for preferred services, then fetches detail on those services.  
				If all of that is successful, this will return an array of the Target details.
			</p>
			<p>
				Method-specific parameters are as follows:
			</p>
			<ul>
				<li><code>email</code>: The email address to look up via WebFinger.</li>
			</ul>
			<h5>An example call</h5>
			<blockquote>
				<a target="_blank" href="api.php?cmd=getUserTargets&jsonpcb=callback&email=will@willmeyer.com">api.php?cmd=getUserTargets&jsonpcb=callback&email=will@willmeyer.com</a>
			</blockquote>

			<a name="getHostTargets"></a>
			<h4>getHostTargets</h4>
			<p>
				Gets the set of available OExchange Targets on a specific host.  
				This looks up the host XRD via host-meta, looks for OExchange target XRDs there, then fetches detail on those services.  
				If all of that is successful, this will return an array of the Target details.
			</p>
			<p>
				Method-specific parameters are as follows:
			</p>
			<ul>
				<li><code>host</code>: The host to look up.</li>
			</ul>
			<h5>An example call</h5>
			<blockquote>
				<a target="_blank" href="api.php?cmd=getHostTargets&jsonpcb=callback&host=oexchange.org">api.php?cmd=getHostTargets&jsonpcb=callback&host=oexchange.org</a>
			</blockquote>

			<a name="getTargetDetail"></a>
			<h4>getTargetDetail</h4>
			<p>
				Gets the details on an OExchange Target from its XRD.  
			</p>
			<p>
				Method-specific parameters are as follows:
			</p>
			<ul>
				<li><code>xrd</code>: The URL of the targets XRD document.</li>
			</ul>
			<h5>An example call</h5>
			<blockquote>
				<a target="_blank" href="api.php?cmd=getTargetDetail&jsonpcb=callback&xrd=http://www.oexchange.org/demo/linkeater/oexchange.xrd">api.php?cmd=getTargetDetail&jsonpcb=callback&xrd=http://www.oexchange.org/demo/linkeater/oexchange.xrd</a>
			</blockquote>

			<a name="getCommonUserTargets"></a>
			<h4>getCommonUserTargets</h4>
			<p>
				Gets the set of available OExchange Targets that can be used to send from one user to N other users.  
				This looks up each user XRD and their services, and tries to match up Targets.
				It returns the senders Targets, each potential recipients Targets, and the set that is common to all of them.
			</p>
			<p>
				Method-specific parameters are as follows:
			</p>
			<ul>
				<li><code>from</code>: The email address of the sender.</li>
			</ul>
			<ul>
				<li><code>to</code>: The email addresses of each recipient, comma-separated.</li>
			</ul>
			<h5>An example call</h5>
			<blockquote>
				<a target="_blank" href="api.php?cmd=getCommonUserTargets&jsonpcb=callback&from=will@willmeyer.com&to=charlie@ecece.com">api.php?cmd=getCommonUserTargets&jsonpcb=callback&from=will@willmeyer.com&to=charlie@ecece.com</a>
			</blockquote>

			</div>	
		<?
		include("../../footer.php");
	}
}



?>