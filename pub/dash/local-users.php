<?php
/*
 * pub/dash/local-users.php
 *
 * A page that lists the users on this instance.
 *
 * since Federama version 0.2
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Local users « $u_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-padding w3-col s12 m8 l10">

				<h2 class="w3-padding"><?php echo _("Local users"); ?></h2>

				<section class="w3-third w3-container">
					<div class="w3-theme-l3 w3-padding">
<?php
/**
 * Let's recommend a random list of users on this instance
 */
$recommendedq = "SELECT * FROM ".TBLPREFIX."users ORDER BY RAND() LIMIT 25";
$recommendedquery = mysqli_query($dbconn,$recommendedq);
while ($recommopt = mysqli_fetch_assoc($recommendedquery)) {
	echo "\t\t\t\t\t\t\t<a href=\"".$website_url."users/".$recommopt['user_name']."\">@".$recommopt['user_name']."@".$_SERVER['SERVER_NAME']."</a><br>";
}
?>
					</div>
				</section>
			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
