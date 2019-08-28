<?php
/*
 * pub/dash/admin/install.php
 *
 * This page gathers some basic information and installs the website.
 *
 * since Federama version 0.1
 *
 */

include "../../../functions.php";


/**
 *
 * Let us verify that the ../../../conn.php file does or does not exist.
 */

if (file_exists("../../../conn.php")) {

	/*
	 * If it exists, we need to include it to verify the constants
	 */
	include_once "../../../conn.php";
	# echo "file exists";
	/**
	 *
	 * Q: What do we do if conn.php already exists?
	 * A: Verify the constants are set.
	 */

	/**
	 * if $global_count === 5 at the end then all global variables are set.
	 * if $global_count < 5 then something is missing.
	 */

	$global_count = 0;

	if (DBHOST != "") {
		#echo DBHOST;
	 	$global_count++;
	}

	if (DBNAME !== "") {
		$global_count++;
	}

	if (DBUSER !== "") {
		$global_count++;
	}

	if (DBPASS !== "") {
		$global_count++;
	}


	/**
	 *
	 * If all of the global variables are set, redirect to config.php to see if the website is configured properly.
	 * If some of the global variables are missing, redirect to repair.php.
	 */
#	if ($global_count === 4) {
		// install the basic database
		// fill the basic database
#		header("Location: config.php");
#	} else {
#		header("Location: repair.php");
#	}

}

if (isset($_POST['startsubmit'])) {

	/**
	 * collect our form data
	 */
	$dbhost	= $_POST['dbhost'];
	$dbname	= $_POST['dbname'];
	$dbuser	= $_POST['dbuser'];
	$dbpass	= $_POST['dbpass'];
	$tblpre	= $_POST['tblprefix'];
	$version = "Federama 0.2";


	if (!isset($message)) {
		/**
		 * now create ../../conn.php
		 */

		$connmeta = fopen("../../conn.php", "x+") or die("Unable to open or create conn.php file");

		$conndata = "<?php\n";
		$conndata .= "/*\n";
		$conndata .= " *\n";
		$conndata .= " * conn.php\n";
		$conndata .= " *\n";
		$conndata .= " * Stores information that allows Federama to connect to the database.\n";
		$conndata .= " *\n";
		$conndata .= " * since Federama version 0.1\n";
		$conndata .= " *\n";
		$conndata .= " */\n\n";
		$conndata .= "define(\"DBHOST\",\"".$dbhost."\");\n";
		$conndata .= "define(\"DBNAME\",\"".$dbname."\");\n";
		$conndata .= "define(\"DBUSER\",\"".$dbuser."\");\n";
		$conndata .= "define(\"DBPASS\",\"".$dbpass."\");\n";
		$conndata .= "define(\"TBLPREFIX\",\"".$tblpre."\");\n";


		// let us try to write to it.
		fwrite($connmeta,$conndata);
		fclose($connmeta);



		/**
		 * now create ../../nodeinfo/version.php
		 */

		$versmeta = fopen("../../nodeinfo/version.php", "x+") or die("Unable to open or create nodeinfo/version.php file");

		$versdata = "<?php\n";
		$versdata .= "/*\n";
		$versdata .= " *\n";
		$versdata .= " * pub/nodeinfo/version.php\n";
		$versdata .= " *\n";
		$versdata .= " * Provides definition of Federama version.\n";
		$versdata .= " *\n";
		$versdata .= " * since Federama version 0.2\n";
		$versdata .= " *\n";
		$versdata .= " */\n\n";
		$versdata .= "define(\"VERSION\",\"".$version."\");\n";


		// let us try to write to it.
		fwrite($versmeta,$versdata);
		fclose($versmeta);




		#include_once "schema.php";
		header("Location: schema.php");
	} // end if !isset $message
}



/**
 * In the future, there will be a language chooser before we get to this point.
 */

$pagetitle = _("Welcome to Federama");
include_once "header.php";

?>
	<!-- THE CONTAINER for the main content -->
	<main class="w3-container w3-content" style="max-width:1400px;margin-top:40px;">
	<!-- THE GRID -->
		<div class="w3-cell-row w3-container">
			<div class="w3-col w3-cell m3 l4">
				<p>
					<?php echo _('Passphrase must be at least 16 characters long.'); ?><br><br>
					<?php echo _('Passphrase must have:')."\n"; ?>
					<ul>
						<li><?php echo _('at least one lowercase letter'); ?></li>
						<li><?php echo _('at least one uppercase letter'); ?></li>
						<li><?php echo _('at least one numeral'); ?></li>
					</ul>
				</p>
			</div>
			<div class="w3-col w3-panel w3-cell m6 l4">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
				<h3><?php echo _("Federama installation"); ?></h3>
				<p><?php echo _("We need some database information before we get started."); ?></p>
				<p>
					<label for"dbhost"><?php echo _("Host"); ?></label>
					<input type="text" name="dbhost" id="dbhost" class="w3-input w3-border w3-margin-bottom" maxlength="255" required value="localhost" title="<?php echo _("The database host. Do not change this unless you know what you are doing."); ?>">
				</p>
				<p>
					<label for"dbname"><?php echo _("Name"); ?></label>
					<input type="text" name="dbname" id="dbname" class="w3-input w3-border w3-margin-bottom" maxlength="30" required value="federama" title="<?php echo _("The name of the database the website will use."); ?>">
				</p>
				<p>
					<label for"dbuser"><?php echo _("Username"); ?></label>
					<input type="text" name="dbuser" id="dbuser" class="w3-input w3-border w3-margin-bottom" maxlength="30" required title="<?php echo _("The username of the database admin."); ?>">
				</p>
				<p>
					<label for"dbpass1"><?php echo _("Passphrase"); ?></label>
					<input type="text" name="dbpass" id="dbpass" class="w3-input w3-border w3-margin-bottom" maxlength="255" required title="<?php echo _("Passphrase must be at least 16 characters long."); ?>">
				</p>
				<p>
					<label for"dbpass2"><?php echo _("Table prefix"); ?></label>
					<input type="text" name="tblprefix" id="tblprefix" class="w3-input w3-border w3-margin-bottom" maxlength="10" value="fed_" title="<?php echo _("An optional prefix for the tables"); ?>">
				</p>
				<p>
					<input type="submit" name="startsubmit" id="startsubmit" class="w3-button w3-button-hover w3-block w3-theme-d3 w3-section w3-padding" value="<?php echo _('START SUBMIT'); ?>">
				</p>
			</form>
			</div>
			<div class="w3-col w3-cell m3 l4">&nbsp;</div> <!-- empty div for the purpose of positioning -->
		</div> <!-- end THE GRID -->
<?php
include_once "footer.php";
?>
