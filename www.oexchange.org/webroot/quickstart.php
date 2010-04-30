<?php
$page_title = "OExchange";
include 'header.php';
?>

<div class="grid_3 omega right">
    <div class="gbox">
        <ol>
            <li><a href="#services">For Services</a></li>
            <li><a href="#tools">For Sharing Tools</a></li>
        </ol>
    </div>
</div>
<div class="grid_8 suffix_1 alpha">

<h1>OExchange Quick Start Guide</h1>

<a name="services"></a>        
<h2>For Services</h2>
<p>
Ok, I'm a service that can accept URLs.  What do I do?
</p>
<h5>1. Become a Standard Endpoint</h5>
<p>
If you're a service that can receive third party content then you probably have a URL that you use for people to pass you that content.  We call this the "sharing endpoint."  The first thing you need to do is make sure that yours uses the standard URL parameters, like this...
</p>
<pre>http://www.example.com/share.php?url={URI}&title={title}</pre>
<p>
The "url" parameter is required.  Depending on your use case, there may be additional parameters that you should use.   Check the spec for more information.
</p>

<h5>2. Become Discoverable</h5>
<p>
Now that third party tools know how to share content to you, they need to be able to discover you.   You do this in 2 steps...
<ol>
	<li>Describe your service, in an XRD file.</li>
	<li>Attach a link tag to your web page that points to the XRD file or declare the XRD file in "/.well-known/host-meta".</li>
</ol>	
</p>

<h5>You're done.</h5>
<p>
	Anyone with a sharing tool, will now be able to discover that they can and how they can share to you.
</p>

<a name="tools"></a>        
<h2>For Sharing Tools</h2>
<p>
    Want to start leveraging OExchange to share content?  Things you need to know...
</p>
<h5>1. Targets accept content in a standard way</h5>
<p>
	lorem ipsum
</p>
<h5>2. You can locate targets automatically</h5>
<p>
	lorem ipsum
</p>
<h5>3. The rest is your call</h5>
<p>
	lorem ipsum
</p>

</div>

<?php
include 'footer.php';
?>
