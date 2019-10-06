<?php
/*
 * pub/dash/add-page.php
 *
 * Allows users to create a page.
 *
 * since Federama version 0.1
 */

include_once    "../../conn.php";
include         "../../functions.php";
require         "../includes/database-connect.php";
require_once    "../includes/configuration-data.php";
require_once    "../includes/verify-cookies.php";

/**
 * Form processing
 */
if (isset($_POST['page-submit'])) {

    $title  = nicetext($_POST['page-title']);
    $slug   = makeslug($_POST['page-title']);
    $text   = nicetext($_POST['page-text']);
    $now    = date("Y-m-d H:i:s");

    $postq  = "INSERT INTO ".TBLPREFIX."posts (post_id, user_id, post_date, post_title, post_slug, post_text, post_status, post_type, post_modified_date, post_tags, post_categories, comments_open, pings_open) VALUES ('', '".$_COOKIE['id']."', '".$now."', '".$title."', '".$slug."', '".$text."', 'PUBLIC', 'PAGE', '".$now."', '', '', '1', '1')";
    $postquery = mysqli_query($dbconn,$postq);
    redirect($website_url."dash/pages.php");
}


$pagetitle = _("Add new page « $website_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

            <article class="w3-padding w3-col s12 m8 l10">

                <h2 class="w3-padding"><?php echo _("Add new page"); ?></h2>
                <form method="post" action="add-page.php">
                    <input type="text" name="page-title" id="page-title" class="w3-input w3-padding w3-margin-left" placeholder="<?php echo _('Add title'); ?>"><br>
                    <textarea name="page-text" id="summernote" class="w3-input w3-padding w3-margin-left" rows="12"></textarea><br>
                    <input type="submit" name="page-submit" id="page-submit" class="w3-theme-dark w3-button w3-margin-left" value="<?php echo _('PUBLISH PAGE'); ?>">
                </form>
            </article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<script>
$(document).ready(function() {
    $('#summernote').summernote({
        toolbar: [
            ['style', ['style']],
            ['font', ['bold','italic','underline','strikethrough','clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul','ol','paragraph']],
            ['table', ['table']],
            ['insert', ['hr','link','picture','video']],
            ['view', ['fullscreen','codeview','help']]
        ],
        height: 240
    });
});
</script>

<?php
include "footer.php";
?>
