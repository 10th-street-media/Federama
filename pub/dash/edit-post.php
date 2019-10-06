<?php
/**
 * WAI-ARIA
 * PSR-2
 * pub/dash/edit-post.php
 *
 * Allows users to edit a post.
 *
 * since Federama version 0.2
 */

include_once    "../../conn.php";
include         "../../functions.php";
require         "../includes/database-connect.php";
require_once    "../includes/configuration-data.php";
require_once    "../includes/verify-cookies.php";

if (isset($_GET["pid"])) {
    $sel_id = $_GET["pid"];
} else {
    $sel_id = "";
}

if ($sel_id != '') {

    $getpostq = "SELECT * FROM ".TBLPREFIX	."posts WHERE post_id='".$sel_id."'";
    $getpostquery = mysqli_query($dbconn,$getpostq);
    while ($getpostopt = mysqli_fetch_assoc($getpostquery)) {
        $userid     = $getpostopt['user_id'];
        $pdate      = $getpostopt['post_date'];
        $ptitle     = $getpostopt['post_title'];
        $pslug      = $getpostopt['post_slug'];
        $ptext      = $getpostopt['post_text'];
        $pstatus    = $getpostopt['post_status'];
        $ptype      = $getpostopt['post_type'];
        $pmdate     = $getpostopt['post_modified_date'];
        $ptags      = $getpostopt['post_tags'];
        $pcats      = $getpostopt['post_categories'];
        $pping      = $getpostopt['ping_status'];
        $pcomment   = $getpostopt['comment_status'];
    }
}


/**
 * Form processing
 */
if (isset($_POST['post-submit'])) {
    $id     = $_POST['post-id'];
    $title  = nicetext($_POST['post-title']);
    $slug   = makeslug($_POST['post-title']);
    $text   = nicetext($_POST['post-text']);
    $now    = date("Y-m-d H:i:s");

    $updpostq   = "UPDATE ".TBLPREFIX."posts SET post_title='".$title."', post_slug='".$slug."', post_text='".$text."', post_modified_date='".$now."' WHERE post_id='".$id."'";
    $updpostquery = mysqli_query($dbconn,$updpostq);
    redirect($website_url."dash/posts.php");
}


$pagetitle = _("Edit post « $website_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

            <article class="w3-padding w3-col s12 m8 l10">

                <h2 class="w3-padding"><?php echo _("Edit post"); ?></h2>
                <form method="post" action="edit-post.php">
                    <input type="hidden" name="post-id" id="post-id" value="<?php echo $sel_id; ?>">
                    <input type="text" name="post-title" id="post-title" role="textbox" aria-multiline="false" class="w3-input w3-padding w3-margin-left" value="<?php echo $ptitle; ?>" tabindex="1"><br>
                    <textarea name="post-text" id="summernote" role="textbox" aria-multiline="true" class="w3-input w3-padding w3-margin-left" rows="12" tabindex="2"><?php echo $ptext; ?></textarea><br>
                    <input type="text" name="post-categories" id="post-categories" role="textbox" aria-multiline="false" class="w3-input w3-padding w3-margin-left" placeholder="<?php echo _('Categories'); ?>" title="<?php echo _('Please separate categories with commas'); ?>" value="<?php echo $pcats; ?>" tabindex="3"><br>
                    <input type="text" name="post-tags" id="post-tags" role="textbox" aria-multiline="false" class="w3-input w3-padding w3-margin-left" placeholder="<?php echo _('Tags'); ?>" title="<?php echo _('Please separate tags with commas'); ?>" value="<?php echo $ptags; ?>" tabindex="4"><br>
                    <input type="submit" name="post-submit" id="post-submit" class="w3-theme-dark w3-button w3-margin-left" value="<?php echo _('UPDATE POST'); ?>" tabindex="5">
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
