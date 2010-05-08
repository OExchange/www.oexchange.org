<?php

require_once("XrdLinkReader.php");

class WebFingerer {

	protected $xrd = null;
	
	/**
	* Gets a set of Link elements from an email address (by webfingering it). 
	*
	* @param string $email The email address of the user
	*
	* @return an array of associative arrays, each representing the attributes and elements of a Link.  Empty if none. 
	*/
	public function getUserLinks($email) {
    
		// Look up the XRD for this user
		$userXrdUrl = $this->getUserXrdUrl($email);
	    if (empty($userXrdUrl)) {
	        return array();
	    }

		// Grab the links from it
		$userLinks = $this->xrd->getLinksFromUrl($userXrdUrl);
		return $userLinks;
	}

	/**
	* Get a user XRD URL from an email address (by webfingering it).
	*
	* @param string $email The email address of the user
	*
	* @return string The XRD URL, null if none found
	*/
	public function getUserXrdUrl($email) {

		// Get the host meta for the domain
		$domain = $this->getEmailHost($email);
	    if (empty($domain))
	        return null;
	    $hostMetaUrl = "http://" . $domain . "/.well-known/host-meta";
		$hostMetaLinks = $this->xrd->getLinksFromUrl($hostMetaUrl);
	
		// Look for an lrdd link with a temnplate
		foreach($hostMetaLinks as $link) {
			if (strtolower($link["REL"]) == "lrdd") {
				if (isset($link["TEMPLATE"]) && (strpos(strtolower($link["TEMPLATE"]), "{uri}") != -1)) {
					//echo "Template: " . $link["TEMPLATE"] . "<br/>";
					$userTemplate = $link["TEMPLATE"];
				}
			}
		}
	
	    // Finally substitute the actual email address into the generic template
		if (isset($userTemplate)) {
		    return str_replace('{uri}', urlencode('acct://'.$email), $userTemplate);
		}
	    return null;
	}
 
	protected function getEmailHost($email) {
	    $emailparts = explode('@', $email);
	    if (!isset($emailparts[1]))
	        return null;
	    return $emailparts[1];
	}
	
	function __construct() {
		$this->xrd = new XrdLinkReader();
	}
	
}