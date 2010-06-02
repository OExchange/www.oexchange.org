<?php
    $xrds = $_GET['xrds'];
    $js_xrds = '[';
    $first = 1;
    if (isset($xrds)) {
        $xrds = split(',', $xrds); 
        foreach ($xrds as $xrd) {
            $js_xrds .= ($first-- <= 0 ? ',' : '') . "'$xrd'"; 
        }
    }
    $js_xrds .= ']';
?>
<html>
<body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="/demo/lib/json2.js"></script>
<script type="text/javascript" src="scripts/pref-service.js"></script>
<script type="text/javascript">
    serviceList = sharingtoolPrefService.getServiceList(<?php $js_xrds ?>);
    serviceHash = (serviceList) ? sharingtoolPrefService.getServiceHash() : null;
    if (serviceList && serviceList.length > 0 && serviceHash == null) {
        sharingtoolPrefService.populateServiceHash(serviceList,function(sh){
            loadingServices = false;
            if (sh) {
                // onSuccess?
        
            } else {
                // onFailure?
            }
        });
    }


if (window.parent && window.parent.postMessage && window.JSON) {
        window.parent.postMessage('rdy=1&sl='+JSON.stringify(serviceList)+'&sh='+JSON.stringify(serviceHash),'*');
}

</script>
</body>
</html>
