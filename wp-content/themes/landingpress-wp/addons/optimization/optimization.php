<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

remove_action( 'wp_head', 'wp_generator' );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
add_filter( 'emoji_svg_url', '__return_false' );

remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );

add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );

remove_action('wp_head', 'wp_oembed_add_discovery_links', 10 );
add_action('init', 'landingpress_deregister_wp_embed');
function landingpress_deregister_wp_embed() {
	if (!is_admin()) {
		wp_deregister_script('wp-embed');
	}
}

if ( ! get_theme_mod('landingpress_optimization_wlw') ) {
	remove_action( 'wp_head', 'wlwmanifest_link' );
}

if ( ! get_theme_mod('landingpress_optimization_xmlrpc') ) {
	remove_action( 'wp_head', 'rsd_link' );
	add_filter( 'xmlrpc_enabled', '__return_false' );
	add_filter( 'wp_headers', 'landingpress_disable_x_pingback' );
	function landingpress_disable_x_pingback( $headers ) {
	    unset( $headers['X-Pingback'] );
		return $headers;
	}
	add_filter( 'xmlrpc_methods', 'landingpress_disable_xmlrpc_pingback' );
	function landingpress_disable_xmlrpc_pingback( $methods ) {
		unset( $methods['pingback.ping'] );
		return $methods;
	}
}
