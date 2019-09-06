<?php
/*
 * pub/dash/import-profile.php
 *
 * A page where users can import their profile from other websites.
 *
 * since Federama version 0.2
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Import profile « $website_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Import profile"); ?></h2>
				<p class="w3-padding"><?php echo "Users can use this page to import profile settings from other CMS platforms. Ideally this will mean all Federama-based platforms, Mastodon, and WordPress. I'm not sure if Pleroma, Misskey, and other Fediverse software platforms have the capability to export profiles."; ?></p>

			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
