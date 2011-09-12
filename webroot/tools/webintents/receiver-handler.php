<html>
<head>
	<script src="http://examples.webintents.org/lib/webintents.js"></script>
	<script src="http://examples.webintents.org/lib/events.js"></script>
	<script src="http://examples.webintents.org/lib/common.js"></script>
</head>
<body>


	<script>
    	attachEventListener(window, "load", function(e) {
			if (intent.data) {
				var url = intent.data;
				var offerUrl = "http://www.oexchange.org/demo/linkeater/offer.php?url=" + url;
				window.location.href = offerUrl;
			} else {
				alert("WTF, bad intent!");
			}
			intent.postResult("Thanks, your link has been shared!");
		});
	</script>
	
</body>