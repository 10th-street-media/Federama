<?php
/*
 * pub/dash/edit-post.php
 *
 * Allows users to edit a post.
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

if ($sel_id != '') {

	$getpostq = "SELECT * FROM ".TBLPREFIX	."posts WHERE post_id='".$sel_id."'";
	$getpostquery = mysqli_query($dbconn,$getpostq);
	while ($getpostopt = mysqli_fetch_assoc($getpostquery)) {
		$userid		= $getpostopt['user_id'];
		$pdate		= $getpostopt['post_date'];
		$ptitle		= $getpostopt['post_title'];
		$pslug		= $getpostopt['post_slug'];
		$ptext		= $getpostopt['post_text'];
		$pstatus		= $getpostopt['post_status'];
		$ptype		= $getpostopt['post_type'];
		$pmdate		= $getpostopt['post_modified_date'];
		$ptags		= $getpostopt['post_tags'];
		$pcats		= $getpostopt['post_categories'];
		$pping		= $getpostopt['ping_status'];
		$pcomment	= $getpostopt['comment_status'];

	}
}


/**
 * Form processing
 */
if (isset($_POST['post-submit'])) {
	$id		= $_POST['post-id'];
	$title	= nicetext($_POST['post-title']);
	$slug		= makeslug($_POST['post-title']);
	$text		= nicetext($_POST['post-text']);
	$now		= date("Y-m-d H:i:s");

	$updpostq	= "UPDATE ".TBLPREFIX."posts SET post_title='".$title."', post_slug='".$slug."', post_text='".$text."', post_modified_date='".$now."' WHERE post_id='".$id."'";
	$updpostquery = mysqli_query($dbconn,$updpostq);
	redirect($website_url."dash/posts.php");
}


$pagetitle = _("Edit post⋮$website_name — Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">
<?php echo $updpostq; ?>
				<h2 class="w3-padding"><?php echo _("Edit post"); ?></h2>
				<form method="post" action="edit-post.php">
					<input type="hidden" name="post-id" id="post-id" value="<?php echo $sel_id; ?>">
					<input type="text" name="post-title" id="post-title" class="w3-input w3-padding w3-margin-left" value="<?php echo $ptitle; ?>"><br>
					<textarea name="post-text" id="post-text" class="w3-input w3-padding w3-margin-left" rows="12"><?php echo $ptext; ?></textarea><br>
					<input type="submit" name="post-submit" id="post-submit" class="w3-theme-dark w3-button w3-margin-left" value="<?php echo _('UPDATE POST'); ?>">
				</form>
			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
