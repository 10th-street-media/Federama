<?php
/*
 * pub/dash/add-messages.php
 *
 * Allows users to create messages.
 *
 * since Federama version 0.1
 */

include_once    "../../conn.php";
include         "../../functions.php";
require         "../includes/database-connect.php";
require_once    "../includes/configuration-data.php";
require_once    "../includes/verify-cookies.php";

/**
 * Form processing
 */
if (isset($_POST['message-submit'])) {

    /**
     * STEP 1:
     * Collect the form data and set our variables.
     */
    $text   = $_POST['message-text'];           // keep it as raw text for the moment
    $mid    = date("YmdHis").$_COOKIE['id'];    // the message id = YmdHis + the user id
    $url    = $website_url."messages/".$mid;    // the presumed path to the message
    $now    = date("Y-m-d H:i:s");




    /**
     * STEP 2:
	 * Find possible usernames in $text and put them in the array $finduserstext
	 */
    preg_match_all('/@([0-9a-zA-Z]+)/i', $text, $finduserstext);




    /**
     * STEP 3:
     * Accounts in $finduserstext[0] will be like '@username'.
     * Accounts in $finduserstext[1] will be like 'username'.
     * For each $finduserstext[1] see if there is a matching user_name in the db.
     * If there is, put the user_name into an array we will use later.
     */
    foreach ($finduserstext[1] as $reguser1) {
        $reguserq = "SELECT * FROM ".TBLPREFIX."users WHERE user_name='".$reguser1."'";
        $reguserquery = mysqli_query($dbconn,$reguserq);
        if ($reguserquery) {
            while ($reguseropt = mysqli_fetch_assoc($reguserquery)) {

                // For each $reguser1 that matches a user_name, put it into an array.
                $actualusers[] = $reguseropt['user_name'];

                // For each $reguser1 that matches a user_name, add an @ symbol and put it in a separate array.
                $attedusers[] = "@".$reguseropt['user_name'];

            } /* end while $reguseropt */
        } /* end if $reguserquery */
    } /* end foreach $finduserstext[1] */




    /**
     * STEP 4:
     * For each $actualuser in the message, create a link to their profile
     * This is a variation of the profileparser function.
     */
    foreach ($actualusers as $actualuser) {

        // This will only work for actual users in our database.
        // Non-users will not be linked.
        $text = preg_replace('/@'.$actualuser.'/i','<a href=\''.$website_url.'users/'.$actualuser.'\'>@'.$actualuser.'</a>',$text);
    }




    /**
     * STEP 5:
     * Put the message in the public inbox
     */
     $messageq = "INSERT INTO ".TBLPREFIX."messages (message_id, message_url, user_name, message_to, message_time, message_text) VALUES ('".$mid."', '".$url."', '".$_COOKIE['uname']."', '".implode(",",$attedusers)."', '".$now."', '".nicetext($text)."')";
     $messagequery = mysqli_query($dbconn,$messageq);




	/**
	 * STEP 6:
	 * Put the message id in the author's outbox.
	 *
	 * The outbox will be a string, so we get it,
	 * split it into an array, add this message id,
	 * then join it together again.
	 */
	if (isset($_COOKIE['uname'])) {

		$getoutboxq = "SELECT * FROM ".TBLPREFIX."users WHERE user_name='".$_COOKIE['uname']."'";
		$getoutboxquery = mysqli_query($dbconn,$getoutboxq);
		while ($getoutboxopt = mysqli_fetch_assoc($getoutboxquery)) {
			// turns a comma separated string into an array
			$outbox = explode(",",$getoutboxopt['user_outbox']);

			// push the encoded url into the array
			$outbox[] = urlencode($url);

			// join the array into a string
			$outboxjoin = implode(",",$outbox);

			// put the joined string into user_outbox for this user
			$outboxaddq = "UPDATE ".TBLPREFIX."users SET user_outbox='".$outboxjoin."' WHERE user_name='".$_COOKIE['uname']."'";
			$outboxaddquery = mysqli_query($dbconn,$outboxaddq);
		} // end while $getoutboxopt


	} /* end if isset $_COOKIE[uname] */


	/**
	 * STEP 7:
	 * Put the message ID in the recipients' inboxes
	 *
	 * The inbox will be a string, so we get it,
	 * split it into an array, add this message id,
	 * then join it together again.
	 */
    foreach ($actualusers as $actualuser) {
        $actq = "SELECT * FROM ".TBLPREFIX."users WHERE user_name='".$actualuser."'";
        $actquery = mysqli_query($dbconn,$actq);
        while ($actopt = mysqli_fetch_assoc($actquery)) {
            // turns a comma separated string into an array
            $actinbox = explode(",",$actopt['user_inbox']);

            // push the encoded url into the array
            $actinbox[] = urlencode($url);

            // join the array into a string
            $actinboxjoin = implode(",",$actinbox);

            // put the joined string into user_outbox for this user
            $actinboxaddq = "UPDATE ".TBLPREFIX."users SET user_inbox='".$actinboxjoin."' WHERE user_name='".$actualuser."'";
            $actinboxaddquery = mysqli_query($dbconn,$actinboxaddq);
        } // end while $actopt
    } // end foreach $actualusers



	redirect($website_url."dash/messages.php");


} /* end if isset $_POST[message-submit] */

$pagetitle = _("Add new message « $u_name « Ꞙederama");
include "header.php";
include "nav.php";

?>

			<article class="w3-content w3-padding">
<?php
#echo $messageq;
?>
				<h2 class="w3-padding"><?php echo _("Add a new message"); ?></h2>
				<form method="post" action="add-message.php">
					<textarea name="message-text" id="message-text" class="w3-input w3-padding w3-margin-left" rows="3"></textarea><br>
					<input type="submit" name="message-submit" id="message-submit" class="w3-theme-dark w3-button w3-margin-left" value="<?php echo _('PUBLISH MESSAGE'); ?>">
				</form>
			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
