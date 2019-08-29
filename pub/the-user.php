<?php
/*
 * pub/the-user.php
 *
 * Displays a public information about a user
 *
 * since Federama version 0.2
 */

include_once	"../conn.php";
include			"../functions.php";
require			"includes/database-connect.php";
require_once	"includes/configuration-data.php";
include_once	"nodeinfo/version.php";


// get the user info
if (isset($_GET["name"])) {
	$name = rtrim($_GET["name"],"/");
} else {
	$name = "";
}


if ($name != '') {

	$usrq = "SELECT * FROM ".TBLPREFIX."users WHERE user_name=\"".$name."\"";
	$usrquery = mysqli_query($dbconn,$usrq);
	while($usr_opt = mysqli_fetch_assoc($usrquery)) {
		$userid		= $usr_opt['user_id'];
		$username	= $usr_opt['user_name'];
		$userdname	= $usr_opt['user_display_name'];
		$userbio		= $usr_opt['user_bio'];
		$userstart	= $usr_opt['user_created'];
		$userlast	= $usr_opt['user_last_seen'];
		$userpubkey	= $usr_opt['user_pub_key'];
	}

}

$pagetitle = $username." &lt; ".$website_name;
include_once 'includes/fed-header.php';
include_once 'includes/fed-nav.php';
include_once "the-user-feeds.php";
include_once "the-user-json.php";
include_once "the-user-webfinger.php";
?>
			<div class="w3-col w3-panel w3-cell m8">

<?php
// let's see if there are any posts to view from this user
$pst_q = "SELECT * FROM ".TBLPREFIX."posts WHERE post_status=\"PUBLIC\" AND user_id=\"".$userid."\" ORDER BY post_date DESC";
$pst_query = mysqli_query($dbconn,$pst_q);
if (mysqli_num_rows($pst_query) <> 0) {
	while ($pst_opt = mysqli_fetch_assoc($pst_query)) {
		$postid		= $pst_opt['post_id'];
		$postby		= $pst_opt['user_id'];
		$postdate	= $pst_opt['post_date'];
		$posttitle	= $pst_opt['post_title'];
		$postslug	= $pst_opt['post_slug'];
		$posttext	= $pst_opt['post_text'];

		$by_q = "SELECT * FROM ".TBLPREFIX."users WHERE user_id=\"".$postby."\"";
		$by_query = mysqli_query($dbconn,$by_q);
		while($by_opt = mysqli_fetch_assoc($by_query)) {
			$byname		= $by_opt['user_name'];
			$bydname		= $by_opt['user_display_name'];

			/**
			 *	If they have a display name, we use that, otherwise we use their user name.
			 */
			if ($bydname !== "" && $bydname !== NULL) {
				$uname = $bydname;
			} else {
				$uname = $byname;
			}
		}
			$now = date('Y-m-d H:i:s');


		echo "\t\t\t<article class=\"w3-content w3-padding\">\n";
		echo "\t\t\t\t<h2 class=\"w3-text-theme w3-container w3-bar\"><a href=\"".$website_url."posts/".$postslug."\">".$posttitle."</a></h2>\n";
		echo "\t\t\t\t<span class=\"w3-container w3-block\">"._('Posted on ').$postdate._(' by ').$uname."</span><br>\n";
		echo "\t\t\t\t<div class=\"w3-container w3-block\">\n";
		echo htmlspecialchars_decode($posttext);
		echo "\t\t\t\t</div>\n";
		echo "\t\t\t</article>\n";
	}
} else {
		echo "\t\t\t\t<div class=\"w3-card-2 w3-theme-l3 w3-padding w3-margin-bottom\">\n";
		echo _("There are no posts at the moment")."<br>\n";
		echo $usrq."<br>\n";
		echo $pst_q."<br>\n";
		echo "\t\t\t\t</div>\n";
}
?>
			</div> <!-- div class="w3-col w3-panel w3-cell m8" -->

			<div class="w3-col w3-cell m3">&nbsp;</div>
		</div> <!-- end THE GRID -->
<?php
include_once "includes/fed-footer.php";
?>
