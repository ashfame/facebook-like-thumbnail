<?php
/**
 * Plugin Name: Facebook Like Thumbnail
 * Plugin URI: http://blog.ashfame.com/?p=888
 * Description: Figures out the thumbnail image to be used for Facebook & Other sites depending on meta:og tag
 * Author: Ashfame
 * Author URI: http://blog.ashfame.com/
 * Version: 0.3
 * License: GPL
 * Notes: This plugin only do the job of assigning meta:og image to pages. Title and description are easily picked up from meta info or derived from page's content.
 */

// die if called directly
defined( 'ABSPATH' ) || die();

// If we are at WordPress Admin side, load the file for option page
is_admin() && require plugin_dir_path( __FILE__ ).'admin.php';

class Ashfame_Facebook_Like_Thumbnail {

	public static $version = '0.3';
	public static $options;
	public static $meta_og_image; // Static variable so that it can be reused for custom code, for instance when constructing pinterest sharing link, this media image can be used
	public static $meta_og_where = 'default fallback';

	public function __construct() {
		// set defaults
		self::$options = get_option( 'fb_like_thumbnail' );
		self::$meta_og_image = apply_filters( 'fb_like_thumbnail_default', self::$options['default'] );

		// This figures out the image to use once so that wherever its needed, its just retrieved from here, saving multiple code which makes same sort of SQL queries again
		add_action( 'wp', array( $this, 'figure_out_media_image_for_social_networks' ) );
		add_action( 'wp_head', array( $this, 'output_meta_og_image_tag' ) );

		// Paid Support link in plugins listing
		add_filter( 'plugin_action_links', array( $this, 'support_plugin_action_link' ), 10, 2 );
	}

	public function bail() {
		// WooCommerce pages
		if ( is_page( 'cart' ) || is_page( 'checkout' ) || is_page( 'my-account' ) ) {
			return true;
		}

		return apply_filters( 'fb_like_thumbnail_bail', false ); // Filter here if you need to set exclusion on pages, best to do this on pages which are only meant for logged in users, saves database queries
	}

	public function figure_out_media_image_for_social_networks() {
		$media = '';

		// bail
		if ( $this->bail() ) {
			return;
		}

		// short-circuit opportunity
		$media = apply_filters( 'fb_like_thumbnail_shortcircuit', '' ); // Short-circuit here if you want to change the logic of image selection here
		if ( ! empty( $media ) ) {
			self::$meta_og_where = 'shortcircuit';
		}

		// check for image inside posts, if we are on a archive page, only if needed
		if ( empty( $media ) && is_archive() ) {
			global $posts;

			foreach ( $posts as $post ) {
				$media = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
				if ( $media ) {
					self::$meta_og_where = 'image from posts loop - archive page';
					break;
				}
			}
		}

		// check for featured thumbnail, if needed
		if ( empty( $media ) && get_post_thumbnail_id() ) {
			$media = wp_get_attachment_url( get_post_thumbnail_id() );
			self::$meta_og_where = 'featured thumbnail';
		}

		// check for attachments (ACF modules or any sort of gallery plugins should be covered here), only if needed
		if ( empty( $media ) && is_singular() ) {

			$attachments = get_posts(
				array(
					'post_type' => 'attachment',
					'numberposts' => 1,
					'post_status' => 'publish',
					'post_parent' => get_the_ID()
				)
			);

			if ( $attachments ) {
				$media = wp_get_attachment_thumb_url( $attachments[0]->ID ); // @TODO possible filtering of attachments by extensions here, not all attachments are going to be media files
				self::$meta_og_where = 'first attachment';
			}
		}

		// assign media image for using it if we managed to get a specific to context, else default will be used
		if ( ! empty( $media ) ) {
			self::$meta_og_image = $media;
		}
	}

	public function output_meta_og_image_tag() {
		echo "\n\n<!-- Facebook Like Thumbnail (v" . self::$version . ") -->\n" . '<meta property="og:image" content="' . self::$meta_og_image . '" />' . "\n<!-- using " . self::$meta_og_where . " -->\n<!-- Facebook Like Thumbnail (By Ashfame - https://github.com/ashfame/facebook-like-thumbnail) -->\n\n";
	}

	public function support_plugin_action_link( $links, $file ) {
		// Also check using strpos because when plugin is actually a symlink inside plugins folder, its plugin_basename will be based off its actual path
		if ( $file == plugin_basename( __FILE__ ) || strpos( plugin_basename( __FILE__ ), $file ) !== false ) {
			$settings_link = '<a href="' . admin_url( 'options-general.php?page=fb-like-thumbnail' ) . '">Settings</a>';
			$support_link = '<a href="mailto:mail@ashfame.com">Premium Support</a>';
			$links = array_merge( array( $settings_link, $support_link ), $links );
		}

		return $links;
	}
}

new Ashfame_Facebook_Like_Thumbnail();