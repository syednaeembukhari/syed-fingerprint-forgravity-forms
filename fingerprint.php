<?php

/**
 *
 * @link              https://github.com/syednaeembukhari/syed-fingerprint-forgravity-forms
 * @since             1.0.0
 * @package           Syed Fingerprint
 *
 * @wordpress-plugin
 * Plugin Name:       Syed Fingerprint for Gravtiy Forms
 * Plugin URI:        https://github.com/syednaeembukhari/syed-fingerprint-forgravity-forms
 * Description:       This plugin will inlcude and store browser Fingerprints  in  gravityforms , On activation of the plugin  it will add a new field in the advance fields area of the   form screen from there  you can drag/add Fingerprint filed in the form to store data.
 * Version:           1.0.0
 * Author:            Syed Naeem 
 * Author URI:        https://www.upwork.com/freelancers/~012db1b3731c7e9808
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       syedfingerprintforgf
 * Domain Path:       /languages
 */
/* 
Required 
1- Gravity Forms Version 2.5.158 or Heigher   
2- Gravity Forms Webhooks Add-On Version 1.5 or Heigher
    Tested with Gravity Forms  Version 2.5.158 and Version 2.6.9 

*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
!defined( 'SYEDFPGF_VERSION' ) && define( 'SYEDFPGF_VERSION', '1.0.0' );
!defined('SYEDGFP_URI') && define( 'SYEDGFP_URI', plugin_dir_url( __FILE__ ) );
!defined( 'SYEDGFP_PATH' ) && define( 'SYEDGFP_PATH', plugin_dir_path( __FILE__ ));
$GLOBALS['frm_fingerprint']=0;
$GLOBALS['gformid']=0;
$GLOBALS['ip']='';
$GLOBALS['gfcounter']=0;
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fingerprint-activator.php
 */
function activate_fingerprint() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fingerprint-activator.php';
	Fingerprint_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fingerprint-deactivator.php
 */
function deactivate_fingerprint() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fingerprint-deactivator.php';
	Fingerprint_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fingerprint' );
register_deactivation_hook( __FILE__, 'deactivate_fingerprint' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fingerprint.php';
require plugin_dir_path( __FILE__ ) . 'includes/include.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fingerprint() {

	$plugin = new Fingerprint();
	$plugin->run();

}
run_fingerprint();
