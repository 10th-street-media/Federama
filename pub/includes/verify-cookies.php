<?php
/*
 * pub/includes/verify-cookies.php
 *
 * This page verifies cookies are set for logged in users.
 * If there are no cookies, they are sent to front page.
 *
 * since Federama version 0.1
 */

include_once	"../conn.php";
include			"../functions.php";
require			"database-connect.php";
require_once	"configuration-data.php";

// if the uid or uname cookie is set, get the user info from the db.
if (isset($_COOKIE['id'])) {
	$uidq	= "SELECT * FROM ".TBLPREFIX."users WHERE user_id='".$_COOKIE['id']."'";
	$uidquery = mysqli_query($dbconn,$uidq);
	while ($uidopt = mysqli_fetch_assoc($uidquery)) {
		$u_id			= $uidopt['user_id'];
		$u_name		= $uidopt['user_name'];
		$u_dname		= $uidopt['user_display_name'];
		$u_level		= $uidopt['user_level'];
		$u_type		= $uidopt['user_actor_type'];
		$u_avatar	= $uidopt['user_avatar'];
		$u_locale	= $uidopt['user_locale'];
	}
} else if (isset($_COOKIE['uname'])) {
	$unameq = "SELECT * FROM ".TBLPREFIX."users WHERE user_name='".$_COOKIE['uname']."'";
	$unamequery = mysqli_query($dbconn,$unameq);
	while ($unameopt = mysqli_fetch_assoc($unamequery)) {
		$u_id			= $unameopt['user_id'];
		$u_name		= $unameopt['user_name'];
		$u_dname		= $unameopt['user_display_name'];
		$u_level		= $unameopt['user_level'];
		$u_type		= $unameopt['user_actor_type'];
		$u_avatar	= $unameopt['user_avatar'];
		$u_locale	= $unameopt['user_locale'];
	}
} else if (!isset($_COOKIE['id']) && !isset($_COOKIE['uname'])) {
	session_destroy();
	setcookie();
	redirect($website_url."index.php");
}

// if the user locale is set, let's set a cookie
if ($u_locale !== "") {
	setcookie("loc",$u_locale);
}

?>
