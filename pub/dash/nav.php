<?php
/*
 * pub/dash/nav.php
 *
 * The main menu for users logged into a Federama website.
 *
 * since Federama version 0.1
 */

?>
	<!-- THE CONTAINER for the main content -->
	<main class="w3-row w3-content" style="max-width:1400px;margin-top:40px;">

		<!-- THE GRID -->
		<div class="w3-cell-row">

			<nav class="w3-sidebar w3-bar-block w3-theme-d2">
				<a href="<?php echo $website_url."dash/index.php"; ?>" class="w3-bar-item w3-button" title="<?php echo _("Your homepage"); ?>"><i class="fa fa-lg fa-home"></i>&nbsp;<?php echo _("Home"); ?></a>
				<a href="<?php echo $website_url."dash/posts.php"; ?>" class="w3-bar-item w3-button" title="<?php echo _("Posts on this instance."); ?>"><i class="fa fa-lg fa-pencil"></i>&nbsp;<?php echo _("Posts"); ?></a>
				<a href="<?php echo $website_url."dash/pages.php"; ?>" class="w3-bar-item w3-button" title="<?php echo _("Pages are posts that exist outside the timeline."); ?>"><i class="fa fa-lg fa-file-text"></i>&nbsp;<?php echo _("Pages"); ?></a>
				<a href="<?php echo $website_url."dash/messages.php"; ?>" class="w3-bar-item w3-button" title="<?php echo _("Your inbox and outbox."); ?>"><i class="fa fa-lg fa-commenting"></i>&nbsp;<?php echo _("Messages"); ?></a>
				<a href="<?php echo $website_url."dash/contacts.php"; ?>" class="w3-bar-item w3-button" title="<?php echo _("Your contact lists."); ?>"><i class="fa fa-lg fa-address-book"></i>&nbsp;<?php echo _("Contacts"); ?></a>
				<a href="<?php echo $website_url."dash/bookmarks.php"; ?>" class="w3-bar-item w3-button" title="<?php echo _("Items you've liked or disliked."); ?>"><i class="fa fa-lg fa-bookmark"></i>&nbsp;<?php echo _("Noteworthy"); ?></a>
				<a href="<?php echo $website_url."dash/media.php"; ?>" class="w3-bar-item w3-button" title="<?php echo _("Images, audio, and video on this instance."); ?>"><i class="fa fa-lg fa-file-image-o"></i>&nbsp;<?php echo _("Media"); ?></a>
				<a href="#" class="w3-bar-item w3-button" title="<?php echo _("Your profile."); ?>" onclick="myProfile()"><i class="fa fa-lg fa-user" ></i>&nbsp;<?php echo _("Profile"); ?>&nbsp;<i class="fa fa-caret-down w3-right"></i></a>
					<div id="profileMenu" class="w3-hide w3-white w3-card">
						<a href="<?php echo $website_url."dash/profile.php"; ?>" class="w3-bar-item w3-button"><?php echo _('View profile'); ?></a>
						<a href="<?php echo $website_url."dash/edit-profile.php"; ?>" class="w3-bar-item w3-button"><?php echo _('Edit profile'); ?></a>
						<a href="<?php echo $website_url."dash/import-profile.php"; ?>" class="w3-bar-item w3-button"><?php echo _('Import profile'); ?></a>
						<a href="<?php echo $website_url."dash/export-profile.php"; ?>" class="w3-bar-item w3-button"><?php echo _('Export profile'); ?></a>
						<a href="<?php echo $website_url."dash/delete-profile.php"; ?>" class="w3-bar-item w3-button"><?php echo _('Delete profile'); ?></a>
					</div>
