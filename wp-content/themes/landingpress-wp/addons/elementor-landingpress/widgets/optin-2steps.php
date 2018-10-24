<?php
namespace ElementorLandingPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LP_Optin_2steps extends Widget_Base {

	public function get_name() {
		return 'optin_2steps';
	}

	public function get_title() {
		return __( 'LP - 2 Steps Opt-in Form', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-dual-button';
	}

	public function get_categories() {
		return [ 'landingpress' ];
	}

	public function get_script_depends() {
		return [ 'magnific-popup' ];
	}

	public function get_style_depends() {
		return [ 'magnific-popup' ];
	}

	public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'landingpress-wp' ),
			'sm' => __( 'Small', 'landingpress-wp' ),
			'md' => __( 'Medium', 'landingpress-wp' ),
			'lg' => __( 'Large', 'landingpress-wp' ),
			'xl' => __( 'Extra Large', 'landingpress-wp' ),
		];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_optin_description',
			[
				'label' => __( 'PENTING!', 'landingpress-wp' ),
			]
		);

		$description = __( 'Anda bisa menggunakan widget ini untuk memasukkan kode HTML opt-in form dari pihak ketiga dalam mode <strong style="color:#9b0a46;">tanpa styling (raw)</strong>, sehingga bisa kita styling (percantik) di sini.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Namun, jika Anda mempunyai kode HTML opt-in form dari pihak ketiga dengan styling tersendiri, jangan gunakan widget ini, langsung gunakan widget <strong style="color:#4054b2;">HTML</strong> saja.', 'landingpress-wp' );

		$this->add_control(
			'optin_description',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_optin',
			[
				'label' => __( 'Opt-in Form Popup', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'optin_heading',
			[
				'label' => __( 'Heading', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => '2',
				'default' => __( 'Title on your opt-in popup', 'landingpress-wp' ),
				'placeholder' => __( 'Title on your opt-in popup', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'optin_subheading',
			[
				'label' => __( 'Subheading', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => '2',
				'default' => '',
				'placeholder' => __( 'Description on your opt-in popup', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'optin',
			[
				'label' => __( 'Opt-in Form Code', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '',
				'placeholder' => __( 'Enter your optin form code here', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'optin_display',
			[
				'label' => __( 'Form Display', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'default' => __( 'Default', 'landingpress-wp' ),
					'fullwidth' => __( 'Full Width', 'landingpress-wp' ),
					'inline' => __( 'Inline', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'optin_button_width',
			[
				'label' => __( 'Form Button Width', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'default' => __( 'Default', 'landingpress-wp' ),
					'input' => __( 'Input Width', 'landingpress-wp' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_optin_label_style',
			[
				'label' => __( 'Opt-in Label (If Available)', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'optin_label_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.elementor-popup-block-white .elementor-lp-form-wrapper label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'optin_label_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '.elementor-popup-block-white .elementor-lp-form-wrapper label',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_optin_input_style',
			[
				'label' => __( 'Opt-in Input', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'optin_input_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.elementor-popup-block-white .elementor-lp-form-wrapper input[type="text"], .elementor-popup-block-white .elementor-lp-form-wrapper input[type="email"], .elementor-popup-block-white .elementor-lp-form-wrapper textarea' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'optin_input_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '.elementor-popup-block-white .elementor-lp-form-wrapper input[type="text"], .elementor-popup-block-white .elementor-lp-form-wrapper input[type="email"], .elementor-popup-block-white .elementor-lp-form-wrapper textarea',
			]
		);

		$this->add_control(
			'optin_input_background_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.elementor-popup-block-white .elementor-lp-form-wrapper input[type="text"], .elementor-popup-block-white .elementor-lp-form-wrapper input[type="email"], .elementor-popup-block-white .elementor-lp-form-wrapper textarea' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'optin_input_border',
				'label' => __( 'Border', 'landingpress-wp' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '.elementor-popup-block-white .elementor-lp-form-wrapper input[type="text"], .elementor-popup-block-white .elementor-lp-form-wrapper input[type="email"], .elementor-popup-block-white .elementor-lp-form-wrapper textarea',
			]
		);

		$this->add_control(
			'optin_input_border_radius',
			[
				'label' => __( 'Border Radius', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'.elementor-popup-block-white .elementor-lp-form-wrapper input[type="text"], .elementor-popup-block-white .elementor-lp-form-wrapper input[type="email"], .elementor-popup-block-white .elementor-lp-form-wrapper textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'optin_input_text_padding',
			[
				'label' => __( 'Text Padding', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'.elementor-popup-block-white .elementor-lp-form-wrapper input[type="text"], .elementor-popup-block-white .elementor-lp-form-wrapper input[type="email"], .elementor-popup-block-white .elementor-lp-form-wrapper textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_optin_button_style',
			[
				'label' => __( 'Opt-in Button', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'optin_button_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.elementor-popup-block-white .elementor-lp-form-wrapper input[type="submit"], .elementor-popup-block-white .elementor-lp-form-wrapper button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'optin_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '.elementor-popup-block-white .elementor-lp-form-wrapper input[type="submit"], .elementor-popup-block-white .elementor-lp-form-wrapper button',
			]
		);

		$this->add_control(
			'optin_background_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'.elementor-popup-block-white .elementor-lp-form-wrapper input[type="submit"], .elementor-popup-block-white .elementor-lp-form-wrapper button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'optin_border',
				'label' => __( 'Border', 'landingpress-wp' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '.elementor-popup-block-white .elementor-lp-form-wrapper input[type="submit"], .elementor-popup-block-white .elementor-lp-form-wrapper button',
			]
		);

		$this->add_control(
			'optin_border_radius',
			[
				'label' => __( 'Border Radius', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'.elementor-popup-block-white .elementor-lp-form-wrapper input[type="submit"], .elementor-popup-block-white .elementor-lp-form-wrapper button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'optin_text_padding',
			[
				'label' => __( 'Text Padding', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'.elementor-popup-block-white .elementor-lp-form-wrapper input[type="submit"], .elementor-popup-block-white .elementor-lp-form-wrapper button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_optin_button_hover',
			[
				'label' => __( 'Opt-in Button Hover', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'optin_hover_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.elementor-popup-block-white .elementor-lp-form-wrapper input[type="submit"]:hover, .elementor-popup-block-white .elementor-lp-form-wrapper button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'optin_button_background_hover_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.elementor-popup-block-white .elementor-lp-form-wrapper input[type="submit"]:hover, .elementor-popup-block-white .elementor-lp-form-wrapper button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'optin_button_hover_border_color',
			[
				'label' => __( 'Border Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.elementor-popup-block-white .elementor-lp-form-wrapper input[type="submit"]:hover, .elementor-popup-block-white .elementor-lp-form-wrapper button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'optin_hover_animation',
			[
				'label' => __( 'Animation', 'landingpress-wp' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button',
			[
				'label' => __( 'Button', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'button_type',
			[
				'label' => __( 'Type', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'landingpress-wp' ),
					'info' => __( 'Info', 'landingpress-wp' ),
					'success' => __( 'Success', 'landingpress-wp' ),
					'warning' => __( 'Warning', 'landingpress-wp' ),
					'danger' => __( 'Danger', 'landingpress-wp' ),
				],
				'prefix_class' => 'elementor-button-',
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __( 'Text', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click me', 'landingpress-wp' ),
				'placeholder' => __( 'Click me', 'landingpress-wp' ),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'landingpress-wp' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'landingpress-wp' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'landingpress-wp' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'landingpress-wp' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'landingpress-wp' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'Size', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'medium',
				'options' => self::get_button_sizes(),
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'landingpress-wp' ),
				'type' => Controls_Manager::ICON,
				'label_block' => true,
				'default' => '',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => __( 'Icon Position', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Before', 'landingpress-wp' ),
					'right' => __( 'After', 'landingpress-wp' ),
				],
				'condition' => [
					'icon!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => __( 'Icon Spacing', 'landingpress-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'landingpress-wp' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_sticky',
			[
				'label' => __( 'Sticky / Floating Button', 'landingpress-wp' ),
			]
		);

		$description = __( 'PERHATIAN:', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Jika ingin menggunakan sticky / floating button, harap letakkan button ini di <strong style="color:#9b0a46;">SECTION PALING BAWAH</strong> untuk mendapatkan hasil terbaik.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Silahkan ke tab <strong style="color:#4054b2;">Advanced - Responsive</strong> jika ingin menyembunyikan sticky button di tampilan DESKTOP.', 'landingpress-wp' );

		$this->add_control(
			'floating_description',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$this->add_control(
			'floating',
			[
				'label' => __( 'Sticky / Floating', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => __( 'Yes', 'landingpress-wp' ),
				'label_off' => __( 'No', 'landingpress-wp' ),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_fbpixel',
			[
				'label' => __( 'Facebook Pixel', 'landingpress-wp' ),
			]
		);

		$description = __( 'PERHATIAN:', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Jika ingin menggunakan fitur ini, pastikan ada minimal satu <strong style="color:#9b0a46;">Facebook Pixel ID</strong> yang aktif.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Silahkan ke <strong style="color:#4054b2;">WordPress Dashboard - Appearance - Customize - LandingPress - Facebook Pixel</strong> untuk memasukkan Facebook Pixel ID.', 'landingpress-wp' );

		$this->add_control(
			'fbevent_description',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$this->add_control(
			'fbevent',
			[
				'label' => __( 'Onclick FB Event', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'No Event', 'landingpress-wp' ),
					'ViewContent' => __( 'ViewContent', 'landingpress-wp' ),
					'AddToCart' => __( 'AddToCart', 'landingpress-wp' ),
					'InitiateCheckout' => __( 'InitiateCheckout', 'landingpress-wp' ),
					'AddCustomerInfo' => __( 'AddCustomerInfo', 'landingpress-wp' ),
					'AddPaymentInfo' => __( 'AddPaymentInfo', 'landingpress-wp' ),
					'Purchase' => __( 'Purchase', 'landingpress-wp' ),
					'AddToWishlist' => __( 'AddToWishlist', 'landingpress-wp' ),
					'Lead' => __( 'Lead', 'landingpress-wp' ),
					'CompleteRegistration' => __( 'CompleteRegistration', 'landingpress-wp' ),
					'custom' => __( 'Custom Event', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'fbcustomevent',
			[
				'label' => __( 'Custom Event Name', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'condition' => [
					'fbevent' => 'custom',
				],
			]
		);

		$this->add_control(
			'fb_value',
			[
				'label' => __( 'value', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'condition' => [
					'fbevent!' => '',
				],
			]
		);

		$this->add_control(
			'fb_currency',
			[
				'label' => __( 'currency', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'IDR',
				'options' => [
					'IDR' => 'IDR',
					'USD' => 'USD',
				],
				'condition' => [
					'fbevent!' => '',
				],
			]
		);

		$this->add_control(
			'fb_content_name',
			[
				'label' => __( 'content_name', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => get_the_title(),
				'condition' => [
					'fbevent!' => '',
				],
			]
		);

		$this->add_control(
			'fb_content_ids',
			[
				'label' => __( 'content_ids', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'condition' => [
					'fbevent!' => '',
				],
			]
		);

		$this->add_control(
			'fb_content_type',
			[
				'label' => __( 'content_type', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'product',
				'options' => [
					'product' => 'product',
					'product_group' => 'product_group',
				],
				'condition' => [
					'fbevent!' => '',
				],
			]
		);

		$this->add_control(
			'fb_campaign_url',
			[
				'label' => __( 'campaign_url', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => get_post_field( 'post_name', get_the_ID() ),
				'condition' => [
					'fbevent!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_adwords',
			[
				'label' => __( 'Google AdWords', 'landingpress-wp' ),
			]
		);

		$description = __( 'PERHATIAN:', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Jika ingin menggunakan fitur ini dengan AdWords versi baru (beta), pastikan ada minimal satu <strong style="color:#9b0a46;">Google AdWords Global Site Tag ID</strong> yang aktif.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Jika ingin menggunakan fitur ini dengan AdWords versi lama, harap masukkan kode adwords conversion untuk "onclick button" di <strong style="color:#9b0a46;">Custom Footer Scripts</strong> di halaman ini.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Silahkan ke <strong style="color:#4054b2;">WordPress Dashboard - Appearance - Customize - LandingPress - Google AdWords</strong> untuk memasukkan Google AdWords Global Site Tag ID (versi baru) atau AdWords Remarketing Tag (versi lama).', 'landingpress-wp' );

		$this->add_control(
			'grc_description',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$this->add_control(
			'grc',
			[
				'label' => __( 'Onclick AdWords Conversion', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => __( 'Yes', 'landingpress-wp' ),
				'label_off' => __( 'No', 'landingpress-wp' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'aw_send_to',
			[
				'label' => __( 'send_to', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'condition' => [
					'grc!' => '',
				],
			]
		);

		$this->add_control(
			'aw_value',
			[
				'label' => __( 'value', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'condition' => [
					'grc!' => '',
				],
			]
		);

		$this->add_control(
			'aw_currency',
			[
				'label' => __( 'currency', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => 'IDR',
				'condition' => [
					'grc!' => '',
				],
			]
		);

		$this->add_control(
			'aw_transaction_id',
			[
				'label' => __( 'transaction_id', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'condition' => [
					'grc!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_sticky_style',
			[
				'label' => __( 'Sticky / Floating Button Container', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'floating!' => '',
				],
			]
		);

		$this->add_control(
			'floating_bg_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button-sticky-yes' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'floating!' => '',
				],
			]
		);

		$this->add_control(
			'floating_padding',
			[
				'label' => __( 'Padding', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button-sticky-yes' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'floating!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Button', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Animation', 'landingpress-wp' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'landingpress-wp' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'text_padding',
			[
				'label' => __( 'Text Padding', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		$selector = 'elementor-popup-form-'.rand( 1000, 9999 );

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

		// if ( ! empty( $settings['align'] ) ) {
		// 	$this->add_render_attribute( 'wrapper', 'class', 'elementor-align-' . $settings['align'] );
		// }

		$this->add_render_attribute( 'button', 'class', 'elementor-popup-with-form' );
		$this->add_render_attribute( 'button', 'href', '#'.$selector );
		$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );

		$this->add_render_attribute( 'button', 'class', 'elementor-button' );

		if ( ! empty( $settings['size'] ) ) {
			$size_to_replace = [
				'small' => 'xs',
				'medium' => 'sm',
				'large' => 'md',
				'xl' => 'lg',
				'xxl' => 'xl',
			];
			$old_size = $settings['size'];
			if ( isset( $size_to_replace[ $old_size ] ) ) {
				$settings['size'] = $size_to_replace[ $old_size ];
			}
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
		}


		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		if ( $settings['floating'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-sticky-' . $settings['floating'] );
		}

		if ( $settings['fbevent'] ) {
			if ( $settings['fbevent'] == 'custom' ) {
				if ( $settings['fbcustomevent'] ) {
					$this->add_render_attribute( 'button', 'data-fbcustomevent', $settings['fbcustomevent'] );
				}					
			}
			else {
				$this->add_render_attribute( 'button', 'data-fbevent', $settings['fbevent'] );
			}
			$fb_data = [];
			$fb_data['source'] = 'landingpress-elementor';
			$fb_data['source_widget'] = $this->get_name();
			$fb_data['version'] = LANDINGPRESS_THEME_VERSION;
			$fb_data['version_elementor'] = LANDINGPRESS_ELEMENTOR_VERSION;
			$fb_data['domain'] = str_replace( array('https://www.','http://www.','https://','http://'), '', home_url() );
			if ( is_singular() ) {
				$fb_data['campaign_url'] = get_queried_object()->post_name;
				$fb_data['content_name'] = get_the_title();
				$fb_data['post_type'] = get_post_type();
			}
			if ( $settings['fbevent'] == 'Purchase' ) {
				$fb_data['value'] = '0';
				$fb_data['currency'] = 'IDR';
			}
			if ( trim($settings['fb_value']) ) {
				$fb_data['value'] = trim($settings['fb_value']);
			}
			else {
				$fb_data['value'] = '0.00';
			}
			if ( $settings['fb_currency'] ) {
				$fb_data['currency'] = trim($settings['fb_currency']);
			}
			else {
				$fb_data['currency'] = 'IDR';
			}
			if ( trim($settings['fb_content_name']) ) {
				$fb_data['content_name'] = trim($settings['fb_content_name']);
			}
			if ( trim($settings['fb_content_ids']) ) {
				$fb_data['content_ids'] = array_map( 'trim', explode( ',', $settings['fb_content_ids'] ) );
				if ( $settings['fb_content_type'] ) {
					$fb_data['content_type'] = trim($settings['fb_content_type']);
				}
				else {
					$fb_data['content_type'] = 'product';
				}
			}
			if ( trim($settings['fb_campaign_url']) ) {
				$fb_data['campaign_url'] = trim($settings['fb_campaign_url']);
			}
			$this->add_render_attribute( 'button', 'data-fbdata', json_encode( $fb_data ) );
		}

		if ( $settings['grc'] == 'yes' ) {
			$this->add_render_attribute( 'button', 'data-grc', $settings['grc'] );
			$aw_data = [];
			if ( $settings['aw_send_to'] ) {
				$aw_data['send_to'] = trim($settings['aw_send_to']);
			}
			if ( $settings['aw_value'] ) {
				$aw_data['value'] = trim($settings['aw_value']);
			}
			if ( $settings['aw_currency'] ) {
				$aw_data['currency'] = trim($settings['aw_currency']);
			}
			if ( $settings['aw_transaction_id'] ) {
				$aw_data['transaction_id'] = trim($settings['aw_transaction_id']);
			}
			$this->add_render_attribute( 'button', 'data-awdata', json_encode( $aw_data, JSON_UNESCAPED_SLASHES ) );
		}

		$this->add_render_attribute( 'content-wrapper', 'class', 'elementor-button-content-wrapper' );
		$this->add_render_attribute( 'icon-align', 'class', 'elementor-align-icon-' . $settings['icon_align'] );
		$this->add_render_attribute( 'icon-align', 'class', 'elementor-button-icon' );

		$this->add_render_attribute( 'optin_wrapper', 'class', 'elementor-lp-form-wrapper' );
		if ( ! empty( $settings['optin_display'] ) ) {
			$this->add_render_attribute( 'optin_wrapper', 'class', 'elementor-lp-form-display-' . $settings['optin_display'] );
		}
		if ( ! empty( $settings['optin_button_width'] ) ) {
			$this->add_render_attribute( 'optin_wrapper', 'class', 'elementor-button-width-' . $settings['optin_button_width'] );
		}

		$optin = $settings['optin'];
		if ( $optin ) {
			$optin = preg_replace( '@<(script|style|noscript)[^>]*?>.*?</\\1>@si', '', $optin );
			if ( strpos( $optin, 'kirimemail' ) !== false ) {
				$optin = str_replace( array( '<link rel="stylesheet" media="all" href="https://aplikasi.kirim.email/assets/css/form.css" />', 'col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2' ), '', $optin );
				echo '
				<style>
					.elementor-lp-form-wrapper .footnote {
						margin:20px 0 0;
						padding:0;
						font-size:12px;
					}
					.elementor-lp-form-wrapper .kirimemail-form-headline {
						margin:0;
						padding:0;
					}
					.elementor-lp-form-wrapper .kirimemail-form-description {
						margin:0 0 20px;
						padding:0;
					}
				</style>';
			}
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
				<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
					<?php if ( ! empty( $settings['icon'] ) ) : ?>
						<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
							<i class="<?php echo esc_attr( $settings['icon'] ); ?>"></i>
						</span>
					<?php endif; ?>
					<span class="elementor-button-text"><?php echo $settings['text']; ?></span>
				</span>
			</a>
		</div>
<?php if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
<style type="text/css">
.mfp-bg,.mfp-wrap{position:fixed;left:0;top:0}.mfp-bg,.mfp-container,.mfp-wrap{height:100%;width:100%}.mfp-arrow:after,.mfp-arrow:before,.mfp-container:before,.mfp-figure:after{content:''}.mfp-bg{z-index:1042;overflow:hidden;background:#0b0b0b;opacity:.8}.mfp-wrap{z-index:1043;outline:0!important;-webkit-backface-visibility:hidden}.mfp-container{text-align:center;position:absolute;left:0;top:0;padding:0 8px;box-sizing:border-box}.mfp-container:before{display:inline-block;height:100%;vertical-align:middle}.mfp-align-top .mfp-container:before{display:none}.mfp-content{position:relative;display:inline-block;vertical-align:middle;margin:0 auto;text-align:left;z-index:1045}.mfp-ajax-holder .mfp-content,.mfp-inline-holder .mfp-content{width:100%;cursor:auto}.mfp-ajax-cur{cursor:progress}.mfp-zoom-out-cur,.mfp-zoom-out-cur .mfp-image-holder .mfp-close{cursor:-moz-zoom-out;cursor:-webkit-zoom-out;cursor:zoom-out}.mfp-zoom{cursor:pointer;cursor:-webkit-zoom-in;cursor:-moz-zoom-in;cursor:zoom-in}.mfp-auto-cursor .mfp-content{cursor:auto}.mfp-arrow,.mfp-close,.mfp-counter,.mfp-preloader{-webkit-user-select:none;-moz-user-select:none;user-select:none}.mfp-loading.mfp-figure{display:none}.mfp-hide{display:none!important}.mfp-preloader{color:#CCC;position:absolute;top:50%;width:auto;text-align:center;margin-top:-.8em;left:8px;right:8px;z-index:1044}.mfp-preloader a{color:#CCC}.mfp-close,.mfp-preloader a:hover{color:#FFF}.mfp-s-error .mfp-content,.mfp-s-ready .mfp-preloader{display:none}button.mfp-arrow,button.mfp-close{overflow:visible;cursor:pointer;background:0 0;border:0;-webkit-appearance:none;display:block;outline:0;padding:0;z-index:1046;box-shadow:none;touch-action:manipulation}.mfp-figure:after,.mfp-iframe-scaler iframe{box-shadow:0 0 8px rgba(0,0,0,.6);position:absolute;left:0}button::-moz-focus-inner{padding:0;border:0}.mfp-close{width:44px;height:44px;line-height:44px;position:absolute;right:0;top:0;text-decoration:none;text-align:center;opacity:.65;padding:0 0 18px 10px;font-style:normal;font-size:28px;font-family:Arial,Baskerville,monospace}.mfp-close:focus,.mfp-close:hover{opacity:1}.mfp-close:active{top:1px}.mfp-close-btn-in .mfp-close{color:#333}.mfp-iframe-holder .mfp-close,.mfp-image-holder .mfp-close{color:#FFF;right:-6px;text-align:right;padding-right:6px;width:100%}.mfp-counter{position:absolute;top:0;right:0;color:#CCC;font-size:12px;line-height:18px;white-space:nowrap}.mfp-figure,img.mfp-img{line-height:0}.mfp-arrow{position:absolute;opacity:.65;margin:-55px 0 0;top:50%;padding:0;width:90px;height:110px;-webkit-tap-highlight-color:transparent}.mfp-arrow:active{margin-top:-54px}.mfp-arrow:focus,.mfp-arrow:hover{opacity:1}.mfp-arrow:after,.mfp-arrow:before{display:block;width:0;height:0;position:absolute;left:0;top:0;margin-top:35px;margin-left:35px;border:inset transparent}.mfp-arrow:after{border-top-width:13px;border-bottom-width:13px;top:8px}.mfp-arrow:before{border-top-width:21px;border-bottom-width:21px;opacity:.7}.mfp-arrow-left{left:0}.mfp-arrow-left:after{border-right:17px solid #FFF;margin-left:31px}.mfp-arrow-left:before{margin-left:25px;border-right:27px solid #3F3F3F}.mfp-arrow-right{right:0}.mfp-arrow-right:after{border-left:17px solid #FFF;margin-left:39px}.mfp-arrow-right:before{border-left:27px solid #3F3F3F}.mfp-iframe-holder{padding-top:40px;padding-bottom:40px}.mfp-iframe-holder .mfp-content{line-height:0;width:100%;max-width:900px}.mfp-image-holder .mfp-content,img.mfp-img{max-width:100%}.mfp-iframe-holder .mfp-close{top:-40px}.mfp-iframe-scaler{width:100%;height:0;overflow:hidden;padding-top:56.25%}.mfp-iframe-scaler iframe{display:block;top:0;width:100%;height:100%;background:#000}.mfp-figure:after,img.mfp-img{width:auto;height:auto;display:block}img.mfp-img{box-sizing:border-box;padding:40px 0;margin:0 auto}.mfp-figure:after{top:40px;bottom:40px;right:0;z-index:-1;background:#444}.mfp-figure small{color:#BDBDBD;display:block;font-size:12px;line-height:14px}.mfp-figure figure{margin:0}.mfp-bottom-bar{margin-top:-36px;position:absolute;top:100%;left:0;width:100%;cursor:auto}.mfp-title{text-align:left;line-height:18px;color:#F3F3F3;word-wrap:break-word;padding-right:36px}.mfp-gallery .mfp-image-holder .mfp-figure{cursor:pointer}@media screen and (max-width:800px) and (orientation:landscape),screen and (max-height:300px){.mfp-img-mobile .mfp-image-holder{padding-left:0;padding-right:0}.mfp-img-mobile img.mfp-img{padding:0}.mfp-img-mobile .mfp-figure:after{top:0;bottom:0}.mfp-img-mobile .mfp-figure small{display:inline;margin-left:5px}.mfp-img-mobile .mfp-bottom-bar{background:rgba(0,0,0,.6);bottom:0;margin:0;top:auto;padding:3px 5px;position:fixed;box-sizing:border-box}.mfp-img-mobile .mfp-bottom-bar:empty{padding:0}.mfp-img-mobile .mfp-counter{right:5px;top:3px}.mfp-img-mobile .mfp-close{top:0;right:0;width:35px;height:35px;line-height:35px;background:rgba(0,0,0,.6);position:fixed;text-align:center;padding:0}}@media all and (max-width:900px){.mfp-arrow{-webkit-transform:scale(.75);transform:scale(.75)}.mfp-arrow-left{-webkit-transform-origin:0;transform-origin:0}.mfp-arrow-right{-webkit-transform-origin:100%;transform-origin:100%}.mfp-container{padding-left:6px;padding-right:6px}}		
</style>
<?php endif; ?>
		<div id="<?php echo $selector; ?>" class="mfp-hide elementor-popup-block-white">
			<div <?php echo $this->get_render_attribute_string( 'optin_wrapper' ); ?>>
				<?php if ( ! empty( $settings['optin_heading'] ) ) : ?>
					<h2><?php echo $settings['optin_heading']; ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $settings['optin_subheading'] ) ) : ?>
					<p><?php echo $settings['optin_subheading']; ?></p>
				<?php endif; ?>
				<?php echo do_shortcode( $optin ); ?>
			</div>
		</div>
		<?php 
	}

	protected function _content_template() {
	}
}
