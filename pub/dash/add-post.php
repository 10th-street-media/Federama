<?php
/* WAI-ARIA
 * PSR-2
 * pub/dash/add-post.php
 *
 * Allows users to create a post.
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
if (isset($_POST['post-submit'])) {

    $title  = nicetext($_POST['post-title']);
    $slug   = makeslug($_POST['post-title']);
    $cats   = nicetext($_POST['post-categories']);
    $tags   = nicetext($_POST['post-tags']);
    $text   = nicetext($_POST['post-text']);
    $now    = date("Y-m-d H:i:s");

    $postq  = "INSERT INTO ".TBLPREFIX."posts (post_id, user_id, post_date, post_title, post_slug, post_text, post_status, post_type, post_modified_date, post_tags, post_categories, comments_open, pings_open) VALUES ('', '".$_COOKIE['id']."', '".$now."', '".$title."', '".$slug."', '".$text."', 'PUBLIC', 'POST', '".$now."', '".$tags."', '".$cats."', '1', '1')";
    $postquery = mysqli_query($dbconn,$postq);
    redirect($website_url."dash/posts.php");
}


$pagetitle = _("Add new post « $website_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

            <article class="w3-padding w3-col s12 m8 l10">

                <h2 class="w3-padding"><?php echo _("Add new post"); ?></h2>
                <form method="post" action="add-post.php">
                    <input type="text" name="post-title" id="post-title" role="textbox" aria-multiline="false" class="w3-input w3-padding w3-margin-left" placeholder="<?php echo _('Add title'); ?>" tabindex="1"><br>
                    <textarea name="post-text" id="summernote" role="textbox" aria-multiline="true" class="w3-input w3-padding w3-margin-left" rows="12"  tabindex="2"></textarea><br>
                    <input type="text" name="post-categories" id="post-categories" role="textbox" aria-multiline="false" class="w3-input w3-padding w3-margin-left" placeholder="<?php echo _('Categories'); ?>" title="<?php echo _('Please separate categories with commas'); ?>"  tabindex="3"><br>
                    <input type="text" name="post-tags" id="post-tags" role="textbox" aria-multiline="false" class="w3-input w3-padding w3-margin-left" placeholder="<?php echo _('Tags'); ?>" title="<?php echo _('Please separate tags with commas'); ?>"  tabindex="4"><br>
                    <input type="submit" name="post-submit" id="post-submit" role="button" class="w3-theme-dark w3-button w3-margin-left" value="<?php echo _('PUBLISH POST'); ?>"  tabindex="5">
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
