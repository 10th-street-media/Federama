<?php
/*
 * pub/includes/configuration-data.php
 *
 * This page is a template to get the website's configuration from the database.
 *
 * since Federama version 0.1
 *
 */
require			"database-connect.php";
// let's get the configuration data

$mysiteq = "SELECT * FROM ".TBLPREFIX."configuration";
$mysitequery = mysqli_query($dbconn,$mysiteq);
while ($mysiteopt = mysqli_fetch_assoc($mysitequery)) {
	$website_url                     = $mysiteopt['website_url'];
	$website_name                    = $mysiteopt['website_name'];
	$website_description             = $mysiteopt['website_description'];
	$default_locale                  = $mysiteopt['default_locale'];
	$open_registration               = $mysiteopt['open_registrations'];
	$admin_account                   = $mysiteopt['admin_account'];
   $admin_email                     = $mysiteopt['admin_email'];
   $installed_themes                = $mysiteopt['installed_themes'];
   $active_theme                    = $mysiteopt['active_theme'];
   $blocked_instances               = $mysiteopt['blocked_instances'];
   $list_with_the_federation_info   = $mysiteopt['list_with_the_federation_info'];
   $list_with_fediverse_network     = $mysiteopt['list_with_fediverse_network'];
   $list_with_federama_social       = $mysiteopt['list_with_federama_social'];
}
?>
