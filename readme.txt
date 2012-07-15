=== Plugin Name ===
Contributors: ashfame
Plugin Name: Facebook Like Thumbnail
Plugin URI: http://blog.ashfame.com/?p=888
Tags: facebook
Author: Ashfame
Author URI: http://blog.ashfame.com/
Requires at least: 2.7
Tested up to: 3.1.1
Stable tag: 0.2
Version: 0.2

Fixes the problem of random thumbnail used by Facebook when someone like/share

== Description ==

Plugin will set the thumbnail used by Facebook to featured thumbnail if available, then fallback to first image of the post and then fallback to a default image as a last resort. Also it will use the default image for your front page and for anything else, it will use the first image of the first post of the loop. You can read explaination on this post - <a href="http://blog.ashfame.com/2011/02/wordpress-plugin-fix-facebook-like-thumbnail/">Facebook Like Thumbnail WordPress plugin</a>

== Installation ==

* Upload the folder `facebook-like-thumbnail` to the `/wp-content/plugins/` directory
* Activate the plugin through the 'Plugins' menu in WordPress
* Settings are in Setting > Facebook Like Thumbnail

== Frequently Asked Questions ==

= How do I change the default image to be used? =

Go to Settings > Facebook Like Thumbnail and enter URL to the default image you would like to use

= Why does it still show an incorrect thumbnail? =

Facebook will update it for all the pages within 24hrs. If you want to refresh for a particular page manually, then you can use the Linter tool - https://developers.facebook.com/tools/lint/

== Changelog ==

= 0.2 =
Switched to FB recommended meta tag og:image
Use featured thumnails if they exist, with a fallback to first image in the post & then the default one
Frontpage & Search page uses the default image
Added options page to enter default image URL, no more plugin editing required
Deleting the plugin via WordPress dashboard will uninstall the saved data in the database
Now supports Nextgen gallery when not using the slideshow mode (and hopefully similar ones too)
Plugin now requires atleast WordPress 2.7 to run

= 0.1 =
Basic plugin! Edit required for changing the default fallback image
