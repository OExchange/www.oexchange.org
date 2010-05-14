<?
$page_title = "OExchange Examples and Demos";
$nav = "demo";
include ("../header.php");
?>
	<h2 class="pagetitle">Examples &amp; Demos</h2>
    
    <hr/>
    
    <p class="mb20">The folling demonstrates OExchange enabled service discovery, service personalization and management via WebFinger protocols:</p>
    
    <div class="grid_7 alpha">
        <object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/ZPBvFXf9Q2U&hl=en_US&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/ZPBvFXf9Q2U&hl=en_US&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>
    </div>
    <div class="grid_3 bigtext omega">
        <h3 class="mb5">Step 1</h3>
        <a href="/demo/blog/">Start at a blog</a> that uses an OExchange enabled sharing tool.<br/>
        
        <h3 class="mb5">Step 2</h3>
        <a href="/demo/linkeater">Visit a service</a> that, via OExchange, can be discovered as a sharing destination. Save the service.<br/>
        
        <h3 class="mb5">Step 3</h3>
        <a href="/demo/blog/">Return to the blog</a>, and note that the new service has been added to the user's favorite sharing destinations.
        
        <!--
        <h4 class="mt0">To walk through the demo:</h4>
        <ol style="padding:0 0 0 20px;">
            <li><a href="/demo/blog/">Start at a blog</a> that uses an OExchange enabled sharing tool.</li>
            <li><a href="/demo/linkeater">Visit a service</a> that, via OExchange, can be discovered as a sharing destination. Save the service.</li>
            <li><a href="/demo/blog/">Return to the blog</a>, and note that the new service has been added to the user's favorite sharing destinations.</li>
        </ol>
        -->
        <p><small>These saved services can be published to the user's WebFinger profile.</small></p>
    </div>
    <div class="clear"></div>        
    
    <br/><hr/>
    
    <h4 class="mb0">Other Examples</h4>
    
    <div class="grid_5 alpha">
        <h3 class="bigger mb5"><a href="./discovery-api/api.php">A JSON Discovery API</a></h3>
        A simple GET/JSON-based Discovery API that can help when using OExchange Discovery and WebFinger together.
    </div>
    <div class="grid_5 omega">
        <h3 class="bigger mb5"><a href="./sendto">Send-To</a></h3>
        The Send-To service uses OExchange and WebFinger protocols together to send links around.
    </div>
    <div class="clear"></div>
    

<?
include("../footer.php");
?>
