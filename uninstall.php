<?php
// Escape out if the file is not called from WordPress
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

delete_option( 'fb_like_thumbnail' );
