<?php
/*
 * pub/includes/fed-footer.php
 *
 * This footer ends the HTML for each public facing webpage in Federama.
 *
 * since Federama version 0.1
 *
 */
?>
		</div> <!-- end The Grid -->
	</main> <!-- end The Container -->
	<footer class="w3-container w3-large w3-theme-d1">
		<span class="w3-left w3-padding"><a href="<?php echo $website_url; ?>atom.xml">Atom</a> | <a href="<?php echo $website_url; ?>rss2.xml">RSS</a> | <a href="<?php echo $website_url; ?>the-statistics.php"><?php echo _("Site Statistics"); ?></a> | <?php echo _("Powered by "); ?><a href="https://github.com/10sm/Federama"><?php echo VERSION; ?></a></span>
		<span class="w3-right w3-padding"><?php

	if($open_registration == 1) {
		echo "<a href=\"".$website_url."the-registration.php\">"._('Registration')."</a> | ";
	}

?><a href="<?php echo $website_url; ?>the-login.php"><?php echo _("Login"); ?></a></span>
	</footer>
</body>
</html>
