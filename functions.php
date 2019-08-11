<?php
/*
 * functions.php
 *
 * This file is used to store nearly all functions used by Federama.
 *
 * since Federama version 0.1
 *
 */

include "conn.php";

// put this here for various functions to use
$dbconn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
mysqli_set_charset($dbconn, "utf8");

$metadescription = _("<i>Federama</i> is an open-source PHP framework and microblogging software for the Fediverse - a decentralized social network of thousands of different communities and millions of users.");

// creates a 20 character ID
function makeid($newid) {
	// the characters we will use
	$chars	= "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

	// splits $chars into an array of individual characters
	$tmp = preg_split("//u", $chars, -1, PREG_SPLIT_NO_EMPTY);

	// shuffles/randomizes the $tmp array
	shuffle($tmp);

	// turns the randomized array into a string
	$tmp2 = join("", $tmp);

	// returns the first 10 characters of the randomized string
	return mb_substr($tmp2,0,20,"UTF-8");
}




// sanitizes text inputs from forms
function nicetext($text) {
	// get rid of whitespace characters at start or end of text
	$text = trim($text);

	// removes \ backslash escape characters
	$text = stripslashes($text);

	// converts special characters (i.e. < > &, etc) into their html entities
	$text = htmlspecialchars($text,ENT_QUOTES,'UTF-8',true);
	return $text;
}




// turns a title into a url-friendly slug
function makeslug($text) {
	/**
	 * taken from https://stackoverflow.com/questions/11330480/strip-php-variable-replace-white-spaces-with-dashes
	 */

	// make all letters lowercase
	$text		= strtolower($text);

	// make it alphanumeric and turn other characters into hyphens
	$text = preg_replace("/[^a-z0-9_\s-]/", "", $text);

	// clean up multiple hyphens and whitespaces
	$text = preg_replace("/[\s-]+/", " ", $text);

	// convert whitespaces and underscores to hyphens
	$text = preg_replace("/[\s_]/", "-", $text);

	return $text;
}

// finds @usernames and turns them into links
function userparser($text) {

	/**
	 *	Look for @user@instance.tld
	 * See if instance.tld has an account named 'user'
	 * If yes, create a link
	 * Else leave as plain text
	 */


	/**
	 * Look for @user with a space after their name
	 * Check against list of users on this instance
	 * If user exists, create a link
	 * Else leave as plain text
	 *
	 * Let us stick with basic letters, numbers, and underscores
	 */
	if($textuser = preg_match_all('/@{1}[a-zA-Z0-9_]+\s+/i',$text)) {

	}
}

// displays a warning message on a page
function warning_message($message) {
	$msg = "\t<div class=\"clear\"></div>\n\n";
	$msg .= "\t<!-- div class message is for general messages & warnings -->\n";
	$msg .= "\t<div class=\"warning-message\">".$message."</div>\n";

	return $msg;
}

// displays an error message on a page
function error_message($message) {
	$msg = "\t<div class=\"clear\"></div>\n\n";
	$msg .= "\t<!-- div class message is for general messages & warnings -->\n";
	$msg .= "\t<div class=\"error-message\">".$message."</div>\n";

	return $msg;
}

// displays a notice message on a page
function notice_message($message) {
	$msg = "\t<div class=\"clear\"></div>\n\n";
	$msg .= "\t<!-- div class message is for general messages & warnings -->\n";
	$msg .= "\t<div class=\"notice-message\">".$message."</div>\n";

	return $msg;
}

// displays a banned account message on a page
function banned_message($message) {
	$msg = "\t<div class=\"clear\"></div>\n\n";
	$msg .= "\t<!-- div class message is for general messages & warnings -->\n";
	$msg .= "\t<div class=\"banned-message\">".$message."</div>\n";

	return $msg;
}

// displays a suspended account message on a page
function suspended_message($message) {
	$msg = "\t<div class=\"clear\"></div>\n\n";
	$msg .= "\t<!-- div class message is for general messages & warnings -->\n";
	$msg .= "\t<div class=\"notice-message\">".$message."</div>\n";

	return $msg;
}

