$(function(){
    var w = window;
    var serviceList, serviceHash;
    var loadingServices = false;
    
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
            }
            else
            {
                if (!loadingServices) completeInit();
            }
        }
    };
    
    var completeInit = function(){
        if (serviceList != null) {
            $('#title').text('My Saved Sharing Services');
            $('#text').html('<p>Sharing Tool makes it easy to keep track of your favorite places to share.  Saved sharing services can be presented by any product that supports OExchange for you to use.</p>');
        }
        displayTable();
        hideLoading();
    };
    
    
    var loadData = function(){
        serviceList = sharingtoolPrefService.getServiceList();
        serviceHash = (serviceList) ? sharingtoolPrefService.getServiceHash() : null;

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
        var xrd,xrdCache,tr;
        var tableBody = $('#srvcs tbody').empty();
        if (serviceList && serviceList.length > 0) {
            for (var i in serviceList) {
                xrd = serviceList[i];
                xrdData = serviceHash[xrd] || null;
                tr = $('<tr />',{rel:i});
                tr.append($('<td />',{text:parseInt(i)+1}))
                  /*.append($('<td />',{html:'<a href="#" class="up-button">up</a> <a href="#" class="down-button">down</a>'}))*/
                  .append($('<td />',{text:(xrdData&&xrdData.name)?xrdData.name:'Unknown',class:'iconified',style:(xrdData&&xrdData.icon)?'background-image:url('+xrdData.icon+')':''}))
                  .append($('<td />',{text:(xrdData&&xrdData.offer)?xrdData.offer:''}))
                  .append($('<td />',{html:'<a href="#" class="remove-button">X</a>'}));
                tableBody.append(tr);
            }

        $('#oex-priority-sort').click(function() {
        });
        $('#oex-services-sort').click(function() {
        });

        $("#srvcs tbody").sortable({
                                        cursor: 'all-scroll',
                                        update: function(event, ui) { 
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
        $("#srvcs").disableSelection();
        } else {
            tableBody.append($('<tr><td colspan="5">You have no saved sharing services.</td></tr>'));
        }
        $('#srvcs').show();
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
        serviceList = $.merge(serviceList || [],services);
        serviceHash = null;
        storeData();
        return true;
    };
    
    var removeService = function(index){
        index = parseInt(index);
        var xrd = serviceList[index];
        if (xrd) {
            serviceList.splice(index,1);
            if (serviceHash[xrd]) delete serviceHash[xrd];
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
    
    $('#srvcs .remove-button').live('click',function(e){
        var index = $(this).parent().parent().attr('rel');

        $('#oex-remove-service').click(
                function () {
                    if (removeService(index)) {
                        displayTable();
                        storeData();
                    }
                }
        );
        $('#oex-delete').slideDown();
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


    $('#oex-main-whatisthis').click(function () {$('#oex-info-services').slideDown();});
    $('#oex-main-whatispublish').click(function () {$('#oex-info-how').slideDown();});
    $('#oex-publish-why').click(function () { $('#oex-publish').slideUp();$('#oex-info-why').slideDown();});
    $('#oex-main-add').click(function () {$('#oex-add').slideDown();});
    $('#oex-main-publish').click(function () {$('#oex-publish').slideDown();});
    $('.oex-sub-cancel').click(function () {$('.oex-sub').slideUp();});
    
    /* onload */
    startInit();
    processQueryString();

});
