<?php
$page_title = "OExchange Quick Start Guide";
$nav = "start";
include '../header.php';
?>


    <h2 class="pagetitle">Quick Start Guide</h2>
    <?php include '../share.php' ?>
    <hr class="mb10"/>
    
    <div class="grid_10 alpha omega"> 
        
        <h4 class="mb10">Jump to instructions for:</h4>
        <ul class="bigtext">
            <li><a href="#services">Service Providers</a></li>
            <li><a href="#sites">Publishers</a></li>
            <li><a href="#tools">Developers</a></li>
        </ul>
                
        <hr/><br/>
        
        <a name="service-providers"></a>
        <a name="services"></a>        
        <h2>OExchange For Service Providers</h2>
        <p>
            If you manage a service that can accept URLs and do something useful with them (a "Target" in OExchange terms), here's what you need to know to support the protocol.  There's also <a target="_blank" href="/demo/linkeater">an example service</a> you can take a look at.
        </p>
        
        <h4>1. Expose an endpoint to receive URLs in a standard way</h4>
        <p>
            First make sure that your service exposes a URL endpoint at which users, via their browsers, can send it content. 
            Your endpoint needs to be compatible with the OExchange Offer specification.  
            This just means that users can navigate to it with their browser, via an HTTP GET, and that it accepts the standard OExchange URL arguments.    
            In simplest terms:
        </p>
        <pre>http://www.example.com/share.php?url={URI}</pre>
        <p>
            In this case, <code>http://www.example.com/share.php</code> is the Offer endpoint.  Your service must accept the <code>url</code> parameter, but that's it.  Depending on whether you accept richer content types, like images, you may want to accept additional parameters as well (but you don't have to).  Note that your endpoint can be anywhere you want, at any URL, as long as it accepts the right parameters.  
        </p>
        <p>
            The <a target="_blank" href="/spec/#offer">Offer spec</a> has all the extra details on the endpoint.
        </p>
        <p>
        	<strong>TIP:</strong> Use the <a href="/tools/sourceharness/">Offer Test Harness</a> to test your endpoint.
        </p>
        
        <h4>2. Make your service discoverable</h4>
        <p>
            Now that third parties are capable of sharing content to your service, they need to be able to discover that your service exists, and locate its Offer endpoint.  This is optional, but if you don't implement it then anyone that wants to share content to your service will have to look it up in documentation and integrate that way.  The <a href="/tools/discoverygen">Discovery File Generator</a> and <a href="/tools/discoveryharness">Discovery Test Harness</a> can help you set all of this up.  Here's basically what you'll do.
        </p>
        <p>
        	Include the details of your service in an XML file, in a specific format (XRD).  
        	This file will contain things like the name, an icon, and some other information including the actual endpoint.  
        	Read about the complete format <a target="_blank" href="/spec/#target-xrd">in the spec</a>, or just take a look at <a target="_blank" href="/demo/linkeater/oexchange.xrd">an example</a>.  You can place this file on your domain anywhere you'd like.
        </p>
        <p>
        	To allow third parties to discover your service from its hostname, include a reference to the XRD file in your site's <code>/.well-known/host-meta</code> file.  
        	If you don't have one, its easy to create.  
        	Read more about it <a target="_blank" href="/spec/#discovery-hostmeta">in the spec</a>, or just <a target="_blank" href="/.well-known/host-meta">look at an example</a>.
        </p>
        <p>
        	Lastly, you can also add a specific HTML tag to any page on your site, to point to a related service.  
        	This works just like adding RSS feed indicators to your pages, for example.  
        	The tag will look something like the following, with an <code>href</code> that points to your service's XRD file.
        </p>
        <pre>&lt;link rel="http://oexchange.org/spec/0.8/rel/related-target" type="application/xrd+xml" href="http://www.example.com/linkeater/oexchange.xrd"/&gt;</pre>
        <p>
        	You can read more about this tag and its purpose, as usual, <a href="/spec/#discovery-page">in the spec</a>.
        </p>
        <p>
        	<strong>TIP:</strong> Remember that the <a href="/tools/discoverygen">Discovery File Generator</a> can help you generate all of the files you need, and the <a href="/tools/discoveryharness">Discovery Test Harness</a> can help you test compliance.
        </p>
        
        <h4>3. You're done.</h4>
        <p>
        	Once you've got a compliant Offer endpoint, a Target XRD that describes your service, and a host-meta resource that lets it be found automatically, your service is ready to accept content from any client on the web!
        </p>
        
        
        <br/><hr/><br/>
        
        
        <a name="publishers"></a>
        <a name="sites"></a>        
        <h2>OExchange For Publishers</h2>
        <p>
            If you're a site that has content to share (a "source" in OExchange terms), you can of course use one of the many sharing aggregators and tools that are out there.  If you want to build your own sophisticated, personalized sharing options yourself, take a look at the information intended for these <a href="#tools">tools</a>.  If you just want to make your own icons and link to the URLs of various services, then all you need to do is link to their Offer endpoints directly.  These look something like:
        </p>
        <pre>http://www.example.com/share.php?url={URI}</pre>
        <p>
            Once you know the core Offer endpoint, then the arguments will be the same no matter which services you are using.  You can implement the most basic sharing icon like this:
        </p>
        <pre>&lt;a href="{service offer endpoint}?url=http://www.example.com"&gt;&lt;img href="{service image here}"&gt;&lt;/a&gt;</pre>
        <p>
            OExchange means that every service accepts the same parameters, all that changes is the offer endpoint URLs; a big improvement over the range of URL patterns in use otherwise.
        </p>
        <p>
            Usually, you will get the offer endpoint location from the service's documentation since you're not figuring it out dynamically at runtime.  If you'd rather do it automatically, then you're operating more like a sharing tool and should probably take a look <a href="#tools">at that guide</a>.
        </p>
        
        
        <br/><hr/><br/>
        
        
        <a name="developers"></a>
        <a name="tools"></a>        
        <h2>OExchange For Developers</h2>
        <p>
            Want to start leveraging OExchange to share content?  Things you need to know...
        </p>
        
        <h4>1. Targets accept content in a standard way</h4>
        <p>
        	If you want to send content to an OExchange-compliant service, all you'll need to do is send the browser to the service's Offer endpoint.  This is a URL that looks something like:
        </p>
        <pre>http://www.example.com/share.php?url={URI}</pre>
        <p>
            There are a bunch of optional parameters you can pass, but really <code>url</code> is the only one that's actually required.  Take a look at the <a target="_blank" href="/spec/#offer">Offer spec</a> for more information on the exact details of the Offer endpoint.
        </p>
        
        <h4>2. You can locate targets automatically</h4>
        <p>
            The more powerful capability of services that support OExchange is their ability to be discovered automatically.  If you know a hostname, for example, you can figure out if there is a service that accepts links there like this:
        </p>
        <ol>
        	<li>Look for a document at the host's <code>/.well-known/host-meta</code> path.</li>
        	<li>If there is one, look for a Link element inside this, with a relation type of <code>http://oexchange.org/spec/0.8/rel/resident-target</code>.</li>
        	<li>If there is one, this describes the path of a an XML document (or several) that describes the service.</li>
        	<li>Look up that XRD document, which will describe everything about the service, including the URL for its Offer endpoint.</li> 
        </ol>
        <p>
            Read more about this discovery flow, and the formats of the two documents, <a target="_blank" href="/spec/#discovery">in the specification</a>.  You can also take a look at the example <a href="/demo/linkeater">LinkEater service</a>, and even use the <a href="/tools/discoveryharness">discovery Test Harness</a> to check hosts automatically.
        </p>
        <p>
            Additional options for locating services are by looking for meta tags in HTML pages that point to related services, or even using WebFinger to look up and record user service preferences.  Take a look at the <a target="_blank" href="/spec/#discovery-page">page metatag</a> and <a href="/spec/#discover-personal">personal XRD</a> specifications.	
        </p>
        	
        <h4>3. The rest is your call</h4>
        <p>
        	What you do with all these capabilities as a sharing tool is up to you, thats the value you're adding!
        </p>
        
    </div>   
    <div class="clear"></div>

<?php
include '../footer.php';
?>
