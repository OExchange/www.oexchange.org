<?php

// Starts a page on the site, writing the page head and starting the body in a sitepage div.  
// Accepts optional variables:
//   $page_title: the title for the page
//   $page_add_head: some arbitrary markup to add to the page head

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>
<?php 
    if (isset($page_title)) { 
	    echo $page_title;
	} else {
	    echo "OExchange Send-To";
	}
?>
    </title>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="oexchange">
	<meta http-equiv="description" content="A demonstration of send-to capabilities using OExchange">
	<link rel="stylesheet" type="text/css" href="main.css">
<?php 
    if (isset($page_add_head)) { 
	    echo $page_add_head;
	}
?>
</head>
<body>
	<div id="outerpage">
