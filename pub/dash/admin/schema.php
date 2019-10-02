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
    echo _("<span style=\"color:green;\">Table <i>".TBLPREFIX."actor_types</i> successfully created.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."actor_types in following message */
    echo _("<span style=\"color:red;\">Error: Could not create table <i>".TBLPREFIX."actor_types</i>.")."</span><br>\n\n";
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
    echo _("<span style=\"color:green;\">Default data added to table <i>".TBLPREFIX."actor_types</i>.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."actor_types in following message */
    echo _("<span style=\"color:red;\">Error: Could not add data to table <i>".TBLPREFIX."actor_types</i>.")."</span><br>\n\n";
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
    echo _("<span style=\"color:green;\">Table <i>".TBLPREFIX."comments</i> successfully created.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."comments in following message */
    echo _("<span style=\"color:red;\">Error: Could not create table <i>".TBLPREFIX."comments</i>.")."</span><br>\n\n";
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
    echo _("<span style=\"color:green;\">Table <i>".TBLPREFIX."configuration</i> successfully created.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."configuration in following message */
    echo _("<span style=\"color:red;\">Error: Could not create table <i>".TBLPREFIX."configuration</i>.")."</span><br>\n\n";
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
    echo _("<span style=\"color:green;\">Default data added to table <i>".TBLPREFIX."configuration</i>.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."configuration in following message */
    echo _("<span style=\"color:red;\">Error: Could not add data to table <i>".TBLPREFIX."configuration</i>.")."</span><br>\n\n";
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
    echo _("<span style=\"color:green;\">Table <i>".TBLPREFIX."locales</i> successfully created.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."locales in following message */
    echo _("<span style=\"color:red;\">Error: Could not create table <i>".TBLPREFIX."locales</i>.")."</span><br>\n\n";
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
    echo _("<span style=\"color:green;\">Default data added to table <i>".TBLPREFIX."locales</i>.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."locales in following message */
    echo _("<span style=\"color:red;\">Error: Could not add data to table <i>".TBLPREFIX."locales</i>.")."</span><br>\n\n";
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
    echo _("<span style=\"color:green;\">Table <i>".TBLPREFIX."locations</i> successfully created.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."locations in following message */
    echo _("<span style=\"color:red;\">Error: Could not create table <i>".TBLPREFIX."locations</i>.")."</span><br>\n\n";
  }


//
// Create the ".TBLPREFIX."media table
//
    $media_user_comment     = _("Who uploaded this media\?");
    $media_date_comment     = _("When was it uploaded\?");
    $media_url_comment      = _("Where is it located on this server\?");
    $media_slug_comment     = _("URL\-friendly version of media\_title");
    $media_status_comment   = _("From ".TBLPREFIX."post\_statuses table");
    $media_type_comment     = _("From ".TBLPREFIX."media\_types table");
    $media_tbl_comment      = _("Table for media");

    $create_media_tbl = "CREATE TABLE ".TBLPREFIX."media (
            media_id int(11) NOT NULL AUTO_INCREMENT,
            user_name varchar(20) NOT NULL COMMENT '".$media_user_comment."',
            media_date datetime NOT NULL COMMENT '".$media_date_comment."',
            media_url tinytext NOT NULL COMMENT '".$media_url_comment."',
            media_title varchar(255) NOT NULL,
            media_slug varchar(255) NOT NULL COMMENT '".$media_tbl_comment."',
            media_status varchar(20) NOT NULL COMMENT '".$media_status_comment."',
            media_type varchar(20) NOT NULL COMMENT '".$media_type_comment."',
            media_modified_date datetime NOT NULL,
            media_tags text NOT NULL,
            media_categories text NOT NULL,
            comments_open tinyint(4) NOT NULL,
            pings_open tinyint(4) NOT NULL,
            PRIMARY KEY (media_id)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='".$media_tbl_comment."' COLLATE=utf8mb4_unicode_ci;";

  if (mysqli_query($dbconn,$create_media_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."media in following message */
    echo _("<span style=\"color:green;\">Table <i>".TBLPREFIX."media</i> successfully created.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."media in following message */
    echo _("<span style=\"color:red;\">Error: Could not create table <i>".TBLPREFIX."media</i>.")."</span><br>\n\n";
    echo $create_media_tbl."<br>\n\n";
  }



//
// Create the ".TBLPREFIX."media_types table
//
  $create_media_types_tbl = "CREATE TABLE ".TBLPREFIX."media_types (
    media_type_name varchar(20) NOT NULL,
    PRIMARY KEY (media_type_name)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

  if (mysqli_query($dbconn,$create_media_types_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."media_types in following message */
    echo _("<span style=\"color:green;\">Table <i>".TBLPREFIX."media_types</i> successfully created.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."media_types in following message */
    echo _("<span style=\"color:red;\">Error: Could not create table <i>".TBLPREFIX."media_types</i>.")."</span><br>\n\n";
  }

//
// Fill the ".TBLPREFIX."media_types table with some default data
// Some of these are aspirational
//
  $fill_media_types_tbl = "INSERT INTO ".TBLPREFIX."media_types (
                            media_type_name
                          ) VALUES
                          ('AUDIO'),
                          ('IMAGE'),
                          ('VIDEO'),
                          ('DOCUMENT'),
                          ('PACKAGE')";

  if (mysqli_query($dbconn,$fill_media_types_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."media_types in following message */
    echo _("<span style=\"color:green;\">Default data added to table <i>".TBLPREFIX."media_types</i>.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."media_types in following message */
    echo _("<span style=\"color:red;\">Error: Could not add data to table <i>".TBLPREFIX."media_types</i>.")."</span><br>\n\n";
  }



//
// Create the ".TBLPREFIX."messages table
//
    $message_url_comment = "website URL \+ \/messages\/ \+ YmdHis \+ userid";
    $message_to_comment = "The accounts that are being sent the message";
    $message_in_reply_to_comment = "The URL that this message is in reply to";
    $message_flagged_by_comment = "The user\_id of the person who flagged it";
    $message_sticky_comment = "Boolean if a message is sticky and will appear at top of timeline.";

    $create_messages_tbl = "CREATE TABLE ".TBLPREFIX."messages (
        message_id varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
        message_url tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '".$message_url_comment."',
        user_name varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
        message_to text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '".$message_to_comment."',
        message_time datetime NOT NULL,
        message_privacy_level varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
        message_in_reply_to tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '".$message_in_reply_to_comment."',
        message_text text COLLATE utf8mb4_unicode_ci NOT NULL,
        message_flagged_on datetime NOT NULL,
        message_flagged_by int(11) NOT NULL COMMENT '".$message_flagged_by_comment."',
        message_deleted_on datetime NOT NULL,
        message_deleted_by int(11) NOT NULL,
        message_likes text COLLATE utf8mb4_unicode_ci NOT NULL,
        message_dislikes text COLLATE utf8mb4_unicode_ci NOT NULL,
        message_shares text COLLATE utf8mb4_unicode_ci NOT NULL,
        message_sticky tinyint(1) NOT NULL COMMENT '".$message_sticky_comment."',
        PRIMARY KEY (message_id),
        KEY user_name (user_name),
        KEY message_time (message_time),
        KEY message_flagged_on (message_flagged_on),
        KEY message_flagged_by (message_flagged_by),
        KEY message_deleted_on (message_deleted_on),
        KEY message_deleted_by (message_deleted_by)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

  if (mysqli_query($dbconn,$create_messages_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."messages in following message */
    echo _("<span style=\"color:green;\">Table <i>".TBLPREFIX."messages</i> successfully created.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."messages in following message */
    echo _("<span style=\"color:red;\">Error: Could not create table <i>".TBLPREFIX."messages</i>.")."</span><br>\n\n";
    echo $create_messages_tbl."<br>\n\n";
  }



//
// Create the ".TBLPREFIX."posts table
//
    $create_posts_tbl = "CREATE TABLE ".TBLPREFIX."posts (
              post_id int(11) NOT NULL AUTO_INCREMENT,
              user_id int(11) NOT NULL,
              post_date datetime NOT NULL,
              post_title varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
              post_slug varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'URL friendly version of post_title',
              post_text text COLLATE utf8mb4_unicode_ci NOT NULL,
              post_status varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'draft, private, or public',
              post_type varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'post or page',
              post_modified_date datetime NOT NULL,
              post_tags text COLLATE utf8mb4_unicode_ci NOT NULL,
              post_categories text COLLATE utf8mb4_unicode_ci NOT NULL,
              comments_open tinyint(4) NOT NULL,
              pings_open tinyint(4) NOT NULL,
              PRIMARY KEY (post_id),
              UNIQUE KEY `post_title` (`post_title`(250)),
              KEY user_id (user_id),
              KEY post_date (post_date),
              KEY post_slug (post_slug(250)),
              KEY post_status (post_status),
              KEY post_type (post_type),
              KEY comments_open (comments_open),
              KEY pings_open (pings_open)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

  if (mysqli_query($dbconn,$create_posts_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."posts in following message */
    echo _("<span style=\"color:green;\">Table <i>".TBLPREFIX."posts</i> successfully created.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."posts in following message */
    echo _("<span style=\"color:red;\">Error: Could not create table <i>".TBLPREFIX."posts</i>.")."</span><br>\n\n";
    echo $create_posts_tbl."<br>\n\n";
  }


//
// Create the ".TBLPREFIX."post_statuses table
//
  $create_post_statuses_tbl = "CREATE TABLE ".TBLPREFIX."post_statuses (
    post_status_name varchar(20) NOT NULL,
    PRIMARY KEY (post_status_name)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

  if (mysqli_query($dbconn,$create_post_statuses_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."post_statuses in following message */
    echo _("<span style=\"color:green;\">Table <i>".TBLPREFIX."post_statuses</i> successfully created.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."post_statuses in following message */
    echo _("<span style=\"color:red;\">Error: Could not create table <i>".TBLPREFIX."post_statuses</i>.")."</span><br>\n\n";
  }

//
// Fill the ".TBLPREFIX."post_statuses table with some default data
// Some of these are aspirational
//
  $fill_post_statuses_tbl = "INSERT INTO ".TBLPREFIX."post_statuses (
                            post_status_name
                          ) VALUES
                          ('DRAFT'),
                          ('PRIVATE'),
                          ('PUBLIC')";

  if (mysqli_query($dbconn,$fill_post_statuses_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."post_statuses in following message */
    echo _("<span style=\"color:green;\">Default data added to table <i>".TBLPREFIX."post_statuses</i>.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."post_statuses in following message */
    echo _("<span style=\"color:red;\">Error: Could not add data to table <i>".TBLPREFIX."post_statuses</i>.")."</span><br>\n\n";
  }



//
// Create the ".TBLPREFIX."post_types table
//
  $create_post_types_tbl = "CREATE TABLE ".TBLPREFIX."post_types (
    post_type_name varchar(20) NOT NULL,
    PRIMARY KEY (post_type_name)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

  if (mysqli_query($dbconn,$create_post_types_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."post_types in following message */
    echo _("<span style=\"color:green;\">Table <i>".TBLPREFIX."post_types</i> successfully created.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."post_types in following message */
    echo _("<span style=\"color:red;\">Error: Could not create table <i>".TBLPREFIX."post_types</i>.")."</span><br>\n\n";
  }

//
// Fill the ".TBLPREFIX."post_types table with some default data
// Some of these are aspirational
//
  $fill_post_types_tbl = "INSERT INTO ".TBLPREFIX."post_types (
                            post_type_name
                          ) VALUES
                          ('POST'),
                          ('PAGE'),
                          ('SINGLE_AUDIO'),
                          ('SINGLE_IMAGE'),
                          ('SINGLE_VIDEO')";

  if (mysqli_query($dbconn,$fill_post_types_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."post_types in following message */
    echo _("<span style=\"color:green;\">Default data added to table <i>".TBLPREFIX."post_types</i>.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."post_types in following message */
    echo _("<span style=\"color:green;\">Error: Could not add data to table <i>".TBLPREFIX."post_types</i>.")."</span><br>\n\n";
  }



//
// Create the ".TBLPREFIX."privacy levels table
//
  $privacy_levels_tbl_comment = _("Table for privacy levels");

  $create_privacy_levels_tbl = "CREATE TABLE ".TBLPREFIX."privacy_levels (
    privacy_level_name varchar(20) NOT NULL,
    PRIMARY KEY (privacy_level_name)
  ) DEFAULT CHARSET=utf8mb4 COMMENT='".$privacy_levels_tbl_comment."'";

  if (mysqli_query($dbconn,$create_privacy_levels_tbl)) {
    /* translators: Do not translate ".TBLPREFIX."privacy_levels in following message */
    echo _("<span style=\"color:green;\">Table <i>".TBLPREFIX."privacy_levels</i> successfully created.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."privacy_levels in following message */
    echo _("<span style=\"color:red;\">Error: Could not create table <i>".TBLPREFIX."privacy_levels</i>.")."</span><br>\n\n";
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
    echo _("<span style=\"color:green;\">Default data added to table <i>".TBLPREFIX."privacy_levels</i>.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."privacy_levels in following message */
    echo _("<span style=\"color:red;\">Error: Could not add data to table <i>".TBLPREFIX."privacy_levels</i>.")."</span><br>\n\n";
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
    echo _("<span style=\"color:green;\">Table <i>".TBLPREFIX."time_zones</i> successfully created.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."time_zones in following message */
    echo _("<span style=\"color:red;\">Error: Could not create table <i>".TBLPREFIX."time_zones</i>.")."</span><br>\n\n";
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
    user_session varchar(128),
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
    echo _("<span style=\"color:green;\">Table <i>".TBLPREFIX."users</i> successfully created.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."users in following message */
    echo _("<span style=\"color:red;\">Error: Could not create table <i>".TBLPREFIX."users</i>.")."</span><br>\n\n";
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
    echo _("<span style=\"color:green;\">Table <i>".TBLPREFIX."user_levels</i> successfully created.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."user_levels in following message */
    echo _("<span style=\"color:red;\">Error: Could not create table <i>".TBLPREFIX."user_levels</i>.")."</span><br>\n\n";
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
    echo _("<span style=\"color:green;\">Default data added to table <i>".TBLPREFIX."user_levels</i>.")."</span><br>\n\n";
  } else {
    /* translators: Do not translate ".TBLPREFIX."user_levels in following message */
    echo _("<span style=\"color:red;\">Error: Could not add data to table <i>".TBLPREFIX."user_levels</i>.")."</span><br>\n\n";
  }

//
// Now that the tables are created, let's fill most of them
//
echo "Go to <a href=\"data-fill.php\">data-fill.php</a>";
#header("Location: data-fill.php");
#redirect("data-fill.php");
?>
