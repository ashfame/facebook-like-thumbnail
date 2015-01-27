var ravs = ravs || {};

( function( $ ) {
	var media;

	ravs.media = media = {
		// Set the button ID
		buttonId: '#fb_set_image',
		// Set the container where the attachment thumbnail will be shown
		imgContainerID: '#fb_default_img_container',

		inuputFieldID: '#fb_like_default',

		/**
		 * This is the initialiser.
		 */
		init: function() {
			// Add the event handler to our button to open the media modal
			$( this.buttonId ).on( 'click', this.openMediaDialog );
		},

		/**
		 * This function which will be called, if the user clicks the button.
		 *
		 * Here we adjuste our own media frame, which will be declared only once.
		 */
		openMediaDialog: function( e ) {
			// Check if the frame is already declared.
			// If true, open the frame.
			if ( this._frame ) {
				this._frame.open();
				return;
			}

			/**
			 * Creates the frame which is based on wp.media().
			 *
			 * wp.media() handles the default media experience. It automatically creates
			 * and opens a media frame, and returns the result.
			 * wp.media() can take some attributes.
			 * In this demo we make use of:
			 *  - title: The title of the frame
			 *  - button
			 *     - text: The string of the select button in the toolbar (bottom)
			 *  - multiple: If false, only one media item can be selected at once
			 *  - library
			 *     - type: Declares which media mime types will be displayed in the library
			 *             Examples: `image` for images, `audio` for audio, `video` for video
			 *
			 * Note: When the frame is generated once, you can open the dialog from the JS
			 * console too: ravs.media.frame.open() or ravs.media.frame.close()
			 */
			this._frame = media.frame = wp.media( {
				// Custom attributes
				title: 'Default FB Like thumbnail',
				button: {
					text: 'Set Thumbnail'
				},
				multiple: false,
				library: {
					type: 'image'
				}
			} );

			/**
			 * Handles the ready event.
			 *
			 * The frame triggers some events on special things. For example when the frame
			 * is opened/closed or is ready.
			 * The ready event will be fired once when the frame is completly initialised.
			 */
			this._frame.on( 'ready', function() {
				// Here we can add a custom class to our media modal.
				// .media-modal doesn't exists before the frame is
				// completly initialised.
				$( '.media-modal' ).addClass( 'no-sidebar' );
			} );

			/**
			 * Handles select button function.
			 *
			 * Our frame has currently one state, the library state.
			 * When you have selected a media item and click the select button
			 * the frame will close. Now it's the time to get the selected attachment.
			 */
			this._frame.state( 'library' ).on( 'select', function() {
				// Get the selected attachment. Since we have disabled multiple selection
				// we want the first one of the collection.
				var attachment = this.get( 'selection' ).first();

				// Call the function which will output the attachment details
				media.handleMediaAttachment( attachment );
			} );

			/**
			 * Opens the modal.
			 *
			 * Now the frame is adjusted and we can open it.
			 */
			this._frame.open();
		},

		/**
		 * Handles the attachment details output
		 *
		 * The attachment is a model and so we can get access to each attachment
		 * attribute: attachment.get( key )
		 */
		handleMediaAttachment: function( attachment ) {

			/**
			 * this image object contain media attachment with diffrent sizes
			 */
			var img_obj = attachment.get('sizes')

			// console.log(attachment.get('sizes'), img_obj.full.url, img_obj.thumbnail.url );

			

			/**
			 * Set default facebook thumbnail input field
			 */
			jQuery(this.inuputFieldID).val( img_obj.full.url );

			/**
			 * Show image thumnail which one selected
			 */
			jQuery( 'img', this.imgContainerID).attr('src', img_obj.full.url );

		}
	};

	$( document ).ready( function() {
		/**
		 * Inits our media object.
		 */
		media.init();
	} );
} )( jQuery );