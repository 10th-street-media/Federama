<?php
/*
 * pub/dash/admin/add-user.php
 *
 * A page where an admin can create a new user.
 *
 * since Federama version 0.2
 */

include_once	"../../../conn.php";
include			"../../../functions.php";
require			"../../includes/database-connect.php";
require_once	"../../includes/configuration-data.php";
require_once	"../../includes/verify-cookies.php";

$pagetitle = _("Add a user⋮$website_name — Ꞙederama");
include "header.php";
include "../nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Add a user"); ?></h2>


			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>