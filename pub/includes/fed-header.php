<?php
/*
 * pub/includes/fed-header.php
 *
 * This header starts the HTML for each public facing webpage in Federama.
 *
 * since Federama version 0.1
 *
 */

   // have Federama use the right localization
	putenv("LC_MESSAGES=".$default_locale);
	setlocale(LC_MESSAGES, $default_locale);

	// set the textdomain
	$textdomain = "federama";
	bindtextdomain($textdomain, "locale");
	bind_textdomain_codeset($textdomain, 'UTF-8');
	textdomain($textdomain);
?>
<!DOCTYPE html>
<html lang="<?php echo $default_locale; ?>">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="shortcut icon" href="favicon.ico">
	<title><?php echo _($pagetitle); ?></title>
	<meta name="description" content="<?php echo $website_description; ?>">
	<link href="<?php echo $theme_path."/style.css"; ?>" rel="stylesheet" type="text/css">
</head>
<body class="w3-theme-l5">
	<div class="w3-top">
	<header class="w3-container w3-bar w3-large w3-theme-d1">
		<div class="w3-left w3-padding"><a href="<?php echo $website_url; ?>index.php"><?php echo $website_name; // $sitetitle doesn't get i18n ?></a></div>
		<div class="w3-right w3-padding"><?php
		echo _('Hello, ');
		// if a user is logged in, display their username and link to dash/my-profile.php
		// if a user isn't logged in, display $visitortitle and link to the-login.php
		if (isset($_COOKIE['uname'])) {
			echo "<a href=\"".$website_url."dash/index.php\">";
		} else {
			echo "<a href=\"".$website_url."the-login.php\">";
		}
		// see if a session is set and get the username, if so.
		if (isset($_COOKIE['uname'])) {
			echo $_COOKIE['uname'];
		} else {
			echo _('Guest');
		}
		echo "</a>&nbsp;|&nbsp;";
		echo "<a href=\"\#\">&#9776;</a>";
?>
</div>
		<div class="w3-center w3-padding w3-large"><img src="<?php echo $website_url; ?>images/federama-logo-white-24.png"></div>
	</header>
	</div> <!-- .w3-top -->
