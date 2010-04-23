<?php

require_once("../../lib-oexchange/OExchangeDiscoverer.php");

// User-oriented params
$me = $_REQUEST["me"];
$to = $_REQUEST["to"];

// Target and control params
$targetUrl = $_REQUEST["targeturl"];
$offerUrl = $_REQUEST["offerurl"];

// Other parameters are just the oexchange parameters (but we will try to get referer if we need to)
if (!isset($_REQUEST["url"])) {
	if (isset($_SERVER['HTTP_REFERER']) && !strpos($_SERVER['HTTP_REFERER'], "offer.php")) {
		$_REQUEST["url"] = $_SERVER['HTTP_REFERER'];
	} 
}

// If we don't have a parameter, is there any cookie that has the user's email in it?
if (!isset($me)) {
	if (isset($_COOKIE["wf_email"]) && (sizeof($_COOKIE["wf_email"]) > 0)) {
		$me = $_COOKIE["wf_email"];
	}
}

$cmd = getParamDflt($_REQUEST, "cmd", "share");

// Handle the different modes
if ($cmd == "share") {
	$oex = new OExchangeDiscoverer();
	
	// If we have a target URL, get the actual target/targets for that as well
	if (isset($targetUrl)) {
		if (strpos($targetUrl, "http") === 0) {
			
			// This is a URL, not a hostname
			$parts = parse_url($targetUrl);
			if (sizeof($parts["path"]) > 0) {
				
				// This looks like a full URL, try to look up an OExchange XRD at this location
				//echo "Attempting to find an oexchange xrd at " . $targetUrl . "<br/>";
				$target = $oex->getTargetInfoFromXrd($targetUrl);
			}
			if (!$target) {
				
				// Well, now try it as a host
				//echo "We were given a URL (" . $targetUrl . "), now attempting to look up host-meta on its host: " . $parts["host"] . "<br/>";
				$explicitTargets = $oex->getTargetsOnHost($parts["host"]);
			} else {
				$explicitTargets = array();
				push_array($explicit_targets, $target);
			}
		} else {
			
			// This might just be a hostname, try that
			//echo "We don't think " . $targetUrl . " is an URL, so attempting to look up host-meta on it." . "<br/>";
			$explicitTargets = $oex->getTargetsOnHost($targetUrl);
		}
	}

	// Do we know of a FROM user?
	if (isset($me)) {
		if ($me == "clear") {

			// We thought we had a user, but really we're forgetting them
			setcookie('wf_email', "", time() + (86400 * 14));
			unset($me); 
		} else {
			
			// We have a user, cookie them to remember them
			setcookie('wf_email', $me, time() + (86400 * 14)); 
		}
	}
	
	// Do we know of any TO users?
	if (isset($to)) {
		$toEmails = explode(",", $to);
	}
	
	// If we have just a FROM user, look up their preferred targets.  If we have both to and from, look up all of them
	if (isset($me) && isset($toEmails) && (sizeof($toEmails) > 0)) {
		$matchTargets = $oex->getCommonUserTargets($me, $toEmails);
		$userTargets = $matchTargets->fromTargets;
	} else if (isset($me)) {
		$userTargets = $oex->getTargetsForUser($me);
	}
	
	// Ok, we have what we need to render the UI
	require_once("pagestart.inc.php");

?>
	<div id="offerpage">
		<? 
		
		// If there was a specificaly-entered URL/host, and we found a Target there, prioritize this
		if (isset($explicitTargets) && sizeof($explicitTargets) > 0) {

			// Yes, great
			echo "<h3>Hurrah!</h3>";
			echo "<p>It looks like " . $targetUrl . " can accept your link!  Ready?</p>";
			foreach($explicitTargets as $target) {
				echo buildTargetLinkForm2($target);
			}
			echo "<p>No thanks, <a href=\"" . urlRemoveParam(currentUrl(), "targeturl") . "\">try something else.</a></p>";
		} else {
			
			// Do the normal choices

			// We'll show an error if there were probs with a specified target
			if (isset($targetUrl)) {

				// We know the user tried to specify a target directly, and it didn't work
				echo "<div class=\"error_message\">Sorry, we asked " . $targetUrl . " if it could accept your link, and it doesn't look like it can :( </div>";
			}
		?>
		
		<!--<h2>Where to?</h2>-->
		<p>
		<?
		if (isset($_REQUEST["url"]) && (sizeof($_REQUEST["url"]) > 0)) {
			echo "What do you want to do with <a title=\"" . $_REQUEST["url"] . "\" href=\"" . $_REQUEST["url"] . "\">" . "your link" . "</a>?";
		} else {
			echo "<div class=\"error_message\">You need to pass a <code>url</code> parameter for this to really work...</div>";
		}
		?>
		</p>

		<? 
		
		// Recommended services (personalized or not)
		if (isset($me) && isset($to)) {
			
			// The user tried to send FROM one user TO other users...and we did a lookup.  Show the results.
			if (sizeof($matchTargets->commonTargets) > 0) {
				
				// Sweet, there are targets the users all have in common
				$conjunction = ((sizeof($toEmails) > 1) ? "all" : "both");
				echo "<h3>Services in common</h3>";
				echo "<p>These are the services that you " . $conjunction . " use:</p>";
				foreach($matchTargets->commonTargets as $target) {
					echo buildTargetLink($target);
				}

				// Also show the others
				echo "<h3>More options</h3>";
				insertAddThisHere();
			} else if (sizeof($matchTargets->fromTargets) > 0) {
				
				// There weren't'any matches...but the user does have some personalized services
				echo "<h3>Choose a Service</h3>";
				echo "<p>We couldn't figure out any services you use in common, but here are your personal favorites:</p>";
				foreach($matchTargets->fromTargets as $target) {
					echo buildTargetLink($target);
				}
				echo "<p>And some other options (or just <a target=\"_blank\" href=\"http://api.addthis.com/oexchange/0.8/forward/email/offer?url=" . $_REQUEST["url"] . "&to=" . $to . "&from=" . $me . "\">email them</a>)</p>";
				insertAddThisHere();
				//echo "<p>Or, just <a href=\"mailto:" . $to . "\">email them</a> directly!</p>";
			} else {

				// There weren't'any matches...
				echo "<h3>Recommended Services</h3>";
				echo "<p>We couldn't figure out any services you use in common, but you can try these options...</p>";
				insertAddThisHere();
				//echo "<p>Or, just <a href=\"mailto:" . $to . "\">email them</a> directly!</p>";
			}
		} else if (isset($userTargets) && sizeof($userTargets) > 0) {
			
			// This user has some preferred services, cool
			echo "<h3>Your preferred services</h3>";
			foreach($userTargets as $target) {
				echo buildTargetLink($target);
			}
			
			// Also show the others
			echo "<h3>More options</h3>";
			insertAddThisHere();
		} else {
			echo "<h3>Recommended Services</h3>";
			insertAddThisHere();
	} 
	?>

		<!-- Direct URL entry -->
		<br/>
		<p>
			<form id="targetEntry" action="<?= currentUrl(); ?>" method="GET" style="">
				You can also try entering the URL of a site you're trying to send this to (the site has to support <a href="http://www.oexchange.org/spec">OExchange</a>).
				<br/>
				&nbsp;
				&nbsp;
				&nbsp;
				&nbsp;
				<input type="text" name="targeturl" value=""/>
					&nbsp;
					&nbsp;
				<?
				echo getContentParamsToFormFields();
				?>	
				<input type="submit" value="Try this URL" />
			</form>
		</p>

		<!-- user stuff -->
		<br/>
		<? 
			// Do we know anything about the current user?
			if (isset($me)) {
				echo "<p>";
				$clearUrl = copyContentParamsTo("?me=clear");
				if (isset($userTargets) && sizeof($userTargets) > 0) {
					echo "We WebFingered you to find your preferred services. ";
				} else {
					echo "We WebFingered you but didn't find any preferred services.";
				}
				echo " (<a href=\"" . $clearUrl . "\">not " . $me . "?</a>)";
				echo "</p>";
			} else {
		?>		
				<p style="font-style: italic;">
					<form id="emailEntry" action="<?= currentUrl(); ?>" method="GET" style="font-style: italic;">
						Want personalization with that?  If you have service preferences set up with your email address and <a href="">WebFinger</a>, we can use your email to look them up.
						<br/>
						&nbsp;
						&nbsp;
						&nbsp;
						&nbsp;
						<input type="text" name="me" value=""/>
							&nbsp;
							&nbsp;
						<?
						echo getContentParamsToFormFields();	
						?>
						<input type="submit" value="Lookup" />
					</form>
				</p>
		<? 
			}
			
			// What about other to users?
			if (isset($to)) {
				
				
			} else {
			
				// Don't have any recipients.  If we know who the current user is, and we found services for them, ask them if they want to send this to someone in particular.
				if (isset($me) && isset($userTargets) && (sizeof($userTargets) > 0)) {
					?>		
					<p style="font-style: italic;">
						<form id="emailEntry" action="<?= currentUrl(); ?>" method="GET" style="font-style: italic;">
							Are you trying to send this to somebody in particular?  Enter comma-separated email address, and we'll try to figure out how.
							<br/>
							&nbsp;
							&nbsp;
							&nbsp;
							&nbsp;
							<input type="text" name="to" value=""/>
								&nbsp;
								&nbsp;
							<?
							echo getContentParamsToFormFields();	
							?>
							<input type="submit" value="Lookup Addresses" />
						</form>
					</p>
					<? 

					
				}
 			}
		}
		?>		
		</div>
	<?
	require_once("footer.inc.php");
	require_once("pageend.inc.php");
} 

