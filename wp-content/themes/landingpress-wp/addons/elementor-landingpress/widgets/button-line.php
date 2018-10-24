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

class LP_Button_Line extends Widget_Base {

	public function get_name() {
		return 'button_line';
	}

	public function get_title() {
		return __( 'LP - Button LINE', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return [ 'landingpress' ];
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
				'default' => __( 'Invite Me on Line', 'landingpress-wp' ),
				'placeholder' => __( 'Invite Me on Line', 'landingpress-wp' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'line',
			[
				'label' => __( 'Line Username', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'label_block' => true,
			]
		);

		$this->add_control(
			'target',
			[
				'label' => __( 'Open in new window', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'landingpress-wp' ),
				'label_off' => __( 'No', 'landingpress-wp' ),
				'return_value' => 'yes',
				'default' => '',
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
				'default' => 'sm',
				'options' => self::get_button_sizes(),
			]
		);

		$this->add_control(
			'icon_show',
			[
				'label' => __( 'Show Line Icon', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'landingpress-wp' ),
				'label_off' => __( 'Hide', 'landingpress-wp' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'landingpress-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'condition' => [
					'icon_show!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-button-icon img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
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
					'icon_show!' => '',
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
					'icon_show!' => '',
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

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

		if ( ! empty( $settings['line'] ) ) {
			$link = 'http://line.me/ti/p/~' . trim( $settings['line'] );
			if ( $settings['fbevent'] || $settings['grc'] == 'yes' ) {
				$this->add_render_attribute( 'button', 'href', $link );
			}
			else {
				$this->add_render_attribute( 'button', 'href', $link );
			}
			if ( $settings['target'] == 'yes' ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}
			$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );
		}

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
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
				<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
					<?php if ( $settings['icon_show'] ) : ?>
						<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/line.svg" alt="" height="15px" width="15px" />
						</span>
					<?php endif; ?>
					<span class="elementor-button-text"><?php echo $settings['text']; ?></span>
				</span>
			</a>
		</div>
		<?php
	}

	protected function _content_template() {}
}
