This is a mobile website I completed for the [Heart Gallery of Alabama](http://heartgalleryalabama.com), a charity supporting adoption of children in foster care with professional videos and photography. You can view it on a desktop browser [here](http://heartgalleryalabama.com/mobile/) (mobile devices are automatically redirected).

### Design Goals
POOOP POOP POOP POOOOOOOOP
The Heart Gallery's existing desktop website included lists of children and a detail page for each child including a short bio, photos, and videos. The client and I identified two core use cases for the site:

* As a potential adoptive family, browse children matching your age or gender preferences.
* As a Heart Gallery employee, quickly find a specific child's detail page to display to a potential adoptive family.

The desktop website suffered from several usability issues that could make acomplishing these goals difficult, especially on mobile devices:

* Child lists were displayed as grids of irregularly sized images and child names, so navigating them required much scrolling and zooming.
* Child lists were long but unsorted, so finding a specific child could require visually scanning the entire list.
* Child detail pages used a Flash video player and were thus not viewable on iOS devices.
* Child detail pages would display several images and videos before the child's bio, so the page did not display information in the order it was most useful to users.

The client wanted to address the mobile issues initially and address any remaining issues using the original developer, so I created a mobile website with the following enhancements:

* Display lists vertically, using fixed-size images and list-item width fixed to the size of the mobile viewport.
* Sort the list by the children's names and support searching by name.
* Support filtering child lists by gender and age.
* Use HTML5 video elements and videos encoded using H.264/MP4 for the widest possible support on mobile browsers.
* Initially display only a single child image and the child's bio, with additional images and videos toggle-able inline with a "Show more pictures" or "Show videos" link.

### Platform Contraints
The site was hosted on a server with PHP 5.2 and MySQL 4.1 but without
the [mysqli](http://php.net/manual/en/book.mysqli.php) or [PDO](http://php.net/manual/en/book.pdo.php) extensions. The only available image manipulation tool was [GD](http://php.net/manual/en/book.image.php).

### Technical Details
I used the [Slim](http://www.slimframework.com/) PHP microframework which facillitated an [MVC](http://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller) architecture, clean URLs, simple template integration, and PHP 5.2 support. I used the [Twig](http://twig.sensiolabs.org/) template library and an HTML layout patterned after [HTML5 Boilerplate](http://html5boilerplate.com/).

I would typically use an [ORM](http://en.wikipedia.org/wiki/Object-relational_mapping) to handle my models, but I was unable to find an ORM compatible with PHP 5.2 that did not use the PDO extension. Lacking [prepared statements](http://en.wikipedia.org/wiki/Prepared_statement), I used the [original MySQL API](http://php.net/manual/en/book.mysql.php) and was careful to avoid SQL injection issues by using [mysql_set_charset](http://php.net/manual/en/function.mysql-set-charset.php) and [mysql_real_escape_string](http://php.net/manual/en/function.mysql-real-escape-string.php) as described [in this StackOverflow post](http://stackoverflow.com/a/12118602).

The site's photography was shot in a variety of sizes and included both landscapes and portraits, so the existing thumbnail strategy of shrinking images to a fixed height was insufficient. I created square thumbnails to provide a consistent look and strike a balance between landscape and portrait images. I followed a pattern I had previously used with [ImageMagick](http://www.imagemagick.org/script/index.php): shrink the image such that its smaller edge is 100 pixels, then evenly crop the edges to create a 100 x 100 pixel square. I then modified the "Add a Child" administration page so that a thumbnail would be created for any child added in the future.

I used [Mobile Detect](https://github.com/serbanghita/Mobile-Detect) to redirect mobile devices to the mobile website. The mobile site provides a "View Full Site" link allowing mobile users to opt out of the mobile site. The user's preference is saved in a cookie to prevent redirection to the mobile site on subsequent page loads.

To add child list searching and filtering and other interactivity, I used [CoffeeScript](http://coffeescript.org/) and [JQuery](http://jquery.com/). I found that CoffeeScript provided a number of minor conveniences over plain Javascript, including cleaner anonymous functions and [destructuring assignment](http://coffeescript.org/#destructuring). However, I found its most useful feature to be [array comprehensions](http://coffeescript.org/#loops), for which I would usually have turned to [Underscore](http://underscorejs.org/).
