<?php
/**
 * The template for displaying header middle template
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
?>

<?php ob_start(); // Initiate the output buffer ?>

<!-- START: Left Menu Navigation -->
<div id="main-header" class="header-logo-left">
    <div class="container clearfix">
        <?php cepatlakoo_logo(); ?>

        <?php
	    // load cart profile menu
	    if ( class_exists( 'WooCommerce' ) ) {
	        echo cepatlakoo_display_cart_profile_menu();
	    }
	    ?>

        <?php if ( has_nav_menu( 'cepatlakoo-left-navigation' ) ) : ?>
            <nav id="main-menu" class="main-menu site-navigation">
                <?php wp_nav_menu( array( 'theme_location' => 'cepatlakoo-left-navigation', 'container' => null, 'menu_class' => 'main-menu', 'depth' => 4 ) ); ?>
            </nav>
        <?php endif; ?>
    </div>
</div>
<!-- END: Left Menu Navigation -->