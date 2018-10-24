<?php
/**
 * Function to load JS & CSS files
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_enqueue_scripts' ) ) {
	function cepatlakoo_enqueue_scripts() {
		global $pagenow, $woocommerce, $cl_options;

		// Only load these scripts on frontend
		if ( !is_admin() && $pagenow != 'wp-login.php' ) {

			if ( is_singular() ) {
				wp_enqueue_script( 'comment-reply' );
			}

			wp_enqueue_script( 'wc-add-to-cart-variation' );

			// Load all JS files
			wp_enqueue_script( 'fitvids', get_template_directory_uri() .'/js/jquery.fitvids.js', array('jquery'), '1.1', true );
			wp_enqueue_script( 'mixitup', get_template_directory_uri() .'/js/jquery.mixitup.min.js', array('jquery'), '2.1.11', true );
    		wp_enqueue_script( 'foundation', get_template_directory_uri() .'/js/foundation.min.js', array('jquery'), '2.2.10', true);
    		wp_enqueue_script( 'why-input', get_template_directory_uri() .'/js/what-input.js', array('jquery'), '2.2.10', true);
			wp_enqueue_script( 'range', get_template_directory_uri() .'/js/jquery.range-min.js', array('jquery'), null, true );
			wp_register_script( 'cl-countdown', get_template_directory_uri() .'/js/jquery.countdown.js', '', '2.1.0', false);
			wp_enqueue_script( 'jrespond', get_template_directory_uri() .'/js/jrespond.min.js', array('jquery'), '0.10', true );
			wp_enqueue_script( 'owl-carousel', get_template_directory_uri() .'/js/owl.carousel.min.js', array('jquery'), null, true );
			wp_enqueue_script( 'owl-carousel-thumb', get_template_directory_uri() .'/js/owl-thumb.js', array('jquery'), null, true );
			wp_enqueue_script( 'jquery.magnific-popup', get_template_directory_uri() .'/js/jquery.magnific-popup.js', array('jquery'), null, true );
			wp_enqueue_script( 'jquery.match-height', get_template_directory_uri() .'/js/matchheight-min.js', array('jquery'), null, true );
			wp_enqueue_script( 'cepatlakoo-functions', get_template_directory_uri() .'/js/functions.js', array('jquery'), null, true );
			
			wp_localize_script( 'cepatlakoo-functions', '_warrior', array(
				'cart_redirection' => get_option('woocommerce_cart_redirect_after_add'),
				'cart_url'	=> esc_url( get_permalink( get_option( 'woocommerce_cart_page_id' ) ) ),
				'currency_woo' => function_exists( 'get_woocommerce_currency' ) ? get_woocommerce_currency() : '',
				'js_textdomain' => array(
                                esc_html__('Navigation', 'cepatlakoo'),
                                esc_html__('Login', 'cepatlakoo'),
                                esc_html__('Register', 'cepatlakoo'),
                                esc_html__('Filter', 'cepatlakoo'),
                              ),
			));

			$settings = array(
				'ajax_url'  		 => admin_url( 'admin-ajax.php' ),
				'cepatlakoo_path'  	 => esc_url( get_template_directory_uri() ),
			);
			wp_localize_script( 'cepatlakoo-functions', 'wc_ajax', $settings );

			// Init cepatlakoo prevent empty data for countdown
			wp_localize_script('cepatlakoo-functions', '_cepatlakoo', array());
			wp_localize_script( 'cepatlakoo-functions', '_fbpixel', array(
				'fbpixel' => !empty( $cl_options['cepatlakoo_facebook_pixel_id'] ) ? $cl_options['cepatlakoo_facebook_pixel_id'] : '',
			));
			wp_localize_script( 'cepatlakoo-functions', '_fbpixel_purchase', array());
			wp_localize_script( 'cepatlakoo-functions', '_fbpixel_initCheckout', array());

			// Load all CSS files
			wp_enqueue_style( 'cepatlakoo-reset', get_template_directory_uri() .'/css/reset.css', array(), false, 'all' );
			wp_enqueue_style( 'icomoon', get_template_directory_uri() .'/fonts/icomoon/style.css', array(), false, 'all' );
			wp_enqueue_style( 'magnific-popup-css', get_template_directory_uri() .'/css/magnific-popup.css', array(), false, 'all' );
			wp_enqueue_style( 'lightslider-css', get_template_directory_uri() .'/css/lightslider.css', array(), false, 'all' );
			wp_enqueue_style( 'owl-carousel', get_template_directory_uri() .'/css/owl.carousel.css', array(), false, 'all' );
			wp_enqueue_style( 'range', get_template_directory_uri() .'/css/jquery.range.css', array(), false, 'all' );
			wp_enqueue_style( 'custom-woocommerce', get_template_directory_uri() .'/css/woocommerce.css', array(), false, 'all' );
			wp_enqueue_style( 'foundation', get_template_directory_uri() .'/css/foundation.min.css', array(), false, 'all' );
			wp_enqueue_style( 'shop-woocommerce', get_template_directory_uri() .'/css/shop.css', array(), false, 'all' );
			wp_enqueue_style( 'cepatlakoo-style', get_template_directory_uri() .'/style.css', array(), false, 'all' );
			wp_enqueue_style( 'cepatlakoo-responsive', get_template_directory_uri() .'/css/responsive.css', array(), false, 'all' );

		}
	}
}
add_action( 'wp_enqueue_scripts', 'cepatlakoo_enqueue_scripts' );

/**
 * Function to load JS & CSS files in wp-admin
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_enquene_admin_scripts' ) ) {
	function cepatlakoo_enquene_admin_scripts($hook) {
		global $typenow;

		wp_enqueue_style( 'cepatlakoo-backend', get_template_directory_uri() .'/css/backend.css', array(), false, 'all' );
		wp_enqueue_script( 'sms-link', get_template_directory_uri() .'/js/sms-link.min.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'cepatlakoo-functions-admin', get_template_directory_uri() .'/js/functions-admin.js', array('jquery'), '1.0.0', true );

  	if ( $typenow != 'shop_order' ) {
		 	 wp_enqueue_script( 'cmb2-conditionals', get_template_directory_uri() .'/includes/cmb2-conditionals/cmb2-conditionals.js', array('jquery'), '1.0.0', true );
		}

		$settings = array(
			'ajax_url'  		 => admin_url( 'admin-ajax.php' ),
			'admin_url'			 => get_admin_url(),
			'texdomain'			 => array(
														esc_html('Migrasi Sukses, Terimakasih', 'cepatlakoo'),
														esc_html('Silahkan Install dan Aktifkan plugin Redux Framework', 'cepatlakoo'),
														esc_html('Plugin Berhasil Diaktifkan...', 'cepatlakoo'),
														esc_html('Plugin Gagal Diaktifkan...', 'cepatlakoo'),
													)
		);
		wp_localize_script( 'cepatlakoo-functions-admin', 'wpadmin_ajax', $settings );

	}
}
add_action( 'admin_enqueue_scripts', 'cepatlakoo_enquene_admin_scripts' );

/**
 * Manage WooCommerce styles and scripts.
 *
 * @package WordPress
 * @subpackage Etalase
 * @since Etalase 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_scripts_include_lightbox' ) ) {
	function cepatlakoo_scripts_include_lightbox() {
	  	global $woocommerce;
	  	if ( class_exists( 'WooCommerce' ) ) {
		  	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		}
		wp_dequeue_script('prettyPhoto');
		wp_dequeue_script('prettyPhoto-init');
	}
}
add_action( 'wp_enqueue_scripts', 'cepatlakoo_scripts_include_lightbox' );

/**
 * Function to load google fonts
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
// https://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/
if ( ! function_exists( 'cepatlakoo_slug_fonts_url' ) ) {
	function cepatlakoo_slug_fonts_url() {
		$fonts_url = '';

		/* Translators: If there are characters in your language that are not
		* supported by Lora, translate this to 'off'. Do not translate
		* into your own language.
		*/

		/* Translators: If there are characters in your language that are not
		* supported by Open Sans, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$cepatlakoo_montserrat = esc_html_x( 'on', 'Montserrat font: on or off', 'cepatlakoo' );

		if ( 'off' !== $cepatlakoo_montserrat ) {
			$font_families = array();

			if ( 'off' !== $cepatlakoo_montserrat ) {
				$font_families[] = 'Montserrat:400,700';
			}

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}
}

/**
 * Function to Enqueue scripts and styles google fonts
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_slug_scripts' ) ) {
	function cepatlakoo_slug_scripts() {
	    wp_enqueue_style( 'cepatlakoo-fonts', cepatlakoo_slug_fonts_url(), array(), null );
	}
}
add_action( 'wp_enqueue_scripts', 'cepatlakoo_slug_scripts' );

/**
 * Function to Inline Style Redux Framework
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_redux_inline_style' ) ) {
	function cepatlakoo_redux_inline_style() {
	    if( get_option('cepatlakoo_migration_themeoption') ) {
	    	global $cl_options;
	    	
			$cepatlakoo_general_theme_color = !empty( $cl_options['cepatlakoo_general_theme_color'] ) ? $cl_options['cepatlakoo_general_theme_color'] : '';
			$cepatlakoo_general_bg_theme_color = !empty( $cl_options['cepatlakoo_general_bg_theme_color'] ) ? $cl_options['cepatlakoo_general_bg_theme_color']['background-color'] : '';
?>
			<style>
	        .custom-shop-buttons i { color: <?php echo $cepatlakoo_general_theme_color; ?> }
	        .custom-shop-buttons { border-bottom: solid 2px <?php echo $cepatlakoo_general_theme_color; ?> !important; }
	        .woocommerce div.product .woocommerce-tabs ul.tabs li.active { border-bottom: solid 2px <?php echo $cepatlakoo_general_theme_color; ?> !important; }
	        .custom-shop-buttons > a:hover i { color: #fff !important }
	        .site-navigation ul.user-menu-menu li { color: #fff !important }

	        .page-template-template-blog #contentarea a.btn { border: <?php echo $cepatlakoo_general_bg_theme_color; ?> !important; }
	        @media screen and (max-width: 1024px) { .user-account-menu, .mobile-menu-menu-expander { background: <?php echo $cepatlakoo_general_bg_theme_color; ?> } }
	        .search-widget-header .search-widget { border-top: solid 2px <?php echo $cepatlakoo_general_bg_theme_color; ?> !important; }
	        #top-bar { background: <?php echo $cepatlakoo_general_bg_theme_color; ?> }
			</style>
<?php
	    }
	}
}
add_action( 'wp_head', 'cepatlakoo_redux_inline_style' );

?>
