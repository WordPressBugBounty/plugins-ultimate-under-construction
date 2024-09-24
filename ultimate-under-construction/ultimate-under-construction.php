<?php
/*
Plugin Name: Ultimate Under Construction page
Plugin URI: http://www.happykite.co.uk
Description: Once Active this will replace your WordPress site with a customizable Under Construction holding page. Admins will still be able to log in and see the original site.
Author: HappyKite
Author URI: http://www.happykite.co.uk/
Version: 1.9.4
Text Domain: ultimate-under-construction
Domain Path: /languages
*/

/*
This file is part of ultimateUnderConstruction.
ultimateUnderConstruction is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
ultimateUnderConstruction is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with ultimateUnderConstruction.  If not, see <http://www.gnu.org/licenses/>.
 */

define( 'UUC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'UUC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'UUC_VERSION', '1.9.4' );


/***************************
 * Global variables
 */

// Retrieve settings from Admin Options table.
$uuc_options = get_option( 'uuc_settings' );

/***************************
 * Includes
 */

require 'includes/scripts.php'; // includes all JS and CSS.
require 'includes/display-functions.php'; // display content functions.
require 'includes/uucadmin.php'; // plugin admin options.

add_action( 'in_plugin_update_message-ultimate-under-construction/ultimate-under-construction.php', 'uuc_plugin_update_message', 10, 2 );

/**
 * Update Notice to make it clear it's a security update.
 */
function uuc_plugin_update_message( $data, $response ) {
	if ( '1.9.4' === $response->new_version ) {
		$new_version = $response->new_version;

		/* translators: %s: version number */
		echo wp_kses_post( sprintf( __( '<strong>Notice:</strong> If you are below version %s. Please update Immediately. This update contains a fix for a known XSS Vulnerability', 'uuc' ), $new_version ) );
	}
}
