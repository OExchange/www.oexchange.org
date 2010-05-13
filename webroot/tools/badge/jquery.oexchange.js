/**
* Work-in-progress jQuery plugin for OExchange integration.
*/
(function () {
    //var addUrl = '//www.oexchange.org/demo/console/', 
    var addUrl = '/demo/console/', 
        shareUrl = 'http://oexchange-{service}.appspot.com/offer?url='+encodeURIComponent(document.location.href),
        oexUrl = 'http://www.oexchange.org',
        supportStorage = window.Storage && window.localStorage,
        loaded = 0,
        serviceList = [],
        serviceHash = {},
        serviceExport = {},
        userServices = [],
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
        if (data.oex && data.oex=='close') closeDialog();
        if (serviceList && serviceList.length && data.sh) fillPreferredServices();
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
                    '<iframe id="oexchange-console-dialog" src="'+addUrl+'" frameborder="0" style="width:500px;height:400px;overflow:hidden">',
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
        var div;
        if (!document.getElementById('oexchange-dialog')) {
           var s = ['',
                    '<div id="oexchange-dialog-inner">',
                    '<div id="oexchange-dialog-titlebar"><h3>OExchange</h3></div>',
                    '<div id="oexchange-dialog-saved" style="display-none">',
                    '<p>This site has been added to your preferred services list.</p>',
                    '</div>',
                    '<div id="oexchange-dialog-saved-button" style="display:none">',
                    '<button onclick="jQuery.oex.closeDialog();return false">Okay</button>',
                    '</div>',
                    '<div id="oexchange-dialog-content">',
                    '<p>Oexchange makes it easy to keep track of your favorite places to share. <a href="'+oexUrl+'" target="_blank">Learn more</a>.</p>',
                    '<p>Would you like to remember this site for sharing?</p>',
                    '</div>',
                    '<div id="oexchange-dialog-buttons">',
                    '<input type="hidden" name="add" value="'+(xrd || getXRD())+'">',
                    '<button onclick="jQuery.oex.saveDialog();jQuery.oex.save()">Save</button>',
                    '<button onclick="jQuery.oex.closeDialog();return false">No Thanks</button>',
                    '</form>',
                    '</div>'].join('');
            jQuery('body').append('<div id="oexchange-dialog">' + s + '</div>');
        }

        jQuery('#oexchange-dialog-content').show();
        jQuery('#oexchange-dialog-buttons').show();
        jQuery('#oexchange-dialog-saved').hide();
        jQuery('#oexchange-dialog-saved-button').hide();
        jQuery('#oexchange-dialog').show();
    }

    /**
    * Lame method to show the "Saved" message
    */
    function saveDialog() {
        jQuery('#oexchange-dialog-content').hide();
        jQuery('#oexchange-dialog-buttons').hide();
        jQuery('#oexchange-dialog-saved').show();
        jQuery('#oexchange-dialog-saved-button').show();
    }

    /**
    * Closes the dialog box
    */
    function closeDialog() {
        jQuery('#oexchange-dialog').hide();
    }

    function createCommFrame(url) {
        jQuery('body').append('<iframe id="oexifr'+Math.floor(100*Math.random())+'" src="' + url + '" style="width:1px;height:1px;border:0px" frameborder="0"></iframe>');
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
                    '<a class="oexchange-enabled-btn" href="'+addUrl+'" target="_blank">Customize</a>'
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

    function dialogLink() {
        this.each(function (i, el) {
                    el.onclick = function () { openRememberDialog(); return false};
                });
    }

    function shareLink(el, xrd) {
        jQuery(el).html('<span><img src="'+serviceHash[xrd].icon32+'" width="32" height="32" style="border:0"></span>');
        el.onclick = function () {
            window.open(serviceHash[xrd].offer + '?url='+ encodeURIComponent(document.location.href));
            return false;
        };

    }

    function renderShare() {
        this.each(function (i, el) {
            var xrd = el.getAttribute('ox:xrd'),
                pref = el.getAttribute('ox:pref');
            if (pref) {
                pref = parseInt(pref);
                if (userServices.length >= parseInt(pref))
                    xrd = userServices[pref - 1].xrd;
            }
            if (xrd) {
                if (!serviceHash[xrd])   {
                    // need to load xrd
                    jQuery.ajax({ 
                        dataType: 'jsonp',
                        url: "http://www.oexchange.org/demo/discovery-api/api.php?cmd=getTargetDetail&xrd="+encodeURIComponent(xrd),
                        jsonp:'jsonpcb',
                        context: document.body, 
                        success: function(data){
                            if (data.endpoint) data.offer = data.endpoint;
                            if (data.offer) {
                                serviceHash[xrd] = data;
                            }
                            if (serviceHash[xrd]) shareLink(el, xrd);
                      }});
                    
                } else {
                    shareLink(el, xrd);
                }
            }
        });
    }

    // Add jQuery functions 
    jQuery.fn.oexchange_badge = renderBadge;
    jQuery.fn.oexchange_console = consoleLink;
    jQuery.fn.oexchange_save = dialogLink;
    jQuery.fn.oexchange_share = renderShare;

    // Add static jQuery methods
    jQuery.oex = {
        getUserServices : getUserServices,
        save : save,
        showPrompt : promptIfOexchange,
        hidePrompt : hidePrompt,
        openDialog : openRememberDialog,
        closeDialog : closeDialog,
        saveDialog : saveDialog
    };

    // XXX just for demo
    jQuery('head').append('<style type="text/css">@import "/tools/badge/css/oex.css";</style>');

    if (jQuery.browser.msie) { 
        window.attachEvent('onmessage', messageHandler);
    } else {
        window.addEventListener('message', messageHandler, false);
    }


    // When the DOM's ready, we check in with the demo console to load the user's preferred services
    jQuery(document).ready(function() {
        if (supportStorage) {
            if (!loaded) {
                createCommFrame(addUrl+'update-cache.html');
                createCommFrame(addUrl+'load.php'); // will postMessage back to this calling frame
                
                loaded = 1;
            }
        }
    });
})()
