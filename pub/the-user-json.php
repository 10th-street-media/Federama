<?php
/*
 * pub/the-user-json.php
 *
 * Creates a JSON-LD document for a user.
 *
 * since Federama version 0.2
 *
 */
?>
<?php

/*
 *
 * CREATE JSON FILE
 *
 * NOTE: In $...meta don't use $website_url in the url to be created, otherwise fopen won't work for some reason
 */
	$jsonmeta = fopen("data/".$username.".json", "w") or die("Unable to open or create data/".$username.".json file");

	$jsondata = "{\n\t\"@context\": [\n\t\t\"https://www.w3.org/ns/activitystreams\",\n\t\t\"https://w31d.org/security/v1\"\n\t],\n\n\t\"id\": \"".$website_url."data/".$username.".json\",\n\t\"type\": \"Person\",\n\t\"preferrefUsername\": \"".$username."\",\n\t\"inbox\": \"".$website_url."users/".$username."/inbox\",\n\n\t\"publicKey\": {\n\t\t\"id\": \"".$website_url."users/".$username."#public-key\",\n\t\t\"owner\": \"".$website_url."users/".$username."\",\n\t\t\"publicKeyPem\": \"".$userpubkey."\"\n\t}\n}";
	fwrite($jsonmeta,$jsondata);
?>
