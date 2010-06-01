/**
* Work-in-progress jQuery plugin for OExchange integration.
*/
(function () {
    //var addUrl = '//www.oexchange.org/demo/console/', 
    var addUrl = '/demo/console/', 
        consoleUrl = addUrl +  (window.oex_demo ? '?demo=true' : ''),
        shareUrl = 'http://oexchange-{service}.appspot.com/offer?url='+encodeURIComponent(document.location.href),
        oexUrl = 'http://www.oexchange.org',
        supportStorage = window.Storage && window.localStorage,
        loaded = 0,
        ready = 0,
        shareLinkHash = {},
        serviceList = [],
        serviceHash = {},
        serviceExport = {},
        userServices = [],
        readyCallbacks = [],
        xrd;


    function reduce( o, fn, acc, cxt ){
        if ( !o )
            return acc;

        if ( o instanceof Array )
            for( var i = 0, len = o.length, v = o[0]; i < len; v = o[++i] )
                acc = fn.call( cxt || o, acc, v, i, o );
        else
            for ( var name in o )
                acc = fn.call( cxt || o, acc, o[ name ], name, o );

        return acc;
    }

    function toKV(o, del){
        return reduce(o, function(acc, v, k){
            acc.push( encodeURIComponent(k) + '=' + encodeURIComponent(v) ); return acc;
        }, []).join(del || "&");
    }

    function fromKV(q, del){
        return reduce(q.split(del || '&'), function(acc, pair){
            var kv = pair.split('='), k = kv[0], v = kv[1];
            if (k) acc[k] = decodeURIComponent(v);
            return acc;
        }, {});
    }

    /**
    * For postMessage integration. Only loads in the user's service list and definition hash when needed.
    */
    function messageHandler(s) {
        if (!s /*|| addUrl.indexOf(s.origin) !== 0*/) return;
        var data = fromKV(s.data);
        if (data.sl) serviceList = JSON.parse(data.sl);
        if (data.sh) {
            var sh = JSON.parse(data.sh);
            for (var k in sh) serviceHash[k] = sh[k];
        }
        if (serviceList && serviceList.length && data.sh) {
            userServices = [];
            fillPreferredServices(1);
        }
        if (data.oex && data.oex=='close') closeDialog();
        if (data.rdy) {
            ready = 1;
            var cb;
            while (cb = readyCallbacks.shift()) {
                cb();
            }
        }
    }

    /**
    * Adds the user's preferred services to the userServices array.
    * Generally only called once, but can be forced on subsequent loads.
    */
    function fillPreferredServices(f) {
        if ((!f || this.f) && userServices.length) return;
        else if (f) this.f = 1;

        var svc;
        for (var i = 0; i < serviceList.length; i++) {
            var k = serviceList[i],
                svc = serviceHash[k];
            if (svc) {
                svc.code = urlToCode(k);
                if (!svc.xrd) svc.xrd = k;
                svc.url = svc.offer;
                serviceExport[svc.code] = {name: svc, code: svc.code, icon: svc.icon, icon32: svc.icon32, url: svc.url};
                userServices.push(svc);
            }
        }
    }

    /**
    * Generates a useful service ID from its ad hoc XRD. AddThis oexchange wrappers are detected.
    */
    function urlToCode(url) {
        var code = url.replace(/ /g,'');
        if (url.indexOf('addthis.com/oexchange')>-1) {
            // special case
            code = url.split('oexchange/0.8/xrd/').pop().split('.').shift();
        }
        return code;
    }

    /**
    * Exposes the user's preferred services array.
    */
    function getUserServices() {
        return userServices;
    } 

    /**
    * Sets a long-lived cookie.
    *
    * @param k  cookie key name
    * @param v  cookie value
    */
    function setCookie(k,v) {
        document.cookie = k+'='+v+'; expires=Wed, 04 Oct 2028 03:19:53 GMT; path=/; domain=' + (jQuery.browser.msie ? '' : '.') + 'addthis.com';
    }

    /**
    * Reads a cookie.
    *
    * @param k  cookie key name
    * @returns  cookie value
    */
    function readCookie(k) {
        var c = document.cookie.split(';')
        for (var i = 0; i < c.length; i++) { var kv = c[i].split('=');
            if (kv.shift() === k) return kv.pop();
        }
    }

    /**
    * @returns an OExchange target XRD, if one is found on the current page.
    * @see http://www.oexchange.org/spec/#discovery-targetxrd
    */
    function getXRD() {
        if (!xrd) {
            var links = document.getElementsByTagName('link'),
                oex = 0;

            for (var i = 0; i < links.length; i++ ){
                var l = links[i];
                if (l.rel && l.rel.match(/oexchange.org\/spec\/0.+\/rel\/related-target/)) {
                    oex = l.href;
                    break;
                }
            }
            xrd = oex;
        }
        return xrd;
    }

    function showConsole() {
        var div;
        if (!document.getElementById('oexchange-dialog')) {
           var s = ['',
                    '<div id="oexchange-dialog">',
                    '<div id="oexchange-dialog-inner">',
                    '<iframe id="oexchange-console-dialog" src="'+consoleUrl+'" frameborder="0" style="width:500px;height:400px;overflow:hidden">',
                    '</div>',
                    '</div>'].join('');
            jQuery('body').append(s);
        }
        jQuery('#oexchange-dialog').show();
    }

    function hideConsole() {
        jQuery('#oexchange-dialog').hide();
    }

    /**
    * Prompts the user to store this OExchange-enabled site.
    */
    function promptIfOexchange() {
        var s = ['',
                '<div id="oexchange-prompt-inner">',
                '<h1>OExchange</h1>',
                '<p>This site has enabled open sharing. Would you like to remember it so you can share here later?</p>',
                '<div id="oexchange-prompt-buttons">',
                '<form action="'+addUrl+'" target="_blank">',
                '<input type="hidden" name="add" value="'+(getXRD())+'">',
                '<button onclick="jQuery.oex.hidePrompt();">Save</button>',
                '<button onclick="jQuery.oex.hidePrompt();return false">No Thanks</button></form>',
                '</div>',
                '</div>'].join('');
        jQuery('body').append('<div id="oexchange-prompt">'+s+'</div>');

        if (readCookie('odbm')) {
            // don't ask again 
        } else {
            jQuery('#oexchange-prompt').slideDown();
        }
    }

    /**
    * Closes the "Would you like to remember this site" prompt, and stores a cookie so we don't prompt again.
    */
    function hidePrompt() {
        var o = document.getElementById('oexchange-prompt');
        o.style.display = 'none';
        _addthis.cookie.sck('odbm',1);
    }

    /**
    * Opens the "Remember this site" OExchange dialog box.
    * Relatively lame.
    * @param xrd    xrd to remember; defaults to page XRD
    */
    function openRememberDialog(xrd) {
        var xrd = xrd || getXRD(),
            service = serviceHash[xrd];
        if (!service) {
            cacheXRD(xrd, function(data) {
                renderRememberDialog(xrd);
            });
        }
        else 
            renderRememberDialog(xrd);

        save();
    }

    function renderRememberDialog(xrd) {
        var service = serviceHash[xrd];
        if (!document.getElementById('oexchange-remember-dialog')) {
           var s = ['',
                    '<div id="oexchange-remember-dialog-inner">',
                    '<div id="oexchange-dialog-titlebar"><h3>'+service.name+' has been saved as a favorite place to share.</h3></div>',
                    '<p class="oexchange-service-description"><img width="16" height="16" src="'+service.icon+'"> '+service.name + (service.title?': ' + service.title:''),
                    service.vendor ? '<br/>By ' + service.vendor + '</p>' : '',
                    '<div id="oexchange-dialog-content">',
                    '<p>When you use sharing tools that support <a href="'+oexUrl+'" target="_blank">OExchange</a>, you\'ll be able to easily share to your favorite services.',
                    '</div>',
                    '<div id="oexchange-dialog-buttons">',
                    '<button onclick="jQuery.oex.closeDialog();">Close</button>',
                    '</div>'].join('');
            jQuery('body').append('<div id="oexchange-remember-dialog">' + s + '</div>');
        }

        jQuery('#oexchange-dialog-content').show();
        jQuery('#oexchange-dialog-buttons').show();
        jQuery('#oexchange-remember-dialog').show();
    }

    /**
    * Closes the dialog box
    */
    function closeDialog() {
        jQuery('#oexchange-dialog').hide();
        jQuery('#oexchange-remember-dialog').hide();
        refreshShareLinks();
    }

    function createCommFrame(url) {
        jQuery('<iframe id="oexifr'+Math.floor(100*Math.random())+'" style="width:1px;height:1px;border:0px" frameborder="0"></iframe>').appendTo(jQuery('body')).attr('src',url);
    }

    /**
    * Instantiates a 1x1 pixel iframe back to the demo console to save the given OExchange target XRD in the user's preferred list.
    * @param    xrd     an XRD to save; defaults to the page's XRD, if any is listed
    */
    function save(xrd) {
        createCommFrame(addUrl + '?add=' + encodeURIComponent(xrd || getXRD()));
    }

    /**
    * @param    xrd     an XRD to save; defaults to the page's XRD, if any is listed
    * @returns true iff the user has already saved the given XRD)
    */
    function hasSaved(xrd) {
        if (!xrd) xrd = getXRD();
        var sl = []; // XXX add reading of array
        for (var i = 0; i < sl.length; i ++){
            if (sl[i] == xrd) {
                return true;
            }
        }
        return false;
    }

    /**
    * Renders an OExchange-enabled badge, with hooks back to the console for saving the current page's XRD. 
    */
    function renderBadge(xrd) {
          xrd = xrd || getXRD();
          this.each(function (i, el){
                el.innerHTML = ['',
                  '<div class="oexchange-enabled">',
                  (hasSaved(xrd) ?
                    '<a class="oexchange-enabled-btn" href="'+consoleUrl+'" target="_blank">Customize</a>'
                    : 
                    '<a class="oexchange-enabled-btn" href="#" onclick="jQuery.oex.openDialog(\''+xrd+'\');return false">Save</a>'),
                  'This site is <a href="'+oexUrl+'" target="_blank">OExchange Enabled</a>.</div>'].join('');
                });
        return this;
    }

    function consoleLink() {
        this.each(function (i, el) {
                    el.onclick = function () { showConsole(); return false};
                });
    }

    function renderSave(i, el, noadd) {
        var xrd = getXRD(),
            newService = !(serviceHash[xrd]);
        if (newService) {
            el.onclick = function () { 
                openRememberDialog(); 
                saveService(this) 
            };
        } else {
            saveService(el);
        }
    }

    function saveService(el) {
        jQuery(el).addClass('oexchange-btn-saved').removeClass('oexchange-btn').html('<span>Service Saved</span>').attr('title','Service Saved');
        el.onclick = function () {return false;};
        return false;
    }

    function shareLink(el, xrd) {
        jQuery(el).html('<span><img src="'+serviceHash[xrd].icon32+'" width="32" height="32" style="border:0"></span>');
        el.onclick = function () {
            window.open(serviceHash[xrd].offer + '?url='+ encodeURIComponent(document.location.href));
            return false;
        };

    }

    function addShareLink(rank, el) {
        if (!shareLinkHash[rank]) shareLinkHash[rank] = [];
        shareLinkHash[rank].push(el);
    }

    function refreshShareLinks() {
        for (var rank in shareLinkHash) {
            if (parseInt(rank) > 0 && shareLinkHash[rank]) {
                for (var i = 0; i < shareLinkHash[rank].length; i++) {
                    renderShare(i, shareLinkHash[rank][i], 1);
                }
            }
        }
    }

    function cacheXRD(xrd, success) {
        jQuery.ajax({ 
            dataType: 'jsonp',
            url: "http://www.oexchange.org/demo/discovery-api/api.php?cmd=getTargetDetail&xrd="+encodeURIComponent(xrd),
            jsonp:'jsonpcb',
            context: document.body, 
            success: function (data) {
                if (data.endpoint) data.offer = data.endpoint;
                if (data.offer) {
                    serviceHash[xrd] = data;
                }
                success();
          }});
    }

    function renderShare(i, el, noadd) {
            var xrd = el.getAttribute('ox:xrd'),
                pref = el.getAttribute('ox:pref');
            if (pref) {
                pref = parseInt(pref);
                if (userServices.length >= parseInt(pref)) {
                    xrd = userServices[pref - 1].xrd;
                }
                if (!noadd) addShareLink(pref, el);
            } else {
                if (!noadd) addShareLink(0, el);
            }
            if (xrd) {
                if (!serviceHash[xrd])   {
                    // need to load xrd
                    cacheXRD(xrd, function(data){
                            if (serviceHash[xrd]) shareLink(el, xrd);
                    });
                    
                } else {
                    shareLink(el, xrd);
                }
            }
    }

    // Add jQuery functions 
    jQuery.fn.oexchange_badge = renderBadge;
    jQuery.fn.oexchange_console = consoleLink;
    jQuery.fn.oexchange_save = function () {
        if (ready) {
            this.each(renderSave);
            return;
        }
    
        var coll = this;
        readyCallbacks.push( function () {coll.each(renderSave);} );
    }
    jQuery.fn.oexchange_share = function () { 
        if (!supportStorage || ready) {
            this.each(renderShare); 
            return;
        }
       
        // not ready
        var coll = this;
        readyCallbacks.push( function () {coll.each(renderShare);} );
    };
    

    // Add static jQuery methods
    jQuery.oex = {
        getUserServices : getUserServices,
        save : save,
        showPrompt : promptIfOexchange,
        hidePrompt : hidePrompt,
        openDialog : openRememberDialog,
        closeDialog : closeDialog
    };

    // XXX just for demo
    jQuery('head').append('<link rel="stylesheet" href="/tools/badge/css/oex.css"/>');

    if (jQuery.browser.msie) { 
        window.attachEvent('onmessage', messageHandler);
    } else {
        window.addEventListener('message', messageHandler, false);
    }

    // When the DOM's ready, we check in with the demo console to load the user's preferred services
    jQuery(document).ready(function() {
        if (supportStorage) {
            if (!loaded) {
                loaded = 1;
                createCommFrame(addUrl+'load.php'); // will postMessage back to this calling frame
            }
        }
    });
})()
