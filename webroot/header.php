<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>
    <? 
    if (!isset($nav)) $nav = '';
    if (isset($page_title)) { 
	    $ptitle = $page_title;
	} else {
	    $ptitle = "OExchange";
	}
	echo $ptitle;
    ?>
    </title>
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />    
	<meta name="robots" content="all" />
	<meta http-equiv="keywords" content="OExchange, share, widget, oEmbed, OAuth, social, Webfinger, sharing" />
	<meta http-equiv="description" content="<?= $ptitle?>" />
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" media="all" href="/styles/960.css" />
	<link rel="stylesheet" type="text/css" media="all" href="/styles/site.css">
	<link rel="icon" type="image/png" href="/images/logo_16x16.png" />
	<link rel="http://oexchange.org/spec/0.8/rel/related-target" type="application/xrd+xml" href="http://www.oexchange.org/demo/linkeater/oexchange.xrd">
</head>
  
<body>
<a name="top"></a>
<div class="container_12">
    <div id="header">
        <div class="grid_2 alpha">
            <h1><a href="/">OExchange</a></h1>
        </div>
        <div class="grid_10 omega right">            			
			<a href="/guide"<?php if($nav=='start') { ?> class="nav-active"<?php }?>>Get Started</a>
            <a href="/spec"<?php if($nav=='spec') { ?> class="nav-active"<?php }?>>Spec</a>
            <a href="/tools"<?php if($nav=='tools') { ?> class="nav-active"<?php }?>>Tools</a>
            <a href="/demo"<?php if($nav=='demo') { ?> class="nav-active"<?php }?>>Demo</a>
            <a href="http://groups.google.com/group/oexchange">Discuss</a>
        </div>
        <div class="clear"></div>
    </div>
    
    <div class="grid_2 alpha">&nbsp;</div>
    <div class="grid_10 omega">	
