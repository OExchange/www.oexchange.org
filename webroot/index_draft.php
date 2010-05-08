<?php
$page_title = "OExchange";
include 'header.php';
?>

<div class="banner">
	<h1>Any content, any service.  The web a big place.</h1>
	<h4>
		Share URLs with any service.  Locate new services automatically.  Personalize the services available to users.
		<br/>
		OExchange is an <a href="/spec">open specification</a> for sharing anything, anywhere.
	</h4>
</div>
	
<p>
	Tweeting on Twitter?  Sharing on Facebook?  Sure thing.  But what about posting to your favorite off-beat forum?  Or translating and printing?  What if your browser and your sharing tools could automatically figure out what options make sense for you, as you browse the web?
</p>
<p>OExchange defines:</p>
<ul>
	<li>A standard HTTP endpoint for sending URL content to a web-based service (like http://www.example.com/post?url=http://www.youface.com).</li>
	<li>A way for services to make themselves discoverable automatically (via XRD and .well-known/host-meta).</li>
	<li>A decentralized, user-centric method for tools to store personal service preferences on behalf of users (via WebFinger)</li>	
</ul>
<p>This specification is interoperable now, with <strong>services live on the web today</strong>.</p>	
<p>Take a look at the <a href="quickstart.php">Quick Start</a>, jump right into <a href="/spec">the full specification</a>, or <a href="http://groups.google.com/group/oexchange">get involved</a>.
</p>	   

<?php
include 'footer.php';
?>



