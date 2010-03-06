<?php
$page_title = "OExchange Specification: Working Draft";
$version = (isset($_GET['v']) ? $_GET['v'] : '0.8-wd4');
include '../header.php';
?>	
<?php
include 'spec_body_' . $version . '.html';
?>
<?php
include '../footer.php';
?>
	

