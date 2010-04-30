<?
require_once("XrdLinkReader.php");
require_once("WebFingerer.php");
require_once("Target.php");
require_once("TargetMatches.php");
require_once("utils.php");

class OExchangeDiscoverer {

	protected $tmpCurrTarget;
	protected $tmpCurrTag;
	protected $tmpCurrPropertyType;

	/**
	* @param toEmails A csv of email addresses to send to
	*
	* @return a TargetMatches object
	*/
	public function getCommonUserTargets($fromEmail, $toEmails) {
		$matches = new TargetMatches();
		$matches->fromTargets = $this->getTargetsForUser($fromEmail);
		$matches->toTargets = array();
		$matches->commonTargets = array();
	
		// Get targets for the to addresses
		foreach($toEmails as $toEmail) {
			$targets = $this->getTargetsForUser($toEmail);
			$matches->toTargets[$toEmail] = $targets;
		}
	
		// Now find matches
		dbglog("Looking for matches within " . sizeof($matches->fromTargets) . " possible from Targets.");
		foreach($matches->fromTargets as $fromTarget) {
			$cantSendTo = false;
		
			// Check each to address and see if they DON'T have this target 
			foreach($matches->toTargets as $toEmail => $toTargets) {
			
				// Check all this to address's targets for the from-target we're checking
				$canSendTo = false;
				dbglog("Looking to see if recipient " . $toEmail . " uses " . $fromTarget->id);
				foreach($toTargets as $toTarget) {
					if ($toTarget->id == $fromTarget->id) {
						//echo "Yes, they do!" . "<br/>";
						$canSendTo = true;
					}
				}
			
				// If we could send to them on this target, great.  If we can't that blows this one entirely.
				if (!$canSendTo) $cantSendTo = true;
			}
		
			// Now we know if all users could accept on this Target
			if (!$cantSendTo) {
				dbglog("We've found that everyone can use " . $fromTarget->id);
				array_push($matches->commonTargets, $fromTarget);
			} else {
				dbglog("Nope, not everyone can use " . $fromTarget->id);
			}
		}
		return $matches;
	}

	public function getTargetsForUser($email) {
	
		// Get this user's webfinger'd Link objects
		$wf = new WebFingerer();
		$links = $wf->getUserLinks($email);
	
		// Look for preferred-service relations
		$userSvcOexUrls = array();
		foreach($links as $link) {
			if ($link["REL"] == "http://oexchange.org/spec/0.8/rel/user-target") {
				array_push($userSvcOexUrls, $link["HREF"]);
			}
		}
	
		// Fetch the targets
		$targets = array();
		foreach($userSvcOexUrls as $targetXrdUrl) {
			//echo "Checking preferred service url: " . $targetXrdUrl;		
			$target = $this->getTargetInfoFromXrd($targetXrdUrl);
			if (isset($target)) array_push($targets, $target);
		}
		return $targets;
	}

	/**
	* @return A Target object, null if not found.
	*/
	public function getTargetInfoFromXrd($targetXrdUrl) {
		dbglog("getTargetInfoFromXrd: Loading XRD from " . $targetXrdUrl);
		$this->tmpCurrTarget = null;
		$this->tmpCurrTag = null;
		$this->tmpCurrPropertyType = null;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $targetXrdUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$xrdRaw = curl_exec($ch);
		if(curl_errno($ch)) {
			//echo "Curl error loading " . $targetXrdUrl . ": " . curl_error($ch) . "<br/>";
			curl_close($ch);
			return null;
		}
		curl_close($ch);

		dbglog("About to parse retrieved XRD: " . $xrdRaw);
		$parser = xml_parser_create();
		xml_set_object($parser, $this); 
		xml_set_element_handler($parser, "startXrdTag", "endXrdTag");
		xml_set_character_data_handler ($parser, "xrdTagContent");		
		if(!(xml_parse($parser, $xrdRaw, true))) {
			dbglog("XML parsing error (line " . xml_get_current_line_number($parser) . "): " . xml_error_string(xml_get_error_code($parser)));
			xml_parser_free($parser);
			return null;
		}
		xml_parser_free($parser);
		if ($this->tmpCurrTarget != null) {
			if (empty($this->tmpCurrTarget->endpoint) || empty($this->tmpCurrTarget->name) || empty($this->tmpCurrTarget->name)) {
				return null;
			}
			if (empty($this->tmpCurrTarget->icon)) {
				$this->tmpCurrTarget->icon = "http://www.oexchange.org/images/logo_16x16.png";
			}
			if (empty($this->tmpCurrTarget->icon32)) {
				$this->tmpCurrTarget->icon32 = "http://www.oexchange.org/images/logo_32x32.png";
			}
			if (empty($this->tmpCurrTarget->title)) {
				$this->tmpCurrTarget->title = $this->tmpCurrTarget->name;
			}
			if (empty($this->tmpCurrTarget->vendor)) {
				$this->tmpCurrTarget->vendor = "unknown";
			}
			if (empty($this->tmpCurrTarget->prompt)) {
				$this->tmpCurrTarget->prompt = "Send to " . $this->tmpCurrTarget->name;
			}
		}
		dbglog("Done parsing target XRD, returning the Target...");
		$return = $this->tmpCurrTarget;
		$this->tmpCurrTarget = null;
		$this->tmpCurrTag = null;
		$this->tmpCurrPropertyType = null;
		return $return;
	}

