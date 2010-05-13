<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>
    <? 
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
    <style type="text/css">
        body { background: #fff; padding: 0; }
        .container_12 { margin: 0 auto; }
    </style>
</head>
  
<body>
<a name="top"></a>
<div class="navbar">
    <div class="navbar-inner">
        <a href="/demo">Back to OExchange Demos</a>
    </div>
</div>
<div class="container_12">
	
