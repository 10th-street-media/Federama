<?php
/*
 * pub/dash/following.php
 *
 * A page that lists accounts that a account follows
 *
 * since Federama version 0.2
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Following « $u_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-padding w3-col s12 m8 l10">

				<h2 class="w3-padding"><?php echo _("Following"); ?></h2>

				<section class="w3-half w3-container">
					<div class="w3-theme-l3 w3-padding">
						<!-- We'll do something more interesting with this later -->
					</div>
				</section>


			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
