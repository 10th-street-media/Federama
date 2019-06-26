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
// Create the actor types table
// FYI: https://www.w3.org/TR/activitystreams-core/#actors
//
  $actor_types_tbl_comment = _("Table for ActivityStreams Actor types.");

  $create_actor_types_tbl = "CREATE TABLE ".TBLPREFIX."actor_types (
    actor_type_name varchar(20) NOT NULL,
    PRIMARY KEY (actor_type_name)
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$actor_types_tbl_comment."'";

  if (mysqli_query($dbconn,$create_actor_types_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."actor_types in following message */
    echo _("Table <i>".TBLPREFIX."actor_types</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."actor_types in following message */
    echo _("Error: Could not create table <i>".TBLPREFIX."actor_types</i>.")."<br>\n\n";
  }

//
// Fill the actor types table with some default data
//
  $fill_actor_types_tbl = "INSERT INTO ".TBLPREFIX."actor_types (
                  actor_type_name
                ) VALUES
                ('APPLICATION'),
                ('GROUP'),
                ('PERSON'),
                ('SERVICE'),
                ('ORGANIZATION')";

  if (mysqli_query($dbconn,$fill_actor_types_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."actor_types in following message */
    echo _("Default data added to table <i>".TBLPREFIX."actor_types</i>.")."<br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."actor_types in following message */
    echo _("Error: Could not add data to table <i>".TBLPREFIX."actor_types</i>.")."<br>\n\n";
  }


//
// Create the comments table
//
	$create_comments_tbl = "CREATE TABLE ".TBLPREFIX."comments (
  			comment_id int(11) NOT NULL AUTO_INCREMENT,
  			post_id int(11) NOT NULL,
  			comment_parent_id int(11) NOT NULL,
  			user_id int(11) NOT NULL COMMENT 'local id',
  			comment_by varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  			comment_author_name varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  			comment_author_email varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  			comment_author_url varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  			comment_author_ip varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  			comment_date datetime NOT NULL COMMENT 'GMT',
  			comment_text text COLLATE utf8mb4_unicode_ci NOT NULL,
  			comment_karma tinyint(4) NOT NULL,
  			comment_approved tinyint(4) NOT NULL,
  			comment_approved_by int(11) NOT NULL,
  			comment_agent varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  			comment_type tinyint(4) NOT NULL COMMENT 'normal, pingback, or ???',
  			PRIMARY KEY (comment_id),
  			KEY post_id (post_id),
  			KEY comment_parent_id (comment_parent_id),
  			KEY user_id (user_id),
  			KEY comment_by (comment_by(250)),
  			KEY comment_author_name (comment_author_name),
  			KEY comment_author_email (comment_author_email(250)),
  			KEY comment_author_url (comment_author_url(250)),
  			KEY comment_author_ip (comment_author_ip),
  			KEY comment_date (comment_date),
  			KEY comment_karma (comment_karma),
  			KEY comment_approved (comment_approved),
  			KEY comment_approved_by (comment_approved_by),
  			KEY comment_agent (comment_agent(250)),
  			KEY comment_type (comment_type)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

  if (mysqli_query($dbconn,$create_comments_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."comments in following message */
    echo _("Table <i>".TBLPREFIX."comments</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."comments in following message */
    echo _("Error: Could not create table <i>".TBLPREFIX."comments</i>.")."<br>\n\n";
  }



//
// Create the configuration table
//
  $configuration_tbl_comment = _("Table for website configuration.");
  $admin_account_field_comment = _("This will be the first account created.");
  $default_yes = _("The default setting is yes.");
  $default_no	= _("The default setting is no.");

  $create_configuration_tbl = "CREATE TABLE ".TBLPREFIX."configuration (
    website_name varchar(50) NOT NULL,
    website_url varchar(255) NOT NULL,
    website_description tinytext NOT NULL,
    default_locale tinytext NOT NULL,
    open_registrations BOOLEAN DEFAULT 0 COMMENT '".$default_no."',
    admin_account varchar(20) NOT NULL COMMENT '".$admin_account_field_comment."',
    admin_email varchar(255) NOT NULL,
    installed_themes text NOT NULL,
    active_theme tinytext NOT NULL,
    banned_user_names text NOT NULL,
    deleted_user_names text NOT NULL,
    blocked_instances text,
    list_with_the_federation_info BOOLEAN DEFAULT 1 COMMENT '".$default_yes."',
    list_with_fediverse_network BOOLEAN DEFAULT 1 COMMENT '".$default_yes."',
    list_with_federama_social BOOLEAN DEFAULT 1 COMMENT '".$default_yes."'
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$configuration_tbl_comment."'";

  if (mysqli_query($dbconn,$create_configuration_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."configuration in following message */
    echo _("Table <i>".TBLPREFIX."configuration</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."configuration in following message */
    echo _("Error: Could not create table <i>".TBLPREFIX."configuration</i>.")."<br>\n\n";
  }

//
// Fill the configuration table with some default data
//
  $default_website_description = _("Another website created with Federama.");

  $fill_configuration_tbl = "INSERT INTO ".TBLPREFIX."configuration (
                    website_name,
                    website_description,
                    default_locale,
                    installed_themes,
                    active_theme
                  ) VALUES (
                    'Federama',
                    '".$default_website_description."',
                    'en-US',
                    'federama-2019-blue,federama-2019-dark',
                    'federama-2019-blue'
                    )";

  if (mysqli_query($dbconn,$fill_configuration_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."configuration in following message */
    echo _("Default data added to table <i>".TBLPREFIX."configuration</i>.")."<br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."configuration in following message */
    echo _("Error: Could not add data to table <i>".TBLPREFIX."configuration</i>.")."<br>\n\n";
  }


//
// Create the ".TBLPREFIX."locales table
// Table will be filled as new locales are added
//
  $locales_tbl_comment = _("Table for i18n/l10n locales.");

  $create_locales_tbl = "CREATE TABLE ".TBLPREFIX."locales (
    locale_language varchar(3) NOT NULL,
    locale_country varchar(3) NOT NULL,
    PRIMARY KEY (locale_language,locale_country)
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$locales_tbl_comment."'";

  if (mysqli_query($dbconn,$create_locales_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."locales in following message */
    echo _("Table <i>".TBLPREFIX."locales</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."locales in following message */
    echo _("Error: Could not create table <i>".TBLPREFIX."locales</i>.")."<br>\n\n";
  }

//
// Fill the ".TBLPREFIX."locales table with a locale
//
  $fill_locales_tbl = "INSERT INTO ".TBLPREFIX."locales (
                  locale_language,
                  locale_country
                ) VALUES ('en', 'US')";

  if (mysqli_query($dbconn,$fill_locales_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."locales in following message */
    echo _("Default data added to table <i>".TBLPREFIX."locales</i>.")."<br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."locales in following message */
    echo _("Error: Could not add data to table <i>".TBLPREFIX."locales</i>.")."<br>\n\n";
  }


//
// Create the ".TBLPREFIX."locations table
// Table will be filled via data-fill.php
//
  $locations_tbl_comment = _("Table for locations/places.");

  $create_locations_tbl = "CREATE TABLE ".TBLPREFIX."locations (
    location_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    location_name tinytext NOT NULL,
    location_parent varchar(60) NOT NULL
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$locations_tbl_comment."'";

  if (mysqli_query($dbconn,$create_locations_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."locations in following message */
    echo _("Table <i>".TBLPREFIX."locations</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."locations in following message */
    echo _("Error: Could not create table <i>".TBLPREFIX."locations</i>.")."<br>\n\n";
  }


//
// Create the ".TBLPREFIX."posts table
//
	$create_posts_tbl = "CREATE TABLE ".TBLPREFIX."posts (
			  post_id int(11) NOT NULL AUTO_INCREMENT,
			  user_id int(11) NOT NULL,
			  post_date datetime NOT NULL,
			  post_title tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
			  post_slug varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'URL friendly version of post_title',
			  post_text text COLLATE utf8mb4_unicode_ci NOT NULL,
			  post_status varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
			  post_type varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
			  post_modified_date datetime NOT NULL,
			  post_tags text COLLATE utf8mb4_unicode_ci NOT NULL,
			  post_categories text COLLATE utf8mb4_unicode_ci NOT NULL,
			  comment_status varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'open or closed',
			  ping_status varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'open or closed',
			  PRIMARY KEY (post_id),
			  KEY user_id (user_id),
			  KEY post_date (post_date),
			  KEY post_slug (post_slug(250)),
			  KEY post_status (post_status),
			  KEY post_type (post_type),
			  KEY comment_status (comment_status),
			  KEY ping_status (ping_status)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

  if (mysqli_query($dbconn,$create_posts_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."posts in following message */
    echo _("Table <i>".TBLPREFIX."posts</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."posts in following message */
    echo _("Error: Could not create table <i>".TBLPREFIX."posts</i>.")."<br>\n\n";
  }


//
// Create the privacy levels table
//
  $privacy_levels_tbl_comment = _("Table for privacy levels");

  $create_privacy_levels_tbl = "CREATE TABLE ".TBLPREFIX."privacy_levels (
    privacy_level_name varchar(20) NOT NULL,
    PRIMARY KEY (privacy_level_name)
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$privacy_levels_tbl_comment."'";

  if (mysqli_query($dbconn,$create_privacy_levels_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."privacy_levels in following message */
    echo _("Table <i>".TBLPREFIX."privacy_levels</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."privacy_levels in following message */
    echo _("Error: Could not create table <i>".TBLPREFIX."privacy_levels</i>.")."<br>\n\n";
  }

//
// Fill the ".TBLPREFIX."privacy_levels table with some default data
// Some of these are aspirational
//
  $fill_privacy_levels_tbl = "INSERT INTO ".TBLPREFIX."privacy_levels (
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
    /* translators: Do not translate ".TBLPREFIX."privacy_levels in following message */
    echo _("Default data added to table <i>".TBLPREFIX."privacy_levels</i>.")."<br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."privacy_levels in following message */
    echo _("Error: Could not add data to table <i>".TBLPREFIX."privacy_levels</i>.")."<br>\n\n";
  }


//
// Create the fed time zones table
// Table will be filled via data-fill.php
//
  $time_zones_tbl_comment = _("Table for time zones");
  $DST_offset_comment = _("Offset if Daylight Savings Time is used");

  $create_time_zones_tbl = "CREATE TABLE ".TBLPREFIX."time_zones (
    time_zone_name varchar(50) NOT NULL,
    time_zone_offset varchar(10) NOT NULL,
    time_zone_DST_offset varchar(10) NOT NULL COMMENT '".$DST_offset_comment."',
    PRIMARY KEY (time_zone_name),
    KEY time_zone_offset (time_zone_offset),
    KEY time_zone_dst_offset (time_zone_dst_offset)
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$time_zones_tbl_comment."'";

  if (mysqli_query($dbconn,$create_time_zones_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."time_zones in following message */
    echo _("Table <i>".TBLPREFIX."time_zones</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."time_zones in following message */
    echo _("Error: Could not create table <i>".TBLPREFIX."time_zones</i>.")."<br>\n\n";
  }


//
// Create the users table
//
  $users_tbl_comment = _("Table for users");
  $display_name_field_comment = _("This is the same as the ActivityPub preferredUsername");

  $create_users_tbl = "CREATE TABLE ".TBLPREFIX."users (
    user_id int(11) NOT NULL AUTO_INCREMENT,
    user_name varchar(20) NOT NULL,
    user_display_name tinytext NOT NULL COMMENT '".$display_name_field_comment."',
    user_pass tinytext NOT NULL,
    user_email tinytext NOT NULL,
    user_date_of_birth date NOT NULL,
    user_level varchar(30) NOT NULL,
    user_actor_type varchar(30) NOT NULL,
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
    user_location int(11),
    user_time_zone varchar(50) NOT NULL,
    user_bio tinytext NOT NULL,
    user_suspended_until datetime,
    user_suspended_on datetime,
    user_suspended_by varchar(10),
    user_is_banned BOOLEAN DEFAULT 0,
    user_banned_on datetime,
    user_banned_by varchar(10),
    user_created datetime NOT NULL,
    user_last_login datetime NOT NULL,
    PRIMARY KEY (user_id),
    UNIQUE KEY user_name (user_name),
    KEY user_date_of_birth (user_date_of_birth),
    KEY user_level (user_level),
    KEY user_actor_type (user_actor_type),
    KEY user_locale (user_locale),
    KEY user_location (user_location),
    KEY user_time_zone (user_time_zone),
    KEY user_suspended_by (user_suspended_by),
    KEY user_suspended_until (user_suspended_until),
    KEY user_suspended_on (user_suspended_on),
    KEY user_banned_by (user_banned_by),
    KEY user_is_banned (user_is_banned),
    KEY user_banned_on (user_banned_on),
    KEY user_created (user_created),
    KEY user_last_login (user_last_login)
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$users_tbl_comment."'";

  if (mysqli_query($dbconn,$create_users_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."users in following message */
    echo _("Table <i>".TBLPREFIX."users</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."users in following message */
    echo _("Error: Could not create table <i>".TBLPREFIX."users</i>.")."<br>\n\n";
  }


//
// Create the user_levels table
//
  $user_levels_tbl_comment = _("Table for user levels");

  $create_user_levels_tbl = "CREATE TABLE ".TBLPREFIX."user_levels (
    user_level_name varchar(20) NOT NULL,
    PRIMARY KEY (user_level_name)
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$user_levels_tbl_comment."'";

  if (mysqli_query($dbconn,$create_user_levels_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."user_levels in following message */
    echo _("Table <i>".TBLPREFIX."user_levels</i> successfully created.")."<br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."user_levels in following message */
    echo _("Error: Could not create table <i>".TBLPREFIX."user_levels</i>.")."<br>\n\n";
  }

//
// Fill the user_levels table with some default data
//
  $fill_user_levels_tbl = "INSERT INTO ".TBLPREFIX."user_levels (
                      user_level_name
                    ) VALUES
                    ('USER'),
                    ('MODERATOR'),
                    ('TRANSLATOR'),
                    ('ADMINISTRATOR'),
                    ('GUIDE')";

  if (mysqli_query($dbconn,$fill_user_levels_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."user_levels in following message */
    echo _("Default data added to table <i>".TBLPREFIX."user_levels</i>.")."<br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."user_levels in following message */
    echo _("Error: Could not add data to table <i>".TBLPREFIX."user_levels</i>.")."<br>\n\n";
  }

//
// Now that the tables are created, let's fill most of them
//
redirect("data-fill.php");
?>
