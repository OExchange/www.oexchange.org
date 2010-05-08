<?

class OExchangeGenerator {

	public function generateHostMeta($serviceHost, $serviceUrl) {
		$hostMeta = "<?xml version='1.0' encoding='UTF-8'?>\n" . 
					"<XRD xmlns='http://docs.oasis-open.org/ns/xri/xrd-1.0' xmlns:hm='http://host-meta.net/xrd/1.0'>\n" .
					"  <hm:Host>" . $serviceHost . "</hm:Host>\n" .
					"  <Link \n" .
					"    rel='http://oexchange.org/spec/0.8/rel/resident-target' \n" .
					"    type='application/xrd+xml' href='" . $serviceUrl . "/oexchange.xrd' >\n" .
					"  </Link>\n" .
					"</XRD>\n";    
		return $hostMeta;
	}

	public function generateTargetXrd($serviceUrl, $vendor, $title, $name, $prompt, $offer, $icon, $icon32) {
		$targetXrd = "<?xml version='1.0' encoding='UTF-8'?>\n" .
					 "<XRD xmlns='http://docs.oasis-open.org/ns/xri/xrd-1.0'>\n" .
					 "  <Subject>" . $serviceUrl . "</Subject>\n" .
					 "  <Property type='http://www.oexchange.org/spec/0.8/prop/vendor'>" . $vendor . "</Property>\n" . 
					 "  <Property type='http://www.oexchange.org/spec/0.8/prop/title'>" . $title . "</Property>\n" .
					 "  <Property type='http://www.oexchange.org/spec/0.8/prop/name'>" . $name . "</Property>\n" .
					 "  <Property type='http://www.oexchange.org/spec/0.8/prop/prompt'>" . $prompt . "</Property>\n" .
					 "  <Link \n" .
					 "    rel='icon'\n" .
					 "    href='" . $icon . "'\n" .
					 "    type='image/png'\n" .
					 "  />\n".
					 "  <Link \n" .
					 "    rel='icon32'\n" .
					 "    href='" . $icon32 . "'\n" .
					 "    type='image/png'\n" .
					 "  />\n".
					 "  <Link \n" .
					 "    rel='http://www.oexchange.org/spec/0.8/rel/offer'\n" .
					 "    href='" . $offer . "'\n" .
					 "    type='text/html'\n" .
					 "  />\n".
					 "</XRD>";
		return $targetXrd;			
	}

}