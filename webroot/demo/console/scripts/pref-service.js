var sharingtoolPrefService = (function () {
    var w = window;
    var storage = w.localStorage;
    var supported = (storage && w.JSON);
    var serviceListKey = 'pref-service-list',
        serviceHashKey = 'pref-service-hash';

    var getServiceList = function(){
        var slEncoded = storage.getItem(serviceListKey);
        if (slEncoded) {
            var sl = JSON.parse(slEncoded);
            if (sl && sl instanceof Object && sl.v) {
                return sl.v;
            }
        }
        return null;
    };
    
    var getServiceHash = function(){
        var shEncoded = storage.getItem(serviceHashKey);
        if (shEncoded) {
            var sh = JSON.parse(shEncoded);
            if (sh && sh instanceof Object && sh.v) {
                return sh.v;
            }
        }
        return null;
    };
    
    var populateServiceHash = function(sl,callback){
        // @todo: refactor out this one jquery call
        $.ajax({
            data:{xrds:sl},
            error:function(r,s,e){
                callback(false);
            },
            success:function(d,s,r){
                if (d && d.data) {
                    saveData(sl,d.data);
                    callback(d.data);
                } else {
                    callback(false);
                }
            },
            type:'post', // only because of the potential data lenth
            url:'fetch-xrd.php'
        });
    };
    
    var saveData = function(sl,sh){
        if (sl) {
            storage.setItem(serviceListKey, JSON.stringify({v:sl}));
            storage.setItem(serviceHashKey, JSON.stringify({v:sh}));
        } else {
            storage.removeItem(serviceListKey);
            storage.removeItem(serviceHashKey);
        }
    };

    return {
        supported: supported,
        getServiceList: getServiceList,
        getServiceHash: getServiceHash,
        populateServiceHash: populateServiceHash,
        saveData: saveData
    }
})();