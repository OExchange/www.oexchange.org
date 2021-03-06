<?

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

$file = getDfltArg("file", "unknown");	

if ($file == "unknown") {
	header("HTTP/1.0 404 Not Found");
} else if ($file == "txrd") {
	$gen = new OExchangeGenerator();
	$targetXrd = $gen->generateTargetXrd($url, $vendor, $title, $name, $prompt, $offer, $icon, $icon32);
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
