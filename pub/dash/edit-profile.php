<?php
/*
 * pub/dash/edit-profile.php
 *
 * A page where users can edit their profile.
 *
 * since Federama version 0.2
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Edit profile⋮$website_name — Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Edit profile"); ?></h2>
				<p class="w3-padding"><?php echo "Users can use this page to edit most parts of their profile."; ?></p>

			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
