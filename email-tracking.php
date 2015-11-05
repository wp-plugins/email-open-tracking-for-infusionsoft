<?php
/**
 * Plugin Name: Email Open Tracking for Infusionsoft
 * Plugin URI: http://automate.fm/email-open-tracking-plugin
 * Description: Use email opens to trigger actions in Infusionsoft
 * Version: 0.2
 * Author: Justin Handley
 * Author URI: http://automate.fm
 * Text Domain: isemailopentracking
 * Network: false
 * License: GPL2
 */

if (!function_exists('add_action'))
	exit;


define( 'EMAILTRACKING__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'EMAILTRACKING__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

register_activation_hook( __FILE__, array( 'EmailTracking', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'EmailTracking', 'plugin_deactivation' ) );

require_once( EMAILTRACKING__PLUGIN_DIR . 'classEmailTracking.php' );

if(!class_exists('iSDK'))
    require_once( EMAILTRACKING__PLUGIN_DIR . 'plugins/iSDK/isdk.php' );

add_action( 'init', array( 'EmailTracking', 'init' ) );

if (is_admin()) {
	require_once( EMAILTRACKING__PLUGIN_DIR . 'classEmailTrackingAdmin.php' );
	add_action( 'init', array('EmailTrackingAdmin', 'init') );
}
