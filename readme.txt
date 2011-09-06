=== YSlider ===
Contributors: Andrea Ferracani;
Plugin Name: YSlider
Plugin URI: http://www.micc.unifi.it/ferracani/blog/web-applications/yslider-wordpress-content-slider-plugin
Author URI: http://www.micc.unifi.it/ferracani/blog/
Author: Andrea Ferracani
Tags: slider, carousel, slideshow, content slider
Requires at least: 3.0.0
Tested up to: 3.2.1
Stable tag: 1.0

YSlider is a content slider for <a href="http://wordpress.org" title="Wordpress content management system website" target="_blank">Wordpress</a> inspired by the look and feel of one of the coolest widget on the home page of <a href="http://www.yahoo.com" title="Yahoo! Homepage" target="_self">Yahoo!</a>

== Description ==

Official website: <a href="http://www.micc.unifi.it/ferracani/blog/web-applications/yslider-wordpress-content-slider-plugin" title="YSlider website">YSlider website</a> 
(If you find a bug please report it here and I will work on it).

Plugin authors: <a href="http://www.micc.unifi.it/ferracani/blog/" title="Andrea Ferracani website">Andrea Ferracani</a> 

You can have multiple instance of YSlider in each page or post. I'm working on a **pro release** which provides widgets and PHP code instantiation in templates. Contact me!

YSlider automatically displays the first image inside the post or page for each item in the widget and takes care to adapt it to the right width size for the main image and to generate the relative thumbnail in the carousel.

YSlider can display the post excerpt as item content. If the excerpt is not present it also creates for each post a teaser of the text to be visualized from the first 55 words! (To visualize the post excerpt go to posts &gt; edit &gt; screen options &gt; excerpt).



== Installation ==

1. **Download** the archive.
1. Use the WordPress "Add new plug-in feature" OR unzip and manually **upload** to your WordPress plugins directory.
1. Check if files can be written in the /cache folder. If not so, **change the folder permissions** to 777.
1. **Activate** the plugin from you WordPress Administration page.

When you activate the plugin a link **YSlider** is created in the left column of Wordpress dashboard.

Once installed YSlider presents three menu items: <strong>YSlider</strong>, <strong>content</strong> and <strong>style / behaviours</strong> where it is possible to configure content and style parameters.

YSlider can be instantiated in pages with the shortcut <strong>[yslider]</strong> and can be configurated to override the default options, for example:
<ul class="in-text-list">
	<li>[yslider posttitle="Recent movies"] to change the slider title</li>
	<li>[yslider posttitle="Recent movies" postwidth=700 postimgheight=300 postcontentheight=100] to have a slider 700px large with the main image 300px in height and the box containing the text 100px in height</li>
</ul>
All the available options:
<ul class="in-text-list">
	<li>posttitle="what you want" to change the title (you can use posttitle="" to remove title and subtitle)</li>
	<li>postsubtitle="what you want" to change the subtitle</li>
	<li>postids="45,42,39" to select the post or pages in the slider (to make it work it is necessary to add the postrecent="off" option). (to find out post or page id, go to post or page list and hover with the mouse on the post or page title: you can see the id in the link that shows in the bottom bar of the browser window)</li>
	<li>postrecent="on or off" to show the last eight post or page published</li>
	<li>postwidth=600 to override the default slider width</li>
	<li>postimgheight=600 to override the default main image height</li>
	<li>postcontentheight=200 to override the main content default height</li>
	<li>postcarouselheight=600 to override the default carousel height</li>
	<li>postthumbheight=600 to override the carousel default image height</li>
	<li>postslideby=5 to override the number of the items for each slide</li>
	<li>postspeed=1000 to override the speed of the slide (in milliseconds)</li>
	<li>postinterval=2000 to override the interval between each slide when postautoplay="on" (in milliseconds)</li>
	<li>postdelay=2000 to change the amount of time to add to postinterval before the slider begins the slideshow when postautoplay="on" (in milliseconds)</li>
	<li>postcontinuous="on or off" to allow or not a circular navigation between items</li>
	<li>postautoplay="on or off" to allow slider autoplay</li>
</ul>

== Changelog ==

* **2011 september 06**: null initialization fixed
* **2011 september 06**: recent post or selected ids check box not working properly fixed


== Frequently Asked Questions ==

Please leave a comment at [YSlider official website] ( http://www.micc.unifi.it/ferracani/blog/web-applications/yslider-wordpress-content-slider-plugin "YSlider official website")  if you have any questions, concerns, suggestions or problems.


== Screenshots ==

1. Yslider Wordpress Content Slider.





