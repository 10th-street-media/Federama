<?php
/*
 * pub/the-message.php
 *
 * Displays a message
 *
 * since Federama version 0.2
 */

include_once	"../conn.php";
include			"../functions.php";
require			"includes/database-connect.php";
require_once	"includes/configuration-data.php";


// get the ID of the message
if (isset($_GET["mid"])) {
	$get_id = $_GET["mid"];
} else {
	$get_id = "";
}


if ($get_id != '') {

	/**
	 *
	 * Get the message from the database
	 */
	$getmessageq = "SELECT * FROM ".TBLPREFIX."messages WHERE message_id='".$get_id."'";
	$getmessagequery = mysqli_query($dbconn,$getmessageq);
	while ($getmessageopt = mysqli_fetch_assoc($getmessagequery)) {
		$mesid	= $getmessageopt['message_id'];
		$mesby	= $getmessageopt['user_name'];
		$mestime	= $getmessageopt['message_time'];
		$mesprv	= $getmessageopt['message_privacy_level'];
		$mesrply	= $getmessageopt['message_in_reply_to'];
		$mestxt	= $getmessageopt['message_text'];
		$mesflag	= $getmessageopt['message_flagged_on'];
		$mesdel	= $getmessageopt['message_deleted_on'];
		$meslik	= $getmessageopt['message_likes'];
		$mesdlik	= $getmessageopt['message_dislikes'];
		$messhar	= $getmessageopt['message_shares'];
	}

	/**
	 * Get the author's preferred display name
	 */
	$authornameq = "SELECT * FROM ".TBLPREFIX."users WHERE user_name='".$mesby."'";
	$authornamequery = mysqli_query($dbconn,$authornameq);
	while ($authornameopt = mysqli_fetch_assoc($authornamequery)) {
		if ($authornameopt['user_display_name'] != "") {
			$author = $authornameopt['user_display_name'];
		} else {
			$author = $mesby;
		}
	}


	/**
	 * Get the number of likes
	 */
	if ($meslik !== '') {
		$msg_likes = preg_split('/,/',$meslik);
		if (count($msg_likes) > 0) {
			$likes = count($msg_likes);
		}
	} else {
		$likes = 0;
	} /* end if $msglikes !== '' */


	/**
	 * Get the number of dislikes
	 */
	if ($mesdlik !== '') {
		$msg_dlikes = preg_split('/,/',$mesdlik);
		if (count($msg_dlikes) > 0) {
			$dlikes = count($msg_dlikes);
		}
	} else {
		$dlikes = 0;
	} /* end if $msgdlikes !== '' */


	/**
	 * Get the number of shares
	 */
	if ($messhar !== '') {
		$msg_shares = preg_split('/,/',$messhar);
		if (count($msg_shares) > 0) {
			$shares = count($msg_shares);
		}
	} else {
		$shares = 0;
	} /* end if $msgshares !== '' */

}

$pagetitle = _("$author « $website_name « Ꞙederama");
include_once "includes/fed-header.php";

?>
	<!-- THE CONTAINER for the main content -->
	<main class="w3-container w3-content" style="max-width:1400px;margin-top:40px;">

		<!-- THE GRID -->
		<div class="w3-cell-row w3-container">
			<div class="w3-col w3-cell m3">&nbsp;</div>

			<article class="w3-col w3-panel w3-cell m6">
				<div class="w3-card-2 w3-theme-l3 w3-padding maincard">
<?php
		echo "\t\t\t\t<span><a href=\"".$website_url."users/".$mesby."/\" class=\"w3-text-theme\">".$author."</a>&nbsp;";
		echo $mestime."</span>\n";
		echo "\t\t\t\t<p>".$mestxt."</p>\n";
		echo "\t\t\t\t<!-- future functionality on span below -->\n";
		echo "\t\t\t\t\t<i class=\"fa fa-smile-o\" aria-hidden=\"true\"></i></a> ".$likes."&nbsp;&nbsp;\n";
		echo "\t\t\t\t\t<i class=\"fa fa-frown-o\" aria-hidden=\"true\"></i></a> ".$dlikes."&nbsp;&nbsp;\n";
		echo "\t\t\t\t\t<i class=\"fa fa-retweet\" aria-hidden=\"true\"></i></a> ".$shares."&nbsp;&nbsp;\n";
?>
					<!-- We'll setup replying and flagging in the future -->
				</div>
			</article>
			<div class="w3-col w3-cell m3">&nbsp;</div>
		</div> <!-- end THE GRID -->

<?php
include_once "includes/fed-footer.php";
?>
