<?php
$page_title = "OExchange Best Practices";
$nav = "tools";
include '../../pagetop-main.inc.php';
?>

    <h2 class="pagetitle">Target Best Practices Guide</h2>

    <hr class="mb10"/>
    
    <div class="grid_10 alpha omega"> 
        <!-- 
        <h4 class="mb10">Jump to instructions for:</h4>
        <ul class="bigtext">
            <li><a href="#services">Service Providers</a></li>
            <li><a href="#sites">Publishers</a></li>
            <li><a href="#tools">Tool Developers</a></li>
        </ul>
        <hr/><br/>
              -->   
        
        <a name="service-providers"></a>
        <a name="services"></a>        
        <p>
            As a service provider, there are a few simple best practices to follow when implementing your OExchange Target support.  These will help you improve the user experience and increase traffic to your service.
        </p>
        
        <h3>Welcome new users on your Offer page</h3>
        <p>
			As OExchange discovery helps drive traffic to your site, <em>your Offer endpoint will become a landing page for new users</em>.  Make sure your Offer page is informative and has some useful context for first time visitors.  If you require authentication, make sure there's a sensible, encouraging experience for someone who doesn't have an account, don't just bounce them to an empty login form.  What does your service do?  Why should they register?  Treat your Offer endpoint like you'd treat any other primary landing page, optimize for bounce rate, etc.
        </p>
        <p>
        	<strong>Test your service:</strong>&nbsp;&nbsp;Log out of your site, if appropriate, and share to it using the <a href="/tools/sourceharness/">Offer Test Harness</a>. Will your page make sense to a new user?
        </p>

        <h3>Preserve URL parameters through the login process</h3>
        <p>
			It's common for users to be redirected when they hit your offer endpoint (to perform authentication, for example) before they can do something useful with the shared content.  Make sure that all of the <a href="/spec/#offer-parameters">content parameters</a> are passed through each step in the flow, otherwise the shared content can get dropped and your user will be stranded.  Preferably, you'll preserve the original offer url, intact, and redirect the user there once they've authenticated.  this is a simple enough task from a development perspective but something that often gets overlooked (and frequently broken by even very large service providers).
		</p>
        <p>
        	<strong>Test your service:</strong>&nbsp;&nbsp;Log out of your site, if appropriate, and share to it using the <a href="/tools/sourceharness/">Offer Test Harness</a>. Once you've landed on your share page (logging in if necessary), make sure that all of the OExchange parameters you support made it through.  If you have a form, make sure the fields are correctly populated.
        </p>

        <h3>Check your URL encoding and decoding</h3>
        <p>
        	Make sure you preserve URL encoding when passing parameters around within your site, over-decoding can cause shared URLs to be stripped of their parameters.  For example, if I was to share <code>http://myblog.com?a=1&amp;b=2</code> to your site it might look like this:
		</p>
		<pre>http://example.com/offer?url=http%3A%2F%2Fmyblog.com%3Fa%3D1%26b%3D2</pre>
		<p>
			If you redirect the user through your login page and don't preserve the url encoding, you could end up with this mess:
		</p>
		<pre>http://example.com/offer?url=http://myblog.com?a=1&amp;b=2</pre>
		<p>
			Most websites will interpret this with the "<code>b=2</code>" parameter belonging to the outer "example.com" url, stripping it from the "myblog.com" url that was shared.  Similarly, make sure you use proper escaping on HTML pages (watch those &amp;'s) and make sure you can handle UTF-8 content. 
		</p>
		<p>
        	<strong>Test your service:</strong>&nbsp;&nbsp;Share an URL with parameters to your site using the <a href="/tools/sourceharness/?url=http%3A%2F%2Fmyblog.com%3Fa%3D1%26b%3D2">Offer Test Harness</a>.  Enter your offer endpoint, click through to your site and submit your form (if applicable).  Verify that the url that you received kept the "myblog.com" parameters intact and that they weren't stripped anywhere in the workflow.
        </p>

        <h3>Don't resize the browser window</h3>
        <p>
			OExchange offers will typically open your endpoint in a new tab in an existing browser window.  Don't use any code that will resize the window, as this could affect the whole browser and be disruptive to the user experience and other sites the user may be browsing.  Please consider your whole sharing and authentication workflow; some sites have login forms and bookmarklet-launched sharing pages that resize because they expect to be displayed in a popup.  
		</p>
        
    </div>   
    <div class="clear"></div>

<?php
include '../../pagebottom.inc.php';
?>
