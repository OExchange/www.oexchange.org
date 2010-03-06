<?php
$page_title = "OExchange Test Source";
include '../header.php';

$dfltTarget = $_REQUEST["target"];
if (empty($dfltTarget)) {
    $dfltTarget = "http://www.willmeyer.com/oexchange/demo/linkeater/offer.php";
}

?>

    <script type="text/javascript">
    
    function shareIframe() {
        var url = baseUrl()
            + "&ctype=iframe" 
            + "&iframeurl=" + escape(document.iframeForm.iframeurl.value)
            + "&height=" + document.iframeForm.height.value
            + "&width=" + document.iframeForm.width.value
            + "&screenshot=" + escape(document.iframeForm.screenshot.value)
        window.open(url);
    }

    function shareImage() {
        var url = baseUrl()
            + "&ctype=image" 
            + "&imageurl=" + escape(document.imageForm.imageurl.value)
            + "&height=" + document.imageForm.height.value
            + "&width=" + document.imageForm.width.value;
        window.open(url);
    }

    function baseUrl() {
        var baseUrl = document.targetForm.target.value
            + "?url=" + escape(document.commonForm.url.value)
            + "&title=" + escape(document.commonForm.title.value)
            + "&description=" + escape(document.commonForm.description.value);
        return baseUrl;
    }
    
    function shareLink() {
        var url = baseUrl();
        window.open(url);
    }

    function shareFlash() {
        var url = baseUrl()
            + "&ctype=flash" 
            + "&swfurl=" + escape(document.flashForm.swfurl.value)
            + "&height=" + document.flashForm.height.value
            + "&width=" + document.flashForm.width.value
            + "&screenshot=" + escape(document.flashForm.screenshot.value);
        window.open(url);
    }
    
    </script>

    <h1>OExchange Test Source</h1>
    <p>
    <i>Initiate OExchange Offer calls to a target of your choice.</i>
    </p>

    <h2>Target</h2>
    <form name="targetForm">
        Offer endpoint: <br/>
        <input name="target" type="text" size="60" value="<?= $dfltTarget ?>" /></input>?url=http://www.oexchange.org<br/>
    </form>
    <p></p>
    
    <h2>Offer Parameters</h2>
    
    <h3>Common link offers</h3>
    <form name="commonForm" action="javascript:void(0);" >
        URL: <input name="url" type="text" size="50" value="http://www.oexchange.org" /><br/><br/>
        title: <input name="title" type="text" size="50" value="" /><br/><br/>
        description: <input name="description" type="text" size="50" value="" /><br/><br/>
        <input type="submit" value="Share (without a ctype)" onclick="shareLink();" />
    </form> 
    <p></p>

    <h3>(Optional) Typed offers</h3>
    <p>
    Adding ctypes and type-specific parameters:
    </p>
        
    <h4>ctype flash</h4>
    <form name="flashForm" action="javascript:void(0);" >
        swfurl: <input name="swfurl" type="text" size="70" value="http://www.youtube.com/v/lFF2bkiHNVQ&hl=en_US&fs=1&" /><br/><br/>
        height: <input name="height" type="text" size="70" value="385" /><br/><br/>
        width: <input name="width" type="text" size="70" value="640" /><br/><br/>
        screenshot: <input name="screenshot" type="text" size="70" value="http://i3.ytimg.com/vi/nRyoN0AITtw/default.jpg" /><br/><br/>
        <input type="submit" value="Share" onclick="shareFlash();" />
    </form> 
    <p></p>

    <h4>ctype iframe</h4>
    <form name="iframeForm" action="javascript:void(0);" >
        iframefurl: <input name="iframeurl" type="text" size="70" value="http://www.oexchange.org" /><br/><br/>
        height: <input name="height" type="text" size="70" value="480" /><br/><br/>
        width: <input name="width" type="text" size="70" value="640" /><br/><br/>
        screenshot: <input name="screenshot" type="text" size="70" value="http://brammofan.files.wordpress.com/2009/08/10_12_07_evel_knievel_dies_69xr750.jpg?w=556&h=432" /><br/><br/>
        <input type="submit" value="Share" onclick="shareIframe();" />
    </form> 
    <p></p>

    <h4>ctype image</h4>
    <form name="imageForm" action="javascript:void(0);" >
        imageurl: <input name="imageurl" type="text" size="70" value="http://brammofan.files.wordpress.com/2009/08/10_12_07_evel_knievel_dies_69xr750.jpg?w=556&h=432" /><br/><br/>
        height: <input name="height" type="text" size="70" value="432" /><br/><br/>
        width: <input name="width" type="text" size="70" value="556" /><br/><br/>
        <input type="submit" value="Share" onclick="shareImage();" />
    </form> 
    <p></p>

<?
include '../footer.php';
?>
