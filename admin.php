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
	}

	public function fb_like_thumbnail_page() {
		$fb_like_thumbnail_admin_hook = add_options_page( 'Facebook Like Thumbnail Setting', 'Facebook Like Thumbnail', 'manage_options', 'fb-like-thumbnail', array( $this, 'fb_like_thumbnail_options_page' ) );

		// add CSS styles specific to our options page on our options page only
		add_action( "admin_head-{$fb_like_thumbnail_admin_hook}", array( $this, 'fb_like_thumbnail_admin_style' ) );
	}

	/**
	 * Function to add CSS styles on our Options page
	 */
	public function fb_like_thumbnail_admin_style() {
		?>
		<style type="text/css">
			.wrap ul {
				list-style-type:disc;
				margin:10px 0 10px 15px;
			}
			.wrap ul ul {
				list-style-type:circle;
			}
		</style>
	<?php
	}

	/**
	 * Function to draw the options page
	 */
	public function fb_like_thumbnail_options_page() {
		?>
		<div class="wrap">
			<h2>Facebook Like Thumbnail</h2>

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
			'Main settings',		// section title
			array( $this, 'fb_like_section_text' ),		// text for the section
			'fb_like_thumbnail'		// specify the output of this section on the options page, same as in do_settings_section
		);
		add_settings_field(
			'fb_like_default',		// field ID
			'Default FB Like thumbnail',	// Field title
			array( $this, 'fb_like_default_setting' ),	// display callback
			'fb_like_thumbnail',		// which settings page?
			'default'			// which settings section?
		);
	}

	public function fb_like_section_text() {
		?>
		Specify the default fallback image to be used. Using a logo or something similar is recommened.
		<?php
	}

	function fb_like_default_setting() {
		$options = get_option( 'fb_like_thumbnail' );
		echo "<input id='fb_like_default' name='fb_like_thumbnail[default]' size='60' type='text' value='{$options['default']}' />";
	}

	function fb_like_thumbnail_validate( $input ) {
		$valid['default'] = esc_url_raw( $input['default'] );
		if ( $valid['default'] != $input['default'] ) {
			add_settings_error(
				'fb_like_default',				// title (?)
				'fb_like_default_url_error',			// error ID (?)
				'Invalid link! Please enter a proper link',	// error message
				'error'						// message type
			);
		}
		return $valid;
	}
}

new Ashfame_Facebook_Like_Thumbnail_Admin();