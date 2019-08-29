<?php
/*
 * pub/dash/index.php
 *
 * The main page for users logged into a Federama website.
 * It has their dashboard with links to items they are allowed to access.
 *
 * since Federama version 0.1
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";
include_once	"../nodeinfo/version.php";

$pagetitle = _("Dashboard⋮$website_name — Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Dashboard"); ?></h2>

				<section class="w3-rest w3-container w3-margin-bottom">
					<span class="w3-large"><b><?php echo $website_name; ?></b> — <?php echo $website_description; ?></span>
				</section>

				<section class="w3-half w3-container">
					<div class="w3-theme-l3 w3-padding">
						<h4><?php echo _("Quick stats"); ?></h4>
						<hr>
						<span><?php echo _("Number of users: ").user_quantity($user); ?></span><br>
						<span><?php echo _("Number of posts: ").post_quantity($post); ?></span><br>
						<span><?php echo _("Number of messages: ").message_quantity($message); ?></span><br>
						<span><?php echo "<b>".$website_name."</b>".(" is running ").VERSION; ?></span>
					</div>
				</section>

				<section class="w3-half w3-container">
					<div class="w3-theme-l3 w3-padding">
						<h4><?php echo _("About Federama"); ?></h4>
						<hr>
						<p><?php echo $metadescription; ?></p>
					</div>
				</section>

				<section class="w3-half w3-container">
					<div class="w3-theme-l3 w3-padding">
						<h4><?php echo _("Recent posts"); ?></h4>
						<hr>
<?php
// get the 5 most recent public posts from DB
$dashpostsq = "SELECT * FROM ".TBLPREFIX."posts WHERE post_type='POST' AND post_status='PUBLIC' ORDER BY post_date DESC LIMIT 5";
$dashpostsquery = mysqli_query($dbconn,$dashpostsq);
if (mysqli_num_rows($dashpostsquery) > 0) {
	while ($dashpostsopt = mysqli_fetch_assoc($dashpostsquery)) {
		$post_id		= $dashpostsopt['post_id'];
		$post_title	= $dashpostsopt['post_title'];
		$post_slug	= $dashpostsopt['post_slug'];
		$post_date	= $dashpostsopt['post_date'];

		echo "\t\t\t\t\t\t<div>\n";
		echo "\t\t\t\t\t\t\t".$post_date."&nbsp;<a href=\"".$website_url."posts/".$post_slug."\">".$post_title."</a>\n";
		echo "\t\t\t\t\t\t</div>\n";
	}
} else {
	echo _("There are currently no posts.");
}
?>
					</div>
				</section>

				<section class="w3-half w3-container">
					<div class="w3-theme-l3 w3-padding w3-margin-top">
					<h4><?php echo _("Future sections"); ?></h4>
					<hr>
					<ul>
						<li><?php echo _("About <code>website_name</code>"); ?></li>
						<li><?php echo _("Recently joined users"); ?></li>
					</ul>
					</div>
				</section>
			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
