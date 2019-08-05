<?php
/*
 * pub/dash/delete-post.php
 *
 * A page where a post can be deleted.
 *
 * since Federama version 0.2
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

if (isset($_GET["pid"])) {
	$sel_id = $_GET["pid"];
} else {
	$sel_id = "";
}

/**
 * Form processing
 */
if (isset($_POST['postdelete'])) {

	$id		= $_POST['post-id'];

	$postq	= "DELETE FROM ".TBLPREFIX."posts WHERE post_id='".$id."'";
	$postquery = mysqli_query($dbconn,$postq);
	redirect($website_url."dash/posts.php");

} else if (isset($_POST['postcancel'])) {
	redirect($website_url."dash/posts.php");
}


$pagetitle = _("Delete post⋮$website_name — Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Delete post"); ?></h2>
				<p class="w3-padding"><?php echo _('Deleting a post will remove it from this instance only. If a post has been shared or reposted by users on this or other instances, those versions will still exist.'); ?></p>
				<p class="w3-padding"><b><?php echo _("Are you sure you want to delete this post?"); ?></b></p>
				<form method="post" action="delete-post.php">
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
