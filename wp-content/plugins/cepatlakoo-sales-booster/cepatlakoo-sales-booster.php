<?php
/*************************
	* Plugin Name: Cepatlakoo - Sales Booster for WooCommerce
	* Plugin URI: https://cepatlakoo.com
	* Description: This is an extension for WooCommerce plugin, It will promote your recent sales and notify visitors about it. Forked from the original Woo Sales Notify plugin from alisaleem252
	* Version: 1.1.4
	* Author: Cepatlakoo
	* Author URI: https://cepatlakoo.com
	* Text Domain: cl-sales-booster
	* Domain Path: /languages
*
 _ |. _ _ | _  _  _ _ '~)L~'~)
(_|||_\(_||(/_(/_| | | /__) /_

*************************/
if ( ! defined( 'ABSPATH' ) ) exit;
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		function cl_salesbooster_settings_link( $links ) {
			$settings_link = '<a href="admin.php?page=cl_sales_booster">'. esc_html__( 'Settings', 'cl-sales-booster' ) .'</a>';
			array_unshift($links, $settings_link);
			return $links;
		}

		$plugin = plugin_basename(__FILE__);
		add_filter( 'plugin_action_links_$plugin', 'cl_salesbooster_settings_link' );

		/*Hook Some Action during Activation */
		register_activation_hook( __FILE__, 'cl_salesbooster_activation' );  //activation hook for Schedule hook

	    function cl_salesboosterer_load_plugin_textdomain() {
	    	$domain = 'cl-sales-booster';
	    	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
	    	// wp-content/languages/plugin-name/plugin-name-de_DE.mo
	    	load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
	    	// wp-content/plugins/plugin-name/languages/plugin-name-de_DE.mo
	    	load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	    }
	    add_action( 'init', 'cl_salesboosterer_load_plugin_textdomain' );

    	function cl_salesbooster_activation() {
			$schedule = get_option( 'schedulevalue' );
			wp_schedule_event( time(), $schedule, 'prefix_'.$schedule.'_event_hook' );
			cl_create_salesbooster();
			add_option( 'cl_enable_salesbooster', 'yes', '', 'yes' );
		} //close function

		define('WOOBOASTERPATH', dirname(__FILE__) );
		// First Check if WooCommerce Is Active

		require_once( WOOBOASTERPATH.'/inc/filejson.php' );
		require_once( WOOBOASTERPATH.'/init.php' );
		
	} else {
		function cl_salesbooster_admin_notice() {
	    ?>
	    <div class="error">
	        <p><?php esc_html_e( 'Cepatlakoo Sales Booster is an Extension to WooCommerce. Please activate WooCommerce first!', 'cl-sales-booster' ); ?></p>
	    </div>
	    <?php
	}
	add_action( 'admin_notices', 'cl_salesbooster_admin_notice' );
}
?>