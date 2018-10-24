<?php
/**
 * LandingPress functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'LANDINGPRESS_URL', 'https://member.landingpress.net' );
define( 'LANDINGPRESS_THEME_NAME', 'LandingPress WordPress Theme 2.0 (ID)' );
define( 'LANDINGPRESS_THEME_SLUG', 'landingpress-wp' );
define( 'LANDINGPRESS_THEME_VERSION', '2.9.4.1' );
define( 'LANDINGPRESS_ELEMENTOR_VERSION', '1.9.8.1-LP' );
define( 'LANDINGPRESS_ELEMENTOR_PRO_VERSION_MINIMUM', '1.4.0' );
define( 'LANDINGPRESS_ELEMENTOR_PRO_VERSION_OFF', '2.0.0-beta1' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 750; /* pixels */
}

if ( ! function_exists( 'landingpress_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function landingpress_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on LandingPress, use a find and replace
	 * to change 'landingpress' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'landingpress-wp', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 570, 320, true );
	add_image_size( 'post-thumbnail-medium', 300, 200, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'header' => esc_html__( 'Header Menu', 'landingpress-wp' ),
		'footer' => esc_html__( 'Footer Menu', 'landingpress-wp' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	// add_theme_support( 'post-formats', array(
	// 	'aside', 'image', 'video', 'quote', 'link',
	// ) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'landingpress_custom_background_args', array(
		'default-color' => '',
		'default-image' => '',
		'wp-head-callback' => '__return_false',
	) ) );

	add_theme_support( 'custom-header', apply_filters( 'landingpress_custom_header_args', array(
		'width'                  => 960,
		'height'                 => 300,
		'default-image'          => '',
		'default-text-color'     => '',
		'flex-width'             => true,
		'flex-height'            => true,
	) ) );

	add_editor_style();

	add_theme_support( 'wc-product-gallery-lightbox' );

	if ( ! get_theme_mod('landingpress_wc_product_gallery_slider_disable') ) {
		add_theme_support( 'wc-product-gallery-slider' );
	}
	else {
		remove_theme_support( 'wc-product-gallery-slider' );
	}

	if ( ! get_theme_mod('landingpress_wc_product_gallery_zoom_disable') ) {
		add_theme_support( 'wc-product-gallery-zoom' ); 
	}
	else {
		remove_theme_support( 'wc-product-gallery-zoom' ); 
	}

}
endif; // landingpress_setup
add_action( 'after_setup_theme', 'landingpress_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function landingpress_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'landingpress-wp' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	for ($i=1; $i <=3 ; $i++) { 
		register_sidebar( array(
			'name'          => sprintf( esc_html__( 'Footer #%s', 'landingpress-wp' ), $i ),
			'id'            => 'footer-'.$i,
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="footer-widget widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
	register_sidebar( array(
		'name'          => esc_html__( 'Header', 'landingpress-wp' ),
		'id'            => 'header',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'landingpress_widgets_init' );

add_action( 'admin_notices', 'landingpress_show_license_status', 1 );
function landingpress_show_license_status() {
	$screen = get_current_screen();
	if ( 'appearance_page_landingpress-wp-license' == $screen->id ) {
		return;
	}
	if ( get_option( LANDINGPRESS_THEME_SLUG . '_license_key_status', false) != 'valid' ) {
		echo '<style>';
		echo '.landingpress-message {padding: 20px !important;}';
		echo '.landingpress-message-inner {overflow:hidden;}';
		echo '.landingpress-message-icon {float:left;width:35px;height:35px;padding-right:20px;}';
		echo '.landingpress-message-button {float:right;padding:3px 0 0 20px;}';
		echo '</style>';
		echo '<div class="error landingpress-message"><div class="landingpress-message-inner">';
		echo '<div class="landingpress-message-icon">';
		echo '<img src="'.get_template_directory_uri().'/assets/images/logo-icon.png" width="35" height="35" alt=""/>';
		echo '</div>';
		echo '<div class="landingpress-message-button">';
		echo '<a href="'.admin_url('themes.php?page=landingpress-wp-license').'" class="button button-primary">'.esc_html__( 'Aktifkan LandingPress', 'landingpress-wp' ).'</a>';
		echo '</div>';
		echo '<strong>'.esc_html__( 'Selamat Datang di LandingPress WordPress Theme.', 'landingpress-wp' ).'</strong> '.esc_html__( 'Silahkan aktifkan lisensi LandingPress untuk mendapatkan update otomatis, support teknis, dan akses ke LandingPress template library.', 'landingpress-wp' );
		echo '</div></div>';
	}
}

function landingpress_register_scripts() {
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/lib/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );
	wp_register_style( 'magnific-popup', get_template_directory_uri() . '/assets/lib/magnific-popup/jquery.magnific.popup.min.css', array(), '1.1.1' );
	wp_register_script( 'magnific-popup', get_template_directory_uri() . '/assets/lib/magnific-popup/jquery.magnific.popup.min.js', array('jquery'), '1.1.1', true );
	wp_register_style( 'webui-popover', get_template_directory_uri() . '/assets/lib/webui-popover/jquery.webui-popover.min.css', array(), '1.2.15' );
	wp_register_script( 'webui-popover', get_template_directory_uri() . '/assets/lib/webui-popover/jquery.webui-popover.min.js', array('jquery'), '1.2.15', true );
	wp_register_script( 'landingpress', get_template_directory_uri() . '/assets/js/script.min.js', array('jquery'), LANDINGPRESS_THEME_VERSION, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		if ( get_theme_mod( 'landingpress_'.get_post_type().'_comments', '1' ) ) {
			global $landingpress_comment_reply_js;
			$landingpress_comment_reply_js = true;
			wp_enqueue_script( 'comment-reply' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'landingpress_register_scripts', 5 );

function landingpress_enqueue_scripts() {
	wp_enqueue_script( 'landingpress' );
}
add_action( 'wp_footer', 'landingpress_enqueue_scripts', 15 );

function landingpress_enqueue_styles() {
	$stylesheet_name = is_rtl() ? 'style-rtl.css' : 'style.css';
	if ( is_child_theme() ) {
		wp_enqueue_style( 'landingpress-parent', trailingslashit( get_template_directory_uri() ) . $stylesheet_name, array(), LANDINGPRESS_THEME_VERSION );
	}
	if ( is_rtl() ) {
		$stylesheet_uri = trailingslashit( get_template_directory_uri() ) . $stylesheet_name;
	}
	else {
		$stylesheet_uri = get_stylesheet_uri();
	}
	wp_enqueue_style( 'landingpress', $stylesheet_uri, array(), LANDINGPRESS_THEME_VERSION );
}
add_action( 'wp_enqueue_scripts', 'landingpress_enqueue_styles', 25 );

include_once( get_template_directory() . '/inc/upgrades.php' );

add_action( 'customize_register', 'landingpress_customize_controls_register', 5 );
function landingpress_customize_controls_register( $wp_customize ){
	require_once( get_template_directory() . '/inc/customize-controls.php' );
}
include_once( get_template_directory() . '/inc/customize.php' );
include_once( get_template_directory() . '/inc/options.php' );

include_once( get_template_directory() . '/inc/frontend.php' );
include_once( get_template_directory() . '/inc/breadcrumb.php' );
include_once( get_template_directory() . '/inc/admin.php' );

include_once( get_template_directory() . '/inc/metabox.php' );

if ( class_exists( 'woocommerce') ) {
	include_once( get_template_directory() . '/inc/woocommerce.php' );
}

include_once( get_template_directory() . '/addons/addons.php' );
