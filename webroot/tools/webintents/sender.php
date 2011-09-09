<html>
<head>
<script src = "http://examples.webintents.org/lib/webintents.js" > </script>
<script src = "http://examples.webintents.org/lib/events.js" > </script>
</head >
<body>

	<script>
		attachEventListener(window, "load", function() {
		    var shareLink = document.getElementById("shareLink");
		    attachEventListener(shareLink, "click", function() {
		        console.log("Creating intent...");
				var url = "http://www.example.com";
		        var intent = new Intent();
		        intent.action = "http://webintents.org/share";
		        intent.type = "text/uri-list";
		        intent.data = [url];
		        console.log("Starting activity...");
		        window.navigator.startActivity(intent);
		        console.log("Activity started.");
		        return false;
		    },
		    false);
		});
	</script>

    <button id="shareLink">Share some URL</button >

</body>
