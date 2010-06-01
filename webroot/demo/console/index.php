<?php include './template/header.html' ?>
<script type="text/javascript">
    var oex_defaultServices = <?php echo ($_GET['demo'] ? 'true' : 'false'); ?>;
</script>

<div id="message" class="messagebox" style="display:none"></div>
<div id="loading"></div>

<div id="header">
	<h1 id="title">My OExchange Services</h1>
    <a id="oex-main-whatisthis" href="#">What is this?</a>
    <button id="oex-main-add">Add</button>
</div>
<div id="content">
    <div id="no-services" style="display:none">
        <p><a href="http://www.oexchange.org" target="_blank">OExchange</a> is a way for websites, sharing tools, and sharing services like Facebook or Twitter to allow you to more easily share content between them.</p>
        <p>When you visit a sharing service that supports OExchange, you have the option of saving that service as one of your favorite places to share.</p>
        <p>Then, when you use a sharing tool that also supports OExchange, you'll be able to easily share to your favorite services.</p>
        <p>Once you've saved at least one OExchange service, you'll be able to manage your services here. Just select <strong>Edit</strong> to return to this screen.</p>
        <p>Want to give it a try? Here are a few services, or select <strong>Add</strong> to search for more:</p>
        <div id="oex-services-promo">
           <a ox:service="facebook" href="#">Facebook</a> 
           <a ox:service="buzz" href="#">Google Buzz</a> 
           <a ox:service="twitter" href="#">Twitter</a> 
           <a ox:service="digg" href="#">Digg</a> 
           <a ox:service="delicious" href="#">Delicious</a>
        </div>
    </div>
    <div class="srvcs" style="display:none">
    <table id="srvcs" cellspacing="0">
        <colgroup><col width="5%"/><col width="85%"/><!--<col width="75%"/>--><col width="10%"/></colgroup>
    	<thead>
    		<tr>
    			<th>Pri</th>
    			<th>Name <span class="oex-note">Drag to reorder this list.</span></th>
    			<!-- <th>URL</th> -->
    			<th>Remove</th>
    		</tr>
    	</thead>    
    	<tbody></tbody>
    </table>
    </div>
    
    <div class="oex-sub" id="oex-delete" style="display:none">
        <h2>Are you sure you want to delete this service?</h2>
        <p>
        If you change your mind, you can add the service again here or at the service's web site.
        </p>
        <div class="oex-controls">
            <button id="oex-remove-service">Delete</button>
            <button class="oex-sub-cancel">Cancel</button>
        </div>
    </div>
    
    <div class="oex-sub" id="oex-add" style="display:none">
        <h2>Add a sharing service</h2>
        <p id="oex-add-content">
        To look up a service to add, enter the URL below to see if that site supports sharing with OExchange:
        </p>
        <p class="oex-feedback" id="oex-add-status" style="display:none">
        Looking for sharing services....
        </p>
        <p class="oex-error" id="oex-add-noservice" style="display:none">
        We're sorry, but no sharing services were found at this web site.
        </p>
        <p id="oex-add-success" style="display:none">
            <span class="oex-success">Success! This service has been added to your favorites.</span>
        </p>
        <p class="oex-error" id="oex-add-error" style="display:none">
        Please enter a valid domain, such as: Google.com or Facebook.com.
        </p>
        <p>
        http://<input type="text" size="30" id="oex-new-service"/>
        </p>
        <div class="oex-controls">
            <button id="oex-search-service">Go</button>
            <button class="oex-sub-cancel" id="oex-add-service" style="display:none">Done</button>
            <button class="oex-sub-cancel" id="oex-add-cancel">Cancel</button>
        </div>
    </div>
    
    <div class="oex-sub" id="oex-publish" style="display:none">
        <h2>Publish your sharing services?</h2>
        <p>
        To publish your sharing services to your Webfinger account, please enter your email address.
        <a id="oex-publish-why" href="#">Why should I do this?</a>
        </p>
        <p class="oex-feedback" id="oex-publish-status" style="display:none">
        Publishing sharing services....
        </p>
        <p class="oex-error" id="oex-publish-error" style="display:none">
        We're sorry, but we were unable to publish your sharing services.
        </p>
        <p id="oex-publish-success" style="display:none">
            <span class="oex-success">Success! Your services have been published.</span>
        </p>
        <p>
        Email: <input id="oex-publish-email" type="text" size="30"/>
        </p>
        <div class="oex-controls" id="oex-publish-controls">
            <button id="oex-xrdp-save">Save</button>
            <button class="oex-sub-cancel">Cancel</button>
        </div>
        <div class="oex-controls" id="oex-publish-close">
            <button class="oex-sub-cancel">Close</button>
        </div>
    </div>
    
    <div class="oex-sub" id="oex-info-services" style="display:none">
        <h2>What are "my sharing services"?</h2>
        <p>
        This is a list of your favorite places to share that support <a href="http://www.oexchange.org" target="_blank">OExchange</a>, a public definition of how sharing should work. 
        These services are saved in a browser cookie unless you choose to publish them to your Webfinger account. 
        </p>
        <div class="oex-controls">
            <button class="oex-sub-cancel">Ok</button>
        </div>
    </div>
    
    <div class="oex-sub" id="oex-info-how" style="display:none">
        <h2>How are my sharing services stored?</h2>
        <p>
        Your sharing services are stored in a local browser cookie. If you choose to publish them, they will be publicly accessible via Webfinger.
        </p>
        <div class="oex-controls">
            <button class="oex-sub-cancel">Ok</button>
        </div>
    </div>
    
    <div class="oex-sub" id="oex-info-why" style="display:none">
        <h2>Why should I publish my sharing services?</h2>
        <p>
        If you choose to publish your sharing services, they will be publicly accessible to other tools that can use them to make sharing more convenient. In addition, your services will be available should you remove or lose your browser cookies.
            </p>
        <div class="oex-controls">
            <button class="oex-publish">Ok</button>
        </div>
    </div>
    
    <div id="foot-publish" style="display:none">
        Publish my saved services to a public profile (<a id="oex-main-whatispublish" href="#">?</a>):
        <button class="oex-publish">Publish</button>
    </div>
    
    <div id="foot-done">
        <button class="oex-done">Done</button>
    </div>
    
    <?php
        if (isset($_GET['debug'])) {
    ?>
    <br />
    <br />
    <br />
    <hr />
    For debugging:<br />
    Enter XRDs, comma-separated:<br />
    <textarea id="tmp-xrd-input" cols="50" rows="10">
    http://www.oexchange.org/demo/linkeater/oexchange.xrd,http://api-dev.addthis.com/oexchange/0.8/xrd/facebook.xrd
    </textarea><br />
    <input type="button" id="tmp-xrd-save" value="save" /><br />
    <input type="button" id="tmp-xrd-add" value="add" /><br />
    <br />
    <input type="button" id="tmp-xrd-empty" value="empty" /><br />
    <br />
    <input type="button" id="tmp-xrd-reset" value="reset" /><br />
    <?php
        }
    ?>


</div>    
<?php include './template/footer.html' ?>