// displays a generic message on a page
function message($message) {
	$msg = "\t<div class=\"clear\"></div>\n\n";
	$msg .= "\t<!-- div class message is for general messages & warnings -->\n";
	$msg .= "\t<div class=\"message\">".$message."</div>\n";

	return $msg;
}

// redirects to another page
function redirect($location) {
	return header("Location: $location");
}

// get the date of birth, return the age
function user_age($userage) {
    return floor((time() - strtotime($userage))/31556926);
}

// strip the protocol from a url
function short_url($url) {
	return preg_replace('/(https:\/\/)|(http:\/\/)/i', '', $url);
}

// make time differences nice looking
# I could never get the code working correctly. It will have to wait until a future release.

 // get the number of users
 function user_quantity($users) {
 	$dbconn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
 	$userqq = "SELECT * FROM ".TBLPREFIX."users";
 	$userqquery = mysqli_query($dbconn,$userqq);
 	$userqty = mysqli_num_rows($userqquery);

 	return $userqty;
 }

 // get the number of active users over the past six months
function users_half_year($sometimes_users) {
	$dbconn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	$usershalfyear = 0;

	$usershalfyearq = "SELECT * FROM ".TBLPREFIX."users";
	$usershalfyearquery = mysqli_query($dbconn,$usershalfyearq);
	while ($usershalfyearopt = mysqli_fetch_assoc($usershalfyearquery)) {
		$lastlogin	= strtotime($usershalfyearopt['user_last_login']);
		$now			= strtotime('now');
		if (($now - $lastlogin) < 15778800) { // 15778800 is six months in seconds
			$usershalfyear++;
		}
	}

	return $usershalfyear;
}

 // get the number of active users over the past month
 function users_past_month($active_users) {
	$dbconn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	$usersmonthqty = 0;

	$usersmonthq = "SELECT * FROM ".TBLPREFIX."users";
	$usersmonthquery = mysqli_query($dbconn,$usersmonthq);
	while ($usersmonthopt = mysqli_fetch_assoc($usersmonthquery)) {
		$lastlogin	= strtotime($usersmonthopt['user_last_login']);
		$now			= strtotime('now');
		if (($now - $lastlogin) < 2629800) { // 2629800 is one month in seconds
			$usersmonthqty++;
		}
	}

	return $usersmonthqty;
 }

 // get the number of posts
 function post_quantity($posts) {
 	$dbconn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
 	$postqq = "SELECT * FROM ".TBLPREFIX."posts WHERE post_type='POST'";
 	$postqquery = mysqli_query($dbconn,$postqq);
 	$postqty = mysqli_num_rows($postqquery);

 	return $postqty;
 }

 // get the number of posts
 function page_quantity($pages) {
 	$dbconn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
 	$pageqq = "SELECT * FROM ".TBLPREFIX."posts WHERE post_type='PAGE'";
 	$pageqquery = mysqli_query($dbconn,$pageqq);
 	$pageqty = mysqli_num_rows($pageqquery);

 	return $pageqty;
 }

 // get the number of posts for nodeinfo
 // includes total number of poasts and pages
 function node_post_quantity($posts) {
   $dbconn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
   $postqq = "SELECT * FROM ".TBLPREFIX."posts";
   $postqquery = mysqli_query($dbconn,$postqq);
   $postqty = mysqli_num_rows($postqquery);

	return $postqty;
}


// Get the number of a user's posts from user_outbox in users table
function user_post_quantity($userid) {
	$dbconn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
	$postsbyq = "SELECT * FROM ".TBLPREFIX."posts WHERE user_id='".$userid."'";
 	$postsbyquery = mysqli_query($dbconn,$postsbyq);
 	$postsbyqty = mysqli_num_rows($postsbyquery);

 	return $postsbyqty;
}

// get the number of the user's followers

// get the number of accounts the user is following

// get the date of the latest post for the Atom feed
function atom_updated($time) {
	$dbconn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
	$postqq = "SELECT * FROM ".TBLPREFIX."posts WHERE post_status=\"6ьötХ5áзÚZ\" ORDER BY post_date DESC LIMIT 1";
	$postqquery = mysqli_query($dbconn,$postqq);
	while ($postopt = mysqli_fetch_assoc($postqquery)) {
		$updated = $postopt['post_date'];
		return date("c", strtotime($updated));
	}
}

?>