<?php
$adminq = "SELECT * FROM ".TBLPREFIX."users WHERE user_id=".$_COOKIE['id'];
$adminquery = mysqli_query($dbconn,$adminq);
while($adminopt = mysqli_fetch_assoc($adminquery)) {
		$level	= $adminopt['user_level'];

		if ($level == 'ADMINISTRATOR') {
			echo "\t\t\t\t<a href=\"#\" class=\"w3-bar-item w3-button\" title=\""._('User list')."\" onclick=\"myUsersMenu()\"><i class=\"fa fa-lg fa-users\"></i>&nbsp;"._('Users')."&nbsp;<i class=\"fa fa-caret-down w3-right\"></i></a>\n";
			echo "\t\t\t\t\t<div id=\"usersMenu\" class=\"w3-hide w3-white w3-card\">\n";
			echo "\t\t\t\t\t\t<a href=\"".$website_url."dash/admin/users.php\" class=\"w3-bar-item w3-button\">"._('All users')."</a>\n";
			echo "\t\t\t\t\t\t<a href=\"".$website_url."dash/admin/add-user.php\" class=\"w3-bar-item w3-button\">"._('Add user')."</a>\n";
			echo "\t\t\t\t\t</div>\n";
			echo "\t\t\t\t<a href=\"#\" class=\"w3-bar-item w3-button\" title=\""._('Administrator dashboard')."\" onclick=\"myAdminMenu()\"><i class=\"fa fa-lg fa-wrench\"></i>&nbsp;"._('Administrators')."&nbsp;<i class=\"fa fa-caret-down w3-right\"></i></a>\n";
			echo "\t\t\t\t\t<div id=\"adminMenu\" class=\"w3-hide w3-white w3-card\">\n";
			echo "\t\t\t\t\t\t<a href=\"".$website_url."dash/admin/configuration.php\" class=\"w3-bar-item w3-button\">"._('Website configuration')."</a>\n";
			echo "\t\t\t\t\t\t<a href=\"#\" class=\"w3-bar-item w3-button\">"._('Some text')."</a>\n";
			echo "\t\t\t\t\t</div>\n";
		}

		if ($level == 'MODERATOR' || 'ADMINISTRATOR') {
			echo "\t\t\t\t<a href=\"#\" class=\"w3-bar-item w3-button\" title=\""._('Moderator dashboard')."\" onclick=\"myModMenu()\"><i class=\"fa fa-lg fa-check-square\"></i>&nbsp;"._('Moderators')."&nbsp;<i class=\"fa fa-caret-down w3-right\"></i></a>\n";
			echo "\t\t\t\t\t<div id=\"modMenu\" class=\"w3-hide w3-white w3-card\">\n";
			echo "\t\t\t\t\t\t<a href=\"".$website_url."dash/admin/moderation-queue.php\" class=\"w3-bar-item w3-button\">"._('Moderation queue')."</a>\n";
			echo "\t\t\t\t\t</div>\n";
		}

		if ($level == 'TRANSLATOR' || 'ADMINISTRATOR') {
			echo "\t\t\t\t<a href=\"#\" class=\"w3-bar-item w3-button\" title=\""._('Translator dashboard')."\" onclick=\"myL10nMenu()\"><i class=\"fa fa-lg fa-globe\"></i>&nbsp;"._('Translators')."&nbsp;<i class=\"fa fa-caret-down w3-right\"></i></a>\n";
			echo "\t\t\t\t\t<div id=\"l10nMenu\" class=\"w3-hide w3-white w3-card\">\n";
			echo "\t\t\t\t\t\t<a href=\"".$website_url."dash/admin/locales.php\" class=\"w3-bar-item w3-button\">"._('Locales')."</a>\n";
			echo "\t\t\t\t\t</div>\n";
		}
}
?>
			</nav>
			<script>
			function myProfile() {
			  var x = document.getElementById("profileMenu");
			  if (x.className.indexOf("w3-show") == -1) {
			    x.className += " w3-show";
			    x.previousElementSibling.className += " w3-theme-d1";
			  } else {
			    x.className = x.className.replace(" w3-show", "");
			    x.previousElementSibling.className =
			    x.previousElementSibling.className.replace(" w3-theme-d1", "");
			  }
			}

			function myUsersMenu() {
			  var x = document.getElementById("usersMenu");
			  if (x.className.indexOf("w3-show") == -1) {
			    x.className += " w3-show";
			    x.previousElementSibling.className += " w3-theme-d1";
			  } else {
			    x.className = x.className.replace(" w3-show", "");
			    x.previousElementSibling.className =
			    x.previousElementSibling.className.replace(" w3-theme-d1", "");
			  }
			}

			function myAdminMenu() {
			  var x = document.getElementById("adminMenu");
			  if (x.className.indexOf("w3-show") == -1) {
			    x.className += " w3-show";
			    x.previousElementSibling.className += " w3-theme-d1";
			  } else {
			    x.className = x.className.replace(" w3-show", "");
			    x.previousElementSibling.className =
			    x.previousElementSibling.className.replace(" w3-theme-d1", "");
			  }
			}

			function myModMenu() {
			  var x = document.getElementById("modMenu");
			  if (x.className.indexOf("w3-show") == -1) {
			    x.className += " w3-show";
			    x.previousElementSibling.className += " w3-theme-d1";
			  } else {
			    x.className = x.className.replace(" w3-show", "");
			    x.previousElementSibling.className =
			    x.previousElementSibling.className.replace(" w3-theme-d1", "");
			  }
			}

			function myL10nMenu() {
			  var x = document.getElementById("l10nMenu");
			  if (x.className.indexOf("w3-show") == -1) {
			    x.className += " w3-show";
			    x.previousElementSibling.className += " w3-theme-d1";
			  } else {
			    x.className = x.className.replace(" w3-show", "");
			    x.previousElementSibling.className =
			    x.previousElementSibling.className.replace(" w3-theme-d1", "");
			  }
			}
			</script>
