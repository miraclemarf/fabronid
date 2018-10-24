<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB directory)
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
if (is_plugin_active('cmb2/init.php')) {
	deactivate_plugins( 'cmb2/init.php');
}else{
	require_once dirname( __FILE__ ) . '/init.php';
}
