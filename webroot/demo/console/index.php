<?php include './template/header.html' ?>

<div id="message" class="messagebox" style="display:none"></div>

<div id="loading"></div>

<h1 id="title">My Saved Sharing Services</h1>

<div id="text">

<h2>What is OExchange?</h2>
<p>OExchange is simple way for content to be shared on the Web. OExchange can keep track of your favorite places to share things, and if you use a sharing product that supports OExchange, personalize your sharing experience for you.</p>
<h2>Ok, how does it work?</h2>
<p>If you are visiting a web site that supports OExchange sharing, look for the OExchange logo to save that site as a favorite place to share. You can make changes to your saved services here at any time.</p> 
<p>Here are a few sites that are using OExchange for sharing. You can also find out if your favorite site supports OExchange sharing by selecting <strong>Find a Service...</strong> above.</p>
<ul>
    <li>Site.com</li>
    <li>Site.com</li>
    <li>Site.com</li>
    <li>Site.com</li>
    <li>Site.com</li>
</ul>
</div>


<table border="1" id="srvcs" style="display:none">
<thead>
    <tr>
        <th>Priority <a href="#" id="priority-button">?</a></th>
        <th>Reorder</th>
        <th>Service Name</th>
        <th>URL</th>
        <th>Remove</th>
    </tr>
</thead>    
<tbody>
</tbody>
</table>

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


<?php include './template/footer.html' ?>
