<?php
/**
 * List of files inclusion and functions
 *
 * Define global variables:
 * $themename : theme name information
 * $shortname : short name information
 * $version : current theme version
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */

$version = wp_get_theme()->Version;

// Include theme functions
require_once( get_template_directory() . '/functions/theme-functions/theme-widgets.php' ); // Load widgets
require_once( get_template_directory() . '/functions/theme-functions/theme-support.php' ); // Load theme support
require_once( get_template_directory() . '/functions/theme-functions/theme-functions.php' ); // Load custom functions
require_once( get_template_directory() . '/functions/theme-functions/theme-post-type.php' ); // Load custom post type functions
require_once( get_template_directory() . '/functions/theme-functions/theme-shortcode.php' ); // Load custom shortcode functions
require_once( get_template_directory() . '/functions/theme-functions/theme-migrations.php' ); // Load custom shortcode functions
require_once( get_template_directory() . '/includes/elementor-functions.php' ); // Load custom elementor functions
require_once( get_template_directory() . '/includes/sms-gateway.php' ); // Load custom elementor functions
require_once( get_template_directory() . '/functions/theme-functions/theme-styles.php' ); // Load JavaScript, CSS & comment list layout

require_once( get_template_directory() . '/functions/class-tgm-plugin-activation.php' ); // Load TGM-Plugin-Activation

require_once( get_template_directory() . '/includes/CMB2/functions.php' );
require_once( get_template_directory() . '/includes/cmb2-conditionals/cmb2-conditionals.php' );

// Load custom woocommerce functions
if ( class_exists( 'WooCommerce' ) ) {
	require_once( get_template_directory() . '/functions/theme-functions/theme-woocommerce.php' ); 
}

//require get_parent_theme_file_path( 'includes/merlin/merlin.php' );
//require get_parent_theme_file_path( 'includes/merlin-config.php' );

/**
 * Check TitanFramework Before Include Metabox Option
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */

require_once( get_template_directory() . '/functions/theme-functions/theme-metabox.php' ); // Load custom metabox functions

/**
 * After setup theme
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if( ! function_exists(' cepatlakoo_theme_init ') ) {
	function cepatlakoo_theme_init() {
		add_action( 'widgets_init', 'cepatlakoo_register_sidebars' );
	}
}
add_action( 'after_setup_theme', 'cepatlakoo_theme_init' );

/**
 * Loads the Options Panel
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( file_exists( get_template_directory() . '/functions/theme-functions/theme-options.php' ) ) {
	require_once( get_template_directory() . '/functions/theme-functions/theme-options.php' );
}

/**
 * Required & recommended plugins
 * *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if( ! function_exists(' cepatlakoo_required_plugins ') ) {
	function cepatlakoo_required_plugins() {
		$plugins = array(
			array(
				'name'			=> esc_html__( 'Elementor Page Builder', 'cepatlakoo' ),
				'slug'			=> 'elementor',
				'required'		=> true,
			),
			array(
				'name'			=> esc_html__( 'WooCommerce - excelling eCommerce', 'cepatlakoo' ),
				'version' 		=> '3.4.0',
				'slug'			=> 'woocommerce',
				'required'		=> true,
			),
			array(
				'name'			=> esc_html__( 'Caldera Forms – More Than Contact Forms', 'cepatlakoo' ),
				'slug'			=> 'caldera-forms',
				'required'		=> true,
			),
			array(
				'name'			=> esc_html__( 'Cepatlakoo - Ongkir', 'cepatlakoo' ),
				'version' 		=> '1.3.3',
				'slug'			=> 'cepatlakoo-ongkir',
				'source'		=> get_template_directory() . '/plugins/cepatlakoo-ongkir.zip',
				'external_url'	=> '',
				'required'		=> true,
			),
			array(
				'name'			=> esc_html__( 'Cepatlakoo - Input Resi', 'cepatlakoo' ),
				'slug'			=> 'cepatlakoo-input-resi',
				'version' 		=> '1.1.0',
				'source'		=> get_template_directory() . '/plugins/cepatlakoo-input-resi.zip',
				'external_url'	=> '',
				'required'		=> true,
			),
			array(
				'name'			=> esc_html__( 'Cepatlakoo - Kode Pembayaran', 'cepatlakoo' ),
				'slug'			=> 'cepatlakoo-kode-pembayaran',
				'version' 		=> '1.1.4',
				'source'		=> get_template_directory() . '/plugins/cepatlakoo-kode-pembayaran.zip',
				'external_url'	=> '',
				'required'		=> true,
			),
			array(
				'name'			=> esc_html__( 'Cepatlakoo - Sales Booster for WooCommerce', 'cepatlakoo' ),
				'slug'			=> 'cl-sales-booster',
				'version' 		=> '1.1.4',
				'source'		=> get_template_directory() . '/plugins/cepatlakoo-sales-booster.zip',
				'external_url'	=> '',
				'required'		=> true,
			),
			array(
				'name'			=> esc_html__( 'Redux Framework', 'cepatlakoo' ),
				'slug'			=> 'redux-framework',
				'required'		=> true,
			)
		);

		$config = array(
			'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}
}
add_action( 'tgmpa_register', 'cepatlakoo_required_plugins' );

/**
 * Load theme updater functions.
 * Action is used so that child themes can easily disable.
 */

/**
 * Function to theme updater
 * *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if( ! function_exists(' cepatlakoo_theme_updater ') ) {
	function cepatlakoo_theme_updater() {
		require( get_template_directory() . '/updater/theme-updater.php' );
	}
}
add_action( 'after_setup_theme', 'cepatlakoo_theme_updater' );


/**
 * Remove Wordpress Admin Bar Sss
 * Action is used to remove WP Admin bar CSS
 */

/**
 * Function to theme updater
 * *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */

add_action('get_header', 'remove_admin_login_header');
function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
    Container::make( 'theme_options', __( 'Theme Options', 'crb' ) )
        ->add_fields( array(
Field::make( 'complex', 'crb_job' )
    ->add_fields( 'driver', array(
        Field::make( 'text', 'name' ),
        Field::make( 'text', 'drivers_license_id' ),
    ))
    ->add_fields( 'teacher', array(
        Field::make( 'image', 'name' ),
        Field::make( 'image', 'years_of_experience' ),
    ))
        ) );
}
