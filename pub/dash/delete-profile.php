<?php
/*
 * pub/dash/delete-profile.php
 *
 * A page where users can delete their profile.
 *
 * since Federama version 0.2
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Delete profile⋮$website_name — Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Delete profile"); ?></h2>
				<p class="w3-padding"><?php echo "Users cannot completely remove their profiles from the Fediverse. Deleting their profiles from this website means their posts will be removed and their profile will be removed from this website, and their username will be 'reserved' to keep anyone else from claiming it. If their posts were shared by other Fediverse users, those shared posts will remain."; ?></p>

			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
