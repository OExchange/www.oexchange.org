<?php
$page_title = "OExchange Specification";
$version = (isset($_GET['v']) ? $_GET['v'] : '0.8-wd6');
include '../header.php';
?>	
<?php
include 'spec_body_' . $version . '.html';
?>
<?php
include '../footer.php';
?>
	

