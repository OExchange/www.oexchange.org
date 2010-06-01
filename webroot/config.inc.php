<?

/**
* Include in every page of the site, sets up environment-specific stuff.  
*/

// Manually-editable config
$CFG_HOMEPAGE_VER = 1;
$CFG_DEMOPAGE_VER = 1;

// Processed during build-time, $STATICFILES_VER is set to the correct version of our static files tree
$CFG_STATICFILES_VER = 2;

// Set up the rest of our config depending on where we'are running
$CFG_IMAGEBASE_URL = "/images";
$CFG_CSSBASE_URL = "/styles";
$CFG_JSBASE_URL = "/js";
 
$hostname = $_SERVER["SERVER_NAME"];
if ($hostname == "www.oexchange.org") {

	// Running in production...
	$CFG_IMAGEBASE_URL = "http://cache.oexchange.org/site/" . $CFG_STATICFILES_VER . "/images";
	$CFG_CSSBASE_URL = "http://cache.oexchange.org/site/" . $CFG_STATICFILES_VER . "/styles";
	$CFG_JSBASE_URL = "http://cache.oexchange.org/site/" . $CFG_STATICFILES_VER . "/js";
} else if ($hostname == "www-localstage.oexchange.org") {

	// Running in the local staging environment...
	$CFG_IMAGEBASE_URL = "http://cache.oexchange.org/site/" . $CFG_STATICFILES_VER . "/images";
	$CFG_CSSBASE_URL = "http://cache.oexchange.org/site/" . $CFG_STATICFILES_VER . "/styles";
	$CFG_JSBASE_URL = "http://cache.oexchange.org/site/" . $CFG_STATICFILES_VER . "/js";
} else {
	
	// running locally, defaults are fine (unversioned, relative paths)...
}


