<?php
/*
 * pub/includes/database-connect.php
 *
 * This page is a template to connect to the database and set the charset.
 *
 * since Federama version 0.1
 *
 */

$dbconn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
mysqli_set_charset($dbconn, "utf8mb4");
?>
