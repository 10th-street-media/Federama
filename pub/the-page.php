<?php
/*
 * pub/the-page.php
 *
 * Displays a page
 *
 * since Federama version 0.2
 */

include_once	"../conn.php";
include			"../functions.php";
require			"includes/database-connect.php";
require_once	"includes/configuration-data.php";
include_once	"nodeinfo/version.php";


// get the ID or title of the page on this webpage
if (isset($_GET["pid"])) {
	$get_id = $_GET["pid"];
} else if (isset($_GET["title"])) {
	$get_title = $_GET["title"];
} else {
	$get_id = "";
	$get_title = "";
}


if ($get_id != '') {

	$pstq = "SELECT * FROM ".TBLPREFIX."posts WHERE post_id=\"".$get_id."\" AND post_type='PAGE'";
	$pstquery = mysqli_query($dbconn,$pstq);
	while($pst_opt = mysqli_fetch_assoc($pstquery)) {
		$postid		= $pst_opt['post_id'];
		$posttitle	= $pst_opt['post_title'];
		$postslug	= $pst_opt['post_slug'];
		$postby		= $pst_opt['post_by'];
		$posttime	= $pst_opt['post_date'];
		$posttext	= htmlspecialchars_decode($pst_opt['post_text']);
		$postpriv	= $pst_opt['post_privacy_level'];
	}

		$by_q = "SELECT * FROM ".TBLPREFIX."users WHERE user_id=\"".$postby."\"";
		$by_query = mysqli_query($dbconn,$by_q);
		while($by_opt = mysqli_fetch_assoc($by_query)) {
			$byname		= $by_opt['user_name'];
		}
} else if ($get_title != '') {
	$pstq = "SELECT * FROM ".TBLPREFIX."posts WHERE post_slug=\"".$get_title."\" AND post_type='PAGE'";
	$pstquery = mysqli_query($dbconn,$pstq);
	while($pst_opt = mysqli_fetch_assoc($pstquery)) {
		$postid		= $pst_opt['post_id'];
		$posttitle	= $pst_opt['post_title'];
		$postslug	= $pst_opt['post_slug'];
		$postby		= $pst_opt['user_id'];
		$posttime	= $pst_opt['post_date'];
		$posttext	= htmlspecialchars_decode($pst_opt['post_text']);
		$postpriv	= $pst_opt['post_privacy_level'];
	}

		$by_q = "SELECT * FROM ".TBLPREFIX."users WHERE user_id=\"".$postby."\"";
		$by_query = mysqli_query($dbconn,$by_q);
		while($by_opt = mysqli_fetch_assoc($by_query)) {
			$byname		= $by_opt['user_name'];
		}
}

$pagetitle = $posttitle;
include_once "includes/fed-header.php";

?>
	<!-- THE CONTAINER for the main content -->
	<main class="w3-container w3-content" style="max-width:1400px;margin-top:40px;">

		<!-- THE GRID -->
		<div class="w3-cell-row w3-container">
			<div class="w3-col w3-cell m3">&nbsp;</div>

<?php
		echo "\t\t\t<article class=\"w3-content w3-padding\">\n";
		echo "\t\t\t\t<h2 class=\"w3-text-theme w3-container w3-bar\">".$posttitle."</h2>\n";
		echo "\t\t\t\t<span class=\"w3-container w3-block\">"._('Posted on ').$posttime._(' by ')."<a href=\"".$website_url."users/".$postby."/\">".$byname."</a></span><br>\n";
		echo "\t\t\t\t<div class=\"w3-container w3-block\">\n";
		echo htmlspecialchars_decode($posttext);
		echo "\t\t\t\t</div>\n";
		echo "\t\t\t</article>\n";
?>
			<div class="w3-col w3-cell m3">&nbsp;</div>
		</div> <!-- end THE GRID -->

<?php
include_once "includes/fed-footer.php";
?>
