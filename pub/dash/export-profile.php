<?php
/*
 * pub/dash/export-profile.php
 *
 * A page where users can export their profiles, hopefully in some sort of standard format.
 *
 * since Federama version 0.2
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Export profile⋮$website_name — Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Export profile"); ?></h2>
				<p class="w3-padding"><?php echo "Users can use this page export their profiles, preferably in a format that can be read by WordPress, Mastodon, and other CMS software."; ?></p>

			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
