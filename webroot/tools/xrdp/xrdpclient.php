<?php
require_once 'HTTP/Request2.php';

/**
 * A client library for interacting with an XRD Provisioning service.
 * see: http://xrdprovisioning.net/specs/1.0/wd01/xrd-provisioning-1.0-wd01.html
 */
class XRDPClient {
	private $headers = array('Content-Type' => 'application/xrd+xml');
	private $url;

	function __construct($url) {
		$this->url = $url;
	}
	
	public function get($acct) {
		$request = new HTTP_Request2($this->url);
		$query = array('acct' => $acct);
		$request->getUrl()->setQueryVariables($query);
		
		try {
		    $response = $request->send();
		    if (200 == $response->getStatus()) {
				return $response->getBody();
		    } else {
		        echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase();
		        return null;
		    }
		} catch (HTTP_Request2_Exception $e) {
		    echo 'Error: ' . $e->getMessage();
		}	
	}

	function add($acct, Link $link) {
		$request = new HTTP_Request2($this->url, HTTP_Request2::METHOD_POST);
		$request->setHeader($this->headers);
		$query = array('acct' => $acct);
		$request->getUrl()->setQueryVariables($query);
		$request->setBody($link->toTag());
		
		try {
		    $response = $request->send();
		    if (200 == $response->getStatus()) {
				return $response->getBody();
		    } else {
		        echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase();
		        return null;
		    }
		} catch (HTTP_Request2_Exception $e) {
		    echo 'Error: ' . $e->getMessage();
		}
	}

	function update($acct, Link $link, Link $newlink) {
		$request = new HTTP_Request2($this->url, HTTP_Request2::METHOD_PUT);
		$request->setHeader($this->headers);
		$query = $link->toArray();
		$query['acct'] = $acct;
		$request->getUrl()->setQueryVariables($query);
		$request->setBody($newlink->toTag());
		
		try {
		    $response = $request->send();
		    if (200 == $response->getStatus()) {
				return $response->getBody();
		    } else {
		        echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase();
		        return null;
		    }
		} catch (HTTP_Request2_Exception $e) {
		    echo 'Error: ' . $e->getMessage();
		}
	}

	function delete($acct, Link $link) {
		$request = new HTTP_Request2($this->url, HTTP_Request2::METHOD_DELETE);
		$query = $link->toArray();
		$query['acct'] = $acct;
		$request->getUrl()->setQueryVariables($query);
		
		try {
		    $response = $request->send();
		    if (200 == $response->getStatus()) {
				return $response->getBody();
		    } else {
		        echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase();
		        return null;
		    }
		} catch (HTTP_Request2_Exception $e) {
		    echo 'Error: ' . $e->getMessage();
		}	
	}
}

/**
 * Encapsulation of an XRD Link element
 * @author cfr
 *
 */
class Link {
	public $rel;
	public $type;
	public $href;
	public $template;

	/**
	 * build a new link.  pass either href OR template but not both
	 * Enter description here ...
	 * @param unknown_type $rel
	 * @param unknown_type $type
	 * @param unknown_type $href
	 * @param unknown_type $template
	 */
	function __construct($rel, $type, $href = null, $template = null) {
		$this->rel = $rel;
		$this->type = $type;
		$this->href = $href;
		$this->template = $template;
	}
	
	/**
	 * Get the XML tag representation of this link 
	 */
	public function toTag() {
		$tag = "<Link";
		$tag .= " rel=\"" . $this->rel . "\"";
		$tag .= " type=\"" . $this->type . "\"";
		if ($this->href) 
			$tag .= " href=\"" . $this->href . "\"";
		if ($this->template) 
			$tag .= " template=\"" . $this->template . "\"";
		$tag .= " />";
		return $tag;
	}

	/**
	 * Get an array of this Link's properties
	 */
	public function toArray() {
		$vars = array('rel' => $this->rel,
					  'type' => $this->type);
		if ($this->href)
			$vars['href'] = $this->href;
		if ($this->template)
			$vars['template'] = $this->template;
		return $vars;
	}
}
?>