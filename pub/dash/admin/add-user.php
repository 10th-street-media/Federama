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

/**  **************************************************************************
 *
 *   FORM PROCESSING
 *
 **  *************************************************************************/
if(isset($_POST['usersubmit'])) {

	/* Set our variables */
	$username		= nicetext($_POST['user-name']);
	$userdname		= nicetext($_POST['user-dname']);
	$useremail		= $_POST['user-email'];
	$userpass		= $_POST['user-pass'];
	$userdob			= $_POST['user-dob'];
	$userlvl			= $_POST['user-lvl'];
	$usertype		= $_POST['user-type'];
	$userlocale		= $_POST['user-l10n'];
	$userlocation	= $_POST['user-loc'];
	$usertzone		= $_POST['user-tzone'];
	$userbio			= nicetext($_POST['user-bio']);

/**
 * If the username is set, see if it is already being used
 */
	if (isset($username)) {
		$origuname		= "SELECT * FROM ".TBLPREFIX."users WHERE user_name='".$username."'";
      $origunameq		= mysqli_query($dbconn,$origuname);
		if (mysqli_num_rows($origunameq) > 0) {
			$message = "USERNAME_TAKEN";
		}
	} // end if isset $username

/**
 * Time to see if the passphrase works well
 */
	if (isset($userpass)) {

		// Is the passphrase at least 16 characters long?
		if (strlen($userpass) < 16) {
			$message = "SHORT_PASSPHRASE";

		// Is the passphrase complex?
		} else if (!preg_match("/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$/",$userpass)) {
			$message = "NOT_COMPLEX";
		} else {

			// if it gets this far without errors, we're good
			$hash_pass = password_hash($userpass,PASSWORD_DEFAULT);
		}

	} // end if isset $regpass1

/**
 * Let's see if the user is old enough to join
 */
	if (isset($userdob)) {

		if (user_age($userdob) < 18) {
			$message = "TOO_YOUNG";
		} else if (user_age($userdob) > 110) {
			$message = "TOO_OLD";
		}
	} // end if isset $regdob

/**
 * If we made it this far, create an ID, start a session, set cookies, etc.
 */
	if (!isset($message)) {
		$udatecreate	= date('Y-m-d H:i:s');
		$outboxseed	= "{\"@context\":\"https://www.w3.org/ns/activitystreams\",\"id\":\"outbox.json\",\"type\":\"OrderedCollection\",\"totalItems\":0,\"orderedItems\":[{}]}";
		$message = "SQL";
		$useraddq = "INSERT INTO ".TBLPREFIX."users (user_id, user_name, user_display_name, user_pass, user_email, user_date_of_birth, user_level, user_actor_type, user_outbox, user_locale, user_location, user_time_zone, user_bio, user_created) VALUES ('', '".$username."', '".$userdname."', '".$hash_pass."', '".$useremail."', '".$userdob."', '".$userlvl."', '".$usertype."', '".$outboxseed."', '".$userlocale."', '".$userlocation."', '".$usertzone."', '".$userbio."', '".$udatecreate."')";
		$useraddquery = mysqli_query($dbconn,$useraddq);

		/* reload to list of users */
		redirect($website_url."dash/admin/users.php");

	}

} /* end if isset $_POST['profsubmit'] */
/**  END FORM PROCESSING  ****************************************************/

$pagetitle = _("Add a user « $website_name « Ꞙederama");
include "header.php";
include "../nav.php";
?>

			<article class="w3-padding w3-col s12 m8 l10">
<?php
switch ($message) {
	case "USERNAME_TAKEN":
		echo "\t\t\t<section class=\"w3-panel w3-leftbar w3-pale-yellow w3-padding\">";
		echo _("That username is already taken. Please choose another.");
		echo "</section><br>\n";
		break;
	case "SHORT_PASSPHRASE":
		echo "\t\t\t<section class=\"w3-panel w3-leftbar w3-pale-yellow w3-padding\">";
		echo _("The passphrase is too short. Please try again.");
		echo "</section><br>\n";
		break;
	case "NOT_COMPLEX":
		echo "\t\t\t<section class=\"w3-panel w3-leftbar w3-pale-yellow w3-padding\">";
		echo _("The passphrase is not complex. Please try again.");
		echo "</section><br>\n";
		break;
	case "TOO_YOUNG":
		echo "\t\t\t<section class=\"w3-panel w3-leftbar w3-pale-yellow w3-padding\">";
		echo _("You are too young to join this website");
		echo "</section><br>\n";
		break;
	case "TOO_OLD":
		echo "\t\t\t<section class=\"w3-panel w3-leftbar w3-pale-yellow w3-padding\">";
		echo _("There was a typo in the date of birth. Please try again.");
		echo "</section><br>\n";
		break;
	case "SQL":
		echo $useraddq;
		break;
}
?>

				<h2 class="w3-padding"><?php echo _("Add a user"); ?></h2>

				<form method="POST" action="<?php echo htmlspecialchars($website_url."dash/admin/add-user.php"); ?>">
					<table class="w3-table w3-margin-left">

						<tr>
							<td><?php echo _("Username"); ?></td>
							<td><input type="text" name="user-name" id="user-name" class="w3-input w3-border w3-margin-bottom" required maxlength="20" title="<?php echo _('The user\'s @ name.'); ?>" required></td>
						</tr>
						<tr>
							<td><?php echo _("Display name"); ?></td>
							<td><input type="text" name="user-dname" id="user-dname" class="w3-input w3-border w3-margin-bottom" maxlength="255" title="<?php echo _('The name that will be displayed.'); ?>"></td>
						</tr>
						<!-- It's plaintext here to reduce errors, but gets encrypted before going in the DB. -->
						<tr>
							<td><?php echo _("Passphrase"); ?></td>
							<td><input type="text" name="user-pass" id="user-pass" class="w3-input w3-border w3-margin-bottom" maxlength="255" title="<?php echo _('The passphrase is plaintext here to reduce errors, but is encrypted before being entered into the database.'); ?>" required></td>
						</tr>
						<tr>
							<td><?php echo _("Email address"); ?></td>
							<td><input type="email" name="user-email" id="user-email" class="w3-input w3-border w3-margin-bottom" maxlength="255" title="<?php echo _('The user\'s email address.'); ?>"></td>
						</tr>
						<tr>
							<td><?php echo _("Date of birth"); ?></td>
							<td><input type="date" name="user-dob" id="user-dob" class="w3-input w3-border w3-margin-bottom" title="<?php echo _('The user\'s date of birth.'); ?>"></td>
						</tr>
						<tr>
							<td><?php echo _("User level"); ?></td>
							<td>
								<select name="user-lvl" id="user-lvl" class="w3-input w3-border w3-margin-bottom" title="<?php echo _('The user\'s level.'); ?>">
