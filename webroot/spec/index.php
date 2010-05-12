<?php
$page_title = "OExchange Specification";
$nav = "spec";
$version = (isset($_GET['v']) ? $_GET['v'] : '0.8-wd7');
include '../header.php';
?>	
    
    <h2 class="pagetitle mb10">Working Draft Specification</h2>
    <div class="bannertext">
        This document defines OExchange, a specification for simple url sharing on the web.
    </div><br/>
    
    <hr/>

<?php
    include 'spec_body_' . $version . '.html';
?>
<?php
    include '../footer.php';
?>
	

