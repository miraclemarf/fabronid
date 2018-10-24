<?php
/*
* Plugin Name: Cepatlakoo Kode Pembayaran
* Plugin URI: https://cepatlakoo.com
* Description: Kode Pembayaran plugin oleh Cepatlakoo.
* Author: Cepatlakoo
* Author URI: httsp://cepatlakoo.com
* Version: 1.1.4
* Text Domain: cepatlakoo-kode-pembayaran
* Domain Path: /languages
*/

session_id();

add_action('admin_menu', 'cepatlakoo_kode_pembayaran_menu'); // Add Menu
	if( ! function_exists('cepatlakoo_kode_pembayaran_menu') ) {
	function cepatlakoo_kode_pembayaran_menu() { //Function Add Menu
		add_submenu_page( 'woocommerce', 'CL Kode Pembayaran Options', 'CL Kode Pembayaran', 'manage_options', 'cepatlakoo_kode_pembayaran', 'clkp_init' );
	}}

add_action( 'admin_init', 'clkp_settings' ); // Function Register WP Settings
	if ( ! function_exists('clkp_settings') ) {
	function clkp_settings() {
		register_setting( 'cepatlakoo-kode-pembayaran', 'cepatlakoo_aktif' );
		register_setting( 'cepatlakoo-kode-pembayaran', 'cepatlakoo_metode' );
        register_setting( 'cepatlakoo-kode-pembayaran', 'cepatlakoo_metode_calculation' );
	}}

add_action( 'plugins_loaded', 'clkp_load_plugin_textdomain' ); //Function Load Text Domain
	if ( ! function_exists('clkp_load_plugin_textdomain') ) {
		function clkp_load_plugin_textdomain() {
			load_plugin_textdomain( 'cepatlakoo-kode-pembayaran', FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
		}
	}

if ( ! function_exists('clkp_init') ) :
	function clkp_init() { // Function Add Interface Backend Setting
		settings_errors(); ?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Cepatlakoo Kode Pembayaran','cepatlakoo-kode-pembayaran' ); ?></h2><hr>
			
			<p><?php _e('Kamu bisa setting plugin kode pembayaranmu disini','cepatlakoo-kode-pembayaran'); ?></p>

			<form method="post" action="options.php">
			    <?php settings_fields( 'cepatlakoo-kode-pembayaran' ); ?>
			    <?php do_settings_sections( 'cepatlakoo-kode-pembayaran' ); ?>
	            <?php $cepatlakoo_metode = get_option('cepatlakoo_metode'); ?>
	            <?php $cepatlakoo_metode_calculation = get_option('cepatlakoo_metode_calculation'); ?>

			    <table class="form-table">
			    	<tbody>
			    		<tr>
			    			<th scope="row"><?php esc_html_e( 'Aktifkan Plugin Cepatlakoo Kode Pembayaran?', 'cepatlakoo-kode-pembayaran' ); ?></th>
			    			<td>
			    				<label for="cepatlakoo_aktif">
	        						<input type="checkbox" id="cepatlakoo_aktif" name="cepatlakoo_aktif" <?php if ( get_option('cepatlakoo_aktif') == 1 ) echo 'checked="checked"'; ?> value="1" ><?php esc_html_e('Aktifkan', 'cepatlakoo-kode-pembayaran'); ?>
	        					</label>
			    			</td>
			    		</tr>
			    		<tr>
			    			<th scope="row"><?php esc_html_e( 'Metode Kode Pembayaran', 'cepatlakoo-kode-pembayaran' ); ?></th>
			    			<td>
			    				<select name="cepatlakoo_metode" id="cepatlakoo_metode" class="chosen_select enhanced" tabindex="-1" title="<?php esc_html_e('Metode Kode Pembayaran', 'cepatlakoo-kode-pembayaran' ); ?>">

									<option value="1" <?php if ( $cepatlakoo_metode == 1 ) : echo 'selected="selected"'; else: endif; ?>><?php esc_html_e( 'Acak', 'cepatlakoo-kode-pembayaran' ) ?></option>

									<option value="2" <?php if ( $cepatlakoo_metode == 2 ) : echo 'selected="selected"'; elseif( ! $cepatlakoo_metode ): echo 'selected="selected"'; endif;?>><?php esc_html_e( '3 Digit Terakhir No. Telepon', 'cepatlakoo-kode-pembayaran' ); ?></option>
								</select>
			    			</td>
			    		</tr>
	                    <tr>
	                        <th scope="row"><?php esc_html_e( 'Metode Perhitungan', 'cepatlakoo-kode-pembayaran' ); ?></th>
	                        <td>
	                            <select name="cepatlakoo_metode_calculation" id="cepatlakoo_metode_calculation" class="chosen_select enhanced" tabindex="-1" title="Metode Perhitungan">
	                                <option value="1" <?php if ( $cepatlakoo_metode_calculation == 1 ) : echo 'selected="selected"'; else: endif; ?>><?php esc_html_e('Menambah Total Belanja', 'cepatlakoo-kode-pembayaran') ?></option>
	                                <option value="2" <?php if ( $cepatlakoo_metode_calculation == 2 ) : echo 'selected="selected"'; elseif( ! $cepatlakoo_metode_calculation ): echo 'selected="selected"'; endif;?>><?php esc_html_e( 'Mengurangi Total Belanja', 'cepatlakoo-kode-pembayaran') ?></option>
	                            </select>
	                        </td>
	                    </tr>
			    	</tbody>
			    </table>
			    <?php submit_button(); ?>
			</form>
		</div>
	<?php } // close function ?>
<?php endif;

if ( ! function_exists( 'clkp_scripts' ) ) {
	function clkp_scripts() {
        if ( class_exists( 'WooCommerce' ) && is_checkout() && get_option('cepatlakoo_metode') == 2 ) {
			wp_enqueue_script( "cepatlakoo-kode-pembayaran", plugins_url('assets/js/cepatlakoo-kode-pembayaran.js', __FILE__), array('jquery') );
			wp_localize_script('cepatlakoo-kode-pembayaran', 'cepatlakooAjax', array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
			));
        }
	}
}
add_action( 'wp_footer', 'clkp_scripts' );

