<?php
/*
 * pub/dash/change-passphrase.php
 *
 * A page where a user can change their passphrase.
 *
 * since Federama version 0.s
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
if(isset($_POST['passsubmit'])) {

	/* Set our variables */
	$oldpass		= $_POST['old-pass'];
	$newpass1	= $_POST['new-pass1'];
	$newpass2	= $_POST['new-pass2'];

	/* let's see if $oldpass matches the passphrase in the database. */
	$sesscheckq = "SELECT * FROM ".TBLPREFIX."users where user_session='".$_COOKIE['PHPSESSID']."'";
	$sesscheckquery = mysqli_query($dbconn,$sesscheckq);
	while ($sesscheckopt = mysqli_fetch_assoc($sesscheckquery)) {
		$pass_tbl = $sesscheckopt['user_pass'];

		if (!password_verify($oldpass,$pass_tbl)) {
			$message = "PASSPHRASE_INCORRECT";
		}
	}

	if (isset($newpass1)) {
		if (isset($newpass2)) {

			// Can the user type the same passphrase twice without typos?
			if ($newpass1 !== $newpass2) {
				$message	= "PASSPHRASE_MISMATCH";
			}

			// Is the passphrase at least 16 characters long?
			if (strlen($newpass1) < 16) {
				$message = "SHORT_PASSPHRASE";

			// Is the passphrase complex?
			} else if (!preg_match("/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$/",$newpass1)) {
				$message = "NOT_COMPLEX";
			} else {

			// if it gets this far without errors, we're good
			$hash_pass = password_hash($newpass1,PASSWORD_DEFAULT);
			}
		} // end if isset $newpass2

		if (!isset($message)) {

			$updpassq = "UPDATE ".TBLPREFIX."users SET user_pass='".$hash_pass."', user_session='' WHERE user_name='".$_COOKIE['uname']."'";
			$updpassquery = mysqli_query($dbconn,$updpassq);

			// after changing their passphrase, the user must logout and log back in.
			session_start();
		   session_destroy();
		   $_SESSION = [];

		   $u_id = "";
		   $u_name = "";
		   $u_session = "";

		   unset($_COOKIE['id']);
		   setcookie('id','', time() - 3600, '/');

		   unset($_COOKIE['loc']);
		   setcookie('loc','', time() - 3600, '/');

		   unset($_COOKIE['uname']);
		   setcookie('uname','', time() - 3600, '/');

		   unset($_COOKIE['PHPSESSID']);
		   setcookie('PHPSESSID','', time() - 3600, '/');

			redirect($website_url."index.php");
		}
	}
} /* end if isset $_POST['passsubmit'] */
/**  END FORM PROCESSING  ****************************************************/

$pagetitle = _("Change passphrase « $website_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

			<article class="w3-padding w3-col s12 m8 l10">
<?php
switch ($message) {
	case "PASSPHRASE_INCORRECT":
		echo "\t\t\t<section class=\"w3-panel w3-leftbar w3-pale-yellow w3-padding\">";
		echo _("The current passphrase was entered incorrectly. Please try again.");
		echo "</section><br>\n";
		break;
	case "PASSPHRASE_MISMATCH":
		echo "\t\t\t<section class=\"w3-panel w3-leftbar w3-pale-yellow w3-padding\">";
		echo _("The new passphrases do not match. Please try again.");
		echo "</section><br>\n";
		break;
	case "SHORT_PASSPHRASE":
		echo "\t\t\t<section class=\"w3-panel w3-leftbar w3-pale-yellow w3-padding\">";
		echo _("The new passphrase is too short. Please try again.");
		echo "</section><br>\n";
		break;
	case "NOT_COMPLEX":
		echo "\t\t\t<section class=\"w3-panel w3-leftbar w3-pale-yellow w3-padding\">";
		echo _("The new passphrase is not complex. Please try again.");
		echo "</section><br>\n";
		break;
	case "SQL":
		echo $useraddq;
		break;
}
?>
				<h2 class="w3-padding"><?php echo _("Change your passphrase"); ?></h2>

				<form method="POST" action="<?php echo htmlspecialchars($website_url."dash/change-passphrase.php"); ?>">

					<table class="w3-table w3-margin-left">
						<tr>
							<td><?php echo _("Current passphrase"); ?></td>
							<td><input type="password" name="old-pass" id="old-pass" class="w3-input w3-border w3-margin-bottom" required title="<?php echo _('Enter your current passphrase.'); ?>"></td>
						</tr>
						<tr>
							<td><?php echo _("New passphrase"); ?></td>
							<td><input type="password" name="new-pass1" id="new-pass1" class="w3-input w3-border w3-margin-bottom" required  title="<?php echo _('Enter your new passphrase.'); ?>"></td>
						</tr>
						<tr>
							<td><?php echo _("Verify new passphrase"); ?></td>
							<td><input type="password" name="new-pass2" id="new-pass2" class="w3-input w3-border w3-margin-bottom" required  title="<?php echo _('Verify your new passphrase.'); ?>"></td>
						</tr>
					</table>
					<input type="submit" name="passsubmit" id="passsubmit" class="w3-button w3-button-hover w3-theme-d3 w3-margin-left" value="<?php echo _('Change passphrase'); ?>">
				</form>

			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
