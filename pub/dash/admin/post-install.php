<?php
/*
 * pub/dash/admin/post-install.php
 *
 * This page has instructions on what to do after installing Federama.
 *
 * since Federama version 0.1
 *
 */

/*
 * conn.php may not have been put in its proper spot yet
 */
if (file_exists("../../../conn.php")) {
	include_once  "../../../conn.php";
} else if (file_exists("../../conn.php")) {
	include_once "../../conn.php";
} else die("Unable to find file conn.php. Have you moved it to the correct directory?");
include			"../../../functions.php";
require			"../../includes/database-connect.php";

if (isset($_POST['amosubmit'])) {

	/**
	 * collect our form data
	 */
	$amosite		= nicetext($_POST['amositename']);
	$amositeurl	= nicetext($_POST['amositeurl'])."/";
	$amouser		= nicetext($_POST['amoadmin']);
	$amopass1	= $_POST['amopass1'];
	$amopass2	= $_POST['amopass2'];

/**
 * Time to see if the passphrase works well
 */
	if (isset($amopass1)) {
		if (isset($amopass2)) {

			// Can the user type the same passphrase twice without typos?
			if ($amopass1 !== $amopass2) {
				$message	= "PASSPHRASE_MISMATCH";
			}
		}

		// Is the passphrase at least 16 characters long?
		if (strlen($amopass1) < 16) {
			$message = "SHORT_PASSPHRASE";

		// Is the passphrase complex?
		} else if (!preg_match("/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$/",$amopass1)) {
			$message = "NOT_COMPLEX";
		} else {

			// if it gets this far without errors, we're good
			$hash_pass = password_hash($amopass1,PASSWORD_DEFAULT);
		}

	} // end if isset $dbpass1

	if (!isset($message)) {
		/**
		 * Create our first user
		 */

		// let's create some keys
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
		$privmeta = fopen("../../../keys/".$amouser."-private.pem", "w") or die("Unable to open or create ../../keys/".$amouser."-private.pem file");
		fwrite($privmeta,$privkey);

		// Extract the public key from $res to $pubkey
		$pubkey = openssl_pkey_get_details($res);
		$pubkey = $pubkey["key"];

		$uid				= makeid($newid);
		$udatecreate	= date('Y-m-d H:i:s');
		$firstuserq		= "INSERT INTO ".TBLPREFIX."users (user_id, user_name, user_pass, user_level, user_actor_type, user_pub_key, user_created, user_last_login) VALUES ('".$uid."', '".$amouser."', '".$hash_pass."', 'ADMINISTRATOR', 'PERSON', '".$pubkey."', '".$udatecreate."', '".$udatecreate."')";
		$firstadminq	= "UPDATE ".TBLPREFIX."configuration SET website_name='".$amosite."', website_url='".$amositeurl."', admin_account='".$amouser."'";

		$message = $firstuserq."<br>\n\n".$firstadminq;
		$firstuserquery		= mysqli_query($dbconn,$firstuserq);
		$firstadminquery		= mysqli_query($dbconn,$firstadminq);

		redirect("final.php");
	} // end if !isset $message
}

$pagetitle = _("Create admin user");
include_once "header.php";
?>

	<!-- THE CONTAINER for the main content -->
	<main class="w3-container w3-content" style="max-width:1400px;margin-top:40px;">
<?php
switch ($message) {
	case "PASSPHRASE_MISMATCH":
		echo _("The passphrases do not match. Please try again.");
		break;
	case "SHORT_PASSPHRASE":
		echo _("The passphrase is too short. Please try again.");
		break;
	case "NOT_COMPLEX":
		echo _("The passphrase is not complex. Please try again.");
		break;
}
?>
	<!-- THE GRID -->
		<div class="w3-cell-row w3-container">
			<div class="w3-col w3-cell m3 l4">
				<p>
					<?php echo _('Passphrase must be at least 16 characters long.'); ?><br><br>
					<?php echo _('Passphrase must have:')."\n"; ?>
					<ul>
						<li><?php echo _('at least one lowercase letter'); ?></li>
						<li><?php echo _('at least one uppercase letter'); ?></li>
						<li><?php echo _('at least one numeral'); ?></li>
						<li><?php echo _('at least one character that is not a number or a letter.'); ?></li>
					</ul>
				</p>
			</div>
			<div class="w3-col w3-panel w3-cell m6 l4">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
				<h3><?php echo _("We're almost done!"); ?></h3>
				<p>
					<label for "amositename"><?php echo _("Site name"); ?></label>
					<input type="text" name="amositename" id="amositename" class="w3-input w3-border w3-margin-bottom" maxlength="255" required title="<?php echo _("The name of the website."); ?>">
				</p>
				<p>
					<label for "amositeurl"><?php echo _("Site URL"); ?></label>
					<input type="text" name="amositeurl" id="amositeurl" class="w3-input w3-border w3-margin-bottom" maxlength="50" required placeholder="https://example.com" title="<?php echo _("The URL of the website."); ?>">
				</p>
				<p>
					<label for "amoadmin"><?php echo _("Username"); ?></label>
					<input type="text" name="amoadmin" id="amoadmin" class="w3-input w3-border w3-margin-bottom" maxlength="30" required title="<?php echo _("The admin user will be the first user account entered in the database."); ?>">
				</p>
				<p>
					<label for "amopass1"><?php echo _("Passphrase"); ?></label>
					<input type="password" name="amopass1" id="amopass1" class="w3-input w3-border w3-margin-bottom" maxlength="255" required title="<?php echo _("Passphrase must be at least 16 characters long."); ?>">
				</p>
				<p>
					<label for "amopass2"><?php echo _("Verify passphrase"); ?></label>
					<input type="password" name="amopass2" id="amopass2" class="w3-input w3-border w3-margin-bottom" maxlength="255" required title="<?php echo _("Verify your passphrase."); ?>">
				</p>
				<p>
					<input type="submit" name="amosubmit" id="amosubmit" class="w3-button w3-button-hover w3-block w3-theme-d3 w3-section w3-padding" value="<?php echo _('CREATE USER'); ?>">
				</p>
				</form>
			</div>
			<div class="w3-col w3-cell m3 l4">&nbsp;</div> <!-- empty div for the purpose of positioning -->
		</div> <!-- end THE GRID -->
<?php
include_once "footer.php";
?>
