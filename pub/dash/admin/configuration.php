<?php
/*
 * pub/dash/admin/configuration.php
 *
 * A page where an administrator can configure the website.
 *
 * since Federama version 0.2
 */

include_once	"../../../conn.php";
include			"../../../functions.php";
require			"../../includes/database-connect.php";
require_once	"../../includes/configuration-data.php";
require_once	"../../includes/verify-cookies.php";

/**  **************************************************************************
 *
 *   FORM PROCESSING
 *
 **  *************************************************************************/
if(isset($_POST['configsubmit'])) {

	/* Set our variables */
	$site_name				= nicetext($_POST['site-name']);
	$site_desc				= nicetext($_POST['site-desc']);
	$site_url				= $_POST['site-url'];
	$site_locale			= $_POST['site-locale'];
	$site_admin				= nicetext($_POST['site-admin']);
	$site_admin_email		= nicetext($_POST['site-admin-email']);

	if (isset($_POST['site-reg'])) {
		$site_reg	= 1;
	} else {
		$site_reg	= 0;
	}

	if (isset($_POST['site-fed-info'])) {
		$site_fed_info	= 1;
	} else {
		$site_fed_info	= 0;
	}

	if (isset($_POST['site-fed-net'])) {
		$site_fed_net	= 1;
	} else {
		$site_fed_net	= 0;
	}

	if (isset($_POST['site-fed-soc'])) {
		$site_fed_soc	= 1;
	} else {
		$site_fed_soc	= 0;
	}

	/* State the query and run it */
	$confq = "UPDATE ".TBLPREFIX."configuration SET website_name='".$site_name."', website_url='".$site_url."', website_description='".$site_desc."', default_locale='".$site_locale."', open_registrations='".$site_reg."', admin_account='".$site_admin."', admin_email='".$site_admin_email."', list_with_the_federation_info='".$site_fed_info."', list_with_fediverse_network='".$site_fed_net."', list_with_federama_social='".$site_fed_soc."'";
	$confquery = mysqli_query($dbconn,$confq);

	/* reload the page by redirecting to itself */
	redirect($website_url."dash/admin/configuration.php");

} /* end if isset $_POST['configsubmit'] */
/**  END FORM PROCESSING  ****************************************************/

$pagetitle = _("Website configuration « $website_name « Ꞙederama");
include "header.php";
include "../nav.php";
?>

			<article class="w3-padding w3-col s12 m8 l10">

				<h2 class="w3-padding"><?php echo _("Website configuration"); ?></h2>

				<form method="POST" action="<?php echo htmlspecialchars($website_url."dash/admin/configuration.php"); ?>">
					<table class="w3-table w3-margin-left">
						<tr>
							<td><?php echo _("Site name"); ?></td>
							<td><input type="text" name="site-name" id="site-name" class="w3-input w3-border w3-margin-bottom" required maxlength="50" value="<?php echo $website_name; ?>" title="<?php echo _('The name of the website'); ?>"></td>
						</tr>
						<tr>
							<td><?php echo _("Description"); ?></td>
							<td><input type="text" name="site-desc" id="site-desc" class="w3-input w3-border w3-margin-bottom" maxlength="255" value="<?php echo $website_description; ?>" title="<?php echo _('A description of the website'); ?>"></td>
						</tr>
						<tr>
							<td><?php echo _("Site URL"); ?></td>
							<td><input type="text" name="site-url" id="site-url" class="w3-input w3-border w3-margin-bottom" required maxlength="255" value="<?php echo $website_url; ?>" title="<?php echo _('The URL of the website'); ?>"></td>
						</tr>
						<tr>
							<td><?php echo _("Default locale"); ?></td>
							<td>
								<select name="site-locale" id="site-locale" class="w3-input w3-border w3-margin-bottom" title="<?php echo _('The default locale of the website'); ?>">
<?php
	if ($default_locale !== "") {
		echo "\t\t\t\t\t\t\t\t\t<option value=\"".$default_locale."\" selected>".$default_locale."</option>\n";
	} else {
		$localeq = "SELECT * FROM ".TBLPREFIX."locales ORDER BY locale_language ASC";
		$localequery = mysqli_query($dbconn,$localeq);
		while ($localeopt = mysqli_fetch_assoc($localequery)) {
			$language	= $localeopt['locale_language'];
			$country		= $localeopt['locale_country'];

			echo "\t\t\t\t\t\t\t\t\t<option value=\"".$language."-".$country."\">".$language."-".$country."</option>\n";
		}
	}
