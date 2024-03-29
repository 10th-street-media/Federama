<?php
/* PSR-2
 * pub/feeds.php
 *
 * Starts/creates files for Atom and RSS.
 *
 * since Federama version 0.1
 *
 */
?>
<?php
#include        "../functions.php";
#require        "includes/database-connect.php";
#require_once   "includes/configuration-data.php";

// define current date and time
$nowa = date('c',strtotime("now")); // for Atom
$nowb = date('r',strtotime("now")); // for RSS2 lastBuildDate
$nowp = date('r',strtotime("today")); // for RSS2 pubDate


/*
 *
 * ATOM FEED
 */
    $atommeta = fopen("atom.xml", "w") or die("Unable to open or create atom.xml file");
    $atomstart = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<feed xmlns=\"http://www.w3.org/2005/Atom\">\n\n\t<title>".$website_name."</title>\n\t<link rel=\"self\" href=\"".$website_url."atom.xml\"/>\n\t<icon>".$theme_path."/favicon.ico</icon>\n\t<updated>".$nowa."</updated>\n\t<id>".$website_url."</id>\n\n";
    fwrite($atommeta,$atomstart);

    // if we have posts, display the most recent 25.
    if (post_quantity($posts) > 0) {
        $pst_q = "SELECT * FROM ".TBLPREFIX."posts WHERE post_type=\"POST\" AND post_status=\"PUBLIC\" ORDER BY post_date DESC LIMIT 25";
        $pst_query = mysqli_query($dbconn,$pst_q);
        while ($pst_opt = mysqli_fetch_assoc($pst_query)) {
            $postid     = $pst_opt['post_id'];
            $postby     = $pst_opt['user_id'];
            $postslug   = $pst_opt['post_slug'];
            $posttitle  = $pst_opt['post_title'];
            $postdate   = date('c',strtotime($pst_opt['post_date']));
            $posttext   = nicetext($pst_opt['post_text']);

            $by_q = "SELECT * FROM ".TBLPREFIX."users WHERE user_id=\"".$postby."\"";
            $by_query = mysqli_query($dbconn,$by_q);
            while($by_opt = mysqli_fetch_assoc($by_query)) {
                $byname = $by_opt['user_name'];
			}
            $atompost = "\n\t<entry>\n\t\t<title type=\"html\">".$posttitle."</title>\n\t\t<link href=\"".$website_url."posts/".$postslug."\" />\n\t\t<id>".$website_url."posts/".$postslug."</id>\n\t\t<updated>".$postdate."</updated>\n\t\t<author>\n\t\t\t<name>".$byname."</name>\n\t\t</author>\n\t\t<content type=\"html\">".$posttext."</content>\n\t</entry>";
            fwrite($atommeta,$atompost);

        } // end while $pst_opt...
    } // end if post_quantity($posts)...


    $atomend = "</feed>";
    fwrite($atommeta,$atomend);
    fclose($atommeta);


/*
 *
 * RSS 2.0 FEED
 */

    $rss2meta = fopen("rss2.xml", "w") or die("Unable to open or create rss2.xml file");
    $rss2start = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<rss version=\"2.0\">\n<channel>\n\t<title>".$website_name."</title>\n\t<description>"._('The primary RSS feed of')." ".$website_name."</description>\n\t<link>".$website_url."</link><pubDate>".$nowp."</pubDate>\n\t<lastBuildDate>".$nowb."</lastBuildDate>\n\n\t<image>\n\t\t<url>".$theme_path."/apple-touch-icon.png</url>\n\t\t<title>".$website_name."</title>\n\t\t<link>".$website_url."</link>\n\t</image>";
    fwrite ($rss2meta,$rss2start);

    // if we have posts, display the most recent 25.
    if (post_quantity($posts) > 0) {
        $rsspst_q = "SELECT * FROM ".TBLPREFIX."posts WHERE post_type=\"POST\" AND post_status=\"PUBLIC\" ORDER BY post_date DESC LIMIT 25";
        $rsspst_query = mysqli_query($dbconn,$rsspst_q);
        while ($rsspst_opt = mysqli_fetch_assoc($rsspst_query)) {
            $rsspostid      = $rsspst_opt['post_id'];
            $rsspostslug    = $rsspst_opt['post_slug'];
            $rssposttitle   = $rsspst_opt['post_title'];
            $rsspostby      = $rsspst_opt['user_id'];
            $rsspostdate    = date('r',strtotime($rsspst_opt['post_date']));
            $rssposttext    = nicetext($rsspst_opt['post_text']);

            $rssby_q = "SELECT * FROM ".TBLPREFIX."users WHERE user_id=\"".$rsspostby."\"";
            $rssby_query = mysqli_query($dbconn,$rssby_q);
            while($rssby_opt = mysqli_fetch_assoc($rssby_query)) {
                $rssbyname  = $rssby_opt['user_name'];
                $rssbyemail = $rssby_opt['user_email'];
            }
            $rss2post = "\n\t<item>\n\t\t<title>".$rssposttitle."</title>\n\t\t<link>".$website_url."posts/".$rsspostslug."</link>\n\t\t<pubDate>".$rsspostdate."</pubDate>\n\t\t<author>".$rssbyemail." (".$rssbyname.")</author>\n\t\t<description>".$rssposttext."</description>\n\t</item>";
            fwrite($rss2meta,$rss2post);

        } // end while $rsspst_opt...
    } // end if post_quantity($posts)...


    $rss2end = "\n</channel>\n</rss>";
    fwrite($rss2meta,$rss2end);
    fclose($rss2meta);
