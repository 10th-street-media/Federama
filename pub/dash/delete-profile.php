<?php
/*
 * pub/dash/delete-profile.php
 *
 * A page where users can delete their profile.
 *
 * since Federama version 0.1
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
				<p class="w3-padding"><?php echo "Users cannot completely remove their profile from the Fediverse. Deleting your profile from this website means yuor posts will be removed and their profile will be removed from this website, and their username will be 'reserved' to keep anyone else from claiming it. If their posts were shared by other Fediverse users, those shared posts will remain."; ?></p>
				<p class="w3-padding"><b><?php echo _("Are you sure you want to delete your profile?"); ?></b></p>
				<form method="post" action="delete-profile.php">
					<input type="hidden" name="post-id" id="post-id" value="<?php echo $sel_id; ?>">
					<table>
						<tr>
							<td><input type="submit" name="postdelete" id="postdelete" class="w3-theme-dark w3-button w3-margin-left" value="<?php echo _('YES'); ?>"></td>
							<td><input type="submit" name="postcancel" id="postcancel" class="w3-theme-dark w3-button w3-margin-left" value="<?php echo _('NO'); ?>"></td>
						</tr>
					</table>
				</form>
			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
