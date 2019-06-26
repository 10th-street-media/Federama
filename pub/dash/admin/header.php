<?php
/*
 * pub/dash/admin/header.php
 *
 * This page provides the header code for the pre-installation admin pages.
 *
 * since Federama version 0.1
 *
 */

 if(isset($_COOKIE['loc'])) {
	$user_locale = $_COOKIE['loc'];
 } else {
	$user_locale = "en";
 }

  	// have Amore use the right localization
	putenv("LC_MESSAGES=".$user_locale);
	setlocale(LC_MESSAGES, $user_locale);

	// set the textdomain
	$textdomain = "federama";
	bindtextdomain($textdomain, "../locales");
	bind_textdomain_codeset($textdomain, 'UTF-8');
	textdomain($textdomain);
?>
<!DOCTYPE html>
<html lang="<?php echo $user_locale; ?>">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="shortcut icon" href="../../favicon.ico">
	<title><?php echo $pagetitle; ?></title>
	<meta name="description" content="<?php echo $website_description; ?>">
	<link href="../style/dash-style-default.css" rel="stylesheet" type="text/css">
</head>
<body class="w3-theme-l5">
	<div class="w3-top">
	<header class="w3-container w3-bar w3-large w3-theme-d1">
		<div class="w3-left w3-padding"><!-- We may put something here eventually --></div>
		<div class="w3-right w3-padding"><!-- We may put something here eventually --></div>
		<div class="w3-center w3-padding w3-xlarge"><b>Ꞙ</b></div>
	</header>
	</div> <!-- .w3-top -->
