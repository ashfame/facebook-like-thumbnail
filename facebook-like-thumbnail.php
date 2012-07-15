<?php
/*
Plugin Name: Facebook Like Thumbnail
Plugin URI: http://blog.ashfame.com/?p=888
Description: Sets the first image of the post as the thumbnail which shows up on FB like and share
Author: Ashfame
Author URI: http://blog.ashfame.com/
Version: 0.1
License: GPL
*/

add_action( 'wp_head', 'fb_like_thumbnails' );

function fb_like_thumbnails()
{
	global $posts;
	$default = 'http://example.com/logo.png';
	
	$content = $posts[0]->post_content; // $posts is an array, fetch the first element
	$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
	if ( $output > 0 )
		$thumb = $matches[1][0];
	else
		$thumb = $default;

	echo "\n\n<!-- Facebook Like Thumbnail -->\n<link rel=\"image_src\" href=\"$thumb\" />\n<!-- End Facebook Like Thumbnail -->\n\n";
}
