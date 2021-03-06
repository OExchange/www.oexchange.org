$(function(){
    var defaultXrd = {
            'http://oexchange-facebook.appspot.com/oexchange/oexchange.xrd' : {
                standard: true,
                vendor: 'Facebook',
                title: 'Facebook',
                name: 'Facebook',
                prompt: 'Share to Facebook',
                icon: 'http://facebook.com/favicon.ico',
                icon32: 'http://oexchange-facebook.appspot.com/images/logo_32x32.png' ,
                offer: 'http://oexchange-facebook.appspot.com/offer',
                xrd: 'http://oexchange-facebook.appspot.com/oexchange/oexchange.xrd'
            },
            'http://oexchange-buzz.appspot.com/buzz/oexchange.xrd' : {
                standard: true,
                vendor: 'Google',
                title: 'Google Buzz',
                name: 'Google Buzz',
                prompt: 'Post to Buzz',
                icon: 'http://oexchange-buzz.appspot.com/images/logo_16x16.gif',
                icon32: 'http://oexchange-buzz.appspot.com/images/logo_32x32.png',
                offer: 'http://www.google.com/buzz/post',
                xrd: 'http://oexchange-buzz.appspot.com/buzz/oexchange.xrd'
            },
            'http://oexchange-twitter.appspot.com/oexchange/oexchange.xrd' : {
                standard: true,
                vendor: 'Twitter',
                title: 'Twitter',
                name: 'Twitter',
                prompt: 'Tweet This',
                icon: 'http://twitter.com/favicon.ico',
                icon32: 'http://oexchange-twitter.appspot.com/images/logo_32x32.png',
                offer: 'http://www.twitter.com/save',
                xrd: 'http://oexchange-twitter.appspot.com/oexchange/oexchange.xrd'
            },
            'http://oexchange-digg.appspot.com/oexchange/oexchange.xrd' : {
                standard: true,
                vendor: 'Digg',
                title: 'Digg',
                name: 'Digg',
                prompt: 'Digg This',
                icon: 'http://digg.com/favicon.ico',
                icon32: 'http://oexchange-digg.appspot.com/images/logo_32x32.png' ,
                offer: 'http://www.digg.com/submit',
                xrd: 'http://oexchange-digg.appspot.com/oexchange/oexchange.xrd'
            },
            'http://oexchange-delicious.appspot.com/oexchange/oexchange.xrd' : {
                standard: true,
                vendor: 'Yahoo',
                title: 'Delicious',
                name: 'Delicious',
                prompt: 'Save on Delicious',
                icon: 'http://delicious.com/favicon.ico',
                icon32: 'http://oexchange-delicious.appspot.com/images/logo_32x32.png' ,
                offer: 'http://www.delicious.com/save',
                xrd: 'http://oexchange-delicious.appspot.com/oexchange/oexchange.xrd'
            }
        },
        w = window,
        defaultServiceList = [],
        serviceList,
        serviceHash,
        sericeToAdd,
        duration = 100,
        loadingServices = false;

    window.oex_defaultServices = !!window.oex_defaultServices;

    for (var xrd in defaultXrd) defaultServiceList.push(xrd);
    if (oex_defaultServices) serviceList = defaultServiceList; 

    if (!window.JSON) window.JSON = {stringify : function () { return '' }};

    var preloadServiceHash = function () {
        serviceHash = {};
        for (var k in defaultXrd) {
            serviceHash[defaultXrd[k].xrd] = defaultXrd[k];
        }
    }

    // preload services with defaults
    if (oex_defaultServices) {
        preloadServiceHash();
    }
    
    var log = function(msg) {
        if (console && console.log) console.log(msg);
    };

    var showLoading = function() {
        $('#loading').text('Loading...').show();
    };
    
    var hideLoading = function() {
        $('#loading').hide();
    };
    
    var startInit = function(){
        if (!sharingtoolPrefService.supported) {
            $('#message').addClass('notice').text('Your browser does not support service customization').show();
        } else {
            showLoading();
            if (!loadData())
            {
                hideLoading();
                displayTable();
            }
            else
            {
                if (!loadingServices) completeInit();
            }
        }
    };
    
    var completeInit = function(){
        if (serviceList != null) {
            $('#title').text('My Sharing Services');
        }
        displayTable();
        hideLoading();
    };
    
    
    var loadData = function(){
        var storedList = sharingtoolPrefService.getServiceList();
        serviceList = (storedList && storedList.length || !oex_defaultServices) ? storedList : serviceList;
        serviceHash = ((serviceList && serviceList == storedList) || !oex_defaultServices) ? sharingtoolPrefService.getServiceHash() : serviceHash || null;

        if (serviceList && serviceList.length > 0 && serviceHash == null) {
            loadingServices = true;
            sharingtoolPrefService.populateServiceHash(serviceList,function(sh){
                loadingServices = false;
                if (sh) {
                    serviceHash = sh;
                } else {
                    processXrdLoadFailure();
                }
                completeInit();
            });
        }
        
        return (serviceList != null);
    };
    
    var storeData = function(){
        sharingtoolPrefService.saveData(serviceList, serviceHash);
    };
    
    var populateServiceHash = function(){
    };
    
    var processXrdLoadFailure = function(){
        $('#message').addClass('notice').text('Could not load XRD data.').show();
        serviceHash = {};
    };
    
    var displayTable = function(){
        //log(serviceList);
        //log(serviceHash);
        var xrd,xrdCache,tr,std = false;
        var tableBody = $('#srvcs tbody').empty();
        // for current demo console, we always default
        if (!serviceList || serviceList.length == 0) {
            serviceList = defaultServiceList;
            preloadServiceHash();
        }
        if (serviceList || serviceList.length > 0) {
            for (var i in serviceList) {
                xrd = serviceList[i];
                xrdData = serviceHash[xrd] || {};
                tr = $('<tr />',{rel:i});
                std = xrdData.standard || (defaultXrd[xrd]||{}).standard;
                tr.append($('<td />',{text:parseInt(i)+1, 'class': 'center'}))
                  .append($('<td />',{html:(xrdData.name?xrdData.name:'Unknown') + (std?' <span style="color:#999;font-size:11px">(default)</span>':''),
                                      'class':'iconified',
                                      style: xrdData.icon?'background-image:url('+xrdData.icon+')':'' }))
                  /*.append($('<td />',{text:xrdData.offer?xrdData.offer:''}))*/
                  .append($('<td />',{html:(std?'n/a':'<a href="#" class="remove-button">X</a>'),
                                      'class':std?'remove-button-disabled':''}));
                tableBody.append(tr);
            }

            if (serviceList.length > 1) {
                $('.oex-note').show();
            } else {
                $('.oex-note').hide();
            }
            $("#srvcs td").disableSelection();
            $('#no-services').hide();
            $('.srvcs').show();
            //$('#foot-publish').show();
        } else {
            tableBody.append($('<tr><td colspan="5">You have no saved sharing services.</td></tr>'));
            $('.srvcs').hide();
            //$('#foot-publish').hide();
            $('#no-services').show();
        }
    };
    
    var processQueryString = function(){
        if (location.search != '') {
            var qs = location.search.substring(1).split('&');
            var kv;
            for(var i in qs) {
                kv = qs[i].split('=');
                if (kv[0] == 'add') {
                    if (addServices([decodeURIComponent(kv[1])])) {
                        w.location.search = '';
                    }
                }
            }
        }
    };
    
    var moveServiceUp = function(index){
        index = parseInt(index);
        if (index > 0) {
            _swapServices(index, index-1);
            return true;
        }
    };
    
    var moveServiceDown = function(index){
        index = parseInt(index);
        if (index < serviceList.length - 1) {
            _swapServices(index,index+1);
            return true;
        }
    };
    
    var _swapServices = function(a,b){
        var v = serviceList[a];
        serviceList[a] = serviceList[b];
        serviceList[b] = v;
    };
    
    var addServices = function(services){
        if (services && services.length == 1) {
            if ($.inArray(services[0], serviceList || []) > -1) return false;
        }
        serviceList = $.merge(services,serviceList || []);
        serviceHash = null;
        storeData();
        return true;
    };
    
    var removeService = function(index){
        index = parseInt(index);
        var xrd = serviceList[index];
        if (xrd) {
            serviceList.splice(index,1);
            //if (serviceHash[xrd]) delete serviceHash[xrd];
            return true;
        }
    };
    
    /* event handlers */
   
    $('#srvcs .up-button').live('click',function(e){
        if (moveServiceUp($(this).parent().parent().attr('rel'))) {
            displayTable();
            storeData();
        }
        return false;
    });
    
    $('#srvcs .down-button').live('click',function(e){
        if (moveServiceDown($(this).parent().parent().attr('rel'))) {
            displayTable();
            storeData();
        }
        return false;
    });
    
    $('#srvcs .remove-button-disabled').live('click',function(e){});
    $('#srvcs .remove-button').live('click',function(e){
        var index = $(this).parent().parent().attr('rel');

        $('#oex-remove-service').unbind('click');
        $('#oex-remove-service').click(
                function () {
                    $('.oex-sub').slideUp(duration);
                    if (removeService(index)) {
                        displayTable();
                        storeData();
                    }
                }
        );
        $('#oex-delete').slideDown(duration);
    });
    
    $('#priority-button').click(function(e){
        $.prompt('<p><strong>What does Priority mean?</strong></p><p>The number of saved services that can be displayed by an OExchange-enabled product may be limited. A higher priority means that service appears before others that follow.</p>',{
            buttons: {'Ok': true}
        });
        return false;
    });
    
    $('#tmp-xrd-save').click(function(e){
        serviceList = $('#tmp-xrd-input').val().split(',');
        serviceHash = null;
        storeData();
        w.location.reload(true);
    });
    
    $('#tmp-xrd-add').click(function(e){
        if (addServices($('#tmp-xrd-input').val().split(','))) {
            w.location.reload(true);
        }
    });
    
    $('#tmp-xrd-empty').click(function(e){
        serviceList = [];
        serviceHash = {};
        storeData();
        w.location.reload(true);
    });
    
    $('#tmp-xrd-reset').click(function(e){
        serviceList = null;
        serviceHash = null;
        storeData();
        w.location.reload(true);
    });

    function isInServiceList(xrd) {
        for (var i = 0; i < serviceList.length; i++) {
            if (serviceList[i] == xrd)
                return true;
        }

        return false;
    }

    function serviceSave() {
        var service = serviceToAdd || {},
            found = 0;
        if (!serviceList) serviceList = [];
        if (!serviceHash) serviceHash = {};
        $('#oex-add').slideUp(duration);
        $('.oex-sub').slideUp(duration);
        if (!isInServiceList(service.xrd)) {
            if (service.target.endpoint) service.target.offer = service.target.endpoint;
            serviceHash[service.xrd] = service.target;
            serviceList.unshift(service.xrd);
            storeData();
            displayTable();
        }
        serviceToAdd = null;
    }

    function serviceSearch() {
        var domain = $('#oex-new-service').val().split('://').pop();
        if (domain.search(/^([a-zA-Z0-9]+(\-[a-zA-Z0-9]+)*\.)*[a-zA-Z0-9]+(\-[a-zA-Z0-9]+)*\.[a-zA-Z]{2,4}\/?$/) > -1) {
            $('#oex-new-service').attr('disabled',true);

            $.getJSON('http://www.oexchange.org/demo/discovery-api/api.php?cmd=getHostTargets&jsonpcb=gethostcb&callback=?&host='+domain);
             
        } else {
            $('#oex-new-service').attr('disabled',false);
            $('#oex-add-content').hide();
            $('#oex-add-error').show();
        }
    }

    function xrdpSave(email, data, callback) {
        if (email && data && data instanceof Array) {
            $.ajax({
                'url': '/tools/xrdp/xrdpproxy.php?acct='+encodeURIComponent(email),
                'type': 'post',
                'processData': false,
                'data': JSON.stringify(data),
                contentType: 'application/json',
                success: callback
            });
        }
    }

        window.gethostcb = function(data) {
            $('#oex-feedback').hide();
            section = 'services';
            if (data.targets && data.targets.length) {
                $('#oex-add-success').show();
                $('#oex-add-service').show();
                $('#oex-add-cancel').hide();
                $('#oex-search-service').hide();
                serviceToAdd = data.targets[0];
            } else {
                $('#oex-add-noservice').show();
                $('#oex-new-service').attr('disabled',false);
            }
        }


    $('#oex-main-whatisthis').click(function () {$('#oex-info-services').slideDown(duration);});
    $('#oex-main-whatispublish').click(function () {$('#oex-info-how').slideDown(duration);});
    $('#oex-publish-why').click(function () { $('#oex-publish').slideUp(duration);$('#oex-info-why').slideDown(duration);});
    $('#oex-main-add').click(function () {
                $('#oex-feedback').hide();
                $('.oex-error').hide();
                $('#oex-add-success').hide();
                $('#oex-new-service').attr('disabled',false);
                $('#oex-new-service').val('');
                $('#oex-add-service').hide();
                $('#oex-search-service').show();
                $('#oex-add-cancel').show();
                $('#oex-add').slideDown(duration);
    });
    $('.oex-publish').click(function () { 
        $('#oex-info-why').hide(); 
        $('#oex-publish-error').hide();
        $('#oex-publish-status').hide();
        $('#oex-publish-success').hide();
        $('#oex-publish-email').attr('disabled',false).val('').show();

        $('#oex-publish-controls').show();
        $('#oex-publish-close').hide();

        $('#oex-publish').slideDown(duration);
    });
    $('.oex-done').click(function () { 
        if (window.parent) {
            var message = 'oex=close' +
                          (serviceList ? '&sl='+(JSON.stringify(serviceList)) : '') + 
                          (serviceHash ? '&sh='+(JSON.stringify(serviceHash)) : '');
            window.parent.postMessage(message, '*'); 
        }
        else window.close()
    });

    $('#oex-priority-sort').click(function() {
    });
    $('#oex-services-sort').click(function() {
    });

    $('#oex-new-service').click(function () { 
                $('.oex-error').hide(); 
                $('#oex-add-service').hide();
                $('#oex-search-service').show();
                $('#oex-add-content').show(); 
    });
    $('#oex-search-service').click(serviceSearch);
    $('#oex-add-service').click(serviceSave);
    $('.oex-sub-cancel').click(function () {$('.oex-sub').slideUp(duration);
                                            $('#oex-new-service').attr('disabled',false);
                                });

    $('#oex-services-promo a').click(function () { var xrd  = defaultXrd[this.getAttribute('ox:service')]; serviceToAdd = {xrd: xrd.xrd, target: xrd}; serviceSave(); });

    $('#oex-xrdp-save').click(function () {
            var email = $('#oex-publish-email').val();
            $('#oex-publish-email').attr('disabled',true);
            $('#oex-publish-status').show(); 
            xrdpSave(email, serviceList, function (data) { 
                $('#oex-publish-status').hide(); 
                if (!data) {
                    $('#oex-publish-success').show();
                    $('#oex-publish-controls').hide();
                    $('#oex-publish-close').show();
                } else {
                $('#oex-publish-email').attr('disabled',false);
                    $('#oex-publish-error').show();
                }
            });
    });

    $("#srvcs tbody").sortable({
        update: function(e, ui) { 
            var row = ui.item[0],
                rows = row.parentNode.children,
                tosort = [];

            for (var i = 0; i < rows.length; i++) {
                tosort.push({idx: i, xrd: serviceList[rows[i].getAttribute('rel')]});
                rows[i].setAttribute('rel',i);
                jQuery([rows[i].firstChild]).html(i + 1);
            }
            tosort.sort(function (a, b) { return a.idx - b.idx; });
            serviceList = [];
            for (var i = 0; i < tosort.length; i++) {
                serviceList.push(tosort[i].xrd);
            } 
            storeData();
        }
    });
    
    /* onload */
    startInit();
    processQueryString();

});
