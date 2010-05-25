<div class="share">                        
    Share: 
    <a title="Share to Facebook" target="_blank" 
        href="http://www.facebook.com/share.php?u=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])  ?>"><img src="/images/facebook-16px.png" border="0" alt="Share on Facebook" /></a> 
    <a title="Share to Twitter" target="_blank" 
        href="http://twitter.com/home?status=<?php echo urlencode("An open protocol for sharing on the web: " . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . " #oexchange")  ?> "><img src="/images/twitter-16px.png" border="0" alt="Post to Twitter" /></a> 
    <a title="Post on Google Buzz" target="_blank"
        href="http://www.google.com/buzz/post?message=<? echo urlencode("An open protocol for sharing on the web") ?>&imageurl=<? echo urlencode('http://' . $_SERVER['HTTP_HOST'] . "/images/logo_128x128.png") ?>&url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])  ?>"><img src="/images/google-buzz-16px.png" border="0" alt="Post to Google Buzz" /></a>
</div>        
