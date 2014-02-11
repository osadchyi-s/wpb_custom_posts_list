=== Plugin Name ===
Contributors: rdsergij
Donate link: http://technocrat.org.ua/
Tags: posts, widget
Requires at least: 3.0.1
Tested up to: 3.7.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Widget to display the list of posts, pages or other types of pages by custom array.

== Description ==

With this widget you can show in the sidebar or other locations site lists posts, pages or other types of materials entering the options arrays of values.
Example:
'posts_per_page'=>'2',
'post_type'=>'post',
'meta_query'=>array(
 '0'=>array(
    'key'=>'id_datetime', 'value'=>(174569332), 'type' => 'numeric', 'compare'=>'>'
  ),
)

Widget receiving this array - show posts (page etc).
Of course, to use this plugin you need to know the basics of array php knowledge. But it is not as difficult as it may seem for beginners.
Also, the default option, you can specify whether you want to display an image and extract the post.



== Installation ==


1. Go to http://your_site.com/wp-admin/plugin-install.php?tab=upload
2. Upload plugoin archive.
3. Press activate plugin.

== Screenshots ==

http://technocrat.org.ua/wp-content/uploads/2013/11/screenshots.png

