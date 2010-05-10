/**
* Work-in-progress jQuery plugin for OExchange integration.
*/
(function () {
    var addUrl = 'http://ve04.clearspring.local/oxconsole/',
        xrd;

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
        for (var i = 0; i < c.length; i++) {
            var kv = c[i].split('=');
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
                if (l.rel && l.rel.match(/http:\/\/oexchange.org\/spec\/0.+\/rel\/related-target/)) {
                    oex = l.href;
                    break;
                }
            }
            xrd = oex;
        }
        return xrd;
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
    */
    function openRememberDialog() {
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
                    '<p>Oexchange makes it easy to keep track of your favorite places to share. <a href="http://oexchange.org" target="_blank">Learn more</a>.</p>',
                    '<p>Would you like to remember this site for sharing?</p>',
                    '</div>',
                    '<div id="oexchange-dialog-buttons">',
                    '<input type="hidden" name="add" value="'+(getXRD())+'">',
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

    /**
    * Instantiates a 1x1 pixel iframe back to the demo console to save the given OExchange target XRD in the user's preferred list.
    * @param    xrd     an XRD to save; defaults to the page's XRD, if any is listed
    */
    function save(xrd) {
        jQuery('body').append('<iframe src="' + addUrl + '?add=' + encodeURIComponent(xrd || getXRD()) + '" style="width:1px;height:1px;border:0px" frameborder="0"></iframe>');
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
    function renderBadge() {
          this.each(function (i, el){
                el.innerHTML = ['',
                  '<div class="oexchange-enabled">',
                  (hasSaved(getXRD()) ?
                    '<a class="oexchange-enabled-btn" href="'+addUrl+'" target="_blank">Customize</a>'
                    : 
                    '<a class="oexchange-enabled-btn" href="#" onclick="jQuery.oex.dopen();return false">Save</a>'),
                  'This site is <a href="http://oexchange.org" target="_blank">OExchange Enabled</a>.</div>'].join('');
                });
        return this;
    }


    // Add jQuery functions 
    jQuery.fn.oexchange_badge = renderBadge;

    // Add static jQuery methods
    jQuery.oex = {
        save : save,
        showPrompt : promptIfOexchange,
        hidePrompt : hidePrompt,
        dopen : openRememberDialog,
        closeDialog : closeDialog,
        saveDialog : saveDialog
    };
})()
