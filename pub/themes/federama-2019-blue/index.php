<?php
/*
 * pub/themes/federama-2019-blue/index.php
 *
 * This is the main page for Federama and serves several purposes.
 * If Federama is not installed, it triggers installation.
 * If Federama is installed, it calls index.php from the active theme.
 * since Federama version 0.1
 *
 */
include			"../../../conn.php";
include			"../../../functions.php";
require			"../../includes/database-connect.php";
require_once	"../../includes/configuration-data.php";
