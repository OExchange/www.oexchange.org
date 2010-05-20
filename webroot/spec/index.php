<?php
$page_title = "OExchange Technical Specification";
$nav = "spec";
$version = (isset($_GET['v']) ? $_GET['v'] : '0.8-wd7');
include '../header.php';
?>	
    
    <h2 class="pagetitle">Technical Specification</h2>

    <hr/>

<?php
    include 'spec_body_' . $version . '.html';
?>
<?php
    include '../footer.php';
?>
	

