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
 *
 * NOTE: In $...meta don't use $website_url in the url to be created, otherwise fopen won't work for some reason
 */
	$fingermeta = fopen(".well-known/webfinger?resource=acct:".$username."@".$_SERVER['SERVER_NAME'], "w") or die("Unable to open or create .well-known/webfinger?resource=acct:".$username."@".$_SERVER['SERVER_NAME']." file");

	$fingerdata = "{\n\t\"subject\": \"acct:".$username."@".$_SERVER['SERVER_NAME']."\",\n\n\t\"links\": [\n\t\t{\n\t\t\t\"rel\": \"self\",\n\t\t\t\"type\": \"application/activity+json\",\n\t\t\t\"href\": \"".$website_url."users/".$username.".json\"\n\t\t}\n\t]\n}";
	fwrite($fingermeta,$fingerdata);
?>
