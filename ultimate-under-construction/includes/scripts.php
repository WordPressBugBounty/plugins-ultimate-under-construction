<?php
/**
 * Scripts File
 *
 * Loads the scripts required for UUC
 *
 * @package Ultimate Under Construction
 */

global $wp_version;

// All Actions to be added.
add_action( 'init', 'uuc_load_scripts' );

if ( is_admin() ) {
	if ( $wp_version >= 3.5 ) {
		add_action( 'init', 'uuc_admin_enqueue_scripts_cp' );
	} else {
		add_action( 'init', 'uuc_admin_enqueue_scripts_farb' );
	}
}

// All functions mentioned above to be added below here only!

/**
 * Load Scripts
 */
function uuc_load_scripts() {
	wp_enqueue_style( 'uuc-styles', plugin_dir_url( __FILE__ ) . 'css/plugin_styles.css', array(), UUC_VERSION );
}

/**
 * Enqueue the Colour Picker Scripts
 */
function uuc_admin_enqueue_scripts_cp() {
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script(
		'uuc-custom',
		plugin_dir_url( __FILE__ ) . 'js/uuc-script.js',
		array(
			'jquery',
			'wp-color-picker',
		),
		'1.1',
		true
	);
	wp_enqueue_style( 'wp-color-picker' );
}

/**
 * Enqueue Farbtastic Scripts
 *
 * Deprecated 1.9.4
 */
function uuc_admin_enqueue_scripts_farb() {
	_deprecated_function( __FUNCTION__, esc_html( UUC_VERSION ), 'uuc_admin_enqueue_scripts_cp' );

	return uuc_admin_enqueue_scripts_cp();
}
