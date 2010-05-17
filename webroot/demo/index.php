<?
$page_title = "OExchange Examples and Demos";
$nav = "demo";
include ("../header.php");
?>
	<h2 class="pagetitle">Demo &amp; Examples</h2>
    <hr/>
    
    <div class="bannertext dgry mb40">The following demonstrates OExchange enabled service discovery, service personalization and management via WebFinger protocols.</div>
    
    <div class="grid_7 alpha">
        <object width="540" height="385"><param name="movie" value="http://www.youtube.com/v/ZPBvFXf9Q2U&hl=en_US&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/ZPBvFXf9Q2U&hl=en_US&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="540" height="385"></embed></object>
    </div>
    <div class="grid_3 omega">
        <div class="bluebox">
            <h3 class="smaller mb5">Step 1</h3>
            <a href="/demo/blog/">Start at a blog</a> that uses an OExchange enabled sharing tool.
            
            <hr/>
            
            <h3 class="smaller mb5">Step 2</h3>
            <a href="/demo/linkeater/?demo=true">Visit a service</a> that, via OExchange, can be discovered as a sharing destination. Save the service.
            
            <hr/>
            
            <h3 class="smaller mb5">Step 3</h3>
            <a href="/demo/blog/">Return to the blog</a>, and note that the new service has been added to the user's favorite sharing destinations. 
            These saved services can be published to the user's WebFinger profile.
        </div>
    </div>
    <div class="clear"></div>        
    
    <br/><hr/>
    
    <h3 class="mb0">Other Examples</h3>
    
    <div class="grid_5 alpha">
        <h4 class="mb5"><a href="./discovery-api/api.php">A JSON Discovery API</a></h4>
        A simple GET/JSON-based Discovery API that can help when using OExchange Discovery and WebFinger together.
    </div>
    <div class="grid_5 omega">
        <h4 class="mb5"><a href="./sendto">Send-To</a></h4>
        The Send-To service uses OExchange and WebFinger protocols together to send links around.
    </div>
    <div class="clear"></div>
    

<?
include("../footer.php");
?>
