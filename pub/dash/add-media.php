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

/**
 * Start processing the form
 */
if (isset($_POST['media-submit'])) {

    /**
     * Figure out our upload directory
     * Files are uploaded to website.tld/images/uploads/YYYY/MM/DD (a/k/a $day_dir)
     *
     * If the directory website.tld/images/uploads/YYYY does not exist, make it
     * Else if the directory website.tld/images/uploads/YYYY/MM does not exist, make that
     * Else if the directory website.tld/images/uploads/YYYY/MM/DD does not exist, make that.
     */
     $year_dir      = $_SERVER['DOCUMENT_ROOT']."/images/uploads/".date("Y")."/";
     $month_dir     = $_SERVER['DOCUMENT_ROOT']."/images/uploads/".date("Y")."/".date("m")."/";
     $day_dir       = $_SERVER['DOCUMENT_ROOT']."/images/uploads/".date("Y")."/".date("m")."/".date("d")."/";


/*     if (!file_exists($year_dir)) {

        if (!mkdir($year_dir, 0777, true)) {


            #echo "<br>\n<pre>\n";
            #$error = error_get_last();
            #print_r($error);
            #Secho "</pre>";
            $dieyeardir = _("Failed to create folder ").$year_dir;
            die($dieyeardir);

        } else {

            chmod($year_dir, 0777);

        }
*/

/*     } else if (!file_exists($month_dir)) {

        if (!mkdir($month_dir, 0777, true)) {

            $diemonthdir = _("Failed to create folder ").$month_dir;
            die($diemonthdir);

        } else {

            chmod($month_dir, 0777);

        }
*/
 /*    } else if (!file_exists($day_dir)) { */
        if (!file_exists($day_dir)) {

        if (!mkdir($day_dir, 0777, true)) {

            $diedaydir = _("Failed to create folder ").$day_dir;
            die($diedaydir);

        } else {

            chmod($day_dir, 0777);

        }

     }


    $filename   = $day_dir.basename($_FILES['media-upload']['name']);
    $filetype   = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
    $fileurl    = $website_url."/images/uploads/".date("Y")."/".date("m")."/".date("d")."/".basename($_FILES['media-upload']['name']);
    $now        = date("Y-m-d H:i:s");


    /**
     * Check the file type
     * Federama will accept the following:
     * Images: jpg, jpeg, gif, png
     * Audio: wav, mp3, ogg
     * Video: webm, mp4
     * Documents: pdf, epub, cbr, cbz
     * Packages: zip, gzip, gz
     *
     * If the file is one of those types, we continue. If not, the process dies
     */
    if ($filetype == "jpeg" || $filetype == "jpg" || $filetype == "gif" || $filetype == "png" || $filetype == "wav" || $filetype == "mp3" || $filetype == "ogg" || $filetype == "webm" || $filetype == "mp4" || $filetype == "pdf" || $filetype == "epub" || $filetype == "cbr" || $filetype == "cbz" || $filetype == "zip" || $filetype == "gz" || $filetype == "gzip") {


        /**
         * Does this filename already exist in the directory?
         */
        if (!file_exists($filename)) {


            /**
             * Is the file too big?
             */
           # if ($_FILES['media-upload']['size'] < ini_get('upload_max_filesize')) {


                /**
                 * If we made it this far, we should be good to go
                 */
                if (move_uploaded_file($_FILES['media-upload']['tmp_name'], $filename)) {


                    /**
                     * Yes, the file was uploaded
                     */
                    #$uploadedyes = _("The file has been uploaded.");
                    #echo $uploadedyes;

                    $uploadq = "INSERT INTO ".TBLPREFIX."media (media_id, user_name, media_date, media_url, media_title) VALUES ('', '".$_COOKIE['uname']."', '".$now."', '".$fileurl."', '".$_FILES['media-upload']['name']."')";
                    echo $uploadq;
                    $uploadquery = mysqli_query($dbconn,$uploadq);
                    redirect($website_url."dash/media.php");

                } else {


                    /**
                     * No, the files hasn't been uploaded for some reason
                     */
                    $uploadedno = _("The file was not uploaded for some reason.");
                    die($uploadedno);

                }
           # } else {

             #   $filetoobig = _("The file is too big");
            #   die($filetoobig);

          # }

        } else {

            $fileexists = _("A file with that name already exists in the directory.");
            die($fileexists);

        }

    } else {

        $wrongtype = _("File is wrong type");
        die($wrongtype);

    }/* end if $filetype == ... */
}


$pagetitle = _("Add media « $website_name « Ꞙederama");
include "header.php";
include "nav.php";
?>

            <article class="w3-padding w3-col s12 m8 l10">

                <h2 class="w3-padding"><?php echo _("Add media"); ?></h2>

                <div class="w3-blue w3-leftbar w3-margin-left w3-padding">
<?php
    echo "\t\t\t\t\t"._("<b>Note:</b> The maximum upload size for this server is ").ini_get('upload_max_filesize')."\n";
?>
                </div>
                <br>
                <div class="w3-blue w3-leftbar w3-margin-left w3-padding">
<?php
    echo "\t\t\t\t\t"._("<b>Note:</b> Federama will work accept the following file types:")." JPG, JPEG, GIF, PNG, WAV, MP3, OGG, WEBM, MP4, PDF, EPUB, CBR, CBZ, ZIP, GZIP, and GZ.\n";
?>
                </div>

                <form method="post" action="add-media.php" enctype="multipart/form-data">
                    <table class="w3-table w3-margin-left">
                        <tr>
                            <td><?php echo _('Select file to upload:'); ?></td>
                            <td><input type="file" name="media-upload" id="media-upload"></td>
                        </tr>
                        <tr><td colspan="2"><input type="submit" class="w3-button w3-button-hover w3-theme-d3 w3-margin-left" value="<?php echo _('Upload file'); ?>" name="media-submit"></td></tr>
                    </table>
                </form>

            </article> <!-- end article (It's not really an article, but it serves the same purpose.) -->

<?php
include "footer.php";
?>
