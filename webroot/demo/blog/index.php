<?php
$page_title = "OExchange Demo Blog";
include '../../pagetop-blog.inc.php';
?>

<div id="wrapper">    
    <div class="header">
        <h1>Demo Blog</h1>        
    </div>
    <div class="content">
        <!-- Blog Post -->
        <div class="post">
            <h2>Lorem ipsum dolor sit amet</h2>
            <img src="<?= $CFG_IMAGEBASE_URL ?>/blog/big_dog_little_dog2.jpg" border="0" alt="" align="right" class="thumb" />
            <h4>Consectetur adipiscing elit. Pellentesque sapien magna.</h4>
            <p>Lorem ipsum <a href="">dolor sit amet</a>, consectetur adipiscing elit. Integer accumsan ultrices velit venenatis sollicitudin. Cras in erat dui, vel varius risus. Maecenas lobortis, diam ut sodales vestibulum, diam libero porttitor est, id tristique elit tellus nec ipsum. Duis mi tellus, tincidunt ac pharetra eu, vehicula et sapien. Cras in erat dui, vel varius risus. Maecenas lobortis, diam ut sodales vestibulum, diam libero porttitor est, id tristique elit tellus nec ipsum. Cras in erat dui, vel varius risus. Maecenas lobortis, diam ut sodales vestibulum, diam libero porttitor est, id tristique elit tellus nec ipsum.</p>
            
            <p>Demo sharing tool:</p>
			<div class="oexchange_toolbox">
				<div class="custom_images">
					<a class="oexchange-share" href="#" ox:pref="1" ox:xrd="http://oexchange-facebook.appspot.com/oexchange/oexchange.xrd"></a>
					<a class="oexchange-share" href="#" ox:pref="2" ox:xrd="http://oexchange-buzz.appspot.com/buzz/oexchange.xrd"></a>
					<a class="oexchange-share" href="#" ox:pref="3" ox:xrd="http://oexchange-twitter.appspot.com/oexchange/oexchange.xrd"></a>
					<a class="oexchange-share" href="#" ox:pref="4" ox:xrd="http://oexchange-digg.appspot.com/oexchange/oexchange.xrd"></a>
					<a class="oexchange-share" href="#" ox:pref="5" ox:xrd="http://oexchange-delicious.appspot.com/oexchange/oexchange.xrd"></a>
                    <a class="oexchange-personalize" href="#">Edit this list</a>
				</div>
			</div>
			<p></p> 
        </div>
        
        <div id="tt1" class="tt" style="position:absolute;top:145px;left:25px;display:none;">
            <div class="tt-x" title="Close" onclick="$('#tt1').fadeOut();"></div>
            <div class="tt-inner">
                These buttons give you choices for acting on this blog post. You can update them with new OExchange-enabled services.<br/><br/>
                To see it in action, browse to <a href="/demo/linkeater/?demo=true">LinkEater</a>, an example of a new service that happens to support OExchange.
            </div>
            <div class="tt-tick"></div>
        </div>
        
    </div>
    <div class="sidebar">
        <h3>Archive</h3>
        
        <h4>April, 2010</h4>
        <ul>
            <li><a href="">Proin est arcu, sodales sed</a></li>
            <li><a href="">Viverra et, ultricies in dui</a></li>
            <li><a href="">Maecenas a dui nec dui</a></li>
            <li><a href="">Sollicitudin fringilla</a></li>
            <li><a href="">Aenean ut tempus nulla</a></li>
            <li><a href="">Sed accumsan placerat massa</a></li>
        </ul>
        
        <h4>March, 2010</h4>
        <ul>
            <li><a href="">Nec rhoncus nec, iaculis eget</a></li>
            <li><a href="">Proin est arcu, sodales sed</a></li>
            <li><a href="">Viverra et, ultricies in dui</a></li>
        </ul>
        
        <p><a href="">More...</a></p>
        
    </div>
    <div class="clear"></div>
    <div class="footer">&copy; 2010 MyBlog</div>
</div>

<script type="text/javascript">
var oex_demo = true;
$(document).ready(
    function() {
        $('.oexchange-personalize').oexchange_console();
        $('.oexchange-share').oexchange_share();
    }
);
setTimeout("$('#tt1').fadeIn();",1000)
</script>
<script type="text/javascript" src="/tools/badge/jquery.oexchange.js"></script>
<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/ga.inc.php");
?>

</body>
</html>
