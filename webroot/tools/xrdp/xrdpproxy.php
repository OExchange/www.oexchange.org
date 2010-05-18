<?php 
require 'xrdpclient.php';

// get HTTP Method
$acct=$_GET["acct"];

$request_method = $_SERVER['REQUEST_METHOD'];
switch ($request_method) {
    // gets are easy...  
    case 'GET':  // read links from the webfinger
		$links = get_links($acct);
		echo json_encode($links);
        break;  
    case 'POST':  // save links to the webfinger via xrdp
		$body = file_get_contents('php://input');
		$newlinks = json_decode($body);
		$oldlinks = get_links($acct);
		$toDel = array_diff($oldlinks, $newlinks);
		$toAdd = array_diff($newlinks, $oldlinks);

		$url = 'http://xrdpdemo.appspot.com/xrdp';
		$client = new XRDPClient($url);
		foreach ($toAdd as $link) {
			$Link = new Link("http://oexchange.org/spec/0.8/rel/user-target", "application/xrd+xml", $link, "");
			$client->add($acct, $Link);
		}
		foreach ($toDel as $link) {
			$Link = new Link("http://oexchange.org/spec/0.8/rel/user-target", "application/xrd+xml", $link, "");
			$client->delete($acct, $Link);
		}
        break;
 }  

function get_links($acct) {
	$url = 'http://xrdpdemo.appspot.com/xrdp';
	$client = new XRDPClient($url);
	$xrddata = $client->get($acct);
	$links = array();
	$xrd = simplexml_load_string($xrddata);
	foreach ($xrd->Link as $link) {
		if ($link["type"] == "application/xrd+xml" 
			and $link["rel"] == "http://oexchange.org/spec/0.8/rel/user-target") {		
			$links[] = (string) $link["href"];
		}
	}
	return $links;
}

/*
echo $client->add($acct, $link);
echo $client->update($acct, $link, $newlink);
echo $client->delete($acct, $newlink);
//echo $client->delete($acct, $link);
*/

?>