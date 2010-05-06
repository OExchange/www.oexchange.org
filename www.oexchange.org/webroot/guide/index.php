<?php
$page_title = "OExchange Quick Start Guide";
include '../header.php';
?>

<div class="grid_3 omega right">
    <div class="gbox">
        <h4>Table of Contents</h4>
        <ol>
            <li><a href="#services">Guide for Services</a></li>
            <li><a href="#services">Guide for Publishers</a></li>
            <li><a href="#tools">Guide for Sharing Tools</a></li>
        </ol>
    </div>
</div>
<div class="grid_8 suffix_1 alpha">

<h1>Quick Start Guide</h1>
<p>
This'll help you get up and running...whether you're a <a href="#services">service that can accept content</a> a site that <a href="#sites">has content to share</a>, or a <a href="#tools">sharing tool</a> of some sort.  And remember that OExchange isn't limited to "sharing" things, it applies to any case where one service wants to send URL-based content to another.  Translation and printing services, social networks, bookmarking, microblogging platforms, whatever.
</p>
 
<a name="services"></a>        
<h2>OExchange For Services</h2>
<p>
If you're a service that can accept URLs and do something useful with them, then in OExchange terms you're referred to as a "target".  These steps'll tell you what you need to know.  There's also an example of all of this, <a target="_blank" href="/demo/linkeater">the LinkEater service</a>.
</p>
<h5>1. Expose an endpoint to receive URLs in a standard way</h5>
<p>
The first thing you'll need to do is make sure that your service exposes a URL endpoint at which users, via their browsers, can send you content. 
Your endpoint needs to be compatible with the OExchange Offer specification.  
This just means that users can navigate to it with their browser, via an HTTP GET, and that it accepts the standard OExchange URL arguments.  
For example:
</p>
<pre>http://www.example.com/share.php?url={URI}&title={title}</pre>
<p>
In this case, <code>http://www.example.com/share.php</code> is the endpoint.  Your service must accept the <code>url</code> parameter, but that's all thats required.  Depending on whether you accept richer content types, like images, there may be other parameters that you will want to accept as well (but you don't have to).  And note that your endpoint can be anywhere you want, at any URL, as long as it accepts the right parameters.  
</p>
<p>
Take a look at the <a target="_blank" href="/spec/#offer">Offer spec</a> for more information on the exact details of the Offer endpoint.
</p>
<p>
	<b>TIP:</b> Use the <a href="/tools/sourceharness/">Source Test Harness</a> to test out your endpoint!
</p>

<h5>2. Make your service discoverable by clients on the web</h5>
<p>
Now that third parties are capable of sharing content to your service, they need to be able to discover that your service exists.  This is optional, but its really the best way to allow your tool to be interoperable with the web.  The <a href="/tools/discoverygen">Discovery File Generator</a> and <a href="/tools/discoveryharness">Discovery Test Harness</a> can help you set all of this up.
</p>
<p>
	Include the details of your service in an XML file, in a specific format (XRD).  
	This file will contain things like the name, an icon, and some other information including the actual endpoint.  
	You can read about the complete format <a target="_blank" href="/spec/#target-xrd">in the spec</a>, or just take a look at <a target="_blank" href="/demo/linkeater/oexchange.xrd">an example</a>.  You can place this file on your domain anywhere you'd like.
</p>
<p>
	To allow third parties to discover your service from its hostname, include a reference to the XRD file in your site's <code>/.well-known/host-meta</code> file.  
	This file just helps clients locate available services on your host.  If you don't have one, its easy to create.  Read more about it in the spec, <a target="_blank" href="/spec/#discovery-hostmeta">here</a>, or just <a target="_blank" href="/.well-known/host-meta">look at an example</a>.
</p>
<p>
	Lastly, you can also add a specific HTML tag to any page on your site, to point to a related service.  
	This works just like adding RSS feed indicators to your pages, for example.  
	The tag will look something like the following, with an <code>href</code> that points to your service's XRD file.
</p>
<pre>&lt;link rel="http://oexchange.org/spec/0.8/rel/related-target" type="application/xrd+xml" href="http://www.example.com/linkeater/oexchange.xrd"/&gt;
</pre>
<p>
	You can read more about this tag and its purpose, as usual, <a href="/spec/#discovery-page">in the spec</a>.
</p>
<p>
	<b>TIP:</b> Remember that the <a href="/tools/discoverygen">Discovery File Generator</a> can help you generate all of the files you need, and the <a href="/tools/discoveryharness">Discovery Test Harness</a> can help you test compliance.
</p>
<h5>3. You're done.</h5>
<p>
	Your service is now ready to accept content from any client on the web!
</p>

<a name="sites"></a>        
<h2>OExchange For Content Publishers</h2>
<p>
    If you're a content publisher (a "source" in OExchange terms) that has content to share, you can of course use one of the many sharing aggregators and tools that are out there.  If you want to build your own sophisticated, personalized sharing options, take a look at the information for <a href="#tools">sharing tools</a>.  If you just want to make your own icons and link to the URLs of various services, then all you need to do is link to their Offer endpoints directly.  These look something like:
</p>
<pre>http://www.example.com/share.php?url={URI}</pre>
<p>
Once you know the core Offer endpoint, then the arguments will be the same no matter which services you are using.  You can implement the most basic sharing icon like this:
</p>
<pre>&lt;a href="{service offer endpoint}?url=http://www.example.com"&gt;&lt;img href="{service image here}"&gt;&lt;/a&gt;</pre>
<p>
This is a big improvement over the range of URL patterns in use otherwise.
</p>
<p>Usually, you will get the offer endpoint location from the service's documentation since you're not figuring it out dynamically at runtime.  If you'd rather do it automatically, then you're operating more like a sharing tool and should probably take a look <a href="#tools">at that guide</a>.
</p>

<a name="tools"></a>        
<h2>OExchange For Sharing Tools</h2>
<p>
    Want to start leveraging OExchange to share content?  Things you need to know...
</p>
<h5>1. Targets accept content in a standard way</h5>
<p>
	If you want to send content to an OExchange-compliant service, all you'll need to do is send the browser to the service's Offer endpoint.  This is a URL that looks something like:
</p>
<pre>http://www.example.com/share.php?url={URI}</pre>
<p>
There are a bunch of optional parameters you can pass, but really <code>url</code> is the only one that's actually required.  Take a look at the <a target="_blank" href="/spec/#offer">Offer spec</a> for more information on the exact details of the Offer endpoint.
</p>

<h5>2. You can locate targets automatically</h5>
<p>
The more powerful capability of services that support OExchange is their ability to be discovered automatically.  If you know a hostname, for example, you can figure out if there is a service that accepts links there like this:
</p>
<p>
<ol>
	<li>Look for a document at the host's <code>/.well-known/host-meta</code> path.</li>
	<li>If there is one, look for a Link element inside this, with a relation type of <code>http://oexchange.org/spec/0.8/rel/resident-target</code>.</li>
	<li>If there is one, this describes the path of a an XML document (or several) that describes the service.</li>
	<li>Look up that XRD document, which will describe everything about the service, including the URL for its Offer endpoint.</li> 
</ol>
</p>	
<p>
Read more about this discovery flow, and the formats of the two documents, <a target="_blank" href="/spec/#discovery">in the specification</a>.  You can also take a look at the example <a href="/demo/linkeater">LinkEater service</a>, and even use the <a href="/tools/discoveryharness">discovery Test Harness</a> to check hosts automatically.
</p>
<p>
Additional options for locating services are by looking for meta tags in HTML pages that point to related services, or even using WebFinger to look up and record user service preferences.  Take a look at the <a target="_blank" href="/spec/#discovery-page">page metatag</a> and <a href="/spec/#discover-personal">personal XRD</a> specifications.	
</p>
	
<h5>3. The rest is your call</h5>
<p>
	What you do with all these capabilities as a sharing tool is up to you, thats the value you're adding!
</p>

</div>

<?php
include '../footer.php';
?>
