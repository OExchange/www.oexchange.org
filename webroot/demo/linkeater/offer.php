<?
$url = $_GET["url"];
$ctype = $_GET["ctype"];
$title = $_GET["title"];
$description = $_GET["description"];

$page_title = "LinkEater Example OExchange Target";
require_once("../../pagetop-demo.inc.php");
require_once("../../lib-oexchange/OExchangeDiscoverer.php");

if (!isset($url)) {
	error("Missing URL (the only required parameter).");
} else {
?>
    <div class="grid_6 alpha">
        <h2>Yum!</h2>
        
        <h4>Here's what you gave me...</h4>        
        <table class="dtbl">
        <thead>
            <tr><th>Param</th><th>Value</th></tr>
        </thead>
        <tbody>
            <tr>
                <td><code>url</code></td>
                <td><?= $url?></td>
            </tr>
            <tr class="alt">
                <td><code>Title</code></td>
                <td><? echo (isset($title) ? $title : "-not provided-") ?></td>
            </tr>
            <tr>
                <td><code>Description</code></td>
                <td><? echo (isset($description) ? $description : "-not provided-") ?></td>
            </tr>
        </tbody>
        </table>
                
        <h4>Type-specific information:</h4>
        <p>
        <?
            echo '<table class="dtbl"><thead><tr><th>Param</th><th>Value</th></tr></thead><tbody>';
            
        if (!isset($ctype)) {
        	echo "<td><code>ctype</code></td><td>-not provided- (defaulting to 'link')</td></tr>";
        	$ctype = "link";
        } else {	
        	echo "<td><code>ctype</code><td><td>" . $ctype . "</td></tr>";
        } 
        if ($ctype == 'link') {
        	echo "<td><code>tags</code></td><td>" . (isset($_GET["tags"]) ? $_GET["tags"] : "-not provided-") . "</td></tr>";
        } else if ($ctype == 'image') {
        	echo "<td><code>imageurl</code></td><td>" . (isset($_GET["imageurl"]) ? $_GET["imageurl"] : "-not provided-") . "</td></tr>";
        	echo "<td><code>height</code></td><td>" . (isset($_GET["height"]) ? $_GET["height"] : "-not provided-") . "</td></tr>";
        	echo "<td><code>width</code></td><td>" . (isset($_GET["width"]) ? $_GET["width"] : "-not provided-") . "</td></tr>";
        } else if ($ctype == 'flash') {
        	echo "<td><code>swfurl</code></td><td>" . (isset($_GET["swfurl"]) ? $_GET["swfurl"] : "-not provided-") . "</td></tr>";
        	echo "<td><code>height</code></td><td>" . (isset($_GET["height"]) ? $_GET["height"] : "-not provided-") . "</td></tr>";
        	echo "<td><code>width</code></td><td>" . (isset($_GET["width"]) ? $_GET["width"] : "-not provided-") . "</td></tr>";
        	echo "<td><code>screenshot</code></td><td>" . (isset($_GET["screenshot"]) ? $_GET["screenshot"] : "-not provided-") . "</td></tr>";
        
        } else if ($ctype == 'iframe') {
        	echo "<td><code>iframeurl</code></td><td>" . (isset($_GET["iframeurl"]) ? $_GET["iframeurl"] : "-not provided-") . "</td></tr>";
        	echo "<td><code>height</code></td><td>" . (isset($_GET["height"]) ? $_GET["height"] : "-not provided-") . "</td></tr>";
        	echo "<td><code>width</code></td><td>" . (isset($_GET["width"]) ? $_GET["width"] : "-not provided-") . "</td></tr>";
        	echo "<td><code>screenshot</code></td><td>" . (isset($_GET["screenshot"]) ? $_GET["screenshot"] : "-not provided-") . "</td></tr>";
        }
        echo "</tbody></table>";
        ?>
        
        <br/>
        
        <h3>WTF?</h3>
        <p>This is a simple example OExchange Target, to which you can send a link.  You didn't expect me to do anything useful with it, did you?</p>
        <p><a href="/demo/linkeater/">&laquo; Back to LinkEater</a></p>
        
        
    </div>
    <div class="grid_6 omega">
        <div class="funny-monster"></div>
    </div>
    <div class="clear"></div>  
<?
	include("../../pagebottom.inc.php");
}

function error($msg) {
	echo "<p>Sorry, something wasn't right.</p>";
	echo $msg;
}
?>