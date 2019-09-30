<?php
/*
 * pub/dash/posts.php
 *
 * A page with all of a user's posts, along with all public posts
 * by other users on the same instance.
 *
 * since Federama version 0.1
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Posts « $website_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-padding w3-col s12 m8 l10">

				<h2 class="w3-padding"><?php echo _("Posts"); ?></h2>

				<a href="add-post.php" class="w3-button w3-theme-dark w3-margin-left"><?php echo _("ADD NEW POST"); ?></a><br><br>

				<table class="w3-table-all w3-hoverable w3-margin-left">
					<tr class="w3-theme-dark">
						<th class="w3-center"><?php echo _('Title'); ?></th>
						<th class="w3-center"><?php echo _('Author'); ?></th>
						<th class="w3-center"><?php echo _('Date'); ?></th>
						<th class="w3-center"><?php echo _('Actions'); ?></th>
						<!-- will add more fields in the future. -->
					</tr>
<?php
$dashpostsq = "SELECT * FROM ".TBLPREFIX."posts WHERE post_type='POST' AND post_status='PUBLIC' ORDER BY post_date DESC";
$dashpostsquery = mysqli_query($dbconn,$dashpostsq);
if (mysqli_num_rows($dashpostsquery) > 0) {
	while ($dashpostsopt = mysqli_fetch_assoc($dashpostsquery)) {
		$post_id		= $dashpostsopt['post_id'];
		$post_by		= $dashpostsopt['user_id'];
		$post_title	= $dashpostsopt['post_title'];
		$post_slug	= $dashpostsopt['post_slug'];
		$post_date	= $dashpostsopt['post_date'];

		/**
		 * find out who wrote the post
		 */
		$useridq = "SELECT * FROM ".TBLPREFIX."users WHERE user_id=".$post_by;
		$useridquery = mysqli_query($dbconn,$useridq);
		while($useridopt = mysqli_fetch_assoc($useridquery)) {
			$user_name	= $useridopt['user_name'];
			$user_dname	= $useridopt['user_display_name'];

			/**
			 *	If they have a display name, we use that, otherwise we use their user name.
			 */
			if ($user_dname !== "" && $user_dname !== NULL) {
				$uname = $user_dname;
			} else {
				$uname = $user_name;
			}
		}


		echo "\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t<td><a href=\"".$website_url."posts/".$post_slug."\">".$post_title."</a></td><td class=\"w3-center\"><a href=\"".$website_url."users/".$user_name."\">".$uname."</a></td><td class=\"w3-center\">".$post_date."</td><td class=\"w3-center\"><a href=\"".$website_url."dash/edit-post.php?pid=".$post_id."\">"._('Edit')."</a> | <a href=\"".$website_url."dash/delete-post.php?pid=".$post_id."\">"._('Delete')."</a></td>\n";
		echo "\t\t\t\t\t</tr>\n";
	}
} else {
	echo _("There are currently no posts.");
}
?>
				</table>

			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
