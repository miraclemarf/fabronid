<?php
/**
 * Plugin Name: WPBisnis - WooCommerce Indo Ongkir
 * Plugin URI: http://www.wpbisnis.com/item/woocommerce-indo-ongkir
 * Description: WPBisnis - WooCommerce Indo Ongkir
 * Version: 1.0.1
 * Author: Agus Muhammad (WPBisnis)
 * Author URI: http://www.wpbisnis.com
 * Copyright: 2017-2018 WPBisnis
 * 
 * 
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * 
 * 
 * This plugin incorporates codes from:
 * 
 * 1) WooCommerce
 * Copyright WooCommerce
 * GPL v3 license
 * @link https://github.com/woocommerce/woocommerce
 * 
 * 2) WooCommerce Australia Post Shipping Method
 * Copyright WooCommerce
 * GPL v3 license
 * @link https://woocommerce.com/products/australia-post-shipping-method/
 * 
 * 3) WooCommerce Shipment Tracking
 * Copyright WooCommerce
 * GPL v3 license
 * @link https://woocommerce.com/products/shipment-tracking/
 * 
 * 4) MyOngkir
 * Copyright eezhal
 * MIT license
 * @link https://github.com/eezhal92/myongkir
 * 
 * 5) LandingPress WC Ongkir
 * Copyright LandingPress
 * GPL v3 license
 * @link http://www.landingpress.net/
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !defined( 'WPBISNIS_WC_INDO_ONGKIR_NAME' ) ) {
	define( 'WPBISNIS_WC_INDO_ONGKIR_NAME', 'WooCommerce Indo Ongkir WordPress Plugin' );
}
if ( !defined( 'WPBISNIS_WC_INDO_ONGKIR_ID' ) ) {
	define( 'WPBISNIS_WC_INDO_ONGKIR_ID', 6974 );
}
if ( !defined( 'WPBISNIS_WC_INDO_ONGKIR_STORE' ) ) {
	define( 'WPBISNIS_WC_INDO_ONGKIR_STORE', 'http://www.wpbisnis.com' );
}
if ( !defined( 'WPBISNIS_WC_INDO_ONGKIR_PATH' ) ) {
	define( 'WPBISNIS_WC_INDO_ONGKIR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'WPBISNIS_WC_INDO_ONGKIR_URL' ) ) {
	define( 'WPBISNIS_WC_INDO_ONGKIR_URL', plugins_url( '', __FILE__ ) );
}
if ( !defined( 'WPBISNIS_WC_INDO_ONGKIR_VERSION' ) ) {
	define( 'WPBISNIS_WC_INDO_ONGKIR_VERSION', '1.0.1' );
}
if ( !defined( 'WPBISNIS_WC_INDO_ONGKIR_PLUGIN' ) ) {
	define( 'WPBISNIS_WC_INDO_ONGKIR_PLUGIN', true );
}

if ( WPBISNIS_WC_INDO_ONGKIR_PLUGIN ) {
	if( !class_exists( 'WPBisnis_WC_Indo_Ongkir_Updater' ) ) {
		include( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-updater.php' );
	}
}

if( !class_exists( 'WPBisnis_WC_Indo_Ongkir_Init' ) ) {

class WPBisnis_WC_Indo_Ongkir_Init {

	private static $instance;

	private $api_url = 'http://ongkir.wpbisnis.com/api/';

	public static function get_instance() {
		return null === self::$instance ? ( self::$instance = new self ) : self::$instance;
	}

	public function __construct() {
		if ( function_exists( 'WC' ) ) {
			define("WPBISNIS_WC_INDO_ONGKIR_NONCE", "wpbisnis-wc-indo-ongkir-nonce");
			add_action( 'init', array( $this, 'load_textdomain' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'add_plugin_links' ) );
			add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_tab' ), 50 );
			add_action( 'woocommerce_settings_tabs_indo_ongkir', array( $this, 'settings_tab' ) );
			add_action( 'woocommerce_update_options_indo_ongkir', array( $this, 'update_settings' ) );
			add_action( 'woocommerce_admin_field_wpbisnis_wc_indo_ongkir_system_status', array( $this, 'system_status' ) );
			add_action( 'woocommerce_admin_field_wpbisnis_wc_indo_ongkir_license', array( $this, 'license_option' ) );
			add_action( 'woocommerce_admin_field_wpbisnis_wc_indo_ongkir_transient', array( $this, 'transient_option' ) );
			add_action( 'admin_head', array( $this, 'admin_inline_style' ) );
			if ( $this->is_active() ) {
				add_action( 'admin_notices', array( $this, 'check_requirements' ) );
				add_action( 'admin_init', array( $this, 'updater' ), 0 );
				add_action( 'woocommerce_checkout_billing', array( $this, 'enqueue_scripts' ) );
				// add_action( 'woocommerce_checkout_shipping', array( $this, 'enqueue_scripts' ) );
				add_action( 'woocommerce_after_edit_account_address_form', array( $this, 'enqueue_scripts' ) );
				add_action( 'woocommerce_shipping_init', array( $this, 'shipping_init' ) );
				add_filter( 'woocommerce_shipping_methods', array( $this, 'shipping_methods' ) );
				add_filter( 'woocommerce_get_country_locale', array( $this, 'country_locale' ) );
				add_filter( 'woocommerce_country_locale_field_selectors', array( $this, 'country_locale_field_selectors' ) );
				add_filter( 'woocommerce_default_address_fields', array( $this, 'address_fields' ) );
				add_filter( 'woocommerce_billing_fields' , array( $this, 'billing_fields' ) );
				add_filter( 'woocommerce_shipping_fields' , array( $this, 'shipping_fields' ) );
				add_filter( 'woocommerce_checkout_fields' , array( $this, 'checkout_fields' ) );
				add_filter( 'default_checkout_billing_country' , array( $this, 'checkout_billing_country' ) );
				add_filter( 'default_checkout_billing_state' , array( $this, 'checkout_billing_state' ) );
				add_filter( 'default_checkout_shipping_country' , array( $this, 'checkout_shipping_country' ) );
				add_filter( 'default_checkout_shipping_state' , array( $this, 'checkout_shipping_state' ) );
				add_action( 'wp_ajax_indo_ongkir_kota', array( $this, 'get_ajax_kota' ) );
				add_action( 'wp_ajax_nopriv_indo_ongkir_kota', array( $this, 'get_ajax_kota' ) );
				add_action( 'wp_ajax_indo_ongkir_kecamatan', array( $this, 'get_ajax_kecamatan' ) );
				add_action( 'wp_ajax_nopriv_indo_ongkir_kecamatan', array( $this, 'get_ajax_kecamatan' ) );
				add_filter( 'woocommerce_package_rates', array( $this, 'free_shipping' ), 100 );
				add_filter( 'woocommerce_cart_shipping_packages', array( $this, 'shipping_packages') );
				add_filter( 'woocommerce_shipping_package_name', array( $this, 'package_name'), 10, 3 );
				add_action( 'woocommerce_checkout_create_order_shipping_item', array( $this, 'order_shipping'), 10, 4 );
				add_filter( 'woocommerce_order_shipping_to_display_shipped_via', array( $this, 'shipped_via' ) );
				add_action( 'woocommerce_product_options_shipping', array( $this, 'add_origin_meta') );
				add_action( 'woocommerce_process_product_meta', array( $this, 'save_origin_meta') );
				add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
				add_action( 'save_post', array( $this, 'save_meta_box' ), 0, 2 );
				add_action( 'woocommerce_view_order', array( $this, 'display_resi_myaccount' ), 5 );
				add_action( 'woocommerce_email_before_order_table', array( $this, 'display_resi_email' ), 5, 3 );
				add_action( 'wp', array( $this, 'fix_woocommerce' ) );
				add_action( 'wp_head', array( $this, 'wp_inline_style' ), 100 );
			}
		} 
		else {
			add_action( 'admin_notices', array( $this, 'install_woocommerce' ) );
		}
	}

	public function load_textdomain() {
		if ( ! WPBISNIS_WC_INDO_ONGKIR_PLUGIN ) {
			return;
		}
		load_plugin_textdomain( 'wpbisnis-wc-indo-ongkir', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	public function add_plugin_links( $links ) {
		$plugin_links = array(
			'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=indo_ongkir' ) . '">' . __( 'Settings', 'wpbisnis-wc-indo-ongkir' ) . '</a>',
			'<a href="http://www.wpbisnis.com/support/">' . __( 'Support', 'wpbisnis-wc-indo-ongkir' ) . '</a>',
		);
		return array_merge( $plugin_links, $links );
	}

	public function is_active() {

		if ( version_compare( WC_VERSION, '3.0.0', '<' ) )
			return false;

		$shipping = wc_shipping_enabled();
		if ( ! $shipping )
			return false;

		$location = wc_get_base_location();
		if ( ! ( isset( $location['country'] ) && $location['country'] == 'ID' ) )
			return false;
		
		$currency = get_woocommerce_currency();
		if ( $currency != 'IDR' )
			return false;

		if ( WPBISNIS_WC_INDO_ONGKIR_PLUGIN ) {
			$license_status = get_option( 'wpbisnis_wc_indo_ongkir_license_status' );
			if ( ! ( isset( $license_status->license ) && $license_status->license == 'valid' ) )
				return false;
		}
		else {
			$license_status = get_option( get_template().'_license_key_status' );
			if ( $license_status != 'valid' )
				return false;
		}

		return true;
	}

	public function check_requirements() {
		if ( version_compare( WC_VERSION, '3.0.0', '<' ) ) {
			echo '<div class="error"><p>'.esc_html__( 'WooCommerce Indo Ongkir membutuhkan WooCommerce versi 3.0 ke atas untuk dapat digunakan.', 'wpbisnis-wc-indo-ongkir' ).'</p></div>';
		}
		if ( ! wc_shipping_enabled() ) {
			return;
		}
		$link = admin_url('admin.php?page=wc-settings&tab=general');
		if ( 'ID' !== WC()->countries->get_base_country() ) {
			echo '<div class="error"><p>'.esc_html__( 'WooCommerce Indo Ongkir membutuhkan negara asal Indonesia (ID) untuk dapat digunakan.', 'wpbisnis-wc-indo-ongkir' ).' <a href="'.admin_url('admin.php?page=wc-settings&tab=general').'">Perbaiki Sekarang!</a></p></div>';
		}
		if ( 'IDR' !== get_woocommerce_currency() ) {
			echo '<div class="error"><p>'.esc_html__( 'WooCommerce Indo Ongkir membutuhkan mata uang Rupiah (IDR) untuk dapat digunakan.', 'wpbisnis-wc-indo-ongkir' ).' <a href="'.admin_url('admin.php?page=wc-settings&tab=general').'">Perbaiki Sekarang!</a></p></div>';
		}
	}

	public function install_woocommerce() {
		echo '<div class="error"><p>'.esc_html__( 'WooCommerce Indo Ongkir membutuhkan plugin WooCommerce untuk dapat digunakan.', 'wpbisnis-wc-indo-ongkir' ).' <a href="'.admin_url('plugin-install.php').'">Install dan Aktifkan WooCommerce Sekarang!</a></p></div>';
	}


	public function add_settings_tab( $settings_tabs ) {
		$settings_tabs['indo_ongkir'] = __( 'Indo Ongkir', 'wpbisnis-wc-indo-ongkir' );
		return $settings_tabs;
	}

	public function settings_tab() {
		woocommerce_admin_fields( $this->get_settings() );
	}

	public function update_settings() {
		woocommerce_update_options( $this->get_settings() );
		if ( isset( $_POST['wpbisnis_wc_indo_ongkir_license'] ) ) {
			$license = trim( $_POST['wpbisnis_wc_indo_ongkir_license'] );
			update_option( 'wpbisnis_wc_indo_ongkir_license', $license, 'yes' );
		}
		if ( isset( $_POST['wpbisnis_wc_indo_ongkir_activate'] ) ) {
			$this->activate_license();
		}
		if ( isset( $_POST['wpbisnis_wc_indo_ongkir_deactivate'] ) ) {
			$this->deactivate_license();
			delete_option( 'wpbisnis_wc_indo_ongkir_license' );
		}
		if ( isset( $_POST['wpbisnis_wc_indo_ongkir_transient_clear'] ) ) {
			delete_transient( 'wpbisnis_wc_indo_ongkir_jne' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_tiki' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_pos' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_jnt' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_sicepat' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_wahana' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_indah' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_rpx' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_pandu' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_pahala' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_cahaya' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_dse' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_first' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_jet' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_ncs' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_nss' );
			delete_transient( 'wpbisnis_wc_indo_ongkir_sap' );
			global $wpbisnis_wc_indo_ongkir_transient_message;
			$wpbisnis_wc_indo_ongkir_transient_message = __( 'Cache data ongkir berhasil dihapus...', 'wpbisnis-wc-indo-ongkir' );
		}
	}

	public function get_settings() {
		$message = '';
		$message .= '<div class="wpbisnis-indo-ongkir-message"><div class="wpbisnis-indo-ongkir-message-inner">';
		$message .= '<div class="wpbisnis-indo-ongkir-message-icon">';
		$message .= '<span class="dashicons dashicons-cart"></span>';
		$message .= '</div>';
		$message .= '<div class="wpbisnis-indo-ongkir-message-button">';
		$message .= '<a href="'.admin_url('admin.php?page=wc-settings&tab=shipping').'" class="button button-primary">'.esc_html__( 'Go To Shipping Zones', 'wpbisnis-wc-indo-ongkir' ).'</a>';
		$message .= '</div>';
		$message .= '<strong>'.esc_html__( 'Selamat Datang di WPBisnis WooCommerce Indo Ongkir.', 'wpbisnis-wc-indo-ongkir' ).'</strong> '.esc_html__( 'Setelah IndoOngkir aktif, silahkan ke halaman Shipping - Shipping Zones untuk mengatur modul pengiriman ke masing-masing daerah yang diinginkan.', 'wpbisnis-wc-indo-ongkir' );
		$message .= '</div></div>';
		$message .= '<div class="wpbisnis-indo-ongkir-message"><div class="wpbisnis-indo-ongkir-message-inner">';
		$message .= '<div class="wpbisnis-indo-ongkir-message-icon">';
		$message .= '<span class="dashicons dashicons-video-alt3"></span>';
		$message .= '</div>';
		$message .= '<div class="wpbisnis-indo-ongkir-message-button">';
		$message .= '<a href="http://www.wpbisnis.com/knowledgebase_category/woocommerce-indo-ongkir-plugin/" class="button button-secondary" target="_blank">'.esc_html__( 'Lihat Video Tutorial', 'wpbisnis-wc-indo-ongkir' ).'</a>';
		$message .= '</div>';
		$message .= '<strong>'.esc_html__( 'Bingung atau belum pernah menggunakan WooCommerce Shipping Zones?', 'wpbisnis-wc-indo-ongkir' ).'</strong> '.esc_html__( 'Silahkan lihat video tutorial WooCommerce Indo Ongkir yang sudah sangat komplit.', 'wpbisnis-wc-indo-ongkir' );
		$message .= '</div></div>';
		$message .= '<div class="wpbisnis-indo-ongkir-message"><div class="wpbisnis-indo-ongkir-message-inner">';
		$message .= '<div class="wpbisnis-indo-ongkir-message-icon">';
		$message .= '<span class="dashicons dashicons-megaphone"></span>';
		$message .= '</div>';
		$message .= '<div class="wpbisnis-indo-ongkir-message-button">';
		$message .= '<a href="http://www.wpbisnis.com/support/" class="button button-secondary" target="_blank">'.esc_html__( 'Laporkan Data Ongkir', 'wpbisnis-wc-indo-ongkir' ).'</a>';
		$message .= '</div>';
		$message .= '<strong>'.esc_html__( 'PENTING! Tidak ada jaminan data ongkir 100% lengkap dan akurat.', 'wpbisnis-wc-indo-ongkir' ).'</strong> '.esc_html__( 'Silahkan laporkan ke kami jika Anda menemukan data ongkir yang tidak tersedia atau tidak akurat disertai screenshot ongkir dari web ekspedisi.', 'wpbisnis-wc-indo-ongkir' );
		$message .= '</div></div>';
		$settings = array(
			array(
				'name'     => __( 'Indo Ongkir', 'wpbisnis-wc-indo-ongkir' ),
				'type'     => 'title',
				'desc'     => $message,
				'id'       => 'wpbisnis_wc_indo_ongkir_section_title',
			),
			array(
				'type'     => 'wpbisnis_wc_indo_ongkir_license',
			),
			array(
				'title'    => __( 'Kota Asal Pengiriman', 'wpbisnis-wc-indo-ongkir' ),
				'desc'     => '<br/>'.
					__( 'Penting untuk diingat, tidak semua kota mempunyai data ongkir untuk semua ekspedisi pengiriman.', 'wpbisnis-wc-indo-ongkir' ),
				'id'       => 'wpbisnis_wc_indo_ongkir_origin',
				'class'    => 'wc-enhanced-select',
				'css'      => 'min-width:300px;',
				'default'  => '151',
				'type'     => 'select',
				'options'  => $this->get_origin_options( array( '' => __( 'Pilih Kota Asal Pengiriman...', 'wpbisnis-wc-indo-ongkir' ) ) ),
				'autoload' => true,
			),
			array(
				'title'    => __( 'Mode Multi Origin', 'wpbisnis-wc-indo-ongkir' ),
				'desc'     => '<span class="description">'.
					__( 'Kami menyediakan beberapa macam mode multi origin yang dapat disesuaikan dengan kebutuhan.', 'wpbisnis-wc-indo-ongkir' ).
					' <br/> '.
					'<strong>1) City Mode</strong>, '.__( 'cocok untuk supplier, ongkir dihitung untuk setiap kota asal pengiriman yang berbeda.', 'wpbisnis-wc-indo-ongkir' ).
					' <br/> '.
					'<strong>2) Product Mode</strong>, '.__( 'cocok untuk dropshipper, ongkir dihitung untuk setiap produk yang berbeda.', 'wpbisnis-wc-indo-ongkir' ).
					' <br/> '.
					'<strong>3) Vendor Mode</strong>, '.__( 'cocok untuk toko online tipe marketplace, saat ini belum tersedia.', 'wpbisnis-wc-indo-ongkir' ).
					' <br/> '.
					' <br/> '.
					'</span>',
				'id'       => 'wpbisnis_wc_indo_ongkir_multi_origin',
				'default'  => 'city',
				'type'     => 'radio',
				'options'  => array( 
					'city' => 'City Mode',
					'product' => 'Product Mode',
				),
				'autoload' => true,
			),
			array(
				'title'    => __( 'Pembagi Berat Volumetrik', 'wpbisnis-wc-indo-ongkir' ),
				'desc'     => '<br/>'.
					__( 'Jika produk mempunyai ukuran panjang,lebar,tinggi, maka berat volumetrik dihitung dengan rumus sebagai berikut:', 'wpbisnis-wc-indo-ongkir' ).
					' <br/> '.
					'<strong>'.
					__( 'berat volumetrik = panjang x lebar x tinggi / 5000 x 1kg', 'wpbisnis-wc-indo-ongkir' ).
					'</strong>'.
					' <br/> '.
					__( 'Faktor pembagi 5000 adalah standard tengah, anda bisa merubahnya ke 4000 atau 6000 sesuai kebijakan dari ekspedisi.', 'wpbisnis-wc-indo-ongkir' ).
					' <br/> '.
					__( 'Jika berat volumetrik lebih besar daripada berat produk, maka berat volumetrik yang akan digunakan untuk perhitungan ongkir.', 'wpbisnis-wc-indo-ongkir' ),
				'id'       => 'wpbisnis_wc_indo_ongkir_volumetrik',
				'default'  => '5000',
				'type'     => 'number',
				'autoload' => true,
			),
			array(
				'title'    => __( 'Link Halaman Cek Resi', 'wpbisnis-wc-indo-ongkir' ),
				'desc'     => '<br/>'.
					__( 'Defaut halaman cek resi:', 'wpbisnis-wc-indo-ongkir' ).
					' <strong>http://www.cekresi.com/?noresi=%noresi%</strong>'.
					' <br/> '.
					__( 'Silahkan ganti dengan link lain jika Anda mempunyai halaman cek resi sendiri atau halaman yang berisi petunjuk bagaimana cara cek resi untuk pembeli Anda.', 'wpbisnis-wc-indo-ongkir' ),
				'id'       => 'wpbisnis_wc_indo_ongkir_cekresi',
				'default'  => '',
				'placeholder' => 'http://www.cekresi.com/?noresi=%noresi%',
				'type'     => 'text',
				'autoload' => true,
			),
			array(
				'title'    => __( 'Metode Akses Data Ongkir', 'wpbisnis-wc-indo-ongkir' ),
				'desc'     => '<br/>'.
					__( 'Kami menyediakan dua macam metode untuk mengakses data ongkir di server ongkir WPBisnis.', 'wpbisnis-wc-indo-ongkir' ).
					' <br/> '.
					__( 'Silahkan pilih metode yang di-support penuh oleh server hosting Anda dan mana yang lebih cepat.', 'wpbisnis-wc-indo-ongkir' ).
					' <br/> '.
					__( 'Cek bagian Status Sistem di bawah untuk mengetahui metode mana yang dapat digunakan.', 'wpbisnis-wc-indo-ongkir' ),
				'id'       => 'wpbisnis_wc_indo_ongkir_mode',
				'default'  => 'wp_remote_post',
				'type'     => 'select',
				'options'  =>  array( 
						'wp_remote_post' => 'wp_remote_post',
						'file_get_contents' => 'file_get_contents',
					),
				'autoload' => true,
			),
			array(
				'type'     => 'wpbisnis_wc_indo_ongkir_transient',
			),
			array(
				'title'         => __( 'JS Debug Mode', 'wpbisnis-wc-indo-ongkir' ),
				'desc'          => __( 'Aktifkan mode debug di javascript console log', 'wpbisnis-wc-indo-ongkir' ).'<span class="description"><br/>'.__( 'Fitur ini bermanfaat untuk troubleshooting jika ada masalah di javascript.', 'wpbisnis-wc-indo-ongkir' ).'</span>',
				'id'            => 'wpbisnis_wc_indo_ongkir_debug_console',
				'default'       => '',
				'type'          => 'checkbox',
				'autoload'      => true,
			),
			array(
				'type' => 'sectionend',
				'id' => 'wpbisnis_wc_indo_ongkir_section_end'
			),
			array(
				'name'     => __( 'Status Sistem', 'wpbisnis-wc-indo-ongkir' ),
				'type'     => 'title',
				'desc'     => 'Catatan Penting: <span style="color:#27ae60;font-weight:bold;">Hijau</span> = OK, <span style="color:#a00;font-weight:bold;">Merah</span> = Tidak OK. Simple!',
				'id'       => 'wpbisnis_wc_indo_ongkir_section_status',
			),
			array(
				'type'     => 'wpbisnis_wc_indo_ongkir_system_status',
			),
			array(
				'type' => 'sectionend',
				'id' => 'wpbisnis_wc_indo_ongkir_section_end'
			),
		);

		return apply_filters( 'wc_settings_tab_indo_ongkir_settings', $settings );
	}

	public function license_option() {
		if ( ! WPBISNIS_WC_INDO_ONGKIR_PLUGIN ) {
			return;
		}

		$license = trim( get_option( 'wpbisnis_wc_indo_ongkir_license' ) );
		$this->check_license();
		$license_status = get_option( 'wpbisnis_wc_indo_ongkir_license_status' );
?>
<tr valign="top">
	<th scope="row" class="titledesc">
		<label><?php _e( 'Lisensi', 'wpbisnis-wc-indo-ongkir' ); ?></label>
	</th>
	<td class="forminp forminp-text">
		<?php if ( isset( $license_status->license ) && ( $license_status->license == 'valid' || $license_status->license == 'expired' || $license_status->license == 'no_activations_left' ) ) : ?>
			<?php 
			$expires = '';
			if ( isset( $license_status->expires ) && 'lifetime' != $license_status->expires ) {
				$expires = ', hingga '.date_i18n( get_option( 'date_format' ), strtotime( $license_status->expires, current_time( 'timestamp' ) ) );
			} 
			elseif ( isset( $license_status->expires ) && 'lifetime' == $license_status->expires ) {
				$expires = ', lifetime';
			}
			$site_count = $license_status->site_count;
			$license_limit = $license_status->license_limit;
			if ( 0 == $license_limit ) {
				$license_limit = ', unlimited';
			}
			elseif ( $license_limit > 1 ) {
				$license_limit = ', sudah dipakai di '.$site_count.' website dari limit '.$license_limit.' website';
			}
			if ( $license_status->license == 'expired' ) {
				$renew_link = '<br/><a href="'.WPBISNIS_WC_INDO_ONGKIR_STORE.'/checkout/?edd_license_key=' . $license . '&download_id=' . WPBISNIS_WC_INDO_ONGKIR_ID.'" target="_blank">&rarr; klik di sini untuk perpanjang lisensi &larr;</a>';
			}
			?>
			<input name="wpbisnis_wc_indo_ongkir_license_hidden" id="wpbisnis_wc_indo_ongkir_license_hidden" type="text" style="min-width:300px;" value="<?php echo $this->get_hidden_license( $license ); ?>" class="" placeholder="" disabled> <input name="wpbisnis_wc_indo_ongkir_deactivate" class="button" type="submit" value="Deactivate">
			<?php if ( $license_status->license == 'valid' ) : ?>
				<span class="description indo-ongkir-yes">
					<br/>
					<?php echo '<strong>'.$license_status->license.'</strong>'.$expires.$license_limit; ?>
				</span>
			<?php elseif ( $license_status->license == 'expired' ) : ?>
				<span class="description indo-ongkir-error">
					<br/>
					<?php echo '<strong>'.$license_status->license.'</strong>'.$expires.$license_limit; ?>
				</span>
				<?php echo $renew_link; ?>
			<?php elseif ( $license_status->license == 'no_activations_left' ) : ?>
				<span class="description indo-ongkir-error">
					<br/>
					<?php echo '<strong>lisensi habis</strong>'.$license_limit; ?>
				</span>
			<?php endif; ?>
		<?php else : ?>
			<input name="wpbisnis_wc_indo_ongkir_license" id="wpbisnis_wc_indo_ongkir_license" type="text" style="min-width:300px;" value="<?php echo $license; ?>" class="" placeholder=""> <input name="wpbisnis_wc_indo_ongkir_activate" class="button-primary" type="submit" value="Activate">
			<span class="description">
				<?php if ( $license && isset( $license_status->license ) ) : ?>
					<br/>
					<span class="indo-ongkir-error">
						Status lisensi: <?php echo '<strong>'.$license_status->license.'</strong>'; ?>
					</span>
				<?php endif; ?>
				<?php echo '<br/>'.sprintf( __( 'Harap masukkan kode lisensi plugin indo ongkir yang benar. %s Kode lisensi bisa ditemukan di halaman %s My Account - WPBisnis %s', 'wpbisnis-wc-indo-ongkir' ), '<br/>', '<a href="'.esc_url('www.wpbisnis.com/account/').'" target="_blank"><strong>', '</strong></a>' ); ?>
			</span>
		<?php endif; ?>
	</td>
</tr>
<?php 
	}

	public function transient_option() {
?>
<tr valign="top">
	<th scope="row" class="titledesc">
		<label><?php _e( 'Cache Data Ongkir', 'wpbisnis-wc-indo-ongkir' ); ?></label>
	</th>
	<td class="forminp forminp-text">
		<style>
			.indo-ongkir-yes{ background: none; color: #27ae60; } 
			.indo-ongkir-error{ background: none; color: #a00; }
			span.description{ display: block; }
			@media screen and (min-width: 783px) {
				.form-table th { width: 250px; }
			}
		</style>
		<input name="wpbisnis_wc_indo_ongkir_transient_clear" class="button" type="submit" value="Hapus Cache Data Ongkir">
		<?php global $wpbisnis_wc_indo_ongkir_transient_message; ?>
		<?php if ( $wpbisnis_wc_indo_ongkir_transient_message ) : ?>
			<br/>
			<span class="description indo-ongkir-error">
				<?php echo '<strong>'.$wpbisnis_wc_indo_ongkir_transient_message.'</strong>'; ?>
			</span>
		<?php endif; ?>
		<span class="description">
		<?php echo '<br/>'.
				__( 'Kami menggunakan teknologi transient di WordPress untuk menyimpan data ongkir yang sudah pernah diakses.', 'wpbisnis-wc-indo-ongkir' ).
				' <br/> '.
				__( 'Hal ini bertujuan untuk mempercepat loading data ongkir tanpa harus terhubung ke server WPBisnis terus menerus.', 'wpbisnis-wc-indo-ongkir' ); ?>
		</span>
	</td>
</tr>
<?php 
	}

	private function get_hidden_license( $license ) {
		if ( !$license )
			return $license;
		$start = substr( $license, 0, 5 );
		$finish = substr( $license, -5 );
		$license = $start.'xxxxxxxxxxxxxxxxxxxx'.$finish;
		return $license;
	}

	public function system_status() {
		$ping_url = trailingslashit( $this->api_url ) . 'ping/';
		$postdata = array(
			'ping'          => 'yes',
		);
		$wrp_response = wp_remote_post( $ping_url, array(
			'body' => $postdata
		) );
		$wrp_status = false;
		if ( is_wp_error( $wrp_response ) ) {
			$wrp_status = false;
			$wrp_message = 'gagal, pesan error: <strong>'.$wrp_response->get_error_message().'</strong>, metode wp_remote_post TIDAK bisa digunakan untuk mengakses data ongkir';
		}
		else {
			if ( $wrp_response['response']['code'] >= 200 && $wrp_response['response']['code'] < 300 && $wrp_response['body'] == 'yes' ) {
				$wrp_status = true;
				$wrp_message = 'sukses, metode wp_remote_post bisa digunakan untuk mengakses data ongkir';
			}
			else {
				$wrp_status = false;
				$wrp_message = 'gagal, status code: '.$wrp_response['response']['code'].', metode wp_remote_post TIDAK bisa digunakan untuk mengakses data ongkir';
			}
		}
		// var_dump( $wrp_status );
		// var_dump( $wrp_message );
		// var_dump( $wrp_response['body'] );
		$fgc_opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
		 		'content' => http_build_query( $postdata )
			),
		);
		$fgc_context = stream_context_create( $fgc_opts );
		$fgc_result = @file_get_contents( $ping_url, false, $fgc_context );
		// echo $fgc_result;
		$fgc_status = false;
		if ( trim( $fgc_result ) == 'yes' ) {
			$fgc_status = true;
			$fgc_message = 'sukses, metode file_get_contents bisa digunakan untuk mengakses data ongkir';
		}
		else {
			$fgc_status = false;
			$fgc_message = 'gagal, metode file_get_contents TIDAK bisa digunakan untuk mengakses data ongkir';
		}
		$server_status = $this->check_server();
		$ongkir_mode = get_option( 'wpbisnis_wc_indo_ongkir_mode' );
		if ( !$ongkir_mode ) {
			$ongkir_mode = 'wp_remote_post';
		}
?>
<tr valign="top">
	<th scope="row" class="titledesc" style="padding-top:0;">
		<label><?php _e( 'Negara Asal (Base Country)', 'wpbisnis-wc-indo-ongkir' ); ?></label>
	</th>
	<td class="forminp forminp-text" style="padding-top:0;">
		<?php $base_country = WC()->countries->get_base_country(); ?>
		<?php if ( $base_country == 'ID' ) : ?>
			<mark class="indo-ongkir-yes"><span class="dashicons dashicons-yes"></span> <strong><?php echo WC()->countries->countries[$base_country]; ?></strong></mark> 
		<?php else : ?>
			<mark class="indo-ongkir-error"><span class="dashicons dashicons-warning"></span> <strong><?php echo WC()->countries->countries[$base_country]; ?></strong></mark> 
		<?php endif; ?>
		<a href="<?php echo admin_url('admin.php?page=wc-settings&tab=general'); ?>"><?php _e( 'Edit', 'wpbisnis-wc-indo-ongkir' ); ?></a>
	</td>
</tr>
<tr valign="top">
	<th scope="row" class="titledesc" style="padding-top:0;">
		<label><?php _e( 'Mata Uang (Currency)', 'wpbisnis-wc-indo-ongkir' ); ?></label>
	</th>
	<td class="forminp forminp-text" style="padding-top:0;">
		<?php $currency = get_woocommerce_currency(); ?>
		<?php $currencies = get_woocommerce_currencies(); ?>
		<?php if ( $currency == 'IDR' ) : ?>
			<mark class="indo-ongkir-yes"><span class="dashicons dashicons-yes"></span> <?php echo $currencies[$currency]; ?> (<strong><?php echo get_woocommerce_currency_symbol(); ?></strong>)</mark> 
		<?php else : ?>
			<mark class="indo-ongkir-error"><span class="dashicons dashicons-warning"></span> <?php echo $currencies[$currency]; ?> (<strong><?php echo get_woocommerce_currency_symbol(); ?></strong>)</mark>
		<?php endif; ?>
		<a href="<?php echo admin_url('admin.php?page=wc-settings&tab=general'); ?>"><?php _e( 'Edit', 'wpbisnis-wc-indo-ongkir' ); ?></a>
	</td>
</tr>
<tr valign="top">
	<th scope="row" class="titledesc" style="padding-top:0;">
		<label><?php _e( 'Satuan Berat (Weight Unit)', 'wpbisnis-wc-indo-ongkir' ); ?></label>
	</th>
	<td class="forminp forminp-text" style="padding-top:0;">
		<?php $weight_unit = get_option('woocommerce_weight_unit'); ?>
		<?php if ( $weight_unit == 'g' ) : ?>
			<mark class="indo-ongkir-yes"><span class="dashicons dashicons-yes"></span> g (gram).</mark> 
		<?php elseif ( $weight_unit == 'kg' ) : ?>
			<mark class="indo-ongkir-yes"><span class="dashicons dashicons-yes"></span> kg.</mark> <mark class="indo-ongkir-error">satuan <strong>g (gram)</strong> lebih direkomendasikan!</mark>
		<?php else : ?>
			<mark class="indo-ongkir-error"><span class="dashicons dashicons-warning"></span> <?php echo $weight_unit; ?>, harap ganti ke satuan <strong>g (gram)</strong>!</mark>
		<?php endif; ?>
		<a href="<?php echo admin_url('admin.php?page=wc-settings&tab=products'); ?>"><?php _e( 'Edit', 'wpbisnis-wc-indo-ongkir' ); ?></a>
	</td>
</tr>
<tr valign="top">
	<th scope="row" class="titledesc" style="padding-top:0;">
		<label><?php _e( 'Satuan Ukuran (Dimension Unit)', 'wpbisnis-wc-indo-ongkir' ); ?></label>
	</th>
	<td class="forminp forminp-text" style="padding-top:0;">
		<?php $dimension_unit = get_option('woocommerce_dimension_unit'); ?>
		<?php if ( $dimension_unit == 'cm' ) : ?>
			<mark class="indo-ongkir-yes"><span class="dashicons dashicons-yes"></span> cm (centimeter).</mark> 
		<?php else : ?>
			<mark class="indo-ongkir-error"><span class="dashicons dashicons-warning"></span> <?php echo $dimension_unit; ?>, harap ganti ke satuan <strong>cm (centimeter)</strong>!</mark>
		<?php endif; ?>
		<a href="<?php echo admin_url('admin.php?page=wc-settings&tab=products'); ?>"><?php _e( 'Edit', 'wpbisnis-wc-indo-ongkir' ); ?></a>
	</td>
</tr>
<tr valign="top">
	<th scope="row" class="titledesc" style="padding-top:0;">
		<label>Metode "wp_remote_post"</label>
	</th>
	<td class="forminp forminp-text" style="padding-top:0;">
		<?php if ( $wrp_status ) : ?>
			<mark class="indo-ongkir-yes"><span class="dashicons dashicons-yes"></span> <?php echo $wrp_message; ?></mark> 
		<?php else : ?>
			<mark class="indo-ongkir-error"><span class="dashicons dashicons-warning"></span> <?php echo $wrp_message; ?></mark>
		<?php endif; ?>
	</td>
</tr>
<tr valign="top">
	<th scope="row" class="titledesc" style="padding-top:0;">
		<label>Metode "file_get_contents"</label>
	</th>
	<td class="forminp forminp-text" style="padding-top:0;">
		<?php if ( $fgc_status ) : ?>
			<mark class="indo-ongkir-yes"><span class="dashicons dashicons-yes"></span> <?php echo esc_html( $fgc_message ); ?></mark> 
		<?php else : ?>
			<mark class="indo-ongkir-error"><span class="dashicons dashicons-warning"></span> <?php echo esc_html( $fgc_message ); ?></mark>
		<?php endif; ?>
	</td>
</tr>
<tr valign="top">
	<th scope="row" class="titledesc" style="padding-top:0;">
		<label>Status Server Ongkir</label>
	</th>
	<td class="forminp forminp-text" style="padding-top:0;">
		<?php if ( $server_status == 'connected' ) : ?>
			<mark class="indo-ongkir-yes"><span class="dashicons dashicons-yes"></span> connected, dengan metode <?php echo esc_html( $ongkir_mode ); ?></mark> 
		<?php else : ?>
			<mark class="indo-ongkir-error"><span class="dashicons dashicons-warning"></span> not connected, dengan metode <?php echo esc_html( $ongkir_mode ); ?></mark>
		<?php endif; ?>
	</td>
</tr>
<?php 
	}

	public function check_license() {
		global $wp_version;
		$license = trim( get_option( 'wpbisnis_wc_indo_ongkir_license' ) );
		$api_params = array(
			'edd_action' => 'check_license',
			'license' => $license,
			'item_name' => urlencode( WPBISNIS_WC_INDO_ONGKIR_NAME ),
			'url'       => home_url()
		);
		$response = wp_remote_post( WPBISNIS_WC_INDO_ONGKIR_STORE, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
		if ( is_wp_error( $response ) )
			return;
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		if( $license_data->license == 'inactive' || $license_data->license == 'site_inactive' ) {
			if ( $license_data->activations_left === 0 ) {
				$license_data->license = 'no_activations_left';
			}
			else {
				$this->activate_license();
			}
		} 
		update_option( 'wpbisnis_wc_indo_ongkir_license_status', $license_data );
	}

	public function activate_license() {
		$license = trim( get_option( 'wpbisnis_wc_indo_ongkir_license' ) );
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_name'  => urlencode( WPBISNIS_WC_INDO_ONGKIR_NAME ), 
			'url'        => home_url()
		);
		$response = wp_remote_post( WPBISNIS_WC_INDO_ONGKIR_STORE, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
		if ( is_wp_error( $response ) )
			return;
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		if ( false !== $license_data->success ) {
			$this->check_license();
		}
	}

	public function deactivate_license() {
		$license = trim( get_option( 'wpbisnis_wc_indo_ongkir_license' ) );
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			'item_name'  => urlencode( WPBISNIS_WC_INDO_ONGKIR_NAME ),
			'url'        => home_url()
		);
		$response = wp_remote_post( WPBISNIS_WC_INDO_ONGKIR_STORE, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
		if ( is_wp_error( $response ) )
			return;
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		if( $license_data->license == 'deactivated' ) {
			delete_option( 'wpbisnis_wc_indo_ongkir_license_status' );
		}
	}

	public function check_server() {

		// $license_status = get_option( 'wpbisnis_wc_indo_ongkir_license_status' );

		// if ( isset( $license_status->license ) && $license_status->license == 'valid' ) {

			if ( WPBISNIS_WC_INDO_ONGKIR_PLUGIN ) {
				$license = trim( get_option( 'wpbisnis_wc_indo_ongkir_license' ) );
			}
			else {
				$license = trim( get_option( get_template().'_license_key' ) );
			}

			$register_url = trailingslashit( $this->api_url ) . 'register/';
			$register = wp_remote_post( $register_url, array(
				'body' => array( 
					'license'         => $license,
					'url'             => home_url(),
					'item_name'       => urlencode( WPBISNIS_WC_INDO_ONGKIR_NAME ),
					'store'           => WPBISNIS_WC_INDO_ONGKIR_STORE,
				)
			) );
			// if ( !is_wp_error( $register ) ) {
			// 	echo 'register '.$register['body'];
			// } 

			$ongkir_mode            = get_option( 'wpbisnis_wc_indo_ongkir_mode' );
			if ( !$ongkir_mode ) {
				$ongkir_mode = 'wp_remote_post';
			}

			$postdata = array(
				'license'         => $license,
				'url'             => home_url(),
				'item_name'       => urlencode( WPBISNIS_WC_INDO_ONGKIR_NAME ),
				'origin'          => 153,
				'originType'      => 'city',
				'destination'     => 2104,
				'destinationType' => 'subdistrict',
				'weight'          => '1000',
				'courier'         => 'pos',
			);

			if ( $ongkir_mode == 'wp_remote_post' ) {
				$response = wp_remote_post( $this->api_url, array(
					'body' => $postdata
				) );
				if ( is_wp_error( $response ) ) {
				   $error_message = $response->get_error_message();
				} 
				else {
					if ( 200 == $response['response']['code'] ) {
						// echo $response['body'];
						$output = json_decode( $response['body'], true );
						if ( !empty( $output ) ) {
							return 'connected';
						}
					}
				}
			}
			elseif ( $ongkir_mode == 'file_get_contents' ) {
				$opts = array('http' =>
					array(
						'method'  => 'POST',
						'header'  => 'Content-type: application/x-www-form-urlencoded',
				 		'content' => http_build_query( $postdata )
					),
				);
				$context = stream_context_create( $opts );
				$result = @file_get_contents( $this->api_url, false, $context );
				if ( $result ) {
					// echo $result;
					$output = json_decode( $result, true );
					if ( !empty( $output ) ) {
						return 'connected';
					}
				}
			}

		// }
		return 'not connected';
	}

	public function updater() {
		if ( ! WPBISNIS_WC_INDO_ONGKIR_PLUGIN ) {
			return;
		}
		$license_key = trim( get_option( 'wpbisnis_wc_indo_ongkir_license' ) );
		if ( ! $license_key ) {
			return;
		}
		$edd_updater = new WPBisnis_WC_Indo_Ongkir_Updater( WPBISNIS_WC_INDO_ONGKIR_STORE, __FILE__, array(
				'version' 	=> WPBISNIS_WC_INDO_ONGKIR_VERSION, 
				'license' 	=> $license_key, 
				'item_name' => WPBISNIS_WC_INDO_ONGKIR_NAME, 
				'author' 	=> 'Agus Muhammad (WPBisnis)', 
				'beta'		=> false
			)
		);
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'wpbisnis-wc-indo-ongkir-script', trailingslashit( WPBISNIS_WC_INDO_ONGKIR_URL ).'assets/js/wpbisnis-wc-indo-ongkir.min.js', array('jquery'), WPBISNIS_WC_INDO_ONGKIR_VERSION, true );
		$user_billing_country = null;
		$user_billing_state = null;
		$user_billing_city = null;
		$user_billing_kota = null;
		$user_billing_kecamatan = null;
		$user_shipping_country = null;
		$user_shipping_state = null;
		$user_shipping_city = null;
		$user_shipping_kota = null;
		$user_shipping_kecamatan = null;
		if ( is_user_logged_in() ) {
			global $current_user;
			$user_id = $current_user->data->ID;
			$user_billing_country = get_user_meta( $user_id, 'billing_country', true );
			$user_billing_state = get_user_meta( $user_id, 'billing_state', true );
			$user_billing_city = get_user_meta( $user_id, 'billing_city', true );
			$user_billing_kota = get_user_meta( $user_id, 'billing_indo_ongkir_kota', true );
			$user_billing_kecamatan = get_user_meta( $user_id, 'billing_indo_ongkir_kecamatan', true );
			$user_shipping_country = get_user_meta( $user_id, 'shipping_country', true );
			$user_shipping_state = get_user_meta( $user_id, 'shipping_state', true );
			$user_shipping_city = get_user_meta( $user_id, 'shipping_city', true );
			$user_shipping_kota = get_user_meta( $user_id, 'shipping_indo_ongkir_kota', true );
			$user_shipping_kecamatan = get_user_meta( $user_id, 'shipping_indo_ongkir_kecamatan', true );
		}
		$settings = array(
			'debug'						=> 'yes' == get_option('wpbisnis_wc_indo_ongkir_debug_console') ? true : false,
			'ajax_url'  				=> admin_url( 'admin-ajax.php' ),
			'nonce' 					=> wp_create_nonce( constant('WPBISNIS_WC_INDO_ONGKIR_NONCE') ),
			'base_state'				=> WC()->countries->get_base_state(),
			'placeholder_kota'			=> esc_attr__( 'Pilih Kota / Kabupaten...', 'wpbisnis-wc-indo-ongkir' ),
			'placeholder_kecamatan'		=> esc_attr__( 'Pilih Kecamatan...', 'wpbisnis-wc-indo-ongkir' ),
			'user_billing_country'		=> $user_billing_country,
			'user_billing_state'		=> $user_billing_state,
			'user_billing_city'			=> $user_billing_city,
			'user_billing_kota'			=> $user_billing_kota,
			'user_billing_kecamatan'	=> $user_billing_kecamatan,
			'user_shipping_country'		=> $user_shipping_country,
			'user_shipping_state'		=> $user_shipping_state,
			'user_shipping_city'		=> $user_shipping_city,
			'user_shipping_kota'		=> $user_shipping_kota,
			'user_shipping_kecamatan'	=> $user_shipping_kecamatan,
		);
		wp_localize_script( 'wpbisnis-wc-indo-ongkir-script', 'wpbisnis_wc_indo_ongkir_ajax', $settings );
	}

	public function shipping_init() {
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-base.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-jne.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-tiki.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-pos.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-jnt.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-sicepat.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-wahana.php' );
		// include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-indah.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-rpx.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-pandu.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-pahala.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-cahaya.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-dse.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-first.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-jet.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-ncs.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-nss.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-ongkir-sap.php' );
	}

	public function shipping_methods( $methods ) {
		$methods['indo_ongkir_jne'] = 'WPBisnis_WC_Indo_Ongkir_JNE';
		$methods['indo_ongkir_tiki'] = 'WPBisnis_WC_Indo_Ongkir_TIKI';
		$methods['indo_ongkir_pos'] = 'WPBisnis_WC_Indo_Ongkir_POS';
		$methods['indo_ongkir_jnt'] = 'WPBisnis_WC_Indo_Ongkir_JNT';
		$methods['indo_ongkir_sicepat'] = 'WPBisnis_WC_Indo_Ongkir_SICEPAT';
		$methods['indo_ongkir_wahana'] = 'WPBisnis_WC_Indo_Ongkir_WAHANA';
		// $methods['indo_ongkir_indah'] = 'WPBisnis_WC_Indo_Ongkir_INDAH';
		$methods['indo_ongkir_rpx'] = 'WPBisnis_WC_Indo_Ongkir_RPX';
		$methods['indo_ongkir_pandu'] = 'WPBisnis_WC_Indo_Ongkir_PANDU';
		$methods['indo_ongkir_pahala'] = 'WPBisnis_WC_Indo_Ongkir_PAHALA';
		$methods['indo_ongkir_cahaya'] = 'WPBisnis_WC_Indo_Ongkir_CAHAYA';
		$methods['indo_ongkir_dse'] = 'WPBisnis_WC_Indo_Ongkir_DSE';
		$methods['indo_ongkir_first'] = 'WPBisnis_WC_Indo_Ongkir_FIRST';
		$methods['indo_ongkir_jet'] = 'WPBisnis_WC_Indo_Ongkir_JET';
		$methods['indo_ongkir_ncs'] = 'WPBisnis_WC_Indo_Ongkir_NCS';
		$methods['indo_ongkir_nss'] = 'WPBisnis_WC_Indo_Ongkir_NSS';
		$methods['indo_ongkir_sap'] = 'WPBisnis_WC_Indo_Ongkir_SAP';
		return $methods;
	}

	public function country_locale_field_selectors( $locale_fields ) {
		$locale_fields['indo_ongkir_kota'] = '#billing_indo_ongkir_kota_field, #shipping_indo_ongkir_kota_field';
		$locale_fields['indo_ongkir_kecamatan'] = '#billing_indo_ongkir_kecamatan_field, #shipping_indo_ongkir_kecamatan_field';
		return $locale_fields;
	}

	public function country_locale( $locale ) {
		// $countries = WC()->countries->get_countries;
		// $countries = apply_filters( 'woocommerce_countries', include( WC()->plugin_path() . '/i18n/countries.php' ) );
		$countries = WC()->countries->get_allowed_countries();
		// var_dump( $countries);
		foreach ($countries as $key => $value) {
			if ( $key != 'ID' ) {
				$locale[$key]['indo_ongkir_kota'] = array(
					'required' => false,
					'hidden' => true,
				);
				$locale[$key]['indo_ongkir_kecamatan'] = array(
					'required' => false,
					'hidden' => true,
				);
			}
		}
		/* country : 40; state = 80; postcode = 90 */
		$locale['ID'] = array(
			'postcode_before_city' => true, /* backward */
			'address_1' => array(
				'priority' => 36,
			),
			'address_2' => array(
				'priority' => 37,
			),
			'state' => array(
				'label'       => __( 'Provinsi', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => __( 'Pilih Provinsi...', 'wpbisnis-wc-indo-ongkir' ),
				'priority' => 80,
			),
			'city' => array(
				'priority' => 81,
				'required' => false,
				'hidden' => true,
			),
			'indo_ongkir_kota' => array(
				'required' => true,
				'priority' => 82,
			),
			'indo_ongkir_kecamatan' => array(
				'required' => true,
				'priority' => 83,
			),
			'postcode' => array(
				'required' => false,
				'priority' => 90,
			),
		);
		// var_dump($locale);
		return $locale;
	}

	function address_fields( $fields ) {
		$fields['address_1']['priority'] = 36;
		$fields['address_2']['priority'] = 37;
		$fields['city']['class'] = array( 'form-row-wide', 'address-field', 'update_totals_on_change' );
		$fields['city']['priority'] = 81;
		$fields['indo_ongkir_kota'] = array(
			'type' 			=> 'select',
			'options'		=> array( '' => '' ),
			'label' 		=> esc_attr__( 'Kota / Kabupaten', 'wpbisnis-wc-indo-ongkir' ),
			'placeholder' 	=> esc_attr__( 'Pilih Kota / Kabupaten...', 'wpbisnis-wc-indo-ongkir' ),
			'required'     => false,
			'class'        => array( 'form-row-wide', 'address-field' ),
			'autocomplete' => '',
			'priority' => 82,
		);
		$fields['indo_ongkir_kecamatan'] = array(
			'type' 			=> 'select',
			'options'		=> array( '' => '' ),
			'label' 		=> esc_attr__( 'Kecamatan', 'wpbisnis-wc-indo-ongkir' ),
			'placeholder' 	=> esc_attr__( 'Pilih Kecamatan...', 'wpbisnis-wc-indo-ongkir' ),
			'required'     => false,
			'class'        => array( 'form-row-wide', 'address-field' ),
			'autocomplete' => '',
			'priority' => 83,
		);
		$fields['postcode']['priority'] = 90;
		return $fields;
	}

	public function billing_fields( $fields ) {
		$fields['billing_address_1']['priority'] = 36;
		$fields['billing_address_2']['priority'] = 37;
		$fields['billing_city']['class'] = array( 'form-row-wide', 'address-field', 'update_totals_on_change' );
		$fields['billing_city']['priority'] = 81;
		$fields['billing_indo_ongkir_kota'] = array(
			'type' 			=> 'select',
			'options'		=> array( '' => '' ),
			'label' 		=> esc_attr__( 'Kota / Kabupaten', 'wpbisnis-wc-indo-ongkir' ),
			'placeholder' 	=> esc_attr__( 'Pilih Kota / Kabupaten...', 'wpbisnis-wc-indo-ongkir' ),
			'required'     => false,
			'class'        => array( 'form-row-wide', 'address-field' ),
			'autocomplete' => '',
			'priority' => 82,
		);
		$fields['billing_indo_ongkir_kecamatan'] = array(
			'type' 			=> 'select',
			'options'		=> array( '' => '' ),
			'label' 		=> esc_attr__( 'Kecamatan', 'wpbisnis-wc-indo-ongkir' ),
			'placeholder' 	=> esc_attr__( 'Pilih Kecamatan...', 'wpbisnis-wc-indo-ongkir' ),
			'required'     => false,
			'class'        => array( 'form-row-wide', 'address-field' ),
			'autocomplete' => '',
			'priority' => 83,
		);
		$fields['billing_postcode']['priority'] = 90;
		if ( isset($fields['billing_email']) ) {
			$fields['billing_email']['class'] = array('form-row-wide');
		}
		if ( isset($fields['billing_phone']) ) {
			$fields['billing_phone']['class'] = array('form-row-wide');
		}
		return $fields;
	}

	public function shipping_fields( $fields ) {
		$fields['shipping_address_1']['priority'] = 36;
		$fields['shipping_address_2']['priority'] = 37;
		$fields['shipping_city']['class'] = array( 'form-row-wide', 'address-field', 'update_totals_on_change' );
		$fields['shipping_city']['priority'] = 81;
		$fields['shipping_indo_ongkir_kota'] = array(
			'type' 			=> 'select',
			'options'		=> array( '' => '' ),
			'label' 		=> esc_attr__( 'Kota / Kabupaten', 'wpbisnis-wc-indo-ongkir' ),
			'placeholder' 	=> esc_attr__( 'Pilih Kota / Kabupaten...', 'wpbisnis-wc-indo-ongkir' ),
			'required'     => false,
			'class'        => array( 'form-row-wide', 'address-field' ),
			'autocomplete' => '',
			'priority' => 82,
		);
		$fields['shipping_indo_ongkir_kecamatan'] = array(
			'type' 			=> 'select',
			'options'		=> array( '' => '' ),
			'label' 		=> esc_attr__( 'Kecamatan', 'wpbisnis-wc-indo-ongkir' ),
			'placeholder' 	=> esc_attr__( 'Pilih Kecamatan...', 'wpbisnis-wc-indo-ongkir' ),
			'required'     => false,
			'class'        => array( 'form-row-wide', 'address-field' ),
			'autocomplete' => '',
			'priority' => 83,
		);
		$fields['shipping_postcode']['priority'] = 90;
		if ( isset($fields['shipping_email']) ) {
			$fields['shipping_email']['class'] = array('form-row-wide');
		}
		if ( isset($fields['shipping_phone']) ) {
			$fields['shipping_phone']['class'] = array('form-row-wide');
		}
		return $fields;
	}

	public function checkout_fields( $fields ) {
		$fields['billing']['billing_first_name']['autofocus'] = false;
		$fields['billing']['billing_address_1']['priority'] = 36;
		$fields['billing']['billing_address_2']['priority'] = 37;
		$fields['billing']['billing_city']['priority'] = 81;
		$fields['billing']['billing_indo_ongkir_kota']['priority'] = 82;
		$fields['billing']['billing_indo_ongkir_kecamatan']['priority'] = 83;
		$fields['billing']['billing_postcode']['priority'] = 90;
		// $fields['billing']['billing_phone']['class'] = array('form-row-wide');
		// $fields['billing']['billing_email']['class'] = array('form-row-wide');
		$fields['shipping']['shipping_address_1']['priority'] = 36;
		$fields['shipping']['shipping_address_2']['priority'] = 37;
		$fields['shipping']['shipping_city']['priority'] = 81;
		$fields['shipping']['shipping_indo_ongkir_kota']['priority'] = 82;
		$fields['shipping']['shipping_indo_ongkir_kecamatan']['priority'] = 83;
		$fields['shipping']['shipping_postcode']['priority'] = 90;
		// $fields['shipping']['shipping_phone']['class'] = array('form-row-wide');
		// $fields['shipping']['shipping_email']['class'] = array('form-row-wide');
		return $fields;
	}

	public function checkout_field_value( $field, $value ) {
		if ( is_user_logged_in() ) {
			global $current_user;
			$user_id = $current_user->data->ID;
			$user_billing_state = get_user_meta( $user_id, $field, true );
			if ( $user_billing_state ) {
				$value = $user_billing_state;
			}
		}
		return $value;
	}

	public function checkout_billing_country( $value ) {
		return $this->checkout_field_value( 'billing_country', $value );
	}

	public function checkout_billing_state( $value ) {
		return $this->checkout_field_value( 'billing_state', $value );
	}

	public function checkout_shipping_country( $value ) {
		return $this->checkout_field_value( 'shipping_country', $value );
	}

	public function checkout_shipping_state( $value ) {
		return $this->checkout_field_value( 'shipping_state', $value );
	}

	public function get_ajax_kota() {
		$nonce = $_GET['nonce'];
		if ( !wp_verify_nonce( $nonce, constant('WPBISNIS_WC_INDO_ONGKIR_NONCE' ) ) ) die( $nonce );
		else {
			$provinsi = $_GET['provinsi'];
			if ( $provinsi ) {
				$kota_file = WPBISNIS_WC_INDO_ONGKIR_PATH.'/includes/data/kota/'.$provinsi.'.php';
				if ( file_exists( $kota_file ) ) {
					$kota = include( $kota_file );
					if ( !empty( $kota ) ) {
						echo json_encode( $kota );
					}
				}
			}
			die();
		}
	}

	public function get_ajax_kecamatan() {
		$nonce = $_GET['nonce'];
		if ( !wp_verify_nonce( $nonce, constant('WPBISNIS_WC_INDO_ONGKIR_NONCE' ) ) ) die( $nonce );
		else {
			$provinsi = $_GET['provinsi'];
			$kota = $_GET['kota'];
			if ( $provinsi && $kota ) {
				$kecamatan_file = WPBISNIS_WC_INDO_ONGKIR_PATH.'/includes/data/kecamatan/'.$provinsi.'.php';
				if ( file_exists( $kecamatan_file ) ) {
					$kecamatan = include( $kecamatan_file );
					if ( isset( $kecamatan[$kota] ) && !empty( $kecamatan[$kota] ) ) {
						echo json_encode( $kecamatan[$kota] );
					}
				}
			}
			die();
		}
	}

	public function free_shipping( $rates ) {
		$free = array();
		foreach ( $rates as $rate_id => $rate ) {
			if ( 'free_shipping' === $rate->method_id ) {
				$free[ $rate_id ] = $rate;
				break;
			}
		}
		return ! empty( $free ) ? $free : $rates;
	}

	public function get_origin_options( $cities_empty = array() ) {
		$cities_file = WPBISNIS_WC_INDO_ONGKIR_PATH.'/includes/data/origin/domestik-option.php';
		if ( file_exists( $cities_file ) ) {
			$cities = include( $cities_file );
			if ( !empty( $cities ) ) {
				if ( !empty($cities_empty) ) {
					return $cities_empty + $cities;
				}
				else {
					return $cities;
				}
			}
		}
		return $cities_empty;
	}

	public function get_origin_name( $id = '' ) {
		if ( !$id ) 
			return false;

		$id = intval( $id );

		if ( $id < 0 ) 
			return false;

		if ( $id > 501 ) 
			return false;

		$origin_file_id = ceil( $id / 10 );
		$origin_file = WPBISNIS_WC_INDO_ONGKIR_PATH.'/includes/data/origin/domestik-'.$origin_file_id.'.php';
		if ( file_exists( $origin_file ) ) {
			$origins = include( $origin_file );
			if ( !empty( $origins ) ) {
				if ( isset( $origins[$id] ) ) {
					return $origins[$id];
				}
			}
		}
		return false;
	}

	public function shipping_packages( $packages ) {
		$origin_mode = get_option( 'wpbisnis_wc_indo_ongkir_multi_origin' );
		$origin_default = get_option( 'wpbisnis_wc_indo_ongkir_origin' );
		$volumetric_div = get_option( 'wpbisnis_wc_indo_ongkir_volumetrik' );
		if ( ! $volumetric_div ) {
			$volumetric_div = 5000;
		}
		$packages = array();
		$origin_items_map = array();
		$origin = array();
		$weight = array();
		$volumetric = array();
		foreach ( WC()->cart->get_cart() as $item ) {
			if ( $item['data']->needs_shipping() ) {
				$product_id = $item['product_id'];
				$origin_id = get_post_meta( $product_id, '_wpbisnis_wc_indo_ongkir_origin', true );
				if ( !$origin_id ) {
					$origin_id = $origin_default;
				}
				if ( $origin_mode == 'product' ) {
					$key = $product_id;
					$origin[$key] = $origin_id;
				}
				else {
					if ( $origin_id ) {
						$key = $origin_id;
						$origin[$key] = $origin_id;
					}
					else {
						$key = '0';
						$origin['0'] = '';
					}
				}
				$origin_items_map[$key][] = $item;
				$item_weight = $item['data']->get_weight();
				$item_length = $item['data']->get_length();
				$item_width = $item['data']->get_width();
				$item_height = $item['data']->get_height();
				if ( $item_length && $item_width && $item_height ) {
					$item_length = $this->wc_get_dimension( $item_length, 'cm' );
					$item_width = $this->wc_get_dimension( $item_width, 'cm' );
					$item_height = $this->wc_get_dimension( $item_height, 'cm' );
					$item_weight_volumetric = $item_length * $item_width * $item_height / $volumetric_div;
					$weight_unit = strtolower( get_option( 'woocommerce_weight_unit' ) );
					if ( 'g' == $weight_unit ) {
						$item_weight_volumetric *= 1000;
					}
					elseif ( 'lbs' == $weight_unit ) {
						$item_weight_volumetric *= 2.20462;
					}
					elseif ( 'oz' == $weight_unit ) {
						$item_weight_volumetric *= 35.274;
					}
					$item_weight = floatval( $item_weight );
					if ( $item_weight_volumetric > $item_weight ) {
						$item_weight = $item_weight_volumetric;
						$dimension_unit = strtolower( get_option( 'woocommerce_dimension_unit' ) );
						$volumetric[$key] = $item_length.'x'.$item_width.'x'.$item_height.' '.$dimension_unit.' (x'.$item['quantity'].')';
					}
				}
				if ( !isset($weight[$key]) ) {
					$weight[$key] = $item['quantity'] * floatval( $item_weight );
				}
				else {
					$weight[$key] = $item['quantity'] * floatval( $item_weight ) + $weight[$key];
				}
			}
		}
		foreach( $origin_items_map as $key => $origin_items ) {
			$origin_name = $origin[$key] > 0 ? $this->get_origin_name( $origin[$key] ) : '';
			if ( isset( $volumetric[$key] ) ) {
				if ( count( $origin_items ) > 1 ) {
					$volumetric[$key] = 'volumetric';
				}
			} 
			else {
				$volumetric[$key] = false;
			}
			$packages[$key] = array(
				'origin' => $origin[$key],
				'origin_name' => $origin_name,
				'weight' => $weight[$key],
				'volumetric' => $volumetric[$key],
				'contents' => $origin_items,
				'contents_cost' => array_sum( wp_list_pluck( $origin_items, 'line_total' ) ),
				'applied_coupons' => WC()->cart->applied_coupons,
				'destination' => array(
					'country' => WC()->customer->get_shipping_country(),
					'state' => WC()->customer->get_shipping_state(),
					'postcode' => WC()->customer->get_shipping_postcode(),
					'city' => WC()->customer->get_shipping_city(),
					'address' => WC()->customer->get_shipping_address(),
					'address_2' => WC()->customer->get_shipping_address_2()
				)
			);	
		}
		// var_dump( $packages );
		return $packages;
	}

	public function package_name( $name, $i, $package ) {
		$name = 'Pengiriman';
		if ( isset( $package['origin_name'] ) && $package['origin_name'] ) {
			$name .= '<br/><small>dari '.$package['origin_name'].'</small>';			
		}
		if ( isset( $package['volumetric'] ) && $package['volumetric'] ) {
			if ( 'volumetric' != $package['volumetric'] ) {
				$name .= '<br/><small>'.$package['volumetric'].'</small>';	
			}
		}
		else {
			if ( isset( $package['weight'] ) && $package['weight'] ) {
				if ( $package['weight'] < 10 ) {
					$package['weight'] = number_format( $package['weight'], 2, '.', '' );
				}
				else {
					$package['weight'] = number_format( $package['weight'], 0, '.', '' );
				}
				$name .= '<br/><small>berat '.wc_format_weight( $package['weight'] ).'</small>';	
			}
		}
		return $name;
	}

	public function wc_get_dimension( $dimension, $to_unit, $from_unit = '' ) {

		if ( function_exists( 'wc_get_dimension' ) ) {
			return wc_get_dimension( $dimension, $to_unit, $from_unit );
		}

		$to_unit = strtolower( $to_unit );

		if ( empty( $from_unit ) ) {
			$from_unit = strtolower( get_option( 'woocommerce_dimension_unit' ) );
		}

		// Unify all units to cm first.
		if ( $from_unit !== $to_unit ) {
			switch ( $from_unit ) {
				case 'in' :
					$dimension *= 2.54;
					break;
				case 'm' :
					$dimension *= 100;
					break;
				case 'mm' :
					$dimension *= 0.1;
					break;
				case 'yd' :
					$dimension *= 91.44;
					break;
			}

			// Output desired unit.
			switch ( $to_unit ) {
				case 'in' :
					$dimension *= 0.3937;
					break;
				case 'm' :
					$dimension *= 0.01;
					break;
				case 'mm' :
					$dimension *= 10;
					break;
				case 'yd' :
					$dimension *= 0.010936133;
					break;
			}
		}

		return ( $dimension < 0 ) ? 0 : $dimension;
	}

	public function add_origin_meta() {
		woocommerce_wp_select( array(
			'id'      => '_wpbisnis_wc_indo_ongkir_origin',
			'label'   => __( 'Kota Asal Pengiriman', 'wpbisnis-wc-indo-ongkir' ),
			'class'   => 'select wc-enhanced-select wide',
			'options' => $this->get_origin_options( array( '' => __( 'Setting default untuk kota asal pengiriman domestik', 'wpbisnis-wc-indo-ongkir' ) ) ),
		) );
	}

	public function save_origin_meta( $post_id ) {
		$origin = $_POST['_wpbisnis_wc_indo_ongkir_origin'];
		if( !empty( $origin ) ) {
			update_post_meta( $post_id, '_wpbisnis_wc_indo_ongkir_origin', esc_attr( $origin ) );
		}
		else {
			delete_post_meta( $post_id, '_wpbisnis_wc_indo_ongkir_origin' );
		}
	}

	public function order_shipping( $item, $package_key, $package, $order ) {
		$name = $item->get_name();
		$origin = '';
		$weight = '';
		if ( isset( $package['origin_name'] ) && $package['origin_name'] ) {
			$name .= ' - ' . $package['origin_name'];
		}
		if ( isset( $package['volumetric'] ) && $package['volumetric'] ) {
			if ( 'volumetric' != $package['volumetric'] ) {
				$name .= ' - '.$package['volumetric'];	
			}
		}
		else {
			if ( isset( $package['weight'] ) && $package['weight'] ) {
				if ( $package['weight'] < 10 ) {
					$package['weight'] = number_format( $package['weight'], 2, '.', '' );
				}
				else {
					$package['weight'] = number_format( $package['weight'], 0, '.', '' );
				}
				$name .= ' - '.wc_format_weight( $package['weight'] );	
			}
		}
		$item->set_name( $name );
	}

	public function shipped_via( $output ) {
		if ( false !== strpos( $output, 'via ' ) ) {
			if ( false !== strpos( $output, ', ' ) ) {
				$output = str_replace( 'via ', '<br/>via<br/> ', $output );
				$output = str_replace( ', ', ',<br/> ', $output );
			}
			else {
				$output = str_replace( 'via ', '<br/>via ', $output );
			}
		}
		return $output;
	}

	public function add_meta_box() {
		add_meta_box( 'wpbisnis-wc-indo-ongkir-resi', __( 'Indo Ongkir - Resi Pengiriman', 'wpbisnis-wc-indo-ongkir' ), array( $this, 'meta_box_resi' ), 'shop_order', 'side', 'low' );
	}

	public function meta_box_resi() {
		global $post, $thepostid, $theorder;
		if ( ! is_int( $thepostid ) ) {
			$thepostid = $post->ID;
		}
		if ( ! is_object( $theorder ) ) {
			$theorder = wc_get_order( $thepostid );
		}
		$order = $theorder;
		$shipping = $order->get_items( 'shipping' );
		// var_dump( $shipping );
		if ( !empty( $shipping ) ) {
		    wp_nonce_field( 'wpbisnis_wc_indo_ongkir_resi_nonce_action', 'wpbisnis_wc_indo_ongkir_resi_nonce' );
			$resi = get_post_meta( $thepostid, '_indo_ongkir_resi', true );
			// var_dump( $resi );
			$date = get_post_meta( $thepostid, '_indo_ongkir_date', true );
			// var_dump( $date );
			foreach ( $shipping as $item_id => $item ) {
				echo '<h4>';
				echo $item->get_name();
				$meta_items = $item->get_meta( 'Items' );
				if ( $meta_items ) {
					echo '<br/><small><em>'.$meta_items.'</em></small>';
				}
				echo '</h4>';
				$item_resi = isset( $resi[$item_id] ) ? $resi[$item_id] : '';
				woocommerce_wp_text_input( array(
					'id'          => 'indo_ongkir_resi['.$item_id.']',
					'label'       => __( 'Nomor Resi Pengiriman:', 'wpbisnis-wc-indo-ongkir' ),
					'placeholder' => '',
					'description' => '',
					'value'       => $item_resi,
				) );
				$item_date = isset( $date[$item_id] ) ? $date[$item_id] : '';
				woocommerce_wp_text_input( array(
					'id'          => 'indo_ongkir_date['.$item_id.']',
					'label'       => __( 'Tanggal Pengiriman:', 'wpbisnis-wc-indo-ongkir' ),
					'placeholder' => date_i18n( __( 'Y-m-d', 'wpbisnis-wc-indo-ongkir' ), time() ),
					'description' => '',
					'class'       => 'date-picker-field',
					'value'       => $item_date,
				) );
				echo '<hr/>';
			}
			echo '<div class="resi_actions"><button type="submit" class="button button-primary" name="save" value="Save">'.__( 'Save', 'wpbisnis-wc-indo-ongkir' ).'</button></div>';
		}
	}

	public function save_meta_box( $post_id, $post ) {
		$nonce_name   = isset( $_POST['wpbisnis_wc_indo_ongkir_resi_nonce'] ) ? $_POST['wpbisnis_wc_indo_ongkir_resi_nonce'] : '';
		$nonce_action = 'wpbisnis_wc_indo_ongkir_resi_nonce_action';
		if ( ! isset( $nonce_name ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}
		if ( isset( $_POST['indo_ongkir_resi'] ) && !empty( $_POST['indo_ongkir_resi'] ) ) {
			if ( is_array( $_POST['indo_ongkir_resi'] ) ) {
				$resi = array();
				$date = array();
				foreach ( $_POST['indo_ongkir_resi'] as $key => $value ) {
					$resi[$key] = sanitize_text_field( $value );
					if ( $resi[$key] ) {
						if ( isset( $_POST['indo_ongkir_date'][$key] ) && $_POST['indo_ongkir_date'][$key] ) {
							$date[$key] = sanitize_text_field( $_POST['indo_ongkir_date'][$key] );
						}
						else {
							$date[$key] = date_i18n( __( 'Y-m-d', 'wpbisnis-wc-indo-ongkir' ), time() );
						}
					}
					else {
						$date[$key] = '';
					}
				}
				update_post_meta( $post_id, '_indo_ongkir_resi', $resi );
				update_post_meta( $post_id, '_indo_ongkir_date', $date );
			}
		}
	}

	public function get_resi_items( $order_id ) {
		$order = wc_get_order( $order_id );
		$shipping = $order->get_items( 'shipping' );
		// var_dump( $shipping );
		$resi_items = array();
		if ( !empty( $shipping ) ) {
			$resi = get_post_meta( $order_id, '_indo_ongkir_resi', true );
			// var_dump( $resi );
			$date = get_post_meta( $order_id, '_indo_ongkir_date', true );
			// var_dump( $date );
			$cekresi_link = get_option( 'wpbisnis_wc_indo_ongkir_cekresi' );
			if ( ! $cekresi_link ) {
				$cekresi_link = 'http://www.cekresi.com/?noresi=%noresi%';
			}
			foreach ( $shipping as $item_id => $item ) {
				if ( isset($resi[$item_id]) && $resi[$item_id] ) {
					$resi_items[$item_id]['name'] = $item->get_name();
					$resi_items[$item_id]['items'] = $item->get_meta( 'Items' );
					$resi_items[$item_id]['resi'] = $resi[$item_id];
					$resi_items[$item_id]['date'] = $date[$item_id];
					$item_cekresi = str_replace( '%noresi%', $resi[$item_id], $cekresi_link );
					$resi_items[$item_id]['link'] = esc_url( $item_cekresi );
				}
			}
		}
		return $resi_items;
	}

	public function display_resi_myaccount( $order_id ) {
		wc_get_template( 'myaccount/indo-ongkir-resi.php', array( 'resi_items' => $this->get_resi_items( $order_id ) ), 'wpbisnis-wc-indo-ongkir/', WPBISNIS_WC_INDO_ONGKIR_PATH . '/templates/' );
	}

	public function display_resi_email( $order, $sent_to_admin, $plain_text = null ) {
		$order_id = is_callable( array( $order, 'get_id' ) ) ? $order->get_id() : $order->id;
		if ( true === $plain_text ) {
			wc_get_template( 'email/plain/indo-ongkir-resi.php', array( 'resi_items' => $this->get_resi_items( $order_id ) ), 'wpbisnis-wc-indo-ongkir/', WPBISNIS_WC_INDO_ONGKIR_PATH . '/templates/' );
		} else {
			wc_get_template( 'email/indo-ongkir-resi.php', array( 'resi_items' => $this->get_resi_items( $order_id ) ), 'wpbisnis-wc-indo-ongkir/', WPBISNIS_WC_INDO_ONGKIR_PATH . '/templates/' );
		}
	}

	public function fix_woocommerce() {
		add_filter( 'pre_option_woocommerce_enable_shipping_calc', array( $this, 'fix_shipping_calc') ); 
		if ( is_cart() && !is_checkout() ) {
			add_filter( 'woocommerce_cart_ready_to_calc_shipping', '__return_false' );
		}
	}

	public function fix_shipping_calc( $option ) {
		return 'no';
	}

	public function admin_inline_style() {
		echo '<style>
		._wpbisnis_wc_indo_ongkir_origin_field .select2-container { width: 100% !important; }
		#wpbisnis-wc-indo-ongkir-resi h4 { margin: 1em 0; padding: 0; }
		#wpbisnis-wc-indo-ongkir-resi hr { margin: 1.5em -12px 1em -12px; padding: 0; border-top: 0; border-bottom: 1px solid #eee; }
		#wpbisnis-wc-indo-ongkir-resi .resi_actions { margin: 0; overflow: hidden; zoom: 1; }
		#wpbisnis-wc-indo-ongkir-resi .button { float: right; }
		.wpbisnis-indo-ongkir-message { background: #fff; border-left: 4px solid #00a0d2; box-shadow: 0 1px 1px 0 rgba(0,0,0,.1); margin: 5px 0 10px; padding: 20px !important;}
		.wpbisnis-indo-ongkir-message-inner {overflow:hidden;}
		.wpbisnis-indo-ongkir-message-icon {float:left;width:35px;height:35px;padding-right:20px;}
		.wpbisnis-indo-ongkir-message-icon .dashicons {width:35px;height:35px;font-size:35px;}
		.wpbisnis-indo-ongkir-message-button {float:right;padding:3px 0 0 20px;}
		.wpbisnis-indo-ongkir-message p { margin:0; padding: 0; }
		</style>';
	}

	public function wp_inline_style() {
		$style = '';
		$countries = WC()->countries->get_allowed_countries();
		if ( 1 == count( $countries ) && isset($countries['ID']) ) {
			$style .= '#billing_country_field, #shipping_country_field { display: none; }';
		}
		if ( $style ) {
			echo '<style>'.$style.'</style>'."\n";
		}
	}
}

}

