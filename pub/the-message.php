<?php
/*
 * pub/the-message.php
 *
 * Displays a message
 *
 * since Federama version 0.2
 */

include_once	"../conn.php";
include			"../functions.php";
require			"includes/database-connect.php";
require_once	"includes/configuration-data.php";


// get the ID of the message
if (isset($_GET["mid"])) {
	$get_id = $_GET["mid"];
} else {
	$get_id = "";
}


if ($get_id != '') {

}

$pagetitle = $posttitle;
include_once "includes/fed-header.php";

?>
	<!-- THE CONTAINER for the main content -->
	<main class="w3-container w3-content" style="max-width:1400px;margin-top:40px;">

		<!-- THE GRID -->
		<div class="w3-cell-row w3-container">
			<div class="w3-col w3-cell m3">&nbsp;</div>

			<article class="w3-col w3-panel w3-cell m6">
				<div class="w3-card-2 w3-theme-l3 w3-padding maincard">
<?php
		echo "\t\t\t\t<span class=\"showpostby\"><a href=\"".$website_url."users/".$byname."/\">".$byname."</a>&nbsp;";
		echo $posttime."</span>\n";
		echo "\t\t\t\t<p class=\"showposttext\">".$posttext."</p>\n";
		echo "\t\t\t\t<!-- future functionality on span below -->\n";
		echo "\t\t\t\t<a href=\"#\" title=\""._('Reply')."\">⮪</a>&nbsp;<a href=\"#\" title=\""._('Share')."\">🔁</a>&nbsp;<a href=\"#\" title=\""._('Like')."\">🎔</a>&nbsp;<a href=\"#\" title=\""._('Dislike')."\">💔</a>&nbsp;\n";
?>
				</div>
			</article>
			<div class="w3-col w3-cell m3">&nbsp;</div>
		</div> <!-- end THE GRID -->

<?php
include_once "includes/fed-footer.php";
?>
