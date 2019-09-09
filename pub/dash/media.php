<?php
/*
 * pub/dash/media.php
 *
 * A page with all media on this instance.
 *
 * since Federama version 0.1
 */

include_once    "../../conn.php";
include         "../../functions.php";
require         "../includes/database-connect.php";
require_once    "../includes/configuration-data.php";
require_once    "../includes/verify-cookies.php";

$pagetitle = _("Media library « $website_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

            <article class="w3-content w3-padding">

                <h2 class="w3-padding"><?php echo _("Media library"); ?></h2>

                <table class="w3-table-all w3-hoverable w3-margin-left">
                    <tr class="w3-theme-dark">
                        <th class="w3-center"><?php echo _('Thumbnail'); ?></th>
                        <th class="w3-center"><?php echo _('ID'); ?></th>
                        <th class="w3-center"><?php echo _('Title'); ?></th>
                        <th class="w3-center"><?php echo _('Uploaded by'); ?></th>
                        <th class="w3-center"><?php echo _('Uploaded on'); ?></th>
                    </tr>


<?php
/**
 * Check the database to see what media we have
 */
$getmedialistq = "SELECT * FROM ".TBLPREFIX."media ORDER BY media_id ASC";
$getmedialistquery = mysqli_query($dbconn,$getmedialistq);
while ($getmedialistopt = mysqli_fetch_assoc($getmedialistquery)) {
    $mediaid    = $getmedialistopt['media_id'];
    $mediauser  = $getmedialistopt['user_name'];
    $mediaurl   = $getmedialistopt['media_url'];
    $mediadate  = $getmedialistopt['media_date'];
    $mediatitle = $getmedialistopt['media_title'];
    $mediaslug  = $getmedialistopt['media_slug'];
    $mediatype  = $getmedialistopt['media_type'];

    echo "\t\t\t\t\t<tr>\n";
    echo "\t\t\t\t\t\t<td>\n";
    echo "\t\t\t\t\t\t\t<a href=\"".$website_url."dash/edit-media.php?mdid=".$mediaid."\"><img src=\"".$mediaurl."\" width=\"50px\" height=\"50px\"></a>\n";
    echo "\t\t\t\t\t\t</td>\n";
    echo "\t\t\t\t\t\t<td>\n";
    echo "\t\t\t\t\t\t\t".$mediaid."\n";
    echo "\t\t\t\t\t\t</td>\n";
    echo "\t\t\t\t\t\t<td>\n";
    echo "\t\t\t\t\t\t\t<a href=\"".$website_url."dash/edit-media.php?mdid=".$mediaid."\">".$mediatitle."</a>\n";
    echo "\t\t\t\t\t\t</td>\n";
    echo "\t\t\t\t\t\t<td>\n";
    echo "\t\t\t\t\t\t\t<a href=\"".$website_url."users/".$mediauser."\">".$mediauser."</a>\n";
    echo "\t\t\t\t\t\t</td>\n";
    echo "\t\t\t\t\t\t<td>\n";
    echo "\t\t\t\t\t\t\t".$mediadate."\n";
    echo "\t\t\t\t\t\t</td>\n";
    echo "\t\t\t\t\t</tr>\n";
}
?>
                </table>
            </article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
