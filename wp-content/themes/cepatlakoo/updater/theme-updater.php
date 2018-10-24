<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://cepatlakoo.com', // Site where EDD is hosted
		'item_name'      => 'Cepatlakoo', // Name of theme
		'theme_slug'     => 'cepatlakoo', // Theme slug
		'version'        => '1.3.7', // The current version of this theme
		'author'         => 'Cepatlakoo', // The author of this theme
		'download_id'    => '126', // Optional, used for generating a license renewal link
		'renew_url'      => '', // Optional, allows for a custom license renewal link
		'beta'           => false, // Optional, set to true to opt into beta versions
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Theme License', 'cepatlakoo' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'cepatlakoo' ),
		'license-key'               => __( 'License Key', 'cepatlakoo' ),
		'license-action'            => __( 'License Action', 'cepatlakoo' ),
		'deactivate-license'        => __( 'Deactivate License', 'cepatlakoo' ),
		'activate-license'          => __( 'Activate License', 'cepatlakoo' ),
		'status-unknown'            => __( 'License status is unknown.', 'cepatlakoo' ),
		'renew'                     => __( 'Renew?', 'cepatlakoo' ),
		'unlimited'                 => __( 'unlimited', 'cepatlakoo' ),
		'license-key-is-active'     => __( 'License key is active.', 'cepatlakoo' ),
		'expires%s'                 => __( 'Expires %s.', 'cepatlakoo' ),
		'expires-never'             => __( 'Lifetime License.', 'cepatlakoo' ),
		'%1$s/%2$-sites'            => __( 'You have <span class="active-sites">%1$s / %2$s</span> sites activated.', 'cepatlakoo' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'cepatlakoo' ),
		'license-key-expired'       => __( 'License key has expired.', 'cepatlakoo' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'cepatlakoo' ),
		'license-is-inactive'       => __( 'License is inactive.', 'cepatlakoo' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'cepatlakoo' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'cepatlakoo' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'cepatlakoo' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'cepatlakoo' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'cepatlakoo' ),
	)

);
add_filter( 'edd_sl_api_request_verify_ssl', '__return_false' );
