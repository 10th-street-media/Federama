<?php
/*
 * pub/dash/add-post.php
 *
 * Allows users to create a post.
 *
 * since Federama version 0.1
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

/**
 * Form processing
 */
if (isset($_POST['post-submit'])) {

	$title	= nicetext($_POST['post-title']);
	$slug		= makeslug($_POST['post-title']);
	$text		= nicetext($_POST['post-text']);
	$now		= date("Y-m-d H:i:s");

	$postq	= "INSERT INTO ".TBLPREFIX."posts (user_id, post_date, post_title, post_slug, post_text, post_status, post_type, post_modified_date, post_tags, post_categories, comment_status, ping_status) VALUES ('".$_COOKIE['id']."', '".$now."', '".$title."', '".$slug."', '".$text."', 'PUBLIC', 'POST', '".$now."', '', '', 'OPEN', 'OPEN')";
	$postquery = mysqli_query($dbconn,$postq);
	redirect($website_url."dash/posts.php");
}


$pagetitle = _("Add new post « $website_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Add new post"); ?></h2>
				<form method="post" action="add-post.php">
					<input type="text" name="post-title" id="post-title" class="w3-input w3-padding w3-margin-left" placeholder="<?php echo _('Add title'); ?>"><br>
					<textarea name="post-text" id="post-text" class="w3-input w3-padding w3-margin-left" rows="12"></textarea><br>
					<input type="submit" name="post-submit" id="post-submit" class="w3-theme-dark w3-button w3-margin-left" value="<?php echo _('PUBLISH POST'); ?>">
				</form>
			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
