<?

/**
* Creates the HEAD of the page, for inclusion in every page.  Looks for variables to set up styles and such:
* $stylesheets: array of relative css urls
* $scriptFiles: array of abs-path js files
* $styleBlocks: array of style blocks to include directly in the head
*/

include "config.inc.php";
 
if (!isset($nav)) $nav = '';
if (isset($page_title)) { 
    $ptitle = $page_title;
} else {
    $ptitle = "OExchange";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">

<head>
    <title><?= $ptitle?></title>
	<meta property="og:title" content="<?= $ptitle?>"/>
	<meta property="og:site_name" content="OExchange"/>
	<meta property="og:image" content="<?= $CFG_IMAGEBASE_URL ?>/logo_128x128.png"/>
	<meta name="robots" content="all" />
	<meta http-equiv="keywords" content="OExchange, share, widget, oEmbed, OAuth, XRD, Host-Meta, LRDD, social, WebFinger, sharing" />
	<meta http-equiv="description" content="<?= $ptitle?>" />
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<link rel="icon" type="image/png" href="<?= $CFG_IMAGEBASE_URL ?>/logo_16x16.png" />
	<link rel="http://oexchange.org/spec/0.8/rel/related-target" type="application/xrd+xml" href="http://www.oexchange.org/demo/linkeater/oexchange.xrd">
	<?
		if ($stylesheets) {
			foreach ($stylesheets as $stylesheet) {
			    echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"" . $CFG_CSSBASE_URL . "/" . $stylesheet . "\" />\n";
			}
		}
		if ($scriptFiles) {
			foreach ($scriptFiles as $scriptFile) {
			    echo "<script type=\"text/javascript\" src=\"" . $scriptFile . "\"></script>\n";
			}
		}
		if ($styleBlocks) {
			foreach ($styleBlocks as $styleBlock) {
			    echo "<style type=\"text/css\">" . $styleBlock . "</style>\n";
			}
		}
	?>
</head>
