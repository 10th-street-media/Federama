<?php
/*
 * pub/includes/verify-cookies.php
 *
 * This page verifies cookies are set for logged in users.
 * If there are no cookies, they are sent to front page.
 *
 * since Federama version 0.1
 */

include_once    "../conn.php";
include         "../functions.php";
require         "database-connect.php";
require_once    "configuration-data.php";

// if the uid or uname cookie is set, get the user info from the db.
if (isset($_COOKIE['PHPSESSID'])) {
    $uidq       = "SELECT * FROM ".TBLPREFIX."users WHERE user_session='".$_COOKIE['PHPSESSID']."'";
    $uidquery   = mysqli_query($dbconn,$uidq);
    while ($uidopt = mysqli_fetch_assoc($uidquery)) {
        $u_id           = $uidopt['user_id'];
        $u_name         = $uidopt['user_name'];
        $u_dname        = $uidopt['user_display_name'];
        $u_email        = $uidopt['user_email'];
        $u_dob          = $uidopt['user_date_of_birth'];
        $u_level        = $uidopt['user_level'];
        $u_type         = $uidopt['user_actor_type'];
        $u_prvkey       = $uidopt['user_priv_key'];
        $u_pubkey       = $uidopt['user_pub_key'];
        $u_avatar       = $uidopt['user_avatar'];
        $u_locale       = $uidopt['user_locale'];
        $u_location     = $uidopt['user_location'];
        $u_tzone        = $uidopt['user_time_zone'];
        $u_bio          = $uidopt['user_bio'];
        $u_susp_til     = $uidopt['user_suspended_until'];
        $u_susp_on      = $uidopt['user_suspended_on'];
        $u_susp_by      = $uidopt['user_suspended_by'];
        $u_bannned      = $uidopt['user_is_banned'];
        $u_ban_on       = $uidopt['user_banned_on'];
        $u_ban_by       = $uidopt['user_banned_by'];
        $u_session      = $uidopt['user_session'];
    }
} else if (isset($_COOKIE['id'])) {
    $uidq       = "SELECT * FROM ".TBLPREFIX."users WHERE user_id='".$_COOKIE['id']."'";
    $uidquery   = mysqli_query($dbconn,$uidq);
    while ($uidopt = mysqli_fetch_assoc($uidquery)) {
        $u_id           = $uidopt['user_id'];
        $u_name         = $uidopt['user_name'];
        $u_dname        = $uidopt['user_display_name'];
        $u_email        = $uidopt['user_email'];
        $u_dob          = $uidopt['user_date_of_birth'];
        $u_level        = $uidopt['user_level'];
        $u_type         = $uidopt['user_actor_type'];
        $u_prvkey       = $uidopt['user_priv_key'];
        $u_pubkey       = $uidopt['user_pub_key'];
        $u_avatar       = $uidopt['user_avatar'];
        $u_locale       = $uidopt['user_locale'];
        $u_location     = $uidopt['user_location'];
        $u_tzone        = $uidopt['user_time_zone'];
        $u_bio          = $uidopt['user_bio'];
        $u_susp_ti      = $uidopt['user_suspended_until'];
        $u_susp_on      = $uidopt['user_suspended_on'];
        $u_susp_by      = $uidopt['user_suspended_by'];
        $u_bannned      = $uidopt['user_is_banned'];
        $u_ban_on       = $uidopt['user_banned_on'];
        $u_ban_by       = $uidopt['user_banned_by'];
        $u_session      = $uidopt['user_session'];
    }
} else if (isset($_COOKIE['uname'])) {
    $uidq       = "SELECT * FROM ".TBLPREFIX."users WHERE user_name='".$_COOKIE['uname']."'";
    $uidquery   = mysqli_query($dbconn,$uidq);
    while ($uidopt = mysqli_fetch_assoc($uidquery)) {
        $u_id           = $uidopt['user_id'];
        $u_name         = $uidopt['user_name'];
        $u_dname        = $uidopt['user_display_name'];
        $u_email        = $uidopt['user_email'];
        $u_dob          = $uidopt['user_date_of_birth'];
        $u_level        = $uidopt['user_level'];
        $u_type         = $uidopt['user_actor_type'];
        $u_prvkey       = $uidopt['user_priv_key'];
        $u_pubkey       = $uidopt['user_pub_key'];
        $u_avatar       = $uidopt['user_avatar'];
        $u_locale       = $uidopt['user_locale'];
        $u_location     = $uidopt['user_location'];
        $u_tzone        = $uidopt['user_time_zone'];
        $u_bio          = $uidopt['user_bio'];
        $u_susp_til     = $uidopt['user_suspended_until'];
        $u_susp_on      = $uidopt['user_suspended_on'];
        $u_susp_by      = $uidopt['user_suspended_by'];
        $u_bannned      = $uidopt['user_is_banned'];
        $u_ban_on       = $uidopt['user_banned_on'];
        $u_ban_by       = $uidopt['user_banned_by'];
        $u_session      = $uidopt['user_session'];
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
