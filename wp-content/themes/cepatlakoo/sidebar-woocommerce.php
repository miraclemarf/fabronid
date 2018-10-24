<?php
/**
 * The Sidebar WooCommerce containing the main widget area
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
?>

<div id="sidebar" class="right-sidebar-shop-page">
<?php
	// Load widgets
	if ( is_active_sidebar( 'cepatlakoo-woocommerce-sidebar' ) ) {
		dynamic_sidebar( 'cepatlakoo-woocommerce-sidebar' );
	}
?>
</div>