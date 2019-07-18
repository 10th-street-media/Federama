<?php
/*
 * pub/dash/add-page.php
 *
 * Allows users to create pages.
 *
 * since Federama version 0.1
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Add new page⋮$website_name — Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Add new page"); ?></h2>
				<form method="post" action="add-page.php">
					<input type="text" name="page-title" id="page-title" class="w3-input w3-padding w3-margin-left" placeholder="<?php echo _('Add title'); ?>"><br>
					<textarea name="page-text" id="page-text" class="w3-input w3-padding w3-margin-left" rows="12"></textarea><br>
					<input type="submit" name="page-submit" id="page-submit" class="w3-theme-dark w3-button w3-margin-left" value="<?php echo _('PUBLISH PAGE'); ?>">
				</form>
			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
