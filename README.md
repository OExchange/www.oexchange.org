OExchange Web
=============

### What's Here? ###

The source for everything on www.oexchange.org, including:
 
* The [OExchange spec](http://github.com/OExchange/www.oexchange.org/tree/master/webroot/spec/) 

* Various [tools](http://github.com/OExchange/www.oexchange.org/tree/master/webroot/tools/) to help OExchange development

* Some PHP utility code, [lib-oexchange](http://github.com/OExchange/www.oexchange.org/tree/master/webroot/lib-oexchange/), currently part of the site but might some day be separated

* The home page, quickstart, all that

Other things are in other repos in the [OExchange account](http://github.com/OExchange).

### How to Contribute ###

If you're interested in being a contributor, join [the discussion](http://groups.google.com/group/oexchange).

### Development Setup ###

The root of the site source is /webroot.  To run it locally, you just need a PHP and Apache environment:

* set up a /etc/hosts to point www-local.oexchange.org to your dev machine

* set up a virtual host for www-local.oexchange.org to point to the webroot

* access the site locally at www-local.oexchange.org

The site uses the hostname that you hit it with to determine the location of static assets, so don't use an alternate hostname or "localhost".

### CDN, Deploying, and Site-Wide Configuration ###

Once deployed, the site relies on static assets cached at http://cache.oexchange.org/site/VERSION/images, etc.  The common configuration script included in every page sets variables, based on requested hostname, for the root path from which to serve these static assets.

The site builds/deploys, once your out of your local source tree, using Ant.  The build script has help.

To deploy a version of the site to your local dev environment, but still have it reference the CDN assets, set up a "www-localstage" virtual host and /etc/host mapping, and use the deploy-localstage build target.

Note that you can't deploy to production, either the main server or the CDN, without proper credentials.






