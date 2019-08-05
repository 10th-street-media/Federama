<?php
/*
 * pub/dash/admin/themes.php
 *
 * A page with templates an admin can use to create some common pages.
 *
 * since Federama version 0.2
 */

include_once	"../../../conn.php";
include			"../../../functions.php";
require			"../../includes/database-connect.php";
require_once	"../../includes/configuration-data.php";
require_once	"../../includes/verify-cookies.php";

$pagetitle = _("Templates « $website_name « Ꞙederama");
include "header.php";
include "../nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Templates"); ?></h2>
				<ul>
					<li>About me/us</li>
					<li>Contact info</li>
					<li>Privacy Policy</li>
					<li>GDPR policy</li>
				</ul>

			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