	/**
	* @return an array of XRD, Target objects.
	*/
	public function getTargetsOnHost($hostname) {
		$targetXrds = array();
	
		// Look up the OExchange relations in the host's main XRD
		$hostMetaUrl = "http://" . $hostname . "/.well-known/host-meta";
		dbglog("Fetching host-meta from " . $hostMetaUrl);
		$xrd = new XrdLinkReader();
		$hostLinks = $xrd->getLinksFromUrl($hostMetaUrl);
		dbglog("Found " . sizeof($hostLinks) . " links in host-meta");
		foreach($hostLinks as $link) {
			if ($link["REL"] == "http://oexchange.org/spec/0.8/rel/resident-target") {
				dbglog("Found a link with our relation type...");
			
				// This link represents an oexchange target
				array_push($targetXrds, $link["HREF"]);
			}
		}
	
		// We now have an array of target descriptors XRD docs, look them each up
		$targets = array();
		$results = array();
		foreach($targetXrds as $targetXrd) {
			dbglog("Fetching target XRD from " . $targetXrd);
			$target = $this->getTargetInfoFromXrd($targetXrd);
			if (isset($target)) {
				dbglog("Got a Target!");
				array_push($targets, $target);
				$result = array();
				$result["target"] = $target;
				$result["xrd"] = $targetXrd;
				array_push($results,$result);
			} else {
				dbglog("Not good.");
			}
		}
		return $results;
	}
	
	protected function startXrdTag($parser, $name, $attributes){
	    dbglog("parser: start " . $name);
		$this->tmpCurrTag = $name;
		if ($name == "XRD") {
			$this->tmpCurrTarget = new Target();
		} else if ($name == "LINK") {
			if ($attributes["REL"] == "http://www.oexchange.org/spec/0.8/rel/offer") {
				$this->tmpCurrTarget->endpoint = $attributes["HREF"];
			} else if ($attributes["REL"] == "icon") {
				$this->tmpCurrTarget->icon = $attributes["HREF"];
			} else if ($attributes["REL"] == "icon32") {
				$this->tmpCurrTarget->icon32 = $attributes["HREF"];
			}
		} else if ($name == "PROPERTY") {
		    dbglog("Starting a property tag, type is: " . $attributes["TYPE"]);
			$this->tmpCurrPropertyType = $attributes["TYPE"];
		}
	}

	protected function endXrdTag($parser, $name){
		if ($name == "XRD") {
			// All done with this Target
			//echo json_encode($this->tmpCurrTarget) . "<br/>";
		} if ($name == "PROPERTY") {
			$this->tmpCurrPropertyType = null;
		}
		$this->tmpCurrTag = null;
	}

	protected function xrdTagContent($parser, $content){
	    dbglog("reading content of tag " . $this->tmpCurrTag . ": " . $content);
		if ($this->tmpCurrTag == "VENDOR") {
			$this->tmpCurrTarget->vendor = $content;
		} else if ($this->tmpCurrTag == "NAME") {
			$this->tmpCurrTarget->name = $content;
		} else if ($this->tmpCurrTag == "TITLE") {
			$this->tmpCurrTarget->title = $content;
		} else if ($this->tmpCurrTag == "PROMPT") {
			$this->tmpCurrTarget->prompt = $content;
		} else if ($this->tmpCurrTag == "SUBJECT") {
			$this->tmpCurrTarget->id = $content;
		} else if ($this->tmpCurrTag == "PROPERTY") {
			dbglog("Have property tag, type is " . $this->tmpCurrPropertyType);
			if ($this->tmpCurrPropertyType == "http://www.oexchange.org/spec/0.8/prop/vendor") {
				$this->tmpCurrTarget->vendor = $content;
			} else if ($this->tmpCurrPropertyType == "http://www.oexchange.org/spec/0.8/prop/title") {
				$this->tmpCurrTarget->title = $content;
			} else if ($this->tmpCurrPropertyType == "http://www.oexchange.org/spec/0.8/prop/name") {
				$this->tmpCurrTarget->name = $content;
			} else if ($this->tmpCurrPropertyType == "http://www.oexchange.org/spec/0.8/prop/prompt") {
				$this->tmpCurrTarget->prompt = $content;
			}
		}
	}

}

