<?php
/*
 * pub/the-user-webfinger.php
 *
 * Creates a webfinger document for a user.
 *
 * since Federama version 0.2
 *
 */
?>
<?php

/*
 *
 * CREATE WEBFINGER DOCUMENT
 */
	$fingermeta = fopen($website_url.".well-known/webfinger?resource=acct:".$username."@".short_url($website_url), "w") or die("Unable to open or create ".$website_url.".well-known/webfinger?resource=acct:".$username."@".short_url($website_url)." file");
	$fingerdata = "{\n\t\"subject\": \"acct:\"".$username."@".short_url($website_url)."\",\n\n\t\"links\": [\n\t\t{\n\t\t\t\"rel\": \"self\",\n\t\t\t\"type\": \"application/activity+json\",\n\t\t\t\"href\": \"".$website_url."users/".$username.".json\"\n\t\t}\n\t]\n}";
	fwrite($fingermeta,$fingerdata);
?>
