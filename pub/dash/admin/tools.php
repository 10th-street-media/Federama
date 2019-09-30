<?php
/*
 * pub/dash/admin/tools.php
 *
 * A page with tools an admin can use for useful tasks.
 *
 * since Federama version 0.2
 */

include_once	"../../../conn.php";
include			"../../../functions.php";
require			"../../includes/database-connect.php";
require_once	"../../includes/configuration-data.php";
require_once	"../../includes/verify-cookies.php";

$pagetitle = _("Tools « $website_name « Ꞙederama");
include "header.php";
include "../nav.php";
?>

			<article class="w3-padding w3-col s12 m8 l10">

				<h2 class="w3-padding"><?php echo _("Tools"); ?></h2>
				<ul>
					<li>Import</li>
					<li>Export</li>
					<li>Categories</li>
					<li>Tags</li>
				</ul>

			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
