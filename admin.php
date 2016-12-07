<?php
/**
 * Function to create an options page
 */

class Ashfame_Facebook_Like_Thumbnail_Admin {

	public function __construct() {
		// Add options page
		add_action( 'admin_menu', array( $this, 'fb_like_thumbnail_page' ) );
		// Settings API
		add_action( 'admin_init', array( $this, 'fb_like_thumbnail_init' ) );
		// Admin scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'fb_enqueue_scripts' ) );
	}

	public function fb_like_thumbnail_page() {
		$fb_like_thumbnail_admin_hook = add_options_page( __( 'Facebook Like Thumbnail Setting', 'facebook-like-thumbnail' ), __( 'Facebook Like Thumbnail', 'facebook-like-thumbnail' ), 'manage_options', 'fb-like-thumbnail', array( $this, 'fb_like_thumbnail_options_page' ) );
	}

	/**
	 * Function to draw the options page
	 */
	public function fb_like_thumbnail_options_page() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Facebook Like Thumbnail', 'facebook-like-thumbnail' ); ?></h2>

			<form action="options.php" method="post">
				<?php settings_fields( 'fb_like_thumbnail_options' ); ?>
				<?php do_settings_sections( 'fb_like_thumbnail' ); ?>
				<br />
				<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e( 'Save' ); ?>" />
			</form>
		</div>
	<?php
	}

	public function fb_like_thumbnail_init() {
		register_setting(
			'fb_like_thumbnail_options',	// same to the settings_field
			'fb_like_thumbnail',		// options name
			array( $this, 'fb_like_thumbnail_validate' )	// validation callback
		);
		add_settings_section(
			'default',			// settings section (a setting page must have a default section, since we created a new settings page, we need to create a default section too)
			__( 'Main settings', 'facebook-like-thumbnail' ),		// section title
			array( $this, 'fb_like_section_text' ),		// text for the section
			'fb_like_thumbnail'		// specify the output of this section on the options page, same as in do_settings_section
		);
		add_settings_field(
			'fb_like_default',		// field ID
			__( 'Default FB Like thumbnail', 'facebook-like-thumbnail' ),	// Field title
			array( $this, 'fb_like_default_setting' ),	// display callback
			'fb_like_thumbnail',		// which settings page?
			'default'			// which settings section?
		);
	}

	public function fb_like_section_text() {
		_e( 'Specify the default fallback image to be used. Using a logo or something similar is recommended.', 'facebook-like-thumbnail' );
	}

	function fb_like_default_setting() {
		$options = get_option( 'fb_like_thumbnail' );
		?>

		<!--	css	-->
		<style type="text/css">
			#fb_like_default, .no-sidebar .media-sidebar {display: none;}
			#fb_default_img_container {margin-top: 25px;}
		</style>

		<!--	input button which open media setting to upload/set image on click	-->
		<div id="fb_image_uploader">
			<input id="fb_set_image" type="button" class="button button-secondary" value="Set Thumbnail" />
		</div>

		<!--	image display container	-->
		<div id="fb_default_img_container">
			<img src="<?php echo $options['default']; ?>" width="150" />
		</div>

		<!--	setting input field	-->
		<input id="fb_like_default" name="fb_like_thumbnail[default]" size="60" type="text" value="<?php echo $options['default']; ?>" placeholder="http://example.com/logo.jpg" />
		<?php
	}

	function fb_like_thumbnail_validate( $input ) {
		$valid['default'] = esc_url_raw( $input['default'] );
		if ( $valid['default'] != $input['default'] ) {
			add_settings_error(
				'fb_like_default',				// title (?)
				'fb_like_default_url_error',			// error ID (?)
				__( 'Invalid link! Please enter a valid link.', 'facebook-like-thumbnail' ),	// error message
				'error'						// message type
			);
		}
		return $valid;
	}

	function fb_enqueue_scripts(){
		if ( isset( $_GET['page'] ) && 'fb-like-thumbnail' === $_GET['page'] ) {
			wp_enqueue_media();
			wp_enqueue_script( 'upload-media-js', plugins_url( 'js/script.js' , __FILE__ ) );
		}
	}
}

new Ashfame_Facebook_Like_Thumbnail_Admin();