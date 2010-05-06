<?

include '../../lib-oexchange/OExchangeGenerator.php';

function getDfltArg($name, $dflt) {
	if (isset($_GET[$name])) return $_GET[$name];
	else if (isset($_POST[$name])) return $_POST[$name];
	else return $dflt;
}

$hostname = getDfltArg("h", "www.example.com");
$url = getDfltArg("u", "http://www.example.com/coolservice");
$vendor = getDfltArg("v", "Examples Inc");
$title = getDfltArg("v", "A cool service that accepts URLs");
$name = getDfltArg("v", "CoolService");
$prompt = getDfltArg("p", "Share to CoolService");
$offer = getDfltArg("o", "http://www.example.com/coolservice/offer.php");
$icon = getDfltArg("i", "http://www.example.com/assets/icon.png");
$icon32 = getDfltArg("i32", "http://www.example.com/assets/icon32.png");

$file = getDfltArg("file", "unknown");	

if ($file == "unknown") {
	header("HTTP/1.0 404 Not Found");
} else if ($file == "txrd") {
	$gen = new OExchangeGenerator();
	$targetXrd = $gen->generateTargetXrd($serviceUrl, $vendor, $title, $name, $prompt, $offer, $icon, $icon32);
	header("Content-type: application/xml+xrd");
	header("Content-Disposition: attachment; filename=oexchange.xrd"); 
	echo $targetXrd;
} else if ($file == "hm") {
	$gen = new OExchangeGenerator();
	$hostMeta = $gen->generateHostMeta($hostname, $url);
	header("Content-type: application/xml+xrd");
	header("Content-Disposition: attachment; filename=host-meta"); 
	echo $hostMeta;
}