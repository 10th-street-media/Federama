<?php
/*
 * pub/dash/admin/schema.php
 *
 * Creates the tables in the database.
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


/*
 * Let's start creating some tables
 */

//
// Create the fed_actor_types table
// FYI: https://www.w3.org/TR/activitystreams-core/#actors
//
  $actor_types_tbl_comment = _("Table for ActivityStreams Actor types.");

  $create_actor_types_tbl = "CREATE TABLE fed_actor_types (
    actor_type_name tinytext NOT NULL,
    PRIMARY KEY (actor_type_name)
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$actor_types_tbl_comment."'";

  if (mysqli_query($dbconn,$create_actor_types_tbl)) {
    /* translators: Do not translate fed_actor_types in following message */
    echo _("Table <i>fed_actor_types</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate fed_actor_types in following message */
    echo _("Error: Could not create table <i>fed_actor_types</i>.")."<br>\n\n";
  }

//
// Fill the fed_actor_types table with some default data
//
  $fill_actor_types_tbl = "INSERT INTO fed_actor_types (
                  actor_type_name
                ) VALUES
                ('APPLICATION'),
                ('GROUP'),
                ('PERSON'),
                ('SERVICE'),
                ('ORGANIZATION')";

  if (mysqli_query($dbconn,$fill_actor_types_tbl)) {
    /* translators: Do not translate fed_actor_types in following message */
    echo _("Default data added to table <i>fed_actor_types</i>.")."<br>\n\n";
  } else {
    /* translators: Do not translate fed_actor_types in following message */
    echo _("Error: Could not add data to table <i>fed_actor_types</i>.")."<br>\n\n";
  }


//
// Create the fed_configuration table
//
  $configuration_tbl_comment = _("Table for website configuration.");
  $admin_account_field_comment = _("This will be the first account created.");
  $default_yes = _("The default setting is yes.");
  $default_no	= _("The default setting is no.");

  $create_configuration_tbl = "CREATE TABLE fed_configuration (
    website_url tinytext NOT NULL,
    website_name tinytext NOT NULL,
    website_description text NOT NULL,
    default_locale tinytext NOT NULL,
    open_registrations BOOLEAN DEFAULT 0 COMMENT '".$default_no."',
    admin_account tinytext NOT NULL COMMENT '".$admin_account_field_comment."',
    admin_email tinytext NOT NULL,
    installed_themes text NOT NULL,
    active_theme tinytext NOT NULL,
    banned_user_names text NOT NULL,
    deleted_user_names text NOT NULL,
    blocked_instances text,
    list_with_the_federation_info BOOLEAN DEFAULT 1 COMMENT '".$default_yes."',
    list_with_fediverse_network BOOLEAN DEFAULT 1 COMMENT '".$default_yes."',
    list_with_federama_social BOOLEAN DEFAULT 1 COMMENT '".$default_yes."',
    PRIMARY KEY (primary_key)
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$configuration_tbl_comment."'";

  if (mysqli_query($dbconn,$create_configuration_tbl)) {
    /* translators: Do not translate fed_configuration in following message */
    echo _("Table <i>fed_configuration</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate fed_configuration in following message */
    echo _("Error: Could not create table <i>fed_configuration</i>.")."<br>\n\n";
  }

//
// Fill the configuration table with some default data
//
  $default_website_description = _("Another fine website made with Amore.");

  $fill_configuration_tbl = "INSERT INTO fed_configuration (
                    website_name,
                    website_description,
                    default_locale,
                    installed_themes,
                    active_theme
                  ) VALUES (
                    'Amore',
                    '".$default_website_description."',
                    'en-US',
                    'Federama 2019',
                    'Federama 2019'
                    )";

  if (mysqli_query($dbconn,$fill_configuration_tbl)) {
    /* translators: Do not translate fed_configuration in following message */
    echo _("Default data added to table <i>fed_configuration</i>.")."<br>\n\n";
  } else {
    /* translators: Do not translate fed_configuration in following message */
    echo _("Error: Could not add data to table <i>fed_configuration</i>.")."<br>\n\n";
  }


//
// Create the fed_locales table
// Table will be filled as new locales are added
//
  $locales_tbl_comment = _("Table for i18n/l10n locales.");

  $create_locales_tbl = "CREATE TABLE fed_locales (
    locale_language tinytext NOT NULL,
    locale_country tinytext NOT NULL,
    PRIMARY KEY (locale_language,locale_country)
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$locales_tbl_comment."'";

  if (mysqli_query($dbconn,$create_locales_tbl)) {
    /* translators: Do not translate fed_locales in following message */
    echo _("Table <i>fed_locales</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate fed_locales in following message */
    echo _("Error: Could not create table <i>fed_locales</i>.")."<br>\n\n";
  }

//
// Fill the fed_locales table with a locale
//
  $fill_locales_tbl = "INSERT INTO fed_locales (
                  locale_language,
                  locale_country
                ) VALUES ('en', 'US')";

  if (mysqli_query($dbconn,$fill_locales_tbl)) {
    /* translators: Do not translate fed_locales in following message */
    echo _("Default data added to table <i>fed_locales</i>.")."<br>\n\n";
  } else {
    /* translators: Do not translate fed_locales in following message */
    echo _("Error: Could not add data to table <i>fed_locales</i>.")."<br>\n\n";
  }


//
// Create the fed_locations table
// Table will be filled via data-fill.php
//
  $locations_tbl_comment = _("Table for locations/places.");

  $create_locations_tbl = "CREATE TABLE fed_locations (
    location_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    location_name tinytext NOT NULL,
    location_parent varchar(60) NOT NULL,
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$locations_tbl_comment."'";

  if (mysqli_query($dbconn,$create_locations_tbl)) {
    /* translators: Do not translate fed_locations in following message */
    echo _("Table <i>fed_locations</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate fed_locations in following message */
    echo _("Error: Could not create table <i>fed_locations</i>.")."<br>\n\n";
  }


//
// Create the privacy levels table
//
  $privacy_levels_tbl_comment = _("Table for privacy levels");

  $create_privacy_levels_tbl = "CREATE TABLE fed_privacy_levels (
    privacy_level_name tinytext NOT NULL,
    PRIMARY KEY (privacy_level_name),
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$privacy_levels_tbl_comment."'";

  if (mysqli_query($dbconn,$create_privacy_levels_tbl)) {
    /* translators: Do not translate fed_privacy_levels in following message */
    echo _("Table <i>fed_privacy_levels</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate fed_privacy_levels in following message */
    echo _("Error: Could not create table <i>fed_privacy_levels</i>.")."<br>\n\n";
  }

//
// Fill the fed_privacy_levels table with some default data
// Some of these are aspirational
//
  $fill_privacy_levels_tbl = "INSERT INTO fed_privacy_levels (
                            privacy_level_name
                          ) VALUES
                          ('INSTANCE'),
                          ('EVERYONE'),
                          ('SELF'),
                          ('PRIVATE'),
                          ('FOLLOWERS'),
                          ('FRIENDS'),
                          ('FEDIVERSE')";

  if (mysqli_query($dbconn,$fill_privacy_levels_tbl)) {
    /* translators: Do not translate fed_privacy_levels in following message */
    echo _("Default data added to table <i>fed_privacy_levels</i>.")."<br>\n\n";
  } else {
    /* translators: Do not translate fed_privacy_levels in following message */
    echo _("Error: Could not add data to table <i>fed_privacy_levels</i>.")."<br>\n\n";
  }


//
// Create the fed time zones table
// Table will be filled via data-fill.php
//
  $time_zones_tbl_comment = _("Table for time zones");
  $DST_offset_comment = _("Offset if Daylight Savings Time is used");

  $create_time_zones_tbl = "CREATE TABLE fed_time_zones (
    time_zone_name tinytext NOT NULL,
    time_zone_offset tinytext NOT NULL,
    time_zone_DST_offset tinytext NOT NULL COMMENT '".$DST_offset_comment."',
    PRIMARY KEY (time_zone_name)
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$time_zones_tbl_comment."'";

  if (mysqli_query($dbconn,$create_time_zones_tbl)) {
    /* translators: Do not translate fed_time_zones in following message */
    echo _("Table <i>fed_time_zones</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate fed_time_zones in following message */
    echo _("Error: Could not create table <i>fed_time_zones</i>.")."<br>\n\n";
  }


//
// Create the users table
//
  $users_tbl_comment = _("Table for users");
  $display_name_field_comment = _("This is the same as the ActivityPub preferredUsername");

  $create_users_tbl = "CREATE TABLE fed_users (
    user_id varchar(10) NOT NULL,
    user_name tinytext NOT NULL,
    user_display_name tinytext NOT NULL COMMENT '".$display_name_field_comment."',
    user_pass tinytext NOT NULL,
    user_email tinytext NOT NULL,
    user_level varchar(10) NOT NULL,
    user_actor_type varchar(10) NOT NULL,
    user_outbox text NOT NULL,
    user_inbox text NOT NULL,
    user_liked text NOT NULL,
    user_disliked text NOT NULL,
    user_shared text NOT NULL,
    user_likes text NOT NULL,
    user_dislikes text NOT NULL,
    user_shares text NOT NULL,
    user_follows text NOT NULL,
    user_followers text NOT NULL,
    user_priv_key text NOT NULL,
    user_pub_key text NOT NULL,
    user_avatar tinytext,
    user_locale varchar(10) NOT NULL,
    user_time_zone varchar(10) NOT NULL,
    user_bio tinytext NOT NULL,
    user_is_suspended datetime,
    user_suspended_on datetime,
    user_suspended_by varchar(10),
    user_is_banned BOOLEAN DEFAULT 0,
    user_banned_on datetime,
    user_banned_by varchar(10),
    user_created datetime NOT NULL,
    user_last_login datetime NOT NULL,
    PRIMARY KEY (user_id),
    UNIQUE KEY user_name (user_name(20))
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$users_tbl_comment."'";

  if (mysqli_query($dbconn,$create_users_tbl)) {
    /* translators: Do not translate fed_users in following message */
    echo _("Table <i>fed_users</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate fed_users in following message */
    echo _("Error: Could not create table <i>fed_users</i>.")."<br>\n\n";
  }


//
// Create the user_levels table
//
  $user_levels_tbl_comment = _("Table for user levels");

  $create_user_levels_tbl = "CREATE TABLE fed_user_levels (
    user_level_name tinytext NOT NULL,
    PRIMARY KEY (user_level_name)
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$user_levels_tbl_comment."'";

  if (mysqli_query($dbconn,$create_user_levels_tbl)) {
    /* translators: Do not translate fed_user_levels in following message */
    echo _("Table <i>fed_user_levels</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate fed_user_levels in following message */
    echo _("Error: Could not create table <i>fed_user_levels</i>.")."<br>\n\n";
  }

//
// Fill the user_levels table with some default data
//
  $fill_user_levels_tbl = "INSERT INTO fed_user_levels (
                      user_level_name
                    ) VALUES
                    ('USER'),
                    ('MODERATOR'),
                    ('TRANSLATOR'),
                    ('ADMINISTRATOR'),
                    ('GUIDE')";

  if (mysqli_query($dbconn,$fill_user_levels_tbl)) {
    /* translators: Do not translate fed_user_levels in following message */
    echo _("Default data added to table <i>fed_user_levels</i>.")."<br>\n\n";
  } else {
    /* translators: Do not translate fed_user_levels in following message */
    echo _("Error: Could not add data to table <i>fed_user_levels</i>.")."<br>\n\n";
  }

//
// Now that the tables are created, let's fill most of them
//
redirect("data-fill.php");
?>
