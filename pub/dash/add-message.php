<?php
/*
 * pub/dash/add-messages.php
 *
 * Allows users to create messages.
 *
 * since Federama version 0.1
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Add new message⋮$website_name — Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Add new message"); ?></h2>
				<form method="post" action="add-message.php">
					<textarea name="message-text" id="message-text" class="w3-input w3-padding w3-margin-left" rows="3"></textarea><br>
					<input type="submit" name="message-submit" id="message-submit" class="w3-theme-dark w3-button w3-margin-left" value="<?php echo _('PUBLISH MESSAGE'); ?>">
				</form>
			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
