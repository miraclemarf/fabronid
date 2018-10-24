<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$menu_logo = get_theme_mod( 'landingpress_menu_logo' );
$menu_cart = class_exists( 'woocommerce' ) && get_theme_mod('landingpress_wc_minicart', '1') ? true : false;
$menu_cart_count = class_exists( 'woocommerce' ) && get_theme_mod('landingpress_wc_optimization_minicart_count_disable') ? false : true;
$menu_class = $menu_logo ? ' main-navigation-logo-yes' : ' main-navigation-logo-no';
$menu_class .= $menu_cart ? ' main-navigation-cart-yes' : ' main-navigation-cart-no';
?>
<nav id="site-navigation" class="main-navigation <?php echo $menu_class; ?>">
	<div class="container">
		<div class="menu-overlay"></div>
		<button class="menu-toggle" aria-controls="header-menu" aria-expanded="false"><span class="menu-icon"><span class="menu-bar"></span><span class="menu-bar"></span><span class="menu-bar"></span></span></button>
		<?php if ( $menu_logo ) : ?>
			<a class="menu-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php echo esc_url( $menu_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
			</a>
		<?php endif; ?>
		<?php if ( $menu_cart ) : ?>
			<?php $wc_cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : WC()->cart->get_cart_url(); ?>
			<a class="menu-minicart" href="<?php echo esc_url( $wc_cart_url ); ?>">
				<?php if ( $menu_cart_count ) : ?> 
					<i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="minicart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
				<?php else : ?>
					<i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="minicart-text"><?php esc_html_e( 'Cart', 'landingpress-wp' ); ?></span>
				<?php endif; ?>
			</a>
		<?php endif; ?>
		<?php 
		echo landingpress_get_nav_menu( array( 
			'theme_location' => 'header', 
			'container_class' => 'header-menu-container', 
			'menu_id' => 'header-menu', 
			'menu_class' => 'header-menu menu nav-menu clearfix', 
			'fallback_cb' => '',
		) ); 
		?>
	</div>
</nav>
