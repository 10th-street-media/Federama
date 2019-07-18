<?php
/*
 * pub/index.php
 *
 * This is the main page for Federama and serves several purposes.
 * If Federama is not installed, it triggers installation.
 * If Federama is installed, it calls index.php from the active theme.
 * since Federama version 0.1
 *
 */

 /**
  * If ../conn.php does not exist...
  */
 if(!file_exists("../conn.php")) {

 	/**
 	 * ...and conn.php does not exist...
 	 */
 	if (!file_exists("conn.php")) {

 		/**
 		 * redirect user to install page.
 		 */
 		header("Location: dash/admin/install.php");
 	} else {

 		/**
 		 * conn.php does exist
 		 * redirect user to post-install page
 		 */
 		header("Location: dash/admin/post-install.php");
 	}
 } else {

 	/**
 	 * ../conn.php does exist
 	 * Let us include it, then verify its constants
 	 */

 	include "../conn.php";

 	/**
 	 * if $global_count === 5 at the end then all global variables are set.
 	 * if $global_count < 5 then something is missing.
 	 */

 	$global_count = 0;

 	if (DBHOST != "") {
 		#echo DBHOST;
 	 	$global_count++;
 	}

 	if (DBNAME != "") {
 		$global_count++;
 	}

 	if (DBUSER != "") {
 		$global_count++;
 	}

 	if (DBPASS != "") {
 		$global_count++;
 	}

 	if (SITEKEY != "") {
 		$global_count++;
 	}
 }

include			"../functions.php";
require			"includes/database-connect.php";
require_once	"includes/configuration-data.php";

// see if a session is set. If so, redirect them to their dashboard.

if (isset($_COOKIE['id'])) {
	redirect("dash/index.php");
} else {
	$visitortitle = _('Guest');
}


$pagetitle = _("Home");
$objdescription = $website_description;

include_once "includes/fed-header.php";
#include_once $theme_path."/header.php";
#echo $theme_path."/header.php";
?>
	<!-- THE CONTAINER for the main content -->
	<main class="w3-row w3-content" style="max-width:1400px;margin-top:40px;">

		<!-- THE GRID -->
		<div class="w3-cell-row">

<?php
// get the public posts
$getpostsq = "SELECT * FROM ".TBLPREFIX."posts WHERE post_type='POST' AND post_status='PUBLIC' ORDER BY post_date DESC";
$getpostsquery = mysqli_query($dbconn,$getpostsq);
if (mysqli_num_rows($getpostsquery) > 0) {
	while ($getpostsopt = mysqli_fetch_assoc($getpostsquery)) {
		$post_id		= $getpostsopt['post_id'];
		$post_by		= $getpostsopt['user_id'];
		$post_title	= $getpostsopt['post_title'];
		$post_slug	= $getpostsopt['post_slug'];
		$post_text	= $getpostsopt['post_text'];
		$post_date	= $getpostsopt['post_date'];

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

		echo "\t\t\t<article class=\"w3-content w3-padding\">\n";
		echo "\t\t\t\t<h2 class=\"w3-text-theme w3-container w3-bar\"><a href=\"".$website_url."posts/".$post_slug."\">".$post_title."</a></h2>\n";
		echo "\t\t\t\t<span class=\"w3-container w3-block\">"._('Posted on ').$post_date._(' by ')."<a href=\"".$website_url."users/".$user_name."/\">".$uname."</a></span><br>\n";
		echo "\t\t\t\t<div class=\"w3-container w3-block\">\n";
		echo htmlspecialchars_decode($post_text);
		echo "\t\t\t\t</div>\n";
		echo "\t\t\t</article>\n";
	}
} else {
	echo "\t\t\t<article class=\"w3-content w3-padding\">"._("There are currently no posts.")."</article>\n";
}

?>

<?php
include_once "includes/fed-footer.php";
?>
