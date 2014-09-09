=== Plugin Name ===
Contributors: ashfame
Plugin Name: Facebook Like Thumbnail
Plugin URI: http://wordpress.org/plugins/facebook-like-thumbnail/
Tags: facebook
Author: Ashfame
Author URI: http://ashfame.com/
Requires at least: 3.1
Tested up to: 4.0
Stable tag: trunk

Plugin for specifying context specific images to be used as thumbnail for links liked/shared on Facebook.

== Description ==

Plugin for specifying which thumbnail to use for links liked/shared on Facebook. It just works! If it doesn’t work for you, let me know by creating an issue here - https://github.com/ashfame/facebook-like-thumbnail/issues

== Installation ==

* Upload the folder `facebook-like-thumbnail` to the `/wp-content/plugins/` directory
* Activate the plugin through the 'Plugins' menu in WordPress
* Settings are in Setting > Facebook Like Thumbnail

== Frequently Asked Questions ==

= How do I change the default image to be used? =

Go to Settings > Facebook Like Thumbnail and enter URL to the default image you would like to use

= When is the default image used? =

When plugin can’t figure out the image to use in any context, then it will use the default image.

= Why does it still show an incorrect thumbnail? =

Facebook will update it for all the pages within 24hrs. If you want to refresh for a particular page manually, then you can use the Linter tool - https://developers.facebook.com/tools/lint/

== Changelog ==

= 0.3.4 =
* Added support for attachment page view
* Better way of checking for attached featured thumbnail

= 0.3.3 =
* Fixed a bug with retrieving attachments correctly
* Check minimum WordPress version compatibility
* Enhancements in architecture

= 0.3.2 =
* Query fix when attachments are scanned for current singular item (post/page etc)

= 0.3.1 =
* Minor fixes

= 0.3 =
* Complete rewrite with better architecture and the ability to plug in custom logic for figuring out media image

= 0.2 =
* Switched to FB recommended meta tag og:image
* Use featured thumbnails if they exist, with a fallback to first image in the post & then the default one
* Frontpage & Search page uses the default image
* Added options page to enter default image URL, no more plugin editing required
* Deleting the plugin via WordPress dashboard will uninstall the saved data in the database
* Now supports Nextgen gallery when not using the slideshow mode (and hopefully similar ones too)
* Plugin now requires atleast WordPress 2.7 to run

= 0.1 =
* Basic plugin! Edit required for changing the default fallback image
