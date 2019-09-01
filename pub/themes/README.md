# Federama 0.2 Themes Documentation
At the moment (June 2019), the use of themes in Federama is a work in progress. The themes in this directory are intended for the public-facing side of the website, not the admin/user side.

Each theme is requried to provide a `style.css` and an `index.php` file. Federama will look for these and the theme will not work if these files are not present. Optional files that a theme can provide include
+ `about.php` - An About page for the website.
+ `category.php` - A page listing all public posts in a given category.
+ `directory.php` - A page of publically-listed accounts on the website.
+ `favicon.ico` - An icon shown in browser bookmarks and other locations. 32 x 32 pixels is recommended.
+ `federama-icon-600.png` - An icon used to make smaller icons for shortcuts for desktops and mobiles. 
+ `followers.php` - A page that lists a user's followers.
+ `following.php` - A page that lists the accounts that a user follows.
+ `footer.php` - A footer for all public facing pages.
+ `header.php` - A header for all public-facing pages.
+ `liked.php` - A page listing all objects that a user has liked.
+ `main.php` - The main page people see when they visit the website.
+ `nav.php` - A navigation element.
+ `post.php` - A page for an individual post.
+ `profile.php` - A user profile page. Sort of like an About page for a user.
+ `shared.php` - A page listing all objects a user has shared.
+ `statistics.php` - A page showing the website's statistics.
+ `tag.php` - A page listing all public posts with a given tag.