<?php
$levelq = "SELECT * FROM ".TBLPREFIX."user_levels";
$levelquery = mysqli_query($dbconn,$levelq);
while ($levelopt = mysqli_fetch_assoc($levelquery)) {
	echo "\t\t\t\t\t\t\t\t\t<option value=\"".$levelopt['user_level_name']."\">".$levelopt['user_level_name']."</option>\n";
}
?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo _("Account type"); ?></td>
							<td>
								<select name="user-type" id="user-type" class="w3-input w3-border w3-margin-bottom" title="<?php echo _('The account type is equivalent to the ActivityStreams Actor Type.'); ?>">
<?php
$typeq = "SELECT * FROM ".TBLPREFIX."actor_types";
$typequery = mysqli_query($dbconn,$typeq);
while ($typeopt = mysqli_fetch_assoc($typequery)) {
	echo "\t\t\t\t\t\t\t\t\t<option value=\"".$typeopt['actor_type_name']."\">".$typeopt['actor_type_name']."</option>\n";
}
?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo _("Locale"); ?></td>
							<td>
								<select name="user-l10n" id="user-l10n" class="w3-input w3-border w3-margin-bottom" title="<?php echo _('The user\'s preferred locale.'); ?>">
<?php
$localeq = "SELECT * FROM ".TBLPREFIX."locales ORDER BY locale_language ASC";
$localequery = mysqli_query($dbconn,$localeq);
while ($localeopt = mysqli_fetch_assoc($localequery)) {
	$l10n	= $localeopt['locale_language']."-".$localeopt['locale_country'];

	echo "\t\t\t\t\t\t\t\t\t<option value=\"".$l10n."\">".$l10n."</option>\n";
}
?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo _("Location"); ?></td>
							<td>
								<select name="user-loc" id="user-loc" class="w3-input w3-border w3-margin-bottom" title="<?php echo _('Some themes may display the user\'s location.'); ?>">
<?php
$locationq = "SELECT * FROM ".TBLPREFIX."locations ORDER BY location_id ASC";
$locationquery = mysqli_query($dbconn,$locationq);
while ($locationopt = mysqli_fetch_assoc($locationquery)) {
	$placeid			= $locationopt['location_id'];
	$placename		= $locationopt['location_name'];
	$placeparent	= $locationopt['location_parent']; # this is a comma separated list

	echo "\t\t\t\t\t\t\t\t\t<option value=\"".$placeid."\">".$placename."</option>\n";
}
?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo _("Time zone"); ?></td>
							<td>
								<select name="user-tzone" id="user-tzone" class="w3-input w3-border w3-margin-bottom" title="<?php echo _('Some themes may display the user\'s time zone.'); ?>">
<?php
$timezoneq = "SELECT * FROM ".TBLPREFIX."time_zones ORDER BY time_zone_name ASC";
$timezonequery = mysqli_query($dbconn,$timezoneq);
while ($timezoneopt = mysqli_fetch_assoc($timezonequery)) {
	$tzname = $timezoneopt['time_zone_name'];

	echo "\t\t\t\t\t\t\t\t\t<option value=\"".$tzname."\">".$tzname."</option>\n";
}
?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo _("Short biography"); ?></td>
							<td><textarea name="user-bio" id="user-bio" class="w3-input w3-border w3-margin-bottom" title="<?php echo _('A short biography/description of the user.'); ?>"></textarea></td>
						</tr>

					</table>
					<input type="submit" name="usersubmit" id="usersubmit" class="w3-button w3-button-hover w3-theme-d3 w3-margin-left" value="<?php echo _('Add user'); ?>">
				</form>

			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
