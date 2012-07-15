=== Plugin Name ===
Contributors: ashfame
Plugin Name: Facebook Like Thumbnail
Plugin URI: http://blog.ashfame.com/?p=888
Tags: facebook
Author: Ashfame
Author URI: http://blog.ashfame.com/
Requires at least: 1.2
Tested up to: 3.1
Stable tag: 0.1
Version: 0.1

Fixes the problem of random thumbnail used by Facebook when someone like/share

== Description ==

Plugin will set the first image of the post as the thumbnail which shows up on FB like and share. Alternatively you can specify a default fallback such as your logo. You can read explaination on this post - <a href="http://blog.ashfame.com/2011/02/wordpress-plugin-fix-facebook-like-thumbnail/">Facebook Like Thumbnail WordPress plugin</a>

== Installation ==

* Upload `facebook-like-thumbnail.php` to the `/wp-content/plugins/` directory
* Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How do I change the default image to be used? =

Change the value of the variable $default to the full path of your logo.
This text should be replaced with the full path of your logo - http://example.com/logo.png

= Why does it still show an incorrect thumbnail? =

Facebook will update it for all the pages within 24hrs. If you want to refresh for a particular page manually, then you can use the Linter tool - https://developers.facebook.com/tools/lint/

== Changelog ==

= 0.1 =
Basic plugin! Edit required for changing the default fallback image
