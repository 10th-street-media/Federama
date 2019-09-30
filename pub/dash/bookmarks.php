<?php
/*
 * pub/dash/bookmarks.php
 *
 * A page with all of a user's ActivityPub likes and dislikes.
 *
 * since Federama version 0.1
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Posts « $website_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-padding w3-col s12 m8 l10">

				<h2 class="w3-padding"><?php echo _("Posts"); ?></h2>

				<p class="w3-padding">A chronological list of posts, toots, messages, images, etc that this user likes or dislikes.</p>

				<p class="w3-padding">Maybe put the dislike items in a different tab on this page.</p>

			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
