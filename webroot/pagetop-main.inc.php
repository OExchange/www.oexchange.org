<?
$stylesheets = array("960.css", "site.css");
include 'head.inc.php';
?>

<body>
<a name="top"></a>
<div class="container_12">
    <div id="header">
        <div class="grid_2 alpha">
            <h1><a href="/">OExchange</a></h1>
        </div>
        <div class="grid_7 navlinks">            			
			<a href="/guide/"<?php if($nav=='start') { ?> class="nav-active"<?php }?>>Get Started</a>
            <a href="/spec/"<?php if($nav=='spec') { ?> class="nav-active"<?php }?>>Spec</a>
            <a href="/tools/"<?php if($nav=='tools') { ?> class="nav-active"<?php }?>>Tools</a>
            <a href="/demo/"<?php if($nav=='demo') { ?> class="nav-active"<?php }?>>Demo</a>
            <a href="http://groups.google.com/group/oexchange">Discuss</a>
        </div>
        <div class="grid_3 omega right">
            <?php include 'share.inc.php' ?>
        </div>
        <div class="clear"></div>
    </div>
    
    <div class="grid_2 alpha">&nbsp;</div>
    <div class="grid_10 omega">	
