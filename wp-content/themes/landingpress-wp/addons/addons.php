<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'ADDONS_PATH', trailingslashit( get_template_directory() ) . 'addons/' );
define( 'ADDONS_URL', trailingslashit( get_template_directory_uri() ) . 'addons/' );

include_once( ADDONS_PATH . 'system-check/system-check.php' );

add_action( 'after_setup_theme', 'landingpress_setup_theme_updater', 20 );
function landingpress_setup_theme_updater() {
	global $pagenow;
	require_once( ADDONS_PATH . 'updater/theme-updater.php' );
	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
		if ( get_option( LANDINGPRESS_THEME_SLUG . '_license_key_status', false) != 'valid' ) {
			wp_redirect(admin_url("themes.php?page=landingpress-wp-license"));
		}
	}	
}

if ( get_option( LANDINGPRESS_THEME_SLUG . '_license_key_status', false) != 'valid' ) {
	return;
}

include_once( ADDONS_PATH . 'export-import/export-import.php' );

if ( class_exists( 'CMB_Meta_Box' ) ) {
	add_action( 'admin_notices', 'landingpress_metabox_active' );
}
else {
	if ( ! version_compare( PHP_VERSION, '5.4', '>=' ) ) {
		add_action( 'admin_notices', 'landingpress_metabox_fail_php_version' );
	} 
	else {
		define( 'CMB_DEV', false );
		define( 'CMB_PATH', ADDONS_PATH . 'metabox/' );
		define( 'CMB_URL', ADDONS_URL . 'metabox/' );
		require_once( CMB_PATH . 'custom-meta-boxes.php' );
	}
}

