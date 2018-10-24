<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPBisnis_WC_Indo_Checkout_Init {

	private static $instance;

	public static function get_instance() {
		return null === self::$instance ? ( self::$instance = new self ) : self::$instance;
	}

	public function __construct() {
		$this->billing_fields = array();
		$this->shipping_fields = array();
		$this->additional_fields = array();
		$this->fields_default();
		$this->fields_setup();
		$this->fields_text();
		if ( function_exists( 'WC' ) ) {
			add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_tab' ), 50 );
			add_action( 'woocommerce_settings_tabs_indo_checkout', array( $this, 'settings_tab' ) );
			add_action( 'woocommerce_update_options_indo_checkout', array( $this, 'update_settings' ) );
			add_action( 'woocommerce_admin_field_wpbisnis_wc_indo_checkout_billing_fields', array( $this, 'admin_billing_fields' ) );
			add_action( 'woocommerce_admin_field_wpbisnis_wc_indo_checkout_shipping_fields', array( $this, 'admin_shipping_fields' ) );
			add_action( 'woocommerce_admin_field_wpbisnis_wc_indo_checkout_additional_fields', array( $this, 'admin_additional_fields' ) );
			if ( $this->is_active() ) {
				add_filter( 'woocommerce_billing_fields', array( $this, 'billing_fields' ), 100 );
				add_filter( 'woocommerce_shipping_fields', array( $this, 'shipping_fields' ), 100 );
				add_filter( 'woocommerce_checkout_fields', array( $this, 'checkout_fields' ), 100 );
				add_filter( 'woocommerce_get_country_locale', array( $this, 'country_locale' ) );
			}
		} 
	}

	private function fields_default(){

		$this->billing_fields_default = array(
			'billing_first_name' => array(
				'show' => 'yes',
				'required' => 'yes',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'billing_last_name' => array(
				'show' => 'yes',
				'required' => 'no',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'billing_company' => array(
				'show' => 'no',
				'required' => 'no',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'billing_address_1' => array(
				'show' => 'yes',
				'required' => 'yes',
				'label' => '',
				'placeholder' => '',
				'type' => 'textarea',
			),
			'billing_address_2' => array(
				'show' => 'no',
				'required' => 'no',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'billing_country' => array(
				'show' => '',
				'required' => '',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'billing_postcode' => array(
				'show' => 'yes',
				'required' => 'no',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'billing_phone' => array(
				'show' => 'yes',
				'required' => 'yes',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'billing_email' => array(
				'show' => 'yes',
				'required' => 'yes',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
		);

		$this->shipping_fields_default = array(
			'shipping_first_name' => array(
				'show' => 'yes',
				'required' => 'yes',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'shipping_last_name' => array(
				'show' => 'yes',
				'required' => 'no',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'shipping_company' => array(
				'show' => 'no',
				'required' => 'no',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'shipping_address_1' => array(
				'show' => 'yes',
				'required' => 'yes',
				'label' => '',
				'placeholder' => '',
				'type' => 'textarea',
			),
			'shipping_address_2' => array(
				'show' => 'no',
				'required' => 'no',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'shipping_country' => array(
				'show' => '',
				'required' => '',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
			'shipping_postcode' => array(
				'show' => 'yes',
				'required' => 'no',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
		);

		$this->additional_fields_default = array(
			'order_comments' => array(
				'show' => 'yes',
				'required' => 'no',
				'label' => '',
				'placeholder' => '',
				'type' => '',
			),
		);

	}

	private function fields_setup(){

		$this->billing_fields_setup = array(
			'billing_first_name' => array(
				'show' => false,
				'required' => false,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'billing_last_name' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'billing_company' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'billing_address_1' => array(
				'show' => false,
				'required' => false,
				'label' => true,
				'placeholder' => true,
				'type' => true,
				'type_choices' => array( 'text' => 'text', 'textarea' => 'textarea' ),
			),
			'billing_address_2' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'billing_country' => array(
				'show' => false,
				'required' => false,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'billing_postcode' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'billing_phone' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'billing_email' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
		);

		$this->shipping_fields_setup = array(
			'shipping_first_name' => array(
				'show' => false,
				'required' => false,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'shipping_last_name' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'shipping_company' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'shipping_address_1' => array(
				'show' => false,
				'required' => false,
				'label' => true,
				'placeholder' => true,
				'type' => true,
				'type_choices' => array( 'text' => 'text', 'textarea' => 'textarea' ),
			),
			'shipping_address_2' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'shipping_country' => array(
				'show' => false,
				'required' => false,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
			'shipping_postcode' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
		);

		$this->additional_fields_setup = array(
			'order_comments' => array(
				'show' => true,
				'required' => true,
				'label' => true,
				'placeholder' => true,
				'type' => false,
			),
		);

	}

	private function fields_text(){

		$this->billing_fields_text = array(
			'billing_first_name' => array(
				'label' => __( 'Nama Depan', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'billing_last_name' => array(
				'label' => __( 'Nama Belakang', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'billing_company' => array(
				'label' => __( 'Nama Perusahaan', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'billing_address_1' => array(
				'label' => __( 'Alamat Lengkap', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => __( 'Nama jalan dan nomor rumah', 'wpbisnis-wc-indo-ongkir' ),
			),
			'billing_address_2' => array(
				'label' => '',
				'placeholder' => __( 'tambahan detail alamat (opsional)', 'wpbisnis-wc-indo-ongkir' ),
			),
			'billing_country' => array(
				'label' => __( 'Negara', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'billing_postcode' => array(
				'label' => __( 'Kode Pos', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'billing_phone' => array(
				'label' => __( 'No HP / Whatsapp', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'billing_email' => array(
				'label' => __( 'Email', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
		);

		$this->shipping_fields_text = array(
			'shipping_first_name' => array(
				'label' => __( 'Nama Depan', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'shipping_last_name' => array(
				'label' => __( 'Nama Belakang', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'shipping_company' => array(
				'label' => __( 'Nama Perusahaan', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'shipping_address_1' => array(
				'label' => __( 'Alamat Lengkap', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => __( 'Nama jalan dan nomor rumah', 'wpbisnis-wc-indo-ongkir' ),
			),
			'shipping_address_2' => array(
				'label' => '',
				'placeholder' => __( 'tambahan detail alamat (opsional)', 'wpbisnis-wc-indo-ongkir' ),
			),
			'shipping_country' => array(
				'label' => __( 'Negara', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
			'shipping_postcode' => array(
				'label' => __( 'Kode Pos', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => '',
			),
		);

		$this->additional_fields_text = array(
			'order_comments' => array(
				'label' => __( 'Catatan Tambahan', 'wpbisnis-wc-indo-ongkir' ),
				'placeholder' => __( 'Catatan dari Anda untuk order ini.', 'wpbisnis-wc-indo-ongkir' ),
			),
		);

	}

	public function is_active() {

		if ( version_compare( WC_VERSION, '3.0.0', '<' ) )
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

		$status = get_option( 'wpbisnis_wc_indo_checkout_status' );
		if ( 'no' == $status )
			return false;

		return true;
	}

	public function add_settings_tab( $settings_tabs ) {
		$settings_tabs['indo_checkout'] = __( 'Indo Checkout', 'wpbisnis-wc-indo-ongkir' );
		return $settings_tabs;
	}

	public function settings_tab() {
		woocommerce_admin_fields( $this->get_settings() );
	}

	public function update_settings() {
		woocommerce_update_options( $this->get_settings() );
		if ( isset( $_POST['indo_checkout_billing'] ) ) {
			$billing_fields = $_POST['indo_checkout_billing'];
			foreach ( $billing_fields as $field_id => $field ) {
				foreach ( $field as $field_key => $field_value) {
					$billing_fields[$field_id][$field_key] = sanitize_text_field( $field_value );
				}
			}
			// var_dump( $billing_fields );
			update_option( 'wpbisnis_wc_indo_checkout_billing', $billing_fields, 'yes' );
		}
		if ( isset( $_POST['indo_checkout_shipping'] ) ) {
			$shipping_fields = $_POST['indo_checkout_shipping'];
			foreach ( $shipping_fields as $field_id => $field ) {
				foreach ( $field as $field_key => $field_value) {
					$shipping_fields[$field_id][$field_key] = sanitize_text_field( $field_value );
				}
			}
			// var_dump( $shipping_fields );
			update_option( 'wpbisnis_wc_indo_checkout_shipping', $shipping_fields, 'yes' );
		}
		if ( isset( $_POST['indo_checkout_additional'] ) ) {
			$additional_fields = $_POST['indo_checkout_additional'];
			foreach ( $additional_fields as $field_id => $field ) {
				foreach ( $field as $field_key => $field_value) {
					$additional_fields[$field_id][$field_key] = sanitize_text_field( $field_value );
				}
			}
			// var_dump( $additional_fields );
			update_option( 'wpbisnis_wc_indo_checkout_additional', $additional_fields, 'yes' );
		}
	}

	public function get_settings() {

		$this->billing_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_billing' ), $this->billing_fields_default );

		$this->shipping_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_shipping' ), $this->shipping_fields_default );

		$this->additional_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_additional' ), $this->additional_fields_default );

		$settings = array(
			array(
				'name'     => __( 'Indo Checkout', 'wpbisnis-wc-indo-ongkir' ),
				'type'     => 'title',
				'desc'     => '<p>'.__( 'Berikut ini beberapa settings yang dapat Anda gunakan untuk mengatur tampilan halaman Checkout.', 'wpbisnis-wc-indo-ongkir' ).'</p>',
				'id'       => 'wpbisnis_wc_indo_checkout_section_title',
			),
			array(
				'title'         => __( 'Status', 'wpbisnis-wc-indo-ongkir' ),
				'desc'          => __( 'Aktifkan modul Indo Checkout', 'wpbisnis-wc-indo-ongkir' ),
				'id'            => 'wpbisnis_wc_indo_checkout_status',
				'default'       => 'yes',
				'type'          => 'checkbox',
				'autoload'      => true,
			),
			array(
				'type'     => 'wpbisnis_wc_indo_checkout_billing_fields',
			),
			array(
				'type'     => 'wpbisnis_wc_indo_checkout_shipping_fields',
			),
			array(
				'type'     => 'wpbisnis_wc_indo_checkout_additional_fields',
			),
			array(
				'type' => 'sectionend',
				'id' => 'wpbisnis_wc_indo_checkout_section_end'
			),
		);

		return apply_filters( 'wc_settings_tab_indo_checkout_settings', $settings );
	}

	public function admin_billing_fields() {
		$this->admin_fields( array( 
			'fields' => $this->billing_fields,
			'fields_setup' => $this->billing_fields_setup,
			'fields_text' => $this->billing_fields_text,
			'fields_title' => __( 'Billing Fields', 'wpbisnis-wc-indo-ongkir' ),
			'fields_post' => 'indo_checkout_billing',
		));
	}

	public function admin_shipping_fields() {
		$this->admin_fields( array( 
			'fields' => $this->shipping_fields,
			'fields_setup' => $this->shipping_fields_setup,
			'fields_text' => $this->shipping_fields_text,
			'fields_title' => __( 'Shipping Fields', 'wpbisnis-wc-indo-ongkir' ),
			'fields_post' => 'indo_checkout_shipping',
		));
	}

	public function admin_additional_fields() {
		$this->admin_fields( array( 
			'fields' => $this->additional_fields,
			'fields_setup' => $this->additional_fields_setup,
			'fields_text' => $this->additional_fields_text,
			'fields_title' => __( 'Additional Fields', 'wpbisnis-wc-indo-ongkir' ),
			'fields_post' => 'indo_checkout_additional',
		));
	}

	public function billing_fields( $fields ) {

		$this->billing_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_billing' ), $this->billing_fields_default );

		foreach ( $this->billing_fields as $billing_field_id => $billing_field ) {
			if ( 'no' == $billing_field['show'] ) {
				unset( $fields[$billing_field_id] );
			}
			else {
				if ( 'yes' == $billing_field['required'] ) {
					$fields[$billing_field_id]['required'] = true;
				}
				elseif ( 'no' == $billing_field['required'] ) {
					$fields[$billing_field_id]['required'] = false;
				}
				if ( $billing_field['label'] ) {
					$fields[$billing_field_id]['label'] = $billing_field['label'];
				}
				else {
					if ( $this->billing_fields_text[$billing_field_id]['label'] ) {
						$fields[$billing_field_id]['label'] = $this->billing_fields_text[$billing_field_id]['label'];
					}
				}
				if ( $billing_field['placeholder'] ) {
					$fields[$billing_field_id]['placeholder'] = $billing_field['placeholder'];
				}
				else {
					if ( $this->billing_fields_text[$billing_field_id]['placeholder'] ) {
						$fields[$billing_field_id]['placeholder'] = $this->billing_fields_text[$billing_field_id]['placeholder'];
					}
				}
				if ( $billing_field['type'] ) {
					$fields[$billing_field_id]['type'] = $billing_field['type'];
				}
			}
		}
		if ( 'no' == $this->billing_fields['billing_last_name']['show'] ) {
			$fields['billing_first_name']['class'] = array('form-row-wide');
		}

		return $fields;
	}

	public function shipping_fields( $fields ) {

		$this->shipping_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_shipping' ), $this->shipping_fields_default );

		foreach ( $this->shipping_fields as $shipping_field_id => $shipping_field ) {
			if ( 'no' == $shipping_field['show'] ) {
				unset( $fields[$shipping_field_id] );
			}
			else {
				if ( 'yes' == $shipping_field['required'] ) {
					$fields[$shipping_field_id]['required'] = true;
				}
				elseif ( 'no' == $shipping_field['required'] ) {
					$fields[$shipping_field_id]['required'] = false;
				}
				if ( $shipping_field['label'] ) {
					$fields[$shipping_field_id]['label'] = $shipping_field['label'];
				}
				else {
					if ( $this->shipping_fields_text[$shipping_field_id]['label'] ) {
						$fields[$shipping_field_id]['label'] = $this->shipping_fields_text[$shipping_field_id]['label'];
					}
				}
				if ( $shipping_field['placeholder'] ) {
					$fields[$shipping_field_id]['placeholder'] = $shipping_field['placeholder'];
				}
				else {
					if ( $this->shipping_fields_text[$shipping_field_id]['placeholder'] ) {
						$fields[$shipping_field_id]['placeholder'] = $this->shipping_fields_text[$shipping_field_id]['placeholder'];
					}
				}
				if ( $shipping_field['type'] ) {
					$fields[$shipping_field_id]['type'] = $shipping_field['type'];
				}
			}
		}
		if ( 'no' == $this->shipping_fields['shipping_last_name']['show'] ) {
			$fields['shipping_first_name']['class'] = array('form-row-wide');
		}

		return $fields;
	}

	public function checkout_fields( $fields ) {

		$this->billing_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_billing' ), $this->billing_fields_default );

		foreach ( $this->billing_fields as $billing_field_id => $billing_field ) {
			if ( 'no' == $billing_field['show'] ) {
				unset( $fields['billing'][$billing_field_id] );
			}
			else {
				if ( 'yes' == $billing_field['required'] ) {
					$fields['billing'][$billing_field_id]['required'] = true;
				}
				elseif ( 'no' == $billing_field['required'] ) {
					$fields['billing'][$billing_field_id]['required'] = false;
				}
				if ( $billing_field['label'] ) {
					$fields['billing'][$billing_field_id]['label'] = $billing_field['label'];
				}
				else {
					if ( $this->billing_fields_text[$billing_field_id]['label'] ) {
						$fields['billing'][$billing_field_id]['label'] = $this->billing_fields_text[$billing_field_id]['label'];
					}
				}
				if ( $billing_field['placeholder'] ) {
					$fields['billing'][$billing_field_id]['placeholder'] = $billing_field['placeholder'];
				}
				else {
					if ( $this->billing_fields_text[$billing_field_id]['placeholder'] ) {
						$fields['billing'][$billing_field_id]['placeholder'] = $this->billing_fields_text[$billing_field_id]['placeholder'];
					}
				}
				if ( $billing_field['type'] ) {
					$fields['billing'][$billing_field_id]['type'] = $billing_field['type'];
				}
			}
		}
		if ( 'no' == $this->billing_fields['billing_last_name']['show'] ) {
			$fields['billing']['billing_first_name']['class'] = array('form-row-wide');
		}

		$this->shipping_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_shipping' ), $this->shipping_fields_default );

		foreach ( $this->shipping_fields as $shipping_field_id => $shipping_field ) {
			if ( 'no' == $shipping_field['show'] ) {
				unset( $fields['shipping'][$shipping_field_id] );
			}
			else {
				if ( 'yes' == $shipping_field['required'] ) {
					$fields['shipping'][$shipping_field_id]['required'] = true;
				}
				elseif ( 'no' == $shipping_field['required'] ) {
					$fields['shipping'][$shipping_field_id]['required'] = false;
				}
				if ( $shipping_field['label'] ) {
					$fields['shipping'][$shipping_field_id]['label'] = $shipping_field['label'];
				}
				else {
					if ( $this->shipping_fields_text[$shipping_field_id]['label'] ) {
						$fields['shipping'][$shipping_field_id]['label'] = $this->shipping_fields_text[$shipping_field_id]['label'];
					}
				}
				if ( $shipping_field['placeholder'] ) {
					$fields['shipping'][$shipping_field_id]['placeholder'] = $shipping_field['placeholder'];
				}
				else {
					if ( $this->shipping_fields_text[$shipping_field_id]['placeholder'] ) {
						$fields['shipping'][$shipping_field_id]['placeholder'] = $this->shipping_fields_text[$shipping_field_id]['placeholder'];
					}
				}
				if ( $shipping_field['type'] ) {
					$fields['shipping'][$shipping_field_id]['type'] = $shipping_field['type'];
				}
			}
		}
		if ( 'no' == $this->shipping_fields['shipping_last_name']['show'] ) {
			$fields['shipping']['shipping_first_name']['class'] = array('form-row-wide');
		}

		$this->additional_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_additional' ), $this->additional_fields_default );

		foreach ( $this->additional_fields as $additional_field_id => $additional_field ) {
			if ( 'no' == $additional_field['show'] ) {
				unset( $fields['order'][$additional_field_id] );
			}
			else {
				if ( 'yes' == $additional_field['required'] ) {
					$fields['order'][$additional_field_id]['required'] = true;
				}
				elseif ( 'no' == $additional_field['required'] ) {
					$fields['order'][$additional_field_id]['required'] = false;
				}
				if ( $additional_field['label'] ) {
					$fields['order'][$additional_field_id]['label'] = $additional_field['label'];
				}
				else {
					if ( $this->additional_fields_text[$additional_field_id]['label'] ) {
						$fields['order'][$additional_field_id]['label'] = $this->additional_fields_text[$additional_field_id]['label'];
					}
				}
				if ( $additional_field['placeholder'] ) {
					$fields['order'][$additional_field_id]['placeholder'] = $additional_field['placeholder'];
				}
				else {
					if ( $this->additional_fields_text[$additional_field_id]['placeholder'] ) {
						$fields['order'][$additional_field_id]['placeholder'] = $this->additional_fields_text[$additional_field_id]['placeholder'];
					}
				}
				if ( $additional_field['type'] ) {
					$fields['order'][$additional_field_id]['type'] = $additional_field['type'];
				}
			}
		}

		return $fields;
	}

	public function country_locale( $locale ) {

		$this->billing_fields = $this->parse_args( get_option( 'wpbisnis_wc_indo_checkout_billing' ), $this->billing_fields_default );

		$locale_fields = array(
			'address_1',
			'address_2',
			'country',
			'postcode',
		);

		foreach ( $locale_fields as $locale_field ) {
			$billing_field_id = 'billing_'.$locale_field;
			$billing_field = $this->billing_fields[$billing_field_id];
			if ( 'no' == $billing_field['show'] ) {
				$locale['ID'][$locale_field]['hidden'] = true;
			}
			else {
				if ( 'yes' == $billing_field['required'] ) {
					$locale['ID'][$locale_field]['required'] = true;
				}
				elseif ( 'no' == $billing_field['required'] ) {
					$locale['ID'][$locale_field]['required'] = false;
				}
				if ( $billing_field['label'] ) {
					$locale['ID'][$locale_field]['label'] = $billing_field['label'];
				}
				else {
					if ( $this->billing_fields_text[$billing_field_id]['label'] ) {
						$locale['ID'][$locale_field]['label'] = $this->billing_fields_text[$billing_field_id]['label'];
					}
				}
				if ( $billing_field['placeholder'] ) {
					$locale['ID'][$locale_field]['placeholder'] = $billing_field['placeholder'];
				}
				else {
					if ( $this->billing_fields_text[$billing_field_id]['placeholder'] ) {
						$locale['ID'][$locale_field]['placeholder'] = $this->billing_fields_text[$billing_field_id]['placeholder'];
					}
				}
			}
		}
		return $locale;
	}

	private function parse_args( $args, $defaults ) {
		if ( empty( $defaults ) ) {
			return $args;
		}
		if ( empty( $args ) ) {
			return $defaults;
		}
		foreach ( $args as $field_key => $field_value ) {
			if ( isset( $defaults[$field_key] ) ) {
				$args[$field_key] = wp_parse_args( $args[$field_key], $defaults[$field_key] );
			}
			else {
				unset( $args[$field_key] );
			}
		}
		foreach ( $defaults as $field_key => $field_value ) {
			if ( !isset( $args[$field_key] ) ) {
				$args[$field_key] = $defaults[$field_key];
			}
		}
		return $args;		
	}

	private function admin_fields( $args = array() ) {
		if ( empty( $args ) ) {
			return;
		}
		$fields = $args['fields'];
		$fields_setup = $args['fields_setup'];
		$fields_title = $args['fields_title'];
		$fields_post = $args['fields_post'];
		$fields_text = $args['fields_text'];
		?>
		<tr valign="top">
			<th scope="row" class="titledesc">
				<style>
					.indo-checkout-fields-id { background-color: #f5f5f5; padding: 6px; font-weight: bold; } 
					.indo-checkout-fields { background-color: #f5f5f5; padding: 6px; } 
					.indo-checkout-select { border: 0; box-shadow: none; }
					.indo-checkout-radio { padding: 6px 6px 0 6px; }
					table.wc_input_table tr.current td .indo-checkout-fields-id { background-color: #fefbcc }
					table.wc_input_table tr.current td .indo-checkout-fields { background-color: #fefbcc }
				</style>
				<?php echo esc_html( $fields_title ); ?>
			</th>
			<td class="forminp">
				<table class="widefat wc_input_table" cellspacing="0">
					<thead>
						<tr>
							<th><?php _e( 'ID', 'wpbisnis-wc-indo-ongkir' ); ?></th>
							<th><?php _e( 'Show', 'wpbisnis-wc-indo-ongkir' ); ?></th>
							<th><?php _e( 'Required', 'wpbisnis-wc-indo-ongkir' ); ?></th>
							<th><?php _e( 'Label', 'wpbisnis-wc-indo-ongkir' ); ?></th>
							<th><?php _e( 'Placeholder', 'wpbisnis-wc-indo-ongkir' ); ?></th>
							<th><?php _e( 'Type', 'wpbisnis-wc-indo-ongkir' ); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ( $fields as $field_id => $field ) : ?>
						<tr>
							<td>
								<div class="indo-checkout-fields-id">
									<?php echo $field_id; ?>
								</div>
							</td>
							<td>
								<?php if ( $fields_setup[$field_id]['show'] ) : ?>
									<?php $this->field_select( array(
										'name' => $fields_post.'['.$field_id.'][show]',
										'value' => $field['show'],
									) ); ?>
								<?php else : ?>
									<div class="indo-checkout-fields">
										<?php echo $field['show'] ? $field['show'] : '&nbsp;'; ?>
									</div>
								<?php endif; ?>
							</td>
							<td>
								<?php if ( $fields_setup[$field_id]['required'] ) : ?>
									<?php $this->field_select( array(
										'name' => $fields_post.'['.$field_id.'][required]',
										'value' => $field['required'],
									) ); ?>
								<?php else : ?>
									<div class="indo-checkout-fields">
										<?php echo $field['required'] ? $field['required'] : '&nbsp;'; ?>
									</div>
								<?php endif; ?>
							</td>
							<td>
								<?php if ( $fields_setup[$field_id]['label'] ) : ?>
									<?php $this->field_input( array(
										'name' => $fields_post.'['.$field_id.'][label]',
										'value' => $field['label'],
										'placeholder' => $fields_text[$field_id]['label'],
									) ); ?>
								<?php else : ?>
									<div class="indo-checkout-fields">
										&nbsp;
									</div>
								<?php endif; ?>
							</td>
							<td>
								<?php if ( $fields_setup[$field_id]['placeholder'] ) : ?>
									<?php $this->field_input( array(
										'name' => $fields_post.'['.$field_id.'][placeholder]',
										'value' => $field['placeholder'],
										'placeholder' => $fields_text[$field_id]['placeholder'],
									) ); ?>
								<?php else : ?>
									<div class="indo-checkout-fields">
										&nbsp;
									</div>
								<?php endif; ?>
							</td>
							<td>
								<?php if ( $fields_setup[$field_id]['type'] ) : ?>
									<?php $this->field_select( array(
										'name' => $fields_post.'['.$field_id.'][type]',
										'value' => $field['type'],
										'choices' => $fields_setup[$field_id]['type_choices'],
									) ); ?>
								<?php else : ?>
									<div class="indo-checkout-fields">
										<?php echo $field['type'] ? $field['type'] : '&nbsp;'; ?>
									</div>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</td>
		</tr>
		<?php
	}

	private function field_input( $args = array() ) {
		if ( empty( $args ) ) {
			return;
		}
		if ( true === $args['placeholder'] ) {
			$args['placeholder'] = '';
		}
		echo '<input type="text" name="'.$args['name'].'" placeholder="'.$args['placeholder'].'" value="'.$args['value'].'" class="indo-checkout-text">';
	}

	private function field_select( $args = array() ) {
		if ( empty( $args ) ) {
			return;
		}
		if ( !isset( $args['choices'] ) || ( isset( $args['choices'] ) && empty( $args['choices'] ) ) ) {
			$args['choices'] = array( 'yes' => 'yes', 'no' => 'no' );
		}
		echo '<select name="'.$args['name'].'" class="indo-checkout-select">';
		foreach ( $args['choices'] as $value => $choice ) {
			if ( $value == $args['value'] ) {
				echo '<option value="'.$value.'" selected="selected">'.$choice.'</option>';
			}
			else {
				echo '<option value="'.$value.'">'.$choice.'</option>';
			}
		}
		echo '</select>';
	}

	private function field_radio( $args = array() ) {
		if ( empty( $args ) ) {
			return;
		}
		if ( !isset( $args['choices'] ) || ( isset( $args['choices'] ) && empty( $args['choices'] ) ) ) {
			$args['choices'] = array( 'yes' => 'yes', 'no' => 'no' );
		}
		foreach ( $args['choices'] as $value => $choice ) {
			echo '<span class="indo-checkout-radio">';
			if ( $value == $args['value'] ) {
				echo '<input type="radio" name="'.$args['name'].'" value="'.$value.'" checked="checked">'.$choice.' ';
			}
			else {
				echo '<input type="radio" name="'.$args['name'].'" value="'.$value.'">'.$choice.' ';
			}
			echo '</span>';
		}
	}

}
if ( WPBISNIS_WC_INDO_ONGKIR_PLUGIN ) {
	add_action( 'plugins_loaded' , array( 'WPBisnis_WC_Indo_Checkout_Init' , 'get_instance' ), 0 );
}
else {
	WPBisnis_WC_Indo_Checkout_Init::get_instance();
}
