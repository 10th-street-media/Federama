<?php
/*
 * pub/dash/add-media.php
 *
 * A page where media can be added to this website's library.
 *
 * since Federama version 0.3
 */

include_once    "../../conn.php";
include         "../../functions.php";
require         "../includes/database-connect.php";
require_once    "../includes/configuration-data.php";
require_once    "../includes/verify-cookies.php";

$pagetitle = _("Add media « $website_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

            <article class="w3-content w3-padding">

                <h2 class="w3-padding"><?php echo _("Add media"); ?></h2>
                <p class="w3-padding">A form where media can be added to this website's media library.</p>
                <p class="w3-padding">Accepted formats: GIF, JPG, JPEG, PNG, SVG, MP3, OGG, WAV, MP4, WEBM, PDF</p>


            </article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
