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
				<a href="<?php echo $website_url."dash/profile.php"; ?>" class="w3-bar-item w3-button" title="<?php echo _("Your profile."); ?>"><i class="fa fa-lg fa-user" ></i>&nbsp;<?php echo _("Profile"); ?></a>
				<a href="<?php echo $website_url."dash/admin/index.php"; ?>" class="w3-bar-item w3-button" title="<?php echo _("Administrator dashboard"); ?>"><i class="fa fa-lg fa-wrench"></i>&nbsp;<?php echo _("Admin"); ?></a>
			</nav>
