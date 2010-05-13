<?php
$page_title = "OExchange Technical Specification";
$nav = "spec";
$version = (isset($_GET['v']) ? $_GET['v'] : '0.8-wd6');
include '../header.php';
?>	
    
    <h2 class="pagetitle mb10">Technical Specification</h2>
<!--
    <div class="bannertext">
        How it works.
    </div><br/>
-->    
    <hr/>

<?php
    include 'spec_body_' . $version . '.html';
?>
<?php
    include '../footer.php';
?>
	

