<?php

define("DBGLOG_ECHO", false);
define("DBGLOG_LOG", false);
define("ERRLOG_ECHO", false);

function dbglog($msg) {
	if (DBGLOG_ECHO || DBGLOG_LOG) {
		$log_line = $msg . "<br/>";
		if (DBGLOG_ECHO) print($log_line);
		if (DBGLOG_LOG) error_log($log_line);
	}
}

function errlog($msg) {
	$log_line = $msg . "<br/>";
	if (ERRLOG_ECHO) print($log_line);
	error_log($log_line);
}

function getParamDflt($params, $name, $dflt_val) {
    if (isset($params[$name])) {
		return $params[$name];
	} else {
		return $dflt_val;
	}	
}

function getDfltArg($name, $dflt) {
	if (isset($_GET[$name])) return $_GET[$name];
	else if (isset($_POST[$name])) return $_POST[$name];
	else return $dflt;
}

function getFullUrl() {
	$query_string = "";
	foreach ($_GET as $key => $value) {
		if ($key != "C") {  // ignore this particular $_GET value
	    	$query_string .= $key . "=" . urlencode($value) . "&";
	    }
	}
	return $SERVER["PHP_SELF"] . "?" . $query_string;
}

/**
* @return The http://server:port part of the request
*/
function getServerBaseRequest() {
	$name = $_SERVER["SERVER_NAME"];
	if (isset($_SERVER["HTTPS"])) {
		if ($_SERVER["SERVER_PORT"] == "443") {
			$str = "https://" . $name;
		} else {
			$str = "https://" . $name . ":" . $_SERVER["SERVER_PORT"];
		}
	} else {
		if ($_SERVER["SERVER_PORT"] == "80") {
			$str = "http://" . $name;
		} else {
			$str = "http://" . $name . ":" . $_SERVER["SERVER_PORT"];
		}
	}
	return $str;
}
