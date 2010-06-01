<?
$page_title = "OExchange Examples and Demos";
$nav = "demo";
include ("../pagetop-main.inc.php");
?>
	<h2 class="pagetitle">Demos &amp; Examples</h2>
    
    <hr/>
    
    <div class="bannertext dgry mb20">OExchange in action...</div>
    
    <div class="grid_7 alpha">
        <h3>Watch the simple demo video</h3>
        <object width="540" height="328"><param name="movie" value="http://www.youtube.com/v/Be9ArGBUTco&hl=en_US&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/Be9ArGBUTco&hl=en_US&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="540" height="328"></embed></object>
    </div>
    <div class="grid_3 omega">
        <h3>Or try it out!</h3>
        <div class="bluebox">
            <h3 class="smaller mb5">Step 1</h3>
            <a href="/demo/blog/">Start at a blog</a> that uses an OExchange-aware tool to show you some sharing options.
            
            <hr/>
            
            <h3 class="smaller mb5">Step 2</h3>
            <a href="/demo/linkeater/?demo=true">Visit a service</a> that also happens to support OExchange. 'Save' the service.
            
            <hr/>
            
            <h3 class="smaller mb5">Step 3</h3>
            <a href="/demo/blog/">Go back to the blog</a>.  This (totally new) service now appears as an option.
        </div>
    </div>
    <div class="clear"></div>        
    
	<h4 class="mb0">Technically, how does this actually work?</h4>
	<p>
	This is just a simple case of some of the things that are possible when tools and services support the protocol.
	<ul>
		<li>A JavaScript sharing tool keeps track of a set of services in local HTML5 storage.  The services are defined by <a target="_blank" href="/spec/#discovery-targetxrd">Target XRD URIs</a></li>
		<li>The <a target="_blank" href="blog/">example blog</a> embeds this sharing tool, which renders the sharing options onto the page; when you click, you're hitting its <a target="_blank" href="/spec/#offer">Offer endpoint</a></li>
		<li>The sample link-accepting service, <a target="_blank" href="linkeater/">LinkEater</a>, includes the JavaScript badge and tells it the location of its own XRD</li>
		<li>When you 'save' the service, the tool performs <a target="_blank" href="/spec/#discovery">discovery</a> and figures out how to share to the service, then stores that for future use</a></li>
		<li>As an extra bonus, you can also edit the list of services the tool knows about manually, adding any host that supports OExchange</li>   
	</ul>
    </p>

	<br/><hr/>
    
    <h3 class="mb0">Other Examples</h3>
    
    <div class="grid_5 alpha">
        <h4 class="mb5"><a href="./discovery-api/api.php">A JSON Discovery API</a></h4>
        A GET/JSON-based Discovery API that can help when using OExchange Discovery and WebFinger together.
    </div>
    <div class="grid_5 omega">
        <h4 class="mb5"><a href="./sendto/">Web Send-To</a></h4>
        The Send-To service uses OExchange and WebFinger protocols together to send links around.
    </div>

    <div class="clear"></div>

    <div class="grid_5 alpha">
        <h4 class="mb5"><a href="./wrappers/">Popular Service Wrappers</a></h4>
        OExchange-compliant wrappers that demonstrate what it would be like for a few popular services to fully support OExchange discovery.
    </div>
    <div class="grid_5 omega">
        <h4 class="mb5"><a href="/tools/">Other Tools</a></h4>
        Several other tools you can also use for development and testing.
    </div>

    <div class="clear"></div>
    

<?
include("../pagebottom.inc.php");
?>
