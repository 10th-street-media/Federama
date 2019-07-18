<?php
/*
 * pub/dash/profile.php
 *
 * A page with a user's profile.
 *
 * since Federama version 0.1
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Profile⋮$website_name — Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Profile"); ?></h2>
				<ul>
					<li>Edit</li>
					<li>Import</li>
					<li>Export</li>
					<li>Delete</li>
				</ul>

			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
