<?php
/*
 * pub/dash/profile.php
 *
 * A page with a user's profile.
 *
 * since Federama version 0.1
 */

include_once	"../../conn.php";
include			"../../functions.php";
require			"../includes/database-connect.php";
require_once	"../includes/configuration-data.php";
require_once	"../includes/verify-cookies.php";

$pagetitle = _("Profile⋮$website_name — Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Profile"); ?></h2>
				<p>The nav menu will be changing soon to something more like:
				<ul>
					<li>View profile
						<ul>
							<li>Edit</li>
						</ul>
					</li>
					<li>Messages
						<ul>
							<li>Inbox</li>
							<li>Outbox</li>
						</ul>
					</li>
					<li>Contacts
						<ul>
							<li>Following</li>
							<li>Followers</li>
							<li>Patrons <i>(ideas)</i></li>
						</ul>
					</li>
					<li>Noteworthy
						<ul>
							<li>Liked</li>
							<li>Boosted</li>
							<li>Disliked <i>(optional)</i></li>
						</ul>
					</li>
					<li>Tools
						<ul>
							<li>Import profile</li>
							<li>Export profile</li>
							<li>Delete profile</li>
						</ul>
					</li>
				</ul>

			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
