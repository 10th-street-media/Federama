<?php
/*
 * pub/the-user-feeds.php
 *
 * Creates Atom and RSS 2.0 feeds of individual users.
 *
 * since Federama version 0.2
 *
 */
?>
<?php

// define current date and time
$nowa = date('c',strtotime("now")); // for Atom
$nowb = date('r',strtotime("now")); // for RSS2 lastBuildDate
$nowp = date('r',strtotime("today")); // for RSS2 pubDate

/*
 *
 * ATOM FEED
 *
 * NOTE: In $...meta don't use $website_url in the url to be created, otherwise fopen won't work for some reason
 */
	$atommeta = fopen("data/".$username."-atom.xml", "w") or die("Unable to open or create data/".$username."-atom.xml file");

	$atomstart = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<feed xmlns=\"http://www.w3.org/2005/Atom\">\n\n\t<title>".$website_name." : ".$username."</title>\n\t<link rel=\"self\" href=\"".$website_url."data/".$username."-atom.xml\"/>\n\t<updated>".$nowa."</updated>\n\t<id>".$website_url."users/".$username."</id>\n\n";
	fwrite($atommeta,$atomstart);

	// if we have posts from this user, show the most recent 25.
	if (post_quantity($posts) > 0) {
		$pst_q = "SELECT * FROM ".TBLPREFIX."posts WHERE post_status=\"PUBLIC\" AND post_type=\"POST\" AND user_id=\"".$userid."\" ORDER BY post_date DESC LIMIT 25";
		$pst_query = mysqli_query($dbconn,$pst_q);
		while ($pst_opt = mysqli_fetch_assoc($pst_query)) {
			$postid		= $pst_opt['post_id'];
			$postby		= $pst_opt['user_id'];
			$posttime	= date('c',strtotime($pst_opt['post_date']));
			$posttext	= $pst_opt['post_text'];
			$postslug	= $pst_opt['post_slug'];
			$posttitle	= $pst_opt['post_title'];

			$by_q = "SELECT * FROM users WHERE user_id=\"".$postby."\"";
			$by_query = mysqli_query($dbconn,$by_q);
			while($by_opt = mysqli_fetch_assoc($by_query)) {
				$byname		= $by_opt['user_name'];
			}
			$atompost = "\n\t<entry>\n\t\t<title type=\"html\">".$posttitle."</title>\n\t\t<link href=\"".$website_url."posts/".$postslug."\" />\n\t\t<id>".$website_url."posts/".$postslug."</id>\n\t\t<updated>".$posttime."</updated>\n\t\t<author>\n\t\t\t<name>".$username."</name>\n\t\t</author>\n\t\t<content type=\"html\">".$posttext."</content>\n\t</entry>";
			fwrite($atommeta,$atompost);

		} // end while $pst_opt...
	} // end if post_quantity($posts)...


	$atomend = "</feed>";
	fwrite($atommeta,$atomend);
	fclose($atommeta);


/*
 *
 * RSS 2.0 FEED
 *
 * NOTE: In $...meta don't use $website_url in the url to be created, otherwise fopen won't work for some reason
 */

	$rss2meta = fopen("data/".$username."-rss2.xml", "w") or die("Unable to open or create data/".$username."-rss2.xml file");

	$rss2start = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<rss version=\"2.0\">\n<channel>\n\t<title>".$website_name." : ".$username."</title>\n\t<description>"._('The RSS feed of')." @".$username."@".$_SERVER['SERVER_NAME']."</description>\n\t<link>".$website_url."users/".$username."/</link>\n\t<pubDate>".$nowp."</pubDate>\n\t<lastBuildDate>".$nowb."</lastBuildDate>\n\n";
	fwrite ($rss2meta,$rss2start);

	// if we have posts, display the most recent ones in a div on the right side of the page
	if (post_quantity($posts) > 0) {
		$rsspst_q = "SELECT * FROM ".TBLPREFIX."posts WHERE post_status=\"PUBLIC\" AND post_type=\"POST\" AND user_id=\"".$userid."\" ORDER BY post_date DESC LIMIT 25";
		$rsspst_query = mysqli_query($dbconn,$rsspst_q);
		while ($rsspst_opt = mysqli_fetch_assoc($rsspst_query)) {
			$rsspostid		= $rsspst_opt['post_id'];
			$rsspostby		= $rsspst_opt['user_id'];
			$rssposttime	= date('r',strtotime($rsspst_opt['post_date']));
			$rssposttext	= $rsspst_opt['post_text'];
			$rssposttitle	= $rsspst_opt['post_title'];
			$rsspostslug	= $rsspst_opt['post_slug'];

			$rssby_q = "SELECT * FROM users WHERE user_id=\"".$rsspostby."\"";
			$rssby_query = mysqli_query($dbconn,$rssby_q);
			while($rssby_opt = mysqli_fetch_assoc($rssby_query)) {
				$rssbyname		= $rssby_opt['user_name'];
			}
			$rss2post = "\n\t<item>\n\t\t<title>".$rssposttitle."</title>\n\t\t<link>".$website_url."posts/".$rsspostslug."\"</link>\n\t\t<pubDate>".$rssposttime."</pubDate>\n\t\t<author>@".$username."@".$_SERVER['SERVER_NAME']."</author>\n\t\t<description>".$rssposttext."</description>\n\t</item>";
			fwrite($rss2meta,$rss2post);

		} // end while $rsspst_opt...
	} // end if post_quantity($posts)...


	$rss2end = "\n</channel>\n</rss>";
	fwrite($rss2meta,$rss2end);
	fclose($rss2meta);

?>
