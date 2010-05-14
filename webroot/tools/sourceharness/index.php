<?php
$page_title = "OExchange Offer Test Harness";
$nav = "tools";
include '../../header.php';

$dfltTarget = $_REQUEST["target"];
if (empty($dfltTarget)) {
    $dfltTarget = "http://www.oexchange.org/demo/linkeater/offer.php";
}

?>

    <script type="text/javascript">
    
    function shareIframe() {
        var url = baseUrl()
            + "&ctype=iframe" 
            + "&iframeurl=" + encodeURIComponent(document.iframeForm.iframeurl.value)
            + "&height=" + document.iframeForm.height.value
            + "&width=" + document.iframeForm.width.value
            + "&screenshot=" + encodeURIComponent(document.iframeForm.screenshot.value)
        window.open(url);
    }

    function shareImage() {
        var url = baseUrl()
            + "&ctype=image" 
            + "&imageurl=" + encodeURIComponent(document.imageForm.imageurl.value)
            + "&height=" + document.imageForm.height.value
            + "&width=" + document.imageForm.width.value;
        window.open(url);
    }

    function baseUrl() {
        var baseUrl = document.targetForm.target.value
            + "?url=" + encodeURIComponent(document.commonForm.url.value)
            + "&title=" + encodeURIComponent(document.commonForm.title.value)
            + "&description=" + encodeURIComponent(document.commonForm.description.value);
        return baseUrl;
    }
    
    function shareLink() {
        var url = baseUrl();
        window.open(url);
    }

    function shareFlash() {
        var url = baseUrl()
            + "&ctype=flash" 
            + "&swfurl=" + encodeURIComponent(document.flashForm.swfurl.value)
            + "&height=" + document.flashForm.height.value
            + "&width=" + document.flashForm.width.value
            + "&screenshot=" + encodeURIComponent(document.flashForm.screenshot.value);
        window.open(url);
    }
    
    </script>
    
    <h2 class="pagetitle mb10">Offer Test Harness</h2>
    <div class="bannertext">Initiate OExchange Offer calls to a target of your choice</div>
    
    <hr/>
    

    <h2>Target</h2>
    <form name="targetForm">
        Offer endpoint: <br/>
        <input name="target" type="text" size="60" value="<?= $dfltTarget ?>" /> <code>?url=http://www.example.com</code><br/>
    </form>
    
    <hr/>
    
    <h2>Offer Parameters</h2>
    
    <h4>Common link offers</h4>
    <form name="commonForm" action="javascript:void(0);">
    <table cellpadding="4">
    <colgroup><col width="15%"/><col width="85%"/></colgroup>
        <tr><td><code>url:</code></td><td><input name="url" type="text" size="70" value="http://www.example.com" /></td></tr>
        <tr><td><code>title:</code></td><td><input name="title" type="text" size="70" value="" /></td></tr>
        <tr><td><code>description:</code></td><td><input name="description" type="text" size="70" value="" /></td></tr>
        <tr><td></td><td><input class="btn" type="submit" value="Share (without a ctype)" onclick="shareLink();" /></td></tr>
    </table>    
    </form> 
    
    <br/>

    <h4>(Optional) Typed offers</h4>
    <p>Adding ctypes and type-specific parameters:</p>
        
    <h5>ctype flash</h5>
    <form name="flashForm" action="javascript:void(0);" >
    <table cellpadding="4">
    <colgroup><col width="15%"/><col width="85%"/></colgroup>
        <tr><td><code>swfurl:</code></td><td><input name="swfurl" type="text" size="70" value="http://www.youtube.com/v/lFF2bkiHNVQ&hl=en_US&fs=1&" /></td></tr>
        <tr><td><code>height:</code></td><td><input name="height" type="text" size="70" value="385" /></td></tr>
        <tr><td><code>width:</code></td><td><input name="width" type="text" size="70" value="640" /></td></tr>
        <tr><td><code>screenshot:</code></td><td><input name="screenshot" type="text" size="70" value="http://i3.ytimg.com/vi/nRyoN0AITtw/default.jpg" /></td></tr>
        <tr><td></td><td><input class="btn" type="submit" value="Share" onclick="shareFlash();" /></td></tr>
    </table>    
    </form> 
    
    <br/>

    <h5>ctype iframe</h5>
    <form name="iframeForm" action="javascript:void(0);" >
    <table cellpadding="4">
    <colgroup><col width="15%"/><col width="85%"/></colgroup>
        <tr><td><code>iframefurl:</code></td><td><input name="iframeurl" type="text" size="70" value="http://www.example.com" /></td></tr>
        <tr><td><code>height:</code></td><td><input name="height" type="text" size="70" value="480" /></td></tr>
        <tr><td><code>width:</code></td><td><input name="width" type="text" size="70" value="640" /></td></tr>
        <tr><td><code>screenshot:</code></td><td><input name="screenshot" type="text" size="70" value="http://brammofan.files.wordpress.com/2009/08/10_12_07_evel_knievel_dies_69xr750.jpg?w=556&h=432" /></td></tr>
        <tr><td></td><td><input class="btn" type="submit" value="Share" onclick="shareIframe();" /></td></tr>
    </table>
    </form> 
    
    <br/>

    <h5>ctype image</h5>
    <form name="imageForm" action="javascript:void(0);" >
    <table cellpadding="4">
    <colgroup><col width="15%"/><col width="85%"/></colgroup>
        <tr><td><code>imageurl:</code></td><td><input name="imageurl" type="text" size="70" value="http://brammofan.files.wordpress.com/2009/08/10_12_07_evel_knievel_dies_69xr750.jpg?w=556&h=432" /></td></tr>
        <tr><td><code>height:</code></td><td><input name="height" type="text" size="70" value="432" /></td></tr>
        <tr><td><code>width:</code></td><td><input name="width" type="text" size="70" value="556" /></td></tr>
        <tr><td></td><td><input class="btn" type="submit" value="Share" onclick="shareImage();" /></td></tr>
    </table>
    </form> 
    <p></p>

<?
include '../../footer.php';
?>