?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo _("Open registrations"); ?></td>
<?php
	if ($open_registration == 1) {
		echo "\t\t\t\t\t\t\t<td><input type=\"checkbox\" name=\"site-reg\" id=\"site-reg\" class=\"w3-check\" value=\"1\" title=\""._('Can anyone register an account on this website?')."\" checked>&nbsp;"._('The default is <b>no</b>.')."</td>\n";
	} else {
		echo "\t\t\t\t\t\t\t<td><input type=\"checkbox\" name=\"site-reg\" id=\"site-reg\" class=\"w3-check\" value=\"1\" title=\""._('Can anyone register an account on this website?')."\">&nbsp;"._('The default is <b>no</b>.')."</td>\n";
	}
?>
						</tr>
						<tr>
							<td><?php echo _("Admin account"); ?></td>
							<td><input type="text" name="site-admin" id="site-admin" class="w3-input w3-border w3-margin-bottom" required maxlength="20" value="<?php echo $admin_account; ?>" title="<?php echo _('The username of the primary administrator of this website.'); ?>"></td>
						</tr>
						<tr>
							<td><?php echo _("Admin email"); ?></td>
							<td><input type="text" name="site-admin-email" id="site-admin-email" class="w3-input w3-border w3-margin-bottom" required maxlength="255" value="<?php echo $admin_email; ?>" title="<?php echo _('The email address of this website\'s primary administrator.'); ?>"></td>
						</tr>
						<tr>
							<td><?php echo _("List with <a href=\"https://the-federation.info\">the-federation.info</a>?"); ?></td>
<?php
	if ($list_with_the_federation_info == 1) {
		echo "\t\t\t\t\t\t\t<td><input type=\"checkbox\" name=\"site-fed-info\" id=\"site-fed-info\" class=\"w3-check\" value=\"1\" title=\""._('Should the site be listed with the-federation.info?')."\" checked>&nbsp;"._('The default is <b>yes</b>.')."</td>\n";
	} else {
		echo "\t\t\t\t\t\t\t<td><input type=\"checkbox\" name=\"site-fed-info\" id=\"site-fed-info\" class=\"w3-check\" value=\"1\" title=\""._('Should the site be listed with the-federation.info?')."\">&nbsp;"._('The default is <b>yes</b>.')."</td>\n";
	}
?>
						</tr>
						<tr>
							<td><?php echo _("List with <a href=\"https://fediverse.network\">fediverse.network</a>?"); ?></td>
<?php
	if ($list_with_fediverse_network == 1) {
		echo "\t\t\t\t\t\t\t<td><input type=\"checkbox\" name=\"site-fed-net\" id=\"site-fed-net\" class=\"w3-check\" value=\"1\" title=\""._('Should the site be listed with fediverse.network?')."\" checked>&nbsp;"._('The default is <b>yes</b>.')."</td>\n";
	} else {
		echo "\t\t\t\t\t\t\t<td><input type=\"checkbox\" name=\"site-fed-net\" id=\"site-fed-net\" class=\"w3-check\" value=\"1\" title=\""._('Should the site be listed with fediverse.network?')."\">&nbsp;"._('The default is <b>yes</b>.')."</td>\n";
	}
?>
						</tr>
						<tr>
							<td><?php echo _("List with <a href=\"https://federama.social\">federama.social</a>?"); ?></td>
<?php
	if ($list_with_federama_social == 1) {
		echo "\t\t\t\t\t\t\t<td><input type=\"checkbox\" name=\"site-fed-soc\" id=\"site-fed-soc\" class=\"w3-check\" value=\"1\" title=\""._('Should the site be listed with federama.social?')."\" checked>&nbsp;"._('The default is <b>yes</b>.')."</td>\n";
	} else {
		echo "\t\t\t\t\t\t\t<td><input type=\"checkbox\" name=\"site-fed-soc\" id=\"site-fed-soc\" class=\"w3-check\" value=\"1\" title=\""._('Should the site be listed with federama.social?')."\">&nbsp;"._('The default is <b>yes</b>.')."</td>\n";
	}
?>
						</tr>
					</table>
					<input type="submit" name="configsubmit" id="configsubmit" class="w3-button w3-button-hover w3-theme-d3 w3-margin-left" value="<?php echo _('Save configuration'); ?>">
				</form>

			</article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
