<?

class XrdLinkReader {

	protected $tmpParsedLinks = array(); 

	/**
	*
	* @return an array of associative arrays, each representing the attributes and elements of a Link (empty if not found)
	*/
	public function getLinksFromUrl($xrdUrl) {
		$this->tmpParsedLinks = array();

		// Load the XRD
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $xrdUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$xrdRaw = curl_exec($ch);
		if(curl_errno($ch)) {
			echo "Curl error loading " . $xrdUrl . ": " . curl_error($ch);
			curl_close($ch);
			return array();
		}
		curl_close($ch);

		// Parse it, building up an array of all Links
		$parser = xml_parser_create();
		xml_set_object($parser, $this); 
		xml_set_element_handler($parser, "startTag", "endTag");
		if(!(xml_parse($parser, $xrdRaw, true))) {
			//echo "XML parsing error: " . xml_error_string(xml_get_error_code($parser));
			xml_parser_free($parser);
		    return array();
		}
		xml_parser_free($parser);
		$return = $this->tmpParsedLinks;
		$this->tmpParsedLinks = null;
		return $return;
	}

	protected function startTag($parser, $name, $attributes) {
		//echo "startTag: " . $name . "<br/>";
		if ($name == "LINK") {
			array_push($this->tmpParsedLinks, $attributes);
		}
	}

	protected function endTag($parser, $name) {
		//echo "endTag: " . $name . "<br/>";
	}
	
}
