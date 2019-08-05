<?php
/*
 * pub/dash/add-messages.php
 *
 * Allows users to create messages.
 *
 * since Federama version 0.1
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

/**
 * Form processing
 */
if (isset($_POST['message-submit'])) {

	/**
	 *
	 * Messages are not posts or pages. They are handled differently.
	 * We need to get the sender's outbox and the recipient’s inbox
	 * and add this message to it.
	 *
	 * We need to parse the recipient(s), then do nicetext().
	 */

	$text		= nicetext($_POST['message-text']);
	$now		= date("Y-m-d H:i:s");
	$nowmin	= date("YmdHis");
	$nowxml	= date("Y-m-dTH:i:sZ");

if (isset($_COOKIE['uname'])) {

	/**
	 * This is how the message will show up in the author's outbox
	 */
	$outboxmessage = "{
		\"@context\": \"https://www.w3.org/ns/activitystreams\",
		\"type\": \"Note\",
		\"id\": \"".$website_url."users/".$_COOKIE['uname']."/status/".$nowmin."\",
		\"content\": \"".$text."\",
		\"published\": \"".$nowxml."\"
	}";

	/**
	 * This is how the message will appear in the recipient's inbox
	 */
	$inboxmessage = "{
		\"@context\": \"https://www.w3.org/ns/activitystreams\",
		\"type\": \"Create\",
		\"id\": \"".$website_url."users/".$_COOKIE['uname']."/status/".$nowmin."\",
		\"actor\": \"".$website_url."users/".$_COOKIE['uname']."\",
		\"object\": {
			\"id\": \"".$website_url."users/".$_COOKIE['uname']."/status/".$nowmin."\",
			\"type\": \"Note\",
			\"attributedTo\": \"".$website_url."users/".$_COOKIE['uname']."\",
			\"content\": \"".$text."\",
			\"published\": \"".$nowxml."\",
			\"to\": \"".$website_url."users/".$_COOKIE['uname']."/followers/\"
		},
		\"published\": \"".$nowxml."\",
		\"to\": \"".$website_url."users/".$_COOKIE['uname']."/followers/\"
	}";
}

	/**
 	 * Send the $outboxmessage to the user's outbox
 	 *
 	 * The outbox is an array, so we need to pull it,
 	 * convert it to a string, then add the message,
 	 * and convert it back into an array before updating
 	 * the table
 	 */
	$outboxq = "SELECT * FROM ".TBLPREFIX."users where user_name='".$_COOKIE['uname']."'";
	$outboxquery = mysqli_query($dbconn,$outboxq);
	while ($outboxfetch = mysqli_fetch_assoc($outboxquery)) {
		$outboxarr = $outboxfetch['user_outbox'];


	}


	/**
	 * Send the $inboxmessage to the site inbox
	 *
	 * The site inbox is the TBLPREFIX.messages table
	 */



	redirect($website_url."dash/messages.php");
}

$pagetitle = _("Add new message « $website_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Add a new message"); ?></h2>
				<form method="post" action="add-message.php">
					<textarea name="message-text" id="message-text" class="w3-input w3-padding w3-margin-left" rows="3"></textarea><br>
					<input type="submit" name="message-submit" id="message-submit" class="w3-theme-dark w3-button w3-margin-left" value="<?php echo _('PUBLISH MESSAGE'); ?>">
				</form>
			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
