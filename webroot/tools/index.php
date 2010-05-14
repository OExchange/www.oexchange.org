<?

$page_title = "OExchange Test Tools";
$nav = "tools";
include '../header.php';

?>
    
    <h2 class="pagetitle mb10">Dev &amp; Test Tools</h2>
<!--
    <div class="bannertext">Testing and development aids</div>
-->    
    <hr/>
    
    <div class="grid_5 alpha">
        <h3 class="mb5"><a href="sourceharness">Offer Test Harness</a></h3>
        A harness that can send OExchange Offer requests to Targets.
    </div>
    <div class="grid_5 omega">
        <h3 class="mb5"><a href="/demo/linkeater/">LinkEater Demo Target</a></h3>
        A demo Target that accepts Offer requests, and is discoverable.
    </div>
    <div class="clear"></div>
    
    <br/>
    
    <div class="grid_5 alpha">
        <h3 class="mb5"><a href="/tools/discoverygen/">Discovery Resource Generator</a></h3>
        A tool to generate required discovery files.
    </div>
    <div class="grid_5 omega">
        <h3 class="mb5"><a href="/demo/discovery-api/">Utility API</a></h3>
        A simple JSON-based API to test out OExchange discovery operations.
    </div>
    <div class="clear"></div>
    
    <br/>
    
    <div class="grid_5 alpha">
        <h3 class="mb5"><a href="/tools/discoveryharness/">Discovery Test Harness</a></h3>
        A test harness to check OExchange Discovery for a service.
    </div>    
    <div class="clear"></div>
    
    
    <!--
	<ul>
		<li>An <a href="sourceharness">Offer Test Harness</a> you can use to send OExchange Offer requests to Targets you are developing</li>
		<li>A <a href="/tools/discoverygen/">Discovery Resource Generator</a> to generate discovery files automatically for your service</li>
		<li>A <a href="/tools/discoveryharness/">Discovery Test Harness</a> you can use to test your service's discovery compliance</li>
		<li>A demo <a href="/demo/linkeater/">Sample Target</a> you can send OExchange Offer requests to</li>
		<li>A simple JSON-based <a href="/demo/discovery-api/">Discovery API</a> to test out OExchange discovery files</li>
	</ul>
    -->

<?
include '../footer.php';
?>
