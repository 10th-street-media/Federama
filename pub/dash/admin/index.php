<?php
/*
 * pub/dash/admin/index.php
 *
 * A page with admin tasks and tools.
 *
 * since Federama version 0.1
 */

include_once	"../../../conn.php";
include			"../../../functions.php";
require			"../../includes/database-connect.php";
require_once	"../../includes/configuration-data.php";
require_once	"../../includes/verify-cookies.php";
include_once	"../../nodeinfo/version.php";

$pagetitle = _("Admin Dashboard « $website_name « Ꞙederama");
include "header.php";
include "../nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Admin Dashboard"); ?></h2>


			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
