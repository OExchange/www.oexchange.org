<?php

$page_redirected_from = $_SERVER['REQUEST_URI'];  
$server_url = "http://" . $_SERVER["SERVER_NAME"] . "/";
$redirect_url = $_SERVER["REDIRECT_URL"];
$redirect_url_array = parse_url($redirect_url);
$end_of_path = strrchr($redirect_url_array["path"], "/");

switch(getenv("REDIRECT_STATUS"))
{
	# "400 - Bad Request"
	case 400:
	$error_code = "400 - Bad Request";
	$explanation = "The syntax of the URL submitted by your browser could not be understood.  Please verify the address and try again.";
	$redirect_to = "";
	break;

	# "401 - Unauthorized"
	case 401:
	$error_code = "401 - Unauthorized";
	$explanation = "This section requires a password or is otherwise protected.  If you feel you have reached this page in error, please return to the login page and try again, or contact the webmaster if you continue to have problems.";
	$redirect_to = "";
	break;

	# "403 - Forbidden"
	case 403:
	$error_code = "403 - Forbidden";
	$explanation = "This section requires a password or is otherwise protected.  If you feel you have reached this page in error, please return to the login page and try again, or contact the webmaster if you continue to have problems.";
	$redirect_to = "";
	break;

	# "404 - Not Found"
	case 404:
	$error_code = "404 - Not Found";
	$explanation = "The requested resource '" . $page_redirected_from . "' could not be found on this server.  Please verify the address and try again.";
	//$redirect_to = $server_url . "wiki" . $end_of_path;
	$redirect_to = "";
	break;

	# "500 - Internal Server Error"
	case 500:
	$error_code = "500 - Internal Server Error";
	$explanation = "The server experienced an unexpected error.  Please verify the address and try again.";
	$redirect_to = "";
	break;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
	if ($redirect_to != "") {
?>
<meta http-equiv="Refresh" content="5; url='<?php print($redirect_to); ?>'">
<?php
	}
?>
<title>Oops!</title>
<style type="text/css">
body {
    background: #fff url(/images/bkg-404.png) no-repeat 0 0;
    padding: 0;
    margin: 0;
    font-family: arial,helvetica,lucida,verdana,sans-serif;
    font-size: 12px;
    color: #444;
}
a {
    text-decoration: none;    
    color: #115bb5;
}
a:hover {
    text-decoration: underline;
    color: #03408a;
    /*color: #ec008c;*/
}
h1 { 
    font-size: 60px; 
    color: #000;
}
h3 { 
    font-size: 16px; 
    color: #000;
}
#content {
    padding: 80px 0 0 450px;
    width: 400px;
}
</style>
</head>
<body>
<div id="content">
    <h1>Oops!</h1>
    <h3>Error Code <?php print ($error_code); ?></h1>
    <p>The <a href="http://en.wikipedia.org/wiki/Uniform_resource_locator">URL</a> you requested was not found. <?PHP echo($explanation); ?></p>
    <p>You may want to try starting from the home page: <a href="<?php print ($server_url); ?>"><?php print ($server_url); ?></a></p>
</div>
</body>
</html>
