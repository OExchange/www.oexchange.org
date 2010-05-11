<?php include './template/header.html' ?>

<div id="message" class="messagebox" style="display:none"></div>
<div id="loading"></div>

<div id="header">
	<h1 id="title">My OExchange Services</h1>
    <a id="oex-main-whatisthis" href="#">What is this?</a>
    <button id="oex-main-add">Add</button>
</div>

<div id="text"></div>

<table border="1" id="srvcs" style="display:none">
	<thead>
		<tr>
			<th><a href="#" id="oex-priority-sort">Priority</a></th>
			<!--<th>Reorder</th>-->
			<th><a href="#" id="oex-services-sort">Services</a> <span class="oex-note">Drag to reorder this list.</span></th>
			<th>URL</th>
			<th>Remove</th>
		</tr>
	</thead>    
	<tbody></tbody>
</table>


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
    <p>
    To look up a service to add, enter the URL below to see if that site supports sharing with OExchange:
    </p>
    <p>
    http://<input type="text" size="30"/>
    </p>
    <div class="oex-controls">
        <button>Go</button>
        <button class="oex-sub-cancel">Cancel</button>
    </div>
</div>

<div class="oex-sub" id="oex-publish" style="display:none">
    <h2>Publish your sharing services?</h2>
    <p>
    To publish your sharing services to your Webfinger account, please enter your email address.
    <a id="oex-publish-why" href="#">Why should I do this?</a>
    </p>
    <p>
    Email: <input type="text" size="30"/>
    </p>
    <div class="oex-controls">
        <button>Save</button>
        <button class="oex-sub-cancel">Cancel</button>
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
    Your sharing services are stored in a local browser cookie. If you choose to Publish them, they will be publicly accessible via your Google Webfinger account and ....
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
        <button class="oex-sub-cancel">Ok</button>
    </div>
</div>

<div>
    Publish my saved services to a public profile. <a id="oex-main-whatispublish" href="#">What does this mean?</a>
    <button id="oex-main-publish">Publish</button>
</div>

<div>
    <button>Done</button>
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

<?php include './template/footer.html' ?>
