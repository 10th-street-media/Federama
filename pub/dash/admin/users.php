<?php
/*
 * pub/dash/admin/users.php
 *
 * A page with all of users on this instance
 *
 * since Federama version 0.2
 */

include_once	"../../../conn.php";
include			"../../../functions.php";
require			"../../includes/database-connect.php";
require_once	"../../includes/configuration-data.php";
require_once	"../../includes/verify-cookies.php";

$pagetitle = _("Users « $website_name « Ꞙederama");
include "header.php";
include "../nav.php";
?>

			<article class="w3-content w3-padding">

				<h2 class="w3-padding"><?php echo _("Users"); ?></h2>

				<a href="add-user.php" class="w3-button w3-theme-dark w3-margin-left"><?php echo _("ADD NEW USER"); ?></a><br><br>

				<table class="w3-table-all w3-hoverable w3-margin-left">
					<tr class="w3-theme-dark">
						<th class="w3-center"><?php echo _('Name'); ?></th>
						<th class="w3-center"><?php echo _('Display name'); ?></th>
						<th class="w3-center"><?php echo _('Level'); ?></th>
						<th class="w3-center"><?php echo _('Type'); ?></th>
						<th class="w3-center"><?php echo _('Joined'); ?></th>
						<th class="w3-center"><?php echo _('Actions'); ?></th>
						<!-- will add more fields in the future. -->
					</tr>
<?php
$usersq = "SELECT * FROM ".TBLPREFIX."users ORDER BY user_name ASC";
$usersquery = mysqli_query($dbconn,$usersq);
if (mysqli_num_rows($usersquery) > 0) {
	while ($usersopt = mysqli_fetch_assoc($usersquery)) {
		$user_id		= $usersopt['user_id'];
		$user_name	= $usersopt['user_name'];
		$user_dname	= $usersopt['user_display_name'];
		$user_lvl	= $usersopt['user_level'];
		$user_type	= $usersopt['user_actor_type'];
		$user_join	= $usersopt['user_created'];
	#}


		echo "\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t<td><a href=\"".$website_url."users/".$user_name."\">".$user_name."</a></td><td>".$user_dname."</td><td>".$user_lvl."</td><td>".$user_type."</td><td>".$user_join."</td><td><a href=\"edit-user.php?uid=".$user_id."\">"._('Edit')."</a> | <a href=\"suspend-user.php?uid=".$user_id."\">"._('Suspend')."</a> | <a href=\"ban-user.php?uid=".$user_id."\">"._('Ban')."</a> | <a href=\"delete-user.php?uid=".$user_id."\">"._('Delete')."</a></td>\n";
		echo "\t\t\t\t\t</tr>\n";
	}
} else {
	echo _("There are currently no users.");
}
?>
				</table>

			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