if ( ! function_exists( 'clkp_calculate_fee' ) ) {
	function clkp_calculate_fee() {
		global $woocommerce, $page;


		if( get_option('cepatlakoo_aktif') == 1 ) { //if plugin activate

			if ( is_admin() && ! defined( 'DOING_AJAX' ) )
			return;

			if ( class_exists( 'WooCommerce' ) && is_checkout() ) {
				if ( session_id() == '' ) session_start();
				
				if ( get_option('cepatlakoo_metode') == 2 ) { //if plugin activate
					if ( isset($_SESSION['kode_pembayaran'] ) && !empty($_SESSION['kode_pembayaran']) ){
						$surcharge = $_SESSION['kode_pembayaran'];
						$surchar[] = substr( $surcharge, -3 );
					} else {
						$surchar[0] = '0';
					}
					
					if ( get_option('cepatlakoo_metode_calculation') == 2 ) {
						$woocommerce->cart->add_fee( esc_html__( 'Kode Unik', 'cepatlakoo-kode-pembayaran' ), -$surchar[0], true, '' );
					} else {
						$woocommerce->cart->add_fee( esc_html__( 'Kode Unik', 'cepatlakoo-kode-pembayaran' ), $surchar[0], true, '' );
					}
				} else {
                	$get_cookie_ses = isset( $_COOKIE['PHPSESSID'] ) ? $_COOKIE['PHPSESSID'] : '';
	                $transient_name = 'cl_unique_code_'.$get_cookie_ses;
	                $unique_code_digit = get_transient( $transient_name );

	                if ( $unique_code_digit === false ) { // regenerate and cache
	                    $digits = 3;
	                    $unique_code_digit = rand( pow(10, $digits-1), pow(10, $digits)-1 );
	                    set_transient($transient_name, $unique_code_digit, 24 * HOUR_IN_SECONDS);
	                }

	                if ( get_option('cepatlakoo_metode_calculation') == 2 ) {
	                      $woocommerce->cart->add_fee( esc_html__( 'Kode Unik', 'cepatlakoo-kode-pembayaran' ), -$unique_code_digit, true, '' );
	                } else {
	                    $woocommerce->cart->add_fee( esc_html__( 'Kode Unik', 'cepatlakoo-kode-pembayaran' ), $unique_code_digit, true, '' );
	                }
				}
			}
		}
	}
}
add_action( 'woocommerce_cart_calculate_fees', 'clkp_calculate_fee' );

if ( ! function_exists( 'clkp_plugin_template' ) ) {
	function clkp_plugin_template( $template, $template_name, $template_path ) {
		global $woocommerce;
		$_template = $template;

		if ( ! $template_path ) {
			$template_path = $woocommerce->template_url;
		}

		$plugin_path  = untrailingslashit( plugin_dir_path( __FILE__ ) )  . '/template/woocommerce/';

		// Look within passed path within the theme - this is priority
		$template = locate_template(
			array(
				$template_path . $template_name,
				$template_name
			));

		if ( ! $template && file_exists( $plugin_path . $template_name ) ) {
			$template = $plugin_path . $template_name;
		}

		if ( ! $template ) {
			$template = $_template;
		}

		return $template;
	}
}
add_filter( 'woocommerce_locate_template', 'clkp_plugin_template', 1, 3 );


if ( ! function_exists( 'clkp_get_data' ) ) {
	function clkp_get_data() {
		$code = $_POST['kode_pembayaran'];
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		$_SESSION['kode_pembayaran'] = $code;
		return true;
	}
}
add_action('wp_ajax_nopriv_clkp_get_data', 'clkp_get_data');
add_action('wp_ajax_clkp_get_data', 'clkp_get_data');

if ( ! function_exists( 'clkp_custom_process_order' ) ) {
	function clkp_custom_process_order( $order_id ) {	
		$get_cookie_ses = isset( $_COOKIE['PHPSESSID'] ) ? $_COOKIE['PHPSESSID'] : '';
		$transient_name = 'cl_unique_code_'.$get_cookie_ses;
		$unique_code_digit = get_transient( $transient_name );
		
		if ( $unique_code_digit !== false ) {
			delete_transient( $transient_name );
		}

		if (session_status() != PHP_SESSION_NONE) {
		    $_SESSION['kode_pembayaran'] = 0;
		}
	}
}
add_action('woocommerce_thankyou', 'clkp_custom_process_order');
?>