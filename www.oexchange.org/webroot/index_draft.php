<?php
$page_title = "OExchange";
include 'header.php';
?>

<div class="banner">
	<h1>Let your content roam the web.  Its a big place.</h1>
	<h3>OExchange is an <a href="/spec">open specification</a> for distributed content sharing on the web.</h3>
	<p>Send content to any service on the web.  Locate new services automatically.  Personalize the services available to users.</p>
</div>
	
<p>
	Tweeting on Twitter?  Sharing on Facebook?  Sure thing.  But what posting to your favorite off-beat forum?  Or translating and printing?  What if your browser and your sharing tools could automatically figure out what options make sense for you, as you browse the web?
</p>
<p>OExchange is an open specification that defines:</p>
<ul>
	<li>A simple method for <b>sending URL-based content to a web-based service</b>.  Send a set of defined parameters via HTTP to a well-defined endpoint.</li>
	<li>A mechanism for <b>specifying and discovering available services automatically</b>. Find services by hostname, using XRD and /.well-known/host-meta, or from web pages, with page-level link tags.</li>
	<li>A method for users to register preferences for <b>fully-personalized, no-NASCAR sharing.</b>  Use WebFinger to include OExchange Target preferences in a decentralized and user-centric way</li>	
</ul>
<p>This specification is interoperable now, with <strong>services live on the web today</strong>.</p>	
<p>Jump right into <a href="/spec">the specification</a>, or <a href="http://groups.google.com/group/oexchange">get involved</a>.</p>	   

<?php
include 'footer.php';
?>



