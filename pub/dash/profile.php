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

/**  **************************************************************************
 *
 *   FORM PROCESSING
 *
 **  *************************************************************************/
if(isset($_POST['profsubmit'])) {

	/* Set our variables */
	$userid			= $u_id;
	$username		= $u_name;
	$userdname		= nicetext($_POST['user-dname']);
	$useremail		= $_POST['user-email'];
	$userdob			= $_POST['user-dob'];
	$userprvkey		= $_POST['user-prv-key'];
	$userpubkey		= $_POST['user-pub-key'];
	$userlocale		= $_POST['user-l10n'];
	$userlocation	= $_POST['user-loc'];
	$usertzone		= $_POST['user-tzone'];
	$userbio			= nicetext($_POST['user-bio']);

	/**
	 * If we don't have public or private keys, let's make some
	 * The private key gets written to ../../keys/username-private.pem
	 * The public key gets written to the database
	 */
	if ($userprvkey == "") {
		// from the comments on https://www.php.net/manual/en/function.openssl-pkey-new.php
		$keyconfig = array(
    		"digest_alg" => "sha512",
    		"private_key_bits" => 4096,
    		"private_key_type" => OPENSSL_KEYTYPE_RSA,
		);

		// Create the private and public key
		$res = openssl_pkey_new($keyconfig);

		// Extract the private key from $res to $privkey
		openssl_pkey_export($res, $privkey);

		// write the private key to a file outside the web root
		$privmeta = fopen("../../keys/".$username."-private.pem", "w") or die("Unable to open or create ../../keys/".$username."-private.pem file");
		fwrite($privmeta,$privkey);

		// Extract the public key from $res to $pubkey
		$pubkey = openssl_pkey_get_details($res);
		$pubkey = $pubkey["key"];


	}

	$userupdq = "UPDATE ".TBLPREFIX."users SET user_display_name='".$userdname."', user_email='".$useremail."', user_date_of_birth='".$userdob."', user_pub_key='".$pubkey."', user_locale='".$userlocale."', user_location='".$userlocation."', user_time_zone='".$usertzone."', user_bio='".$userbio."' WHERE user_name='".$username."'";
	$userupdquery = mysqli_query($dbconn,$userupdq);

	/* reload the page by redirecting to itself */
	redirect($website_url."dash/profile.php");

} /* end if isset $_POST['profsubmit'] */
/**  END FORM PROCESSING  ****************************************************/

if ($u_name == "") {
	$u_name = $_COOKIE['uname'];
}
$pagetitle = _("Profile « $website_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-padding w3-col s12 m8 l10">
<?php echo $userupdq; ?>
				<h2 class="w3-padding"><?php echo _("Profile"); ?></h2>

				<form method="POST" action="<?php echo htmlspecialchars($website_url."dash/profile.php"); ?>">
					<!-- <input type="hidden" value="<?php echo $u_id?>"> -->
					<input type="hidden" name="user-prv-key" id="user-prv-key" value="<?php echo $u_prvkey?>">
					<input type="hidden" name="user-pub-key" id="user-pub-key" value="<?php echo $u_pubkey?>">
					<table class="w3-table w3-margin-left">

						<tr>
							<td><?php echo _("Username"); ?></td>
							<td><input type="text" name="user-name" id="user-name" class="w3-input w3-border w3-margin-bottom" required maxlength="20" value="<?php echo $u_name; ?>" title="<?php echo _('Usernames cannot be changed.'); ?>" disabled></td>
						</tr>
						<tr>
							<td><?php echo _("Display name"); ?></td>
							<td><input type="text" name="user-dname" id="user-dname" class="w3-input w3-border w3-margin-bottom" maxlength="255" value="<?php echo $u_dname; ?>" title="<?php echo _('The name that will be displayed.'); ?>"></td>
						</tr>
						<tr>
							<td><?php echo _("Email address"); ?></td>
							<td><input type="email" name="user-email" id="user-email" class="w3-input w3-border w3-margin-bottom" maxlength="255" value="<?php echo $u_email; ?>" title="<?php echo _('Your email address.'); ?>"></td>
						</tr>
						<tr>
							<td><?php echo _("Date of birth"); ?></td>
							<td><input type="date" name="user-dob" id="user-dob" class="w3-input w3-border w3-margin-bottom" value="<?php echo $u_dob; ?>" title="<?php echo _('Your date of birth.'); ?>"></td>
						</tr>
						<tr>
							<td><?php echo _("Locale"); ?></td>
							<td>
								<select name="user-l10n" id="user-l10n" class="w3-input w3-border w3-margin-bottom" title="<?php echo _('Your preferred locale.'); ?>">
<?php
$localeq = "SELECT * FROM ".TBLPREFIX."locales ORDER BY locale_language ASC";
$localequery = mysqli_query($dbconn,$localeq);
while ($localeopt = mysqli_fetch_assoc($localequery)) {
	$l10n	= $localeopt['locale_language']."-".$localeopt['locale_country'];

	if ($l10n !== $u_locale) {
		echo "\t\t\t\t\t\t\t\t\t<option value=\"".$l10n."\">".$l10n."</option>\n";
	} else {
		echo "\t\t\t\t\t\t\t\t\t<option value=\"".$l10n."\" selected>".$l10n."</option>\n";
	}
}
?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo _("Location"); ?></td>
							<td>
								<select name="user-loc" id="user-loc" class="w3-input w3-border w3-margin-bottom" title="<?php echo _('Some themes may display your location.'); ?>">
<?php
$locationq = "SELECT * FROM ".TBLPREFIX."locations ORDER BY location_id ASC";
$locationquery = mysqli_query($dbconn,$locationq);
while ($locationopt = mysqli_fetch_assoc($locationquery)) {
	$placeid			= $locationopt['location_id'];
	$placename		= $locationopt['location_name'];
	$placeparent	= $locationopt['location_parent']; # this is a comma separated list


	if ($placeid !== $u_location) {
		echo "\t\t\t\t\t\t\t\t\t<option value=\"".$placeid."\">".$placename."</option>\n";
	} else {
		echo "\t\t\t\t\t\t\t\t\t<option value=\"".$placeid."\" selected>".$placename."</option>\n";
	}
}
?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo _("Time zone"); ?></td>
							<td>
								<select name="user-tzone" id="user-tzone" class="w3-input w3-border w3-margin-bottom" title="<?php echo _('Some themes may display your time zone.'); ?>">
<?php
$timezoneq = "SELECT * FROM ".TBLPREFIX."time_zones ORDER BY time_zone_name ASC";
$timezonequery = mysqli_query($dbconn,$timezoneq);
while ($timezoneopt = mysqli_fetch_assoc($timezonequery)) {
	$tzname = $timezoneopt['time_zone_name'];

	if ($tzname !== $u_tzone) {
		echo "\t\t\t\t\t\t\t\t\t<option value=\"".$tzname."\">".$tzname."</option>\n";
	} else {
		echo "\t\t\t\t\t\t\t\t\t<option value=\"".$tzname."\" selected>".$tzname."</option>\n";
	}
}
?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo _("Short biography"); ?></td>
							<td><textarea name="user-bio" id="user-bio" class="w3-input w3-border w3-margin-bottom" title="<?php echo _('A short bio or description.'); ?>"><?php echo $u_bio; ?></textarea></td>
						</tr>

					</table>
					<input type="submit" name="profsubmit" id="profsubmit" class="w3-button w3-button-hover w3-theme-d3 w3-margin-left" value="<?php echo _('Update profile'); ?>">
				</form>

			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
