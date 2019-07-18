<?php
/*
 * pub/dash/messages.php
 *
 * A page with a user's ActivityPub inbox and outbox.
 *
 * since Federama version 0.1
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Messages⋮$u_name — Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Messages"); ?></h2>

				<a href="add-message.php" class="w3-button w3-theme-dark w3-margin-left"><?php echo _("ADD NEW MESSAGE"); ?></a>
				<p class="w3-padding">A chronological list of messages/toots from accounts this user subscribes to, plus any messages from this user to others.</p>
				<p class="w3-padding">It would be nice if the messages could be sorted into months for easier access to older messages. Otherwise it should look like a timeline from Twitter, Mastodon, Pleroma, etc.</p>
			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
