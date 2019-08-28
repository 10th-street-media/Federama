<?php
/*
 * pub/dash/local-timeline.php
 *
 * A page with all public messages on this instance.
 *
 * since Federama version 0.2
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Local timeline « $u_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Local timeline"); ?></h2>

<?php
/**
 * In the future, this should pay attention to whether the message is public,
 * Also, DMs, msgs from this user, public @ messages, and regular timeline messages should each look different from each other,
 * And older messages should be sorted into folders depending on age (i.e. 2019, 2020, 2021, _('January'), _('February'), etc)
 * In the future...
 */


/**
 * Putting this here temporarily
 */
 echo "\t\t\t\t<section class=\"w3-indigo w3-padding w3-margin-left w3-margin-bottom\">\n";
 echo "\t\t\t\t<p>The <b>local timeline</b> will contain all public messages created by all public accounts on this instance.</p>\n";
 echo "\t\t\t\t</section>\n";


/**
 * Let's see if there are any messages in the database
 */
$msgq = "SELECT * FROM ".TBLPREFIX."messages ORDER BY message_time DESC"; /* Newer posts should appear first */
$msgquery = mysqli_query($dbconn,$msgq);
if (mysqli_num_rows($msgquery) > 0) {
	while ($msgopt = mysqli_fetch_assoc($msgquery)) {
		$msgid		= $msgopt['message_id'];
		$msgby		= $msgopt['user_name']; // this is their user name
		$msgtime		= $msgopt['message_time'];
		$msgtxt		= $msgopt['message_text'];
		$msglikes	= $msgopt['message_likes']; // a collection of users who liked this message
		$msgdlikes	= $msgopt['message_dislikes']; // a collection of users who disliked this message
		$msgshares	= $msgopt['message_shares']; // a collection of users who shared this message

		/**
		 * Get the name of the user who created the message
		 */
		$byq = "SELECT * FROM ".TBLPREFIX."users WHERE user_name=\"".$msgby."\"";
		$byquery = mysqli_query($dbconn,$byq);
		while($byopt = mysqli_fetch_assoc($byquery)) {
			$uname		= $byopt['user_name'];
			$udname		= $byopt['user_display_name'];

			if ($udname !== '') {
				$author = $udname;
			} else {
				$author = $uname;
			}
		} /* end while $byopt */


		/**
		 * Get the number of likes
		 */
		if ($msglikes !== '') {
			$msg_likes = preg_split('/,/',$msglikes);
			if (count($msg_likes) > 0) {
				$likes = count($msg_likes);
			}
		} else {
			$likes = 0;
		} /* end if $msglikes !== '' */


		/**
		 * Get the number of dislikes
		 */
		if ($msgdlikes !== '') {
			$msg_dlikes = preg_split('/,/',$msgdlikes);
			if (count($msg_dlikes) > 0) {
				$dlikes = count($msg_dlikes);
			}
		} else {
			$dlikes = 0;
		} /* end if $msgdlikes !== '' */


		/**
		 * Get the number of shares
		 */
		if ($msgshares !== '') {
			$msg_shares = preg_split('/,/',$msgshares);
			if (count($msg_shares) > 0) {
				$shares = count($msg_shares);
			}
		} else {
			$shares = 0;
		} /* end if $msgshares !== '' */

		echo "\t\t\t\t<section class=\"w3-theme-l3 w3-padding w3-margin-left w3-margin-bottom\">\n";
		echo "\t\t\t\t\t<span><a href=\"".$website_url."users/".$uname."\">".$author."</a>&nbsp;";
		echo "<a href=\"".$website_url."messages/".$msgid."\">".$msgtime."</a></span>\n";
		echo "\t\t\t\t\t<p>".$msgtxt."</p>\n";
		echo "\t\t\t\t\t<a href=\"".$website_url."dash/messages.php?uid=".$msgby."&mid=".$msgid."&type=like\" title=\""._('Like')."\"><i class=\"fa fa-smile-o\" aria-hidden=\"true\"></i></a> ".$likes."&nbsp;&nbsp;\n";
		echo "\t\t\t\t\t<a href=\"".$website_url."dash/messages.php?uid=".$msgby."&mid=".$msgid."&type=dislike\" title=\""._('Dislike')."\"><i class=\"fa fa-frown-o\" aria-hidden=\"true\"></i></a> ".$dlikes."&nbsp;&nbsp;\n";
		echo "\t\t\t\t\t<a href=\"#\" title=\""._('Share')."\"><i class=\"fa fa-retweet\" aria-hidden=\"true\"></i></a> ".$shares."&nbsp;&nbsp;\n";
		echo "\t\t\t\t\t<a href=\"#\" title=\""._('Reply')."\"><i class=\"fa fa-commenting\" aria-hidden=\"true\"></i></a>&nbsp;&nbsp;\n";
		echo "\t\t\t\t\t<a href=\"".$website_url."dash/messages.php?uid=".$msgby."&mid=".$msgid."&type=flag\" title=\""._('Flag for moderation')."\"><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i></a>&nbsp;&nbsp;\n";

		if ($usrlevel === 'ADMINISTRATOR' || 'MODERATOR') {
		echo "\t\t\t\t\t<a href=\"".$website_url."dash/admin/delete-message.php?mid=".$msgid."\" title=\""._('Delete the message')."\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a>\n";
		}
		echo "\t\t\t\t</section>\n";
	}
} else {
	echo "\t\t\t\t<p class=\"w3-padding\">"._('There are no messages yet.')."</p>";
} // end if mysqli_num_rows($msgquery)
?>
			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
