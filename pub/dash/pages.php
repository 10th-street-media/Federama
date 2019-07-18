<?php
/*
 * pub/dash/pages.php
 *
 * Pages are posts that exist outside the timeline. Useful for things
 * like documentation and tutorials.
 *
 * since Federama version 0.1
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Pages⋮$website_name — Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Pages"); ?></h2>

				<a href="add-page.php" class="w3-button w3-theme-dark w3-margin-left"><?php echo _("ADD NEW PAGE"); ?></a>
				<p class="w3-padding">A list of pages on this instance, sorted by alphabetically by title of parent page, then titles of subpages.</p>


			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