function landingpress_metabox_active() {
	$message = esc_html__( 'LandingPress use custom version of CMB. Please deactivate your CMB plugin.', 'landingpress-wp' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

function landingpress_metabox_fail_php_version() {
	$message = esc_html__( 'LandingPress membutuhkan PHP dengan minimum versi 5.4 ke atas. Silahkan cek video tutorial di member area untuk merubah versi PHP di hosting Anda, atau minta tolong hosting Anda untuk upgrade versi PHP di website Anda.', 'landingpress-wp' ).' <br/><a href="'.esc_url('http://member.landingpress.net/00-troubleshooting-php-version-upload-max-file-size/').'">'.esc_html__( 'Tutorial merubah php version dan upload_max_filesize melalui cPanel', 'landingpress-wp' ).'</a>';
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

if ( ! did_action( 'elementor/loaded' ) && ! get_theme_mod('landingpress_pagebuilder_elementor_disable')  ) {
	if ( ! version_compare( PHP_VERSION, '5.4', '>=' ) ) {
		add_action( 'admin_notices', 'landingpress_elementor_fail_php_version' );
	} 
	else {
		define( 'ELEMENTOR_VERSION', LANDINGPRESS_ELEMENTOR_VERSION );
		define( 'ELEMENTOR_PLUGIN_BASE', 'elementor' );
		define( 'ELEMENTOR_PATH', trailingslashit( ADDONS_PATH . ELEMENTOR_PLUGIN_BASE ) );
		define( 'ELEMENTOR_URL', trailingslashit( ADDONS_URL . ELEMENTOR_PLUGIN_BASE ) );
		define( 'ELEMENTOR_ASSETS_URL', ELEMENTOR_URL . 'assets/' );
		require_once( ELEMENTOR_PATH . 'includes/plugin.php' );
		add_action( 'admin_notices', 'landingpress_elementor_notices', 100 );
		add_filter( 'pre_option_elementor_allow_tracking', 'landingpress_elementor_allow_tracking' ); 
		add_filter( 'pre_option_elementor_tracker_notice', 'landingpress_elementor_tracker_notice' ); 
		if ( class_exists( 'Elementor\\Tracker' ) ) {
			remove_action( 'admin_notices', array( 'Elementor\\Tracker', 'admin_notices' ) );
		}
		if ( in_array( 'elementor-pro/elementor-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			if ( function_exists('elementor_pro_fail_load') ) {
				remove_action( 'admin_notices', 'elementor_pro_fail_load' );
			}
			if ( defined('ELEMENTOR_PRO_PATH') && defined('ELEMENTOR_PRO_VERSION') ) {
				if ( version_compare( ELEMENTOR_PRO_VERSION, LANDINGPRESS_ELEMENTOR_PRO_VERSION_OFF, '>' ) ) {
					add_action( 'admin_notices', 'landingpress_elementor_pro_off' );
				}
				else {
					if ( file_exists( ELEMENTOR_PRO_PATH . 'plugin.php' ) ) {
						require_once( ELEMENTOR_PRO_PATH . 'plugin.php' );
					}
				}
				if ( version_compare( ELEMENTOR_PRO_VERSION, LANDINGPRESS_ELEMENTOR_PRO_VERSION_MINIMUM, '<' ) ) {
					add_action( 'admin_notices', 'landingpress_elementor_pro_low_version' );
				}
			}
		}
		add_action('dp_duplicate_page', 'landingpress_dp_duplicate_post', 15, 2);
		add_action('dp_duplicate_post', 'landingpress_dp_duplicate_post', 15, 2);
	}
}
elseif ( did_action( 'elementor/loaded' ) && ! get_theme_mod('landingpress_pagebuilder_elementor_disable') ) {
	add_action( 'admin_notices', 'landingpress_elementor_active' );
}
if ( did_action( 'elementor/loaded' ) ) {
	include_once( ADDONS_PATH . 'elementor-landingpress/elementor-landingpress.php' );
}

function landingpress_elementor_notices() {
	$screen = get_current_screen();
	if ( 
		$screen->id == 'toplevel_page_elementor' || 
		$screen->id == 'edit-elementor_library' || 
		$screen->id == 'elementor_page_elementor-tools' || 
		$screen->id == 'elementor_page_elementor-system-info' 
	) {
		$message = esc_html__( 'LandingPress menggunakan plugin Elementor yang sudah di-modifikasi. Update plugin Elementor menjadi tanggung jawab tim LandingPress sepenuhnya.', 'landingpress-wp' );
		$html_message = sprintf( '<div class="notice notice-info">%s</div>', wpautop( $message ) );
		echo wp_kses_post( $html_message );
	}
}

function landingpress_elementor_active() {
	$message = esc_html__( 'Harap nonaktifkan (deactivate) plugin Elementor. LandingPress menggunakan plugin Elementor yang sudah di-modifikasi untuk hasil yang optimal.', 'landingpress-wp' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

function landingpress_elementor_fail_php_version() {
	$message = esc_html__( 'Page Builder requires PHP version 5.4+, Page Builder is currently NOT ACTIVE.', 'landingpress-wp' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

function landingpress_elementor_pro_low_version() {
	$screen = get_current_screen();
	if ( 
		$screen->id == 'toplevel_page_elementor' || 
		$screen->id == 'edit-elementor_library' || 
		$screen->id == 'elementor_page_elementor-tools' || 
		$screen->id == 'elementor_page_elementor-system-info' 
	) {
		$message = sprintf( esc_html__( 'Elementor Pro aktif. LandingPress versi %s bekerja optimal untuk Elementor Pro dengan versi %s ke atas.', 'landingpress-wp' ), LANDINGPRESS_THEME_VERSION, LANDINGPRESS_ELEMENTOR_PRO_VERSION_MINIMUM );
		$html_message = sprintf( '<div class="notice notice-info">%s</div>', wpautop( $message ) );
		echo wp_kses_post( $html_message );
	}
}

function landingpress_elementor_pro_off() {
	$screen = get_current_screen();
	if ( 
		$screen->id == 'toplevel_page_elementor' || 
		$screen->id == 'edit-elementor_library' || 
		$screen->id == 'elementor_page_elementor-tools' || 
		$screen->id == 'elementor_page_elementor-system-info' 
	) {
		$message = sprintf( esc_html__( 'Elementor Pro TIDAK AKTIF. LandingPress versi %s tidak kompatibel dengan Elementor Pro versi %s ke atas.', 'landingpress-wp' ), LANDINGPRESS_THEME_VERSION, LANDINGPRESS_ELEMENTOR_PRO_VERSION_OFF );
		$html_message = sprintf( '<div class="notice notice-error">%s</div>', wpautop( $message ) );
		echo wp_kses_post( $html_message );
	}
}

function landingpress_elementor_allow_tracking( $option ) {
	return 'no';
}

function landingpress_elementor_tracker_notice( $option ) {
	return '1';
}

function landingpress_dp_duplicate_post($new_post_id, $post) {
	$data = get_post_meta($post->ID, '_elementor_data', true);
	if ( is_string( $data ) && ! empty( $data ) ) {
		$data = wp_slash( $data );
		update_post_meta($new_post_id, '_elementor_data', $data);
	}
	$draft_data = get_post_meta($post->ID, '_elementor_draft_data', true);
	if ( is_string( $draft_data ) && ! empty( $draft_data ) ) {
		$draft_data = wp_slash( $draft_data );
		update_post_meta($new_post_id, '_elementor_draft_data', $draft_data);
	}
}

if ( class_exists( 'woocommerce') && ! class_exists( 'LandingPress_WC_Ongkir_Shipping_Method' ) ) {
	$lp_wc_ongkir = true;
	if ( class_exists('WPBisnis_WC_Indo_Ongkir_Init') ) {
		$license_status = get_option( 'wpbisnis_wc_indo_ongkir_license_status' );
		if ( isset( $license_status->license ) && $license_status->license == 'valid' ) {
			$lp_wc_ongkir = false;
		}
	}
	if ( $lp_wc_ongkir ) {
		define( 'LP_WC_ONGKIR_PATH', ADDONS_PATH . 'ongkir/' );
		define( 'LP_WC_ONGKIR_URL', ADDONS_URL . 'ongkir/' );
		require_once( LP_WC_ONGKIR_PATH . 'landingpress-wc-ongkir.php' );
	}
}

/*
WP Filters Extras
http://www.beapi.fr
https://github.com/herewithme/wp-filters-extras
Copyright 2012 Amaury Balmer - amaury@beapi.fr
*/
function landingpress_remove_filters_with_method_name( $hook_name = '', $method_name = '', $priority = 0 ) {
	global $wp_filter;
	if ( !isset($wp_filter[$hook_name][$priority]) || !is_array($wp_filter[$hook_name][$priority]) )
		return false;
	foreach( (array) $wp_filter[$hook_name][$priority] as $unique_id => $filter_array ) {
		if ( isset($filter_array['function']) && is_array($filter_array['function']) ) {
			if ( is_object($filter_array['function'][0]) && get_class($filter_array['function'][0]) && $filter_array['function'][1] == $method_name ) {
			    if( is_a( $wp_filter[$hook_name], 'WP_Hook' ) ) {
			        unset( $wp_filter[$hook_name]->callbacks[$priority][$unique_id] );
			    }
			    else {
				    unset($wp_filter[$hook_name][$priority][$unique_id]);
			    }
			}
		}
	}
	return false;
}
function landingpress_remove_filters_for_anonymous_class( $hook_name = '', $class_name ='', $method_name = '', $priority = 0 ) {
	global $wp_filter;
	if ( !isset($wp_filter[$hook_name][$priority]) || !is_array($wp_filter[$hook_name][$priority]) )
		return false;
	foreach( (array) $wp_filter[$hook_name][$priority] as $unique_id => $filter_array ) {
		if ( isset($filter_array['function']) && is_array($filter_array['function']) ) {
			if ( is_object($filter_array['function'][0]) && get_class($filter_array['function'][0]) && get_class($filter_array['function'][0]) == $class_name && $filter_array['function'][1] == $method_name ) {
			    if( is_a( $wp_filter[$hook_name], 'WP_Hook' ) ) {
			        unset( $wp_filter[$hook_name]->callbacks[$priority][$unique_id] );
			    }
			    else {
				    unset($wp_filter[$hook_name][$priority][$unique_id]);
			    }
			}
		}
	}
	return false;
}

include_once( ADDONS_PATH . 'shortcodes/shortcodes.php' );
include_once( ADDONS_PATH . 'optimization/optimization.php' );
