<?php
/*
 * pub/the-login.php
 *
 * The main login page for Federama. Also provides functionality for login widget on main page
 *
 * since Federama version 0.1
 */

include_once	"../conn.php";
include			"../functions.php";
require			"includes/database-connect.php";
require_once	"includes/configuration-data.php";
include_once	"nodeinfo/version.php";

if (isset($_COOKIE['id'])) {
	redirect($website_url."dash/index.php");
} else {
	$visitortitle = _('Guest');
}


/* if $_POST['loginsubmit'] is set                  */
if(isset($_POST['loginsubmit'])) {

	$uname = $_POST['loginuser'];
	$upass = $_POST['loginpass'];

	$acc_query  = "SELECT * FROM ".TBLPREFIX."users WHERE user_name='".$uname."'";
	$acc_q      = mysqli_query($dbconn,$acc_query);

/* is the user in the database?             			*/
	if (mysqli_num_rows($acc_q) <> 0) {

/* the user IS in the db									*/
		while ($acc_cic = mysqli_fetch_assoc($acc_q)) {
			$pass		= $acc_cic["user_pass"];
			$id		= $acc_cic["user_id"];

/* let us check if the password is correct			*/
 			if (password_verify($upass,$pass)) {
 				session_start();
				setcookie("id",$id,0);
				setcookie("uname",$uname,0);
				$loginq = "UPDATE ".TBLPREFIX."users SET user_last_login='".date('Y-m-d H:i:s')."', user_session='".session_id()."' WHERE user_id='".$id."'";
				$loginquery = mysqli_query($dbconn,$loginq);
				redirect($website_url."dash/index.php");

/* if the password is incorrect							*/
			} else {
				$message = "PASSPHRASE_INCORRECT";
			} /* end if password verify 					*/
		} /* end while $acc_cic								*/

/* the user IS NOT in the db								*/
	} else {
		$message = "USER_NOT_FOUND";

	}


/* else if $_post['loginsubmit'] is not set     	*/
/* probably when someone first visits the page		*/
} else {
    unset($uid);
    session_destroy();
}

include_once "includes/fed-header.php";
?>
	<!-- THE CONTAINER for the main content -->
	<main class="w3-container w3-content" style="max-width:1400px;margin-top:50px;">

		<!-- THE GRID -->
		<div class="w3-cell-row w3-container">
<?php
switch ($message) {
	case "PASSPHRASE_INCORRECT":
		echo "\t\t\t<section class=\"w3-panel w3-leftbar w3-pale-yellow w3-padding\">";
		echo _("The passphrase was entered incorrectly. Please try again.");
		echo "</section><br>\n";
		break;
	case "USER_NOT_FOUND":
		echo "\t\t\t<section class=\"w3-panel w3-leftbar w3-pale-yellow w3-padding\">";
		echo _("The username was not found. Perhaps it was entered incorrectly.");
		echo "</section><br>\n";
		break;
}
?>

			<div class="w3-col w3-cell m3 l4">&nbsp;</div>

			<div class="w3-col w3-panel w3-cell m6 l4">
				<form id="basicform" method="post" class="w3-card-2 w3-theme-l3 w3-padding maincard" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<h2 class="w3-center"><?php echo _("Login to")." ".$website_name; ?></h2>
					<p>
						<label for="loginuser"><?php echo _('Username'); ?></label>
						<input type="text" name="loginuser" id="loginuser" class="w3-input w3-border w3-margin-bottom" required maxlength="50">
					</p>
					<p>
						<label for="loginpass"><?php echo _('Passphrase'); ?></label>
						<input type="password" name="loginpass" id="loginpass" class="w3-input w3-border w3-margin-bottom" required>
					</p>
					<input type="submit" name="loginsubmit" id="loginsubmit" class="w3-button w3-button-hover w3-block w3-theme-d3 w3-section w3-padding" value="<?php echo _('TO LOGIN'); ?>">
				</form>
	<?php
				if($open_registration == TRUE) {
					echo "\t\t\t<a href=\"the-registration.php\">"._('Create an account')."</a>\n";
				} else {
					echo "\n\n\t\t\t<!-- registrations are closed -->\n\n";
				}
	?>
			</div>
			<div class="w3-col w3-cell m3 l4">&nbsp;</div>
		</div> <!-- end THE GRID -->
<?php
include_once "includes/fed-footer.php";
?>
