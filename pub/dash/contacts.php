<?php
/*
 * pub/dash/contacts.php
 *
 * A page with lists of a user's followers and following.
 *
 * since Federama version 0.1
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Contacts « $u_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Contacts"); ?></h2>

				<section class="w3-third w3-container">
					<div class="w3-theme-l3 w3-padding">
						<h4><?php echo _("Followers"); ?></h4>
						<hr>
						<a href="https://example.social/users/root">@root@example.social</a><br>
						<a href="https://peertube.tld/user">@user@peertube.tld</a><br>
						<a href="https://pleroma.duderino/arduino">@arduino@pleroma.duderino</a><br>
					</div>
				</section>

				<section class="w3-third w3-container">
					<div class="w3-theme-l3 w3-padding">
						<h4><?php echo _("Following"); ?></h4>
						<hr>
						<a href="https://example.social/users/root">@root@example.social</a><br>
						<a href="https://peertube.tld/user">@user@peertube.tld</a><br>
						<a href="https://pleroma.duderino/arduino">@arduino@pleroma.duderino</a><br>
					</div>
				</section>

				<section class="w3-third w3-container">
					<div class="w3-theme-l3 w3-padding">
						<h4><?php echo _("Recommended"); ?></h4>
						<hr>
						<a href="https://example.social/users/celebrity">@celebrity@example.social</a><br>
						<a href="https://tomato.tomato/users/famous">@famous@tomato.tomato</a><br>
						<a href="https://secret.lair/dragon">@dragon@secret.lair</a><br>
					</div>
				</section>
			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