function buildTargetLink($target) {
	$offerUrl = copyContentParamsTo($target->endpoint);
	return "<img src=\"" . $target->icon . " \">" . "&nbsp;" . "&nbsp;". "<a target=\"_blank\" href=\"" . $offerUrl . "\">" .  $target->name . "</a> (" . $target->prompt . ")<br/>";
}

function buildTargetLinkForm2($target) {
	$offerUrl = copyContentParamsTo($target->endpoint);
	return "<img src=\"" . $target->icon . " \">" . "&nbsp;" . "&nbsp;". "<a target=\"_blank\" href=\"" . $offerUrl . "\">" .  $target->prompt . "</a><br/>";
}

function currentUrl() {
	$pageUrl = "http://" . $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	return $pageUrl;
}

function urlRemoveParam($url, $paramName) {
	$start = strpos($url, $paramName);
	if ($start > 0) {
		
		// param is present
		if (strpos($url, "&", $start + 1) == -1) 
			
			// this is the last param 
			$url = substr($url, 0, $start);
		else { 
			
			// there are more params after this
			$end = strpos($url, "&", $start + 1);
			$url = substr($url, 0, $start) . substr($url, $end);
		}
	}
	return $url;
}

function urlAddOrReplaceParam($url, $paramName, $paramVal) {
	$url = urlRemoveParam($url, $paramName);
	if (strpos($url, "?") === false) {
		$url = $url . "?" . $paramName . "=" . $paramVal;
	} else {
		$url = $url . "&" . $paramName . "=" . $paramVal;
	}
	return $url;
}

function getContentParamsToFormFields() {
	$form = "";
	if (isset($_REQUEST["title"])) 
		$form .= ("<input type=\"hidden\" name=\"title\" value=\"" . $_REQUEST["title"] . "\"/>");
	if (isset($_REQUEST["url"])) 
		$form .= ("<input type=\"hidden\" name=\"url\" value=\"" . $_REQUEST["url"] . "\"/>");
	if (isset($_REQUEST["description"])) 
		$form .= ("<input type=\"hidden\" name=\"description\" value=\"" . $_REQUEST["description"] . "\"/>");
	return $form;
}

/**
* Copy content-related params from current GET request to the specified url
*/
function copyContentParamsTo($newUrl) {
	if (isset($_REQUEST["url"])) {
		$newUrl = urlAddOrReplaceParam($newUrl, "url", $_REQUEST["url"]);
	}
	if (isset($_REQUEST["title"])) {
		$newUrl = urlAddOrReplaceParam($newUrl, "title", $_REQUEST["title"]);
	}
	if (isset($_REQUEST["description"])) {
		$newUrl = urlAddOrReplaceParam($newUrl, "description", $_REQUEST["description"]);
	}
	return $newUrl;
}

function insertAddThisHere() {
	?>
	<div class="addthis_toolbox addthis_default_style">
		<a class="addthis_button_preferred_1" style="cursor:pointer"></a>&nbsp;&nbsp;&nbsp;
		<a class="addthis_button_preferred_2" style="cursor:pointer"></a>&nbsp;&nbsp;&nbsp;
		<a class="addthis_button_preferred_3" style="cursor:pointer"></a>&nbsp;&nbsp;&nbsp;
		<a class="addthis_button_preferred_4" style="cursor:pointer"></a>&nbsp;&nbsp;&nbsp;
		<a class="addthis_button_preferred_5" style="cursor:pointer"></a>&nbsp;&nbsp;&nbsp;
		<a class="addthis_button_preferred_6" style="cursor:pointer"></a>&nbsp;&nbsp;&nbsp;
		<a class="addthis_button_preferred_7" style="cursor:pointer"></a>&nbsp;&nbsp;&nbsp;
		<a class="addthis_button_compact" style="cursor:pointer"></a>
	</div>
	
	<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=willmeyer"></script>
	<?	
}

?>