<?php
/*
 * pub/the-statistics.php
 *
 * Displays some website statistics
 *
 * since Federama version 0.2
 */

include_once	"../conn.php";
include			"../functions.php";
require			"includes/database-connect.php";
require_once	"includes/configuration-data.php";
include_once	"nodeinfo/version.php";



$pagetitle = _("Statistics « $website_name « Ꞙederama");
include_once "includes/fed-header.php";

?>
	<!-- THE CONTAINER for the main content -->
	<main class="w3-container w3-content" style="max-width:1400px;margin-top:40px;">

		<!-- THE GRID -->
	<div class="w3-row w3-container">
		<div class="w3-col m8 w3-row-padding w3-panel">
			<div class="w3-card-2 w3-padding w3-margin-bottom w3-theme-l3">
				<h2><?php echo _("Statistics for ").$website_name; ?></h2>
				<p><b><?php echo $website_description; ?></b></p>
			</div>
			<div class="w3-card-2 w3-padding w3-margin-bottom w3-theme-l3">
				<h2><?php echo _("Website statistics"); ?></h2>
				<ul>
					<li><?php echo _("Total number of accounts: ").user_quantity($user); ?></li>
					<li><?php echo _("Number of signed-in users in the past 30 days: ").users_past_month($active_users); ?></li>
					<li><?php echo _("Number of signed-in users in the past 180 months: ").users_half_year($sometimes_users); ?></li>
					<li><?php echo _("Total number of posts: ").post_quantity($post); ?></li>
					<li><?php echo _("Total number of pages: ").page_quantity($page);; ?></li>
					<!-- <li><?php echo _("Total number of messages: "); ?></li> we'll add this capability in the future -->
				</ul>
		</div>

			<div class="w3-col w3-cell m3">&nbsp;</div>
		</div> <!-- end THE GRID -->

<?php
include_once "includes/fed-footer.php";
?>
