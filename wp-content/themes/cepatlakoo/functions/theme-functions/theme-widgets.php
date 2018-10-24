<?php
/**
 * Function to register widget areas
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_register_sidebars' ) ) {
	function cepatlakoo_register_sidebars(){
		// Sidebar Widget
		if ( function_exists( 'register_sidebar' ) ) {
			register_sidebar( array(
				'name' => esc_html__( 'Sidebar', 'cepatlakoo' ),
				'id' => 'cepatlakoo-sidebar-widget',
				'description' => esc_html__( 'Widgets will be displayed default widget in right sidebar.', 'cepatlakoo' ),
				'class' => '',
				'before_widget' => '<div id="widget-%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			) );
		}

		// WooCommerce Widget
		if ( function_exists( 'register_sidebar') && class_exists( 'WooCommerce' ) ) {
			register_sidebar( array(
				'name' => esc_html__( 'WooCommerce Sidebar', 'cepatlakoo' ),
				'id' => 'cepatlakoo-woocommerce-sidebar',
				'description' => esc_html__( 'Widgets will be displayed woocommerce widget in left sidebar.', 'cepatlakoo' ),
				'class' => '',
				'before_widget' => '<div id="widget-%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			) );
		}

		// WooCommerce Detail Widget
		if ( function_exists( 'register_sidebar') && class_exists( 'WooCommerce' ) ) {
			register_sidebar( array(
				'name' => esc_html__( 'WooCommerce Detail Sidebar', 'cepatlakoo' ),
				'id' => 'cepatlakoo-woocommerce-detail-sidebar',
				'description' => esc_html__( 'Widgets will be displayed woocommerce detail widget in right sidebar.', 'cepatlakoo' ),
				'class' => '',
				'before_widget' => '<div id="widget-%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			) );
		}

		// Footer Widget
		if ( function_exists( 'register_sidebar' ) ) {
			register_sidebar( array(
				'name' => esc_html__( 'Footer', 'cepatlakoo' ),
				'id' => 'cepatlakoo-footer-widget',
				'description' => esc_html__( 'Widgets will be displayed default widget in footer.', 'cepatlakoo' ),
				'class' => '',
				'before_widget' => '<div id="footer-widget-%1$s" class="footer-widget column %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			) );
		}
	}
}

// Load Custom Widgets
include_once( get_template_directory() . '/includes/widgets/cepatlakoo-recent-posts.php' );
include_once( get_template_directory() . '/includes/widgets/cepatlakoo-recent-comments.php' );
?>