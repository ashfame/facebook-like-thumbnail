<?php
/*
Plugin Name: Facebook Like Thumbnail
Plugin URI: http://blog.ashfame.com/?p=888
Description: Sets the first image of the post as the thumbnail which shows up on FB like and share
Author: Ashfame
Author URI: http://blog.ashfame.com/
Version: 0.2
License: GPL

@todo Add author avatar for author pages
@todo Ignore smilies as a first match
*/

// If we are at WordPress Admin side, load the file for option page
if ( is_admin() )
	require plugin_dir_path( __FILE__ ).'admin.php';

add_action( 'wp_head', 'fb_like_thumbnails' );

function fb_like_thumbnails()
{
	global $posts;
	$options = get_option('fb_like_thumbnail');	
	$default = $options['default'];
	
	if ( is_front_page() || is_search() ) {
		$thumb = $default;
	} else {
		$thumb_set = false;
		
		if ( is_single() || is_page() ) {
			if ( function_exists( 'has_post_thumbnail' ) ) { // compatibility with themes who doesn't support featured thumbnails
				if ( has_post_thumbnail( $posts[0]->ID ) ) {
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $posts[0]->ID) );
					$thumb = $thumb[0]; // take the URL from the array
					$thumb_set = true;
				}
			}
		}
		
		if ( !$thumb_set ) {
			$content = do_shortcode( $posts[0]->post_content ); // $posts is an array, fetch the first element
			$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
			if ( $output > 0 ) {
				$thumb = $matches[1][0];
				// #dirtyhack - check for nextgen loader file (if embedded as slideshow), and fallback to default
				if ( strpos( $thumb, 'nextgen-gallery/images/loader.gif' ) ) {
					$thumb = $default;
				}
			} else
				$thumb = $default;
		}
	}

	echo "\n\n<!-- Facebook Like Thumbnail -->\n<meta property=\"og:image\" content=\"$thumb\" />\n<!-- End Facebook Like Thumbnail -->\n\n";
}