if ( WPBISNIS_WC_INDO_ONGKIR_PLUGIN ) {
	add_action( 'plugins_loaded' , array( 'WPBisnis_WC_Indo_Ongkir_Init' , 'get_instance' ), 0 );

	function wpbisnis_wc_indo_ongkir_plugin_activate() {
		add_option( 'wpbisnis_wc_indo_ongkir_activation_redirect', true );
	}
	register_activation_hook( __FILE__ , 'wpbisnis_wc_indo_ongkir_plugin_activate');

	function wpbisnis_wc_indo_ongkir_plugin_redirect() {
		if ( get_option( 'wpbisnis_wc_indo_ongkir_activation_redirect', false ) ) {
			delete_option( 'wpbisnis_wc_indo_ongkir_activation_redirect' );
			if ( !isset( $_GET['activate-multi'] ) ) {
				wp_redirect("admin.php?page=wc-settings&tab=indo_ongkir");
				exit;
			}
		}
	}
	add_action( 'admin_init', 'wpbisnis_wc_indo_ongkir_plugin_redirect' );
}
else {
	WPBisnis_WC_Indo_Ongkir_Init::get_instance();
}

include( dirname( __FILE__ ) . '/upgrades.php' );

if( !class_exists( 'WPBisnis_WC_Indo_Checkout_Init' ) ) {
	include( dirname( __FILE__ ) . '/includes/class-wpbisnis-wc-indo-checkout.php' );
}
