<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>
    <? 
    if (isset($page_title)) { 
	    $title = $page_title;
	} else {
	    $title = "OExchange";
	}
	echo $title;
    ?>
    </title>
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />    
	<meta name="robots" content="all" />
	<meta http-equiv="keywords" content="OExchange, share, widget, oEmbed, OAuth, social, Webfinger, sharing" />
	<meta http-equiv="description" content="<?= $title?>" />
	<link rel="stylesheet" type="text/css" media="all" href="/styles/reset.css" />
    <link rel="stylesheet" type="text/css" media="all" href="/styles/text.css" />
    <link rel="stylesheet" type="text/css" media="all" href="/styles/960.css" />
	<link rel="stylesheet" type="text/css" media="all" href="/styles/main.css">
</head>
  
<body>
<a name="top"></a>
<div class="container_12">
	<div id="header">
		<div class="grid_9 alpha"><h1>OExchange</h1></div>
		<div class="grid_3 omega right">			
			<a href="http://groups.google.com/group/oexchange">Discuss</a>
			<a href="/test">Test</a>
			<a href="/spec">Spec</a>
		</div>	
		<div class="clear"></div>
	</div>
	
