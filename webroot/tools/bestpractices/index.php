<?php
$page_title = "OExchange Quick Start Guide";
$nav = "start";
include '../../pagetop-main.inc.php';
?>

    <h2 class="pagetitle">OExchange Best Practices</h2>

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
        <h2>Best Practices For Service Providers</h2>
        <p>
            If you are an OExchange Service Provider, there are a few best practices you should follow to improve your user experience and increase traffic.
        </p>
        
        <h3>Welcome New Users</h3>
        <p>
			OExchange discovery will help drive traffic to your site and your Offer endpoint can be a landing page for new users.  Make sure your Offer page is informative and has some useful context for first time visitors.  If you require authentication, make sure there's a sensible, encouraging experience for someone who doesn't have an account, don't just bounce them to an empty login form.  What does your service do?  Why should they register?
        </p>
        <p>
        	<strong>Test your service:</strong>&nbsp;&nbsp;Log out of your site and share to it using the <a href="/tools/sourceharness/">Offer Test Harness</a>. Will your page make sense to a new user?
        </p>

        <h3>Preserve Parameters on Login</h3>
        <p>
			It's common for users to be redirected when they hit an offer endpoint (authentication, for example) before they can do something useful with the shared content.  Make sure that all of the <a href="/spec/#offer-parameters">content parameters</a> are passed through each step in the flow, otherwise the shared content can get dropped and your user will be stranded.  Preferrably you'll preserve the original offer url, intact, and redirect the user there once they've authenticated.
		</p>
        <p>
        	<strong>Test your service:</strong>&nbsp;&nbsp;Log out of your site and share to it using the <a href="/tools/sourceharness/">Offer Test Harness</a>. Once you've landed on your share page (logging in if necessary), make sure that all of the oexchange parameters you support made it through.  If you have a form, make sure the fields are correctly populated.
        </p>

        <h3>Check Your URL Encoding and Decoding</h3>
        <p>
        	Make sure you preserve URL encoding when passing parameters around within your site, over decoding can cause shared urls to be stripped of their parameters.  For example, if I was to share <code>http://myblog.com?a=1&amp;b=2</code> to your site it might look like this:
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

        <h3>Don't Resize the Browser</h3>
        <p>
			OExchange offers will typically open your endpoint in a new tab in an existing browser window.  Don't use any code that will resize the window, this could affect the whole browser and be disruptive to the user experience.  Please consider your whole sharing and authentication workflow,	some sites have login forms and bookmarklet-launched sharing pages that resize because they expect to be displayed in a popup.  
		</p>
        
    </div>   
    <div class="clear"></div>

<?php
include '../../pagebottom.inc.php';
?>
