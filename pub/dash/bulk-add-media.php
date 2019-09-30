<?php
/*
 * pub/dash/bulk-add-media.php
 *
 * A page where media can be added to this website's library in bulk.
 *
 * since Federama version 0.3
 */

include_once    "../../conn.php";
include         "../../functions.php";
require         "../includes/database-connect.php";
require_once    "../includes/configuration-data.php";
require_once    "../includes/verify-cookies.php";

$pagetitle = _("Add bulk media « $website_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

            <article class="w3-padding w3-col s12 m8 l10">

                <h2 class="w3-padding"><?php echo _("Add bulk media"); ?></h2>
                <p class="w3-padding">A form where the user points to a folder on the server, and Federama looks at it for any media files.</p>
                <p class="w3-padding">Accepted formats: GIF, JPG, JPEG, PNG, SVG, MP3, OGG, WAV, MP4, WEBM, PDF</p>


            </article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
