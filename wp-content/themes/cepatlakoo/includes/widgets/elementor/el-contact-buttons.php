<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class CepatLakoo_Messenger_Buttons_Widget_Elementor extends Widget_Base {

	public function get_name() {
		return 'cepatlakoo-messenger-button';
	}

	public function get_title() {
		return esc_html__( 'CL - Contact Buttons', 'cepatlakoo' );
	}

	public function get_icon() {
		// Icon name from the Elementor font file, as per http://dtbaker.net/web-development/creating-your-own-custom-elementor-widgets/
		return 'eicon-button';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'cepatlakoo_section_name',
			[
				'label' => esc_html__( 'CL - Contact Buttons', 'cepatlakoo' ),
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_type',
			[
				'label' => esc_html__( 'Button Type', 'cepatlakoo' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sms',
				'options' => [
					'bbm' => esc_html__( 'BBM', 'cepatlakoo' ),
					'wa' => esc_html__( 'WhatsApp', 'cepatlakoo' ),
					'sms' => esc_html__( 'SMS', 'cepatlakoo' ),
					'line' => esc_html__( 'Line', 'cepatlakoo' ),
					'phone' => esc_html__( 'Phone', 'cepatlakoo' ),
					'telegram' => esc_html__( 'Telegram', 'cepatlakoo' ),
					'messenger' => esc_html__( 'Messenger', 'cepatlakoo' ),
				],
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_bbm',
			[
				'label' => esc_html__( 'BBM ID', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXT,
				'title' => esc_html__( 'Enter BBM ID', 'cepatlakoo' ),
				'condition' => [
					'cepatlakoo_msg_button_type' => 'bbm',
				],
				'default' => 'E09K98',
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_text_bbm',
			[
				'label' => esc_html__( 'Button Text', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXT,
				'title' => esc_html__( 'Enter rext of button', 'cepatlakoo' ),
				'condition' => [
					'cepatlakoo_msg_button_type' => 'bbm',
				],
				'default' => 'PIN: E09K98',
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_wa',
			[
				'label' => esc_html__( 'Phone Number', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXT,
				'title' => esc_html__( 'Enter WhatsApp Number', 'cepatlakoo' ),
				'condition' => [
					'cepatlakoo_msg_button_type' => 'wa',
				],
				'default' => '628127776622',
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_text_wa',
			[
				'label' => esc_html__( 'Button Text', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXT,
				'title' => esc_html__( 'Enter text of button', 'cepatlakoo' ),
				'condition' => [
					'cepatlakoo_msg_button_type' => 'wa',
				],
				'default' => 'WA: +628127776622',
			]
		);

		$this->add_control(
			'cepatlakoo_wa_msg_button_text_wa',
			[
				'label' => esc_html__( 'WhatsApp Message', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXTAREA,
				'title' => esc_html__( 'Enter text of WhatsApp Message', 'cepatlakoo' ),
				'condition' => [
					'cepatlakoo_msg_button_type' => 'wa',
				],
				'default' => esc_html__('Halo, saya tertarik dengan produknya', 'cepatlakoo'),
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_phone',
			[
				'label' => esc_html__( 'Phone Number', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXT,
				'title' => esc_html__( 'Enter Phone Number', 'cepatlakoo' ),
				'condition' => [
					'cepatlakoo_msg_button_type' => 'phone',
				],
				'default' => '+628127776622',
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_text_phone',
			[
				'label' => esc_html__( 'Button Text', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXT,
				'title' => esc_html__( 'Enter text of button', 'cepatlakoo' ),
				'condition' => [
					'cepatlakoo_msg_button_type' => 'phone',
				],
				'default' => 'Phone : +628127776622',
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_sms',
			[
				'label' => esc_html__( 'Phone Number', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXT,
				'title' => esc_html__( 'Enter Phone Number', 'cepatlakoo' ),
				'condition' => [
					'cepatlakoo_msg_button_type' => 'sms',
				],
				'default' => '0812000912',
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_text_sms',
			[
				'label' => esc_html__( 'Button Text', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXT,
				'title' => esc_html__( 'Enter text of button', 'cepatlakoo' ),
				'condition' => [
					'cepatlakoo_msg_button_type' => 'sms',
				],
				'default' => 'SMS: 0812000912',
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_sms_msg',
			[
				'label' => esc_html__( 'SMS Message', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => '10',
				'condition' => [
					'cepatlakoo_msg_button_type' => 'sms',
				],
				'default' => esc_html__('Saya ingin memesan produk Anda, mohon SMS saya', 'cepatlakoo'),
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_line',
			[
				'label' => esc_html__( 'Line ID', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXT,
				'title' => esc_html__( 'Enter Line ID', 'cepatlakoo' ),
				'condition' => [
					'cepatlakoo_msg_button_type' => 'line',
				],
				'default' => 'agnezmos',
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_text_line',
			[
				'label' => esc_html__( 'Button Text', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXT,
				'title' => esc_html__( 'Enter text of button', 'cepatlakoo' ),
				'condition' => [
					'cepatlakoo_msg_button_type' => 'line',
				],
				'default' => 'LINE: agnezmos',
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_telegram',
			[
				'label' => esc_html__( 'Username', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXT,
				'title' => esc_html__( 'Enter Telegram ID', 'cepatlakoo' ),
				'condition' => [
					'cepatlakoo_msg_button_type' => 'telegram',
				],
				'default' => 'telegram',
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_text_telegram',
			[
				'label' => esc_html__( 'Button Text', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXT,
				'title' => esc_html__( 'Enter text of button', 'cepatlakoo' ),
				'condition' => [
					'cepatlakoo_msg_button_type' => 'telegram',
				],
				'default' => '@telegram',
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_messenger',
			[
				'label' => esc_html__( 'FB Page Username / ID', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXT,
				'title' => esc_html__( 'Enter FB Page Username / ID', 'cepatlakoo' ),
				'condition' => [
					'cepatlakoo_msg_button_type' => 'messenger',
				],
				'default' => '',
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_text_messenger',
			[
				'label' => esc_html__( 'Button Text', 'cepatlakoo' ),
				'type' => Controls_Manager::TEXT,
				'title' => esc_html__( 'Enter text of button', 'cepatlakoo' ),
				'condition' => [
					'cepatlakoo_msg_button_type' => 'messenger',
				],
				'default' => 'Send Message',
			]
		);

		$this->add_control(
		    'cepatlakoo_msg_button_display_icon',
		    [
		        'label' => esc_html__( 'Display Icon', 'cepatlakoo' ),
		        'type' => Controls_Manager::SWITCHER,
		        'default' => 'yes',
		        'label_on' => esc_html__( 'Yes', 'cepatlakoo' ),
				'label_off' => esc_html__( 'No', 'cepatlakoo' ),
		        'return_value' => 'yes',
		    ]
		);

		$this->add_control(
			'cepatlakoo_msg_button_size',
			[
				'label' => esc_html__( 'Button Size', 'cepatlakoo' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'medium',
				'options' => [
					'extra_small' => esc_html__( 'Extra Small', 'cepatlakoo' ),
					'small' => esc_html__( 'Small', 'cepatlakoo' ),
					'medium' => esc_html__( 'Medium', 'cepatlakoo' ),
					'large' => esc_html__( 'Large', 'cepatlakoo' ),
					'extra_large' => esc_html__( 'Extra Large', 'cepatlakoo' ),
				],
			]
		);

		$this->add_responsive_control(
			'cepatlakoo_msg_button_align',
			[
				'label' => esc_html__( 'Button Alignment', 'cepatlakoo' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'cepatlakoo' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'cepatlakoo' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'cepatlakoo' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'cepatlakoo' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'prefix_class' => 'btn%s-align-',
				'default' => 'left',
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_fb_ads_event',
			[
				'label' => esc_html__( 'FB Ads Event', 'cepatlakoo' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'noevent',
				'options' => [
					'noevent' => esc_html__( 'No Event', 'cepatlakoo' ),
					'ViewContent' => esc_html__( 'ViewContent', 'cepatlakoo' ),
					'AddToWishlist' => esc_html__( 'AddToWishlist', 'cepatlakoo' ),
					'AddToCart' => esc_html__( 'AddToCart', 'cepatlakoo' ),
					'InitiateCheckout' => esc_html__( 'InitiateCheckout', 'cepatlakoo' ),
					'AddCustomerInfo' => esc_html__( 'AddCustomerInfo', 'cepatlakoo' ),
					'Purchase' => esc_html__( 'Purchase', 'cepatlakoo' ),
					'AddPaymentInfo' => esc_html__( 'AddPaymentInfo', 'cepatlakoo' ),
					'Lead' => esc_html__( 'Lead', 'cepatlakoo' ),
					'CompleteRegistration' => esc_html__( 'CompleteRegistration', 'cepatlakoo' ),
				],
			]
		);

		$this->add_control(
			'cepatlakoo_msg_button_sticky_mobile',
			[
				'label' => esc_html__( 'Make button sticky on mobile device', 'cepatlakoo' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'disable',
				'options' => [
					'disable' => esc_html__( 'Disable', 'cepatlakoo' ),
					'enable' => esc_html__( 'Enable', 'cepatlakoo' ),
				],
			]
		);

		$this->add_control(
			'cepatlakoo_desktop_lightbox_heading',
         	[
	            'label' => esc_html__( 'Desktop Lightbox Heading', 'cepatlakoo' ),
	            'type' => Controls_Manager::TEXT,
	            'default' => esc_html__( 'Cara membeli', 'cepatlakoo' ),
	            'title' => esc_html__( 'Enter some text', 'cepatlakoo' ),
	         ]
		);

		$this->add_control(
			'cepatlakoo_desktop_lightbox_message',
         	[
	            'label' => esc_html__( 'Desktop Lightbox Message', 'cepatlakoo' ),
	            'type' => Controls_Manager::TEXTAREA,
	            'default' => esc_html__( 'Harap menghubungi kami via [contact_app] di [contact_id] pada handphone Anda.', 'cepatlakoo' ),
	            'title' => esc_html__( 'Enter some text', 'cepatlakoo' ),
	         ]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Button', 'cepatlakoo' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => esc_html__( 'Typography', 'cepatlakoo' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .quick-contact-info a',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'cepatlakoo' ),
			]
		);

		$this->add_control(
			'cepatlakoo_btn_text_color',
			[
				'label' => esc_html__( 'Text Color', 'cepatlakoo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .quick-contact-info a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cepatlakoo_btn_background_color',
			[
				'label' => esc_html__( 'Background Color', 'cepatlakoo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .quick-contact-info a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'cepatlakoo' ),
			]
		);

		$this->add_control(
			'cepatlakoo_btn_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'cepatlakoo' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .quick-contact-info a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cepatlakoo_btn_background_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'cepatlakoo' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .quick-contact-info a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
	}

	protected function render() {
		// Reference : https://github.com/pojome/elementor/issues/738
		// get our input from the widget settings.
   	$settings = $this->get_settings();
		$cepatlakoo_button_type = ! empty( $settings['cepatlakoo_msg_button_type'] ) ? esc_attr($settings['cepatlakoo_msg_button_type']) : 'bbm';
		$cepatlakoo_msg_bbm_id = ! empty( $settings['cepatlakoo_msg_button_bbm'] ) ? esc_attr($settings['cepatlakoo_msg_button_bbm']) : '';
		$cepatlakoo_msg_bbm_text = ! empty( $settings['cepatlakoo_msg_button_text_bbm'] ) ? esc_attr($settings['cepatlakoo_msg_button_text_bbm']) : '';
		$cepatlakoo_msg_wa_id = ! empty( $settings['cepatlakoo_msg_button_wa'] ) ? esc_attr($settings['cepatlakoo_msg_button_wa']) : '';
		$cepatlakoo_msg_wa_text = ! empty( $settings['cepatlakoo_msg_button_text_wa'] ) ? esc_attr($settings['cepatlakoo_msg_button_text_wa']) : '';
		$cepatlakoo_msg_wa_message = ! empty( $settings['cepatlakoo_wa_msg_button_text_wa'] ) ? esc_attr(cepatlakoo_replace_hexcode($settings['cepatlakoo_wa_msg_button_text_wa'])) : '';
		$cepatlakoo_msg_phone_id = ! empty( $settings['cepatlakoo_msg_button_phone'] ) ? esc_attr($settings['cepatlakoo_msg_button_phone']) : '';
		$cepatlakoo_msg_phone_text = ! empty( $settings['cepatlakoo_msg_button_text_phone'] ) ? esc_attr($settings['cepatlakoo_msg_button_text_phone']) : '';
		$cepatlakoo_msg_sms_id = ! empty( $settings['cepatlakoo_msg_button_sms'] ) ? esc_attr($settings['cepatlakoo_msg_button_sms']) : '';
		$cepatlakoo_msg_sms_text = ! empty( $settings['cepatlakoo_msg_button_text_sms'] ) ? esc_attr($settings['cepatlakoo_msg_button_text_sms']) : '';
		$cepatlakoo_msg_sms_message = ! empty( $settings['cepatlakoo_msg_button_sms_msg'] ) ? esc_attr( cepatlakoo_replace_hexcode($settings['cepatlakoo_msg_button_sms_msg'])) : '';
		$cepatlakoo_msg_line_id = ! empty( $settings['cepatlakoo_msg_button_line'] ) ? esc_attr($settings['cepatlakoo_msg_button_line']) : '';
		$cepatlakoo_msg_line_text = ! empty( $settings['cepatlakoo_msg_button_text_line'] ) ? esc_attr($settings['cepatlakoo_msg_button_text_line']) : '';
		$cepatlakoo_msg_telegram_id = ! empty( $settings['cepatlakoo_msg_button_telegram'] ) ? esc_attr($settings['cepatlakoo_msg_button_telegram']) : '';
		$cepatlakoo_msg_telegram_text = ! empty( $settings['cepatlakoo_msg_button_text_telegram'] ) ? esc_attr($settings['cepatlakoo_msg_button_text_telegram']) : '';
		$cepatlakoo_msg_messenger_id = ! empty( $settings['cepatlakoo_msg_button_messenger'] ) ? esc_attr($settings['cepatlakoo_msg_button_messenger']) : '';
		$cepatlakoo_msg_messenger_text = ! empty( $settings['cepatlakoo_msg_button_text_messenger'] ) ? esc_attr($settings['cepatlakoo_msg_button_text_messenger']) : '';
		$cepatlakoo_button_display_icon = ! empty( $settings['cepatlakoo_msg_button_display_icon'] ) ? esc_attr($settings['cepatlakoo_msg_button_display_icon']) : '';
		$cepatlakoo_button_size = ! empty( $settings['cepatlakoo_msg_button_size'] ) ? esc_attr($settings['cepatlakoo_msg_button_size']) : '';
		$cepatlakoo_button_align = ! empty( $settings['cepatlakoo_button_align'] ) ? esc_attr($settings['cepatlakoo_button_align']) : '';
		$cepatlakoo_button_fbads_event = ! empty( $settings['cepatlakoo_msg_button_fb_ads_event'] ) ? esc_attr($settings['cepatlakoo_msg_button_fb_ads_event']) : '';
		$cepatlakoo_button_sticky_mobile = ! empty( $settings['cepatlakoo_msg_button_sticky_mobile'] ) ? esc_attr($settings['cepatlakoo_msg_button_sticky_mobile']) : 'disable';
		$cepatlakoo_desktop_lightbox_heading = ! empty( $settings['cepatlakoo_desktop_lightbox_heading'] ) ? esc_attr($settings['cepatlakoo_desktop_lightbox_heading']) : esc_html_e('How To Buy', 'cepatlakoo');
		$cepatlakoo_desktop_lightbox_message = ! empty( $settings['cepatlakoo_desktop_lightbox_message'] ) ? esc_attr($settings['cepatlakoo_desktop_lightbox_message']) : esc_html_e('Please contact us via [contact_app] at [contact_id] on your mobile device.', 'cepatlakoo');
		switch ( $cepatlakoo_button_size ) {
			case 'extra_small':
					$size_classes = " btn-size-xs ";
				break;
			case 'small':
					$size_classes = " btn-size-sm ";
				break;
			case 'medium':
					$size_classes = " btn-size-md ";
				break;
			case 'large':
					$size_classes = " btn-size-lg ";
				break;
			case 'extra_large':
					$size_classes = " btn-size-xl ";
				break;

			default:
					$size_classes = " btn-size-md ";
				break;
		}
?>
		<div class="custom-button-area">
			<div class="quick-contact-info <?php echo ( $cepatlakoo_button_sticky_mobile == 'enable' && wp_is_mobile() ) ? 'sticky-button' : ''; ?>">


					<?php if( $cepatlakoo_button_type == 'messenger' ) : ?>
						<a href="https://m.me/<?php echo $cepatlakoo_msg_messenger_id ?>" class="messenger <?php echo ( $cepatlakoo_button_display_icon == 'yes' ) ? $size_classes : 'btn-no-icon ' . $size_classes; ?>" fb-pixel="<?php echo $cepatlakoo_button_fbads_event; ?>">
							<?php if ( $cepatlakoo_button_display_icon == 'yes' ) : ?>
								<img src="<?php echo get_template_directory_uri() ?>/images/fb-messenger-icon.svg">
							<?php endif; ?>
							<?php echo $cepatlakoo_msg_messenger_text; ?>
						</a>
					<?php elseif( $cepatlakoo_button_type == 'bbm' ) : ?>
						<?php if ( wp_is_mobile() ) : ?>
									<a fb-pixel="<?php echo $cepatlakoo_button_fbads_event; ?>" href="bbmi://<?php echo $cepatlakoo_msg_bbm_id ?>" class="blackberry <?php echo ( $cepatlakoo_button_display_icon == 'yes' ) ? $size_classes : 'btn-no-icon ' . $size_classes; ?>">
											<?php if ( $cepatlakoo_button_display_icon == 'yes' ) : ?>
												<img src="<?php echo get_template_directory_uri() ?>/images/bbm-icon-a.svg">
											<?php endif; ?>
											<?php echo $cepatlakoo_msg_bbm_text; ?>
									</a>
						<?php else : ?>
									<a fb-pixel="<?php echo $cepatlakoo_button_fbads_event; ?>" href="#" class="blackberry reveal-link  <?php echo ( $cepatlakoo_button_display_icon == 'yes' ) ? $size_classes : 'btn-no-icon ' . $size_classes; ?>" data-open="data-lightbox-bbm">
										<?php if ( $cepatlakoo_button_display_icon == 'yes' ) : ?>
											<img src="<?php echo get_template_directory_uri(); ?>/images/bbm-icon-a.svg">
										<?php endif; ?>
									<?php echo $cepatlakoo_msg_bbm_text; ?></a>
									<div id="data-lightbox-bbm" class="reveal" data-reveal>
											<h2 id="modalTitle" class="header"><?php echo $cepatlakoo_desktop_lightbox_heading; ?></h2>
											<p>
											<?php
													$cepatlakoo_lightbox_message = str_replace("[contact_app]","BBM", $cepatlakoo_desktop_lightbox_message);
													$cepatlakoo_lightbox_final_message = str_replace("[contact_id]", $cepatlakoo_msg_bbm_id, $cepatlakoo_lightbox_message);
													esc_attr_e( $cepatlakoo_lightbox_final_message );
											?>
											</p>
											<a class="close-button close-reveal-modal" data-close>&#215;</a>
									</div>
							<?php endif; ?>
					<?php elseif( $cepatlakoo_button_type == 'wa' ) : ?>
						<?php
								if ( preg_match('[^\+62]', $cepatlakoo_msg_wa_id ) ) {
										$cepatlakoo_msg_wa_id = str_replace('+62', '62', $cepatlakoo_msg_wa_id);
								}elseif ( $cepatlakoo_msg_wa_id[0] == '0' ) {
										$cepatlakoo_msg_wa_id = ltrim( $cepatlakoo_msg_wa_id, '0' );
										$cepatlakoo_msg_wa_id = '62'. $cepatlakoo_msg_wa_id;
								}elseif ( $cepatlakoo_msg_wa_id[0] == '8' ) {
										$cepatlakoo_msg_wa_id = '62'. $cepatlakoo_msg_wa_id;
								} else {
									 $cepatlakoo_msg_wa_id = $cepatlakoo_msg_wa_id;
								}
						?>
						<a fb-pixel="<?php echo $cepatlakoo_button_fbads_event; ?>" href="https://api.whatsapp.com/send?l=id&phone=<?php echo esc_attr( $cepatlakoo_msg_wa_id ); ?>&text=<?php echo cepatlakoo_replace_hexcode( $cepatlakoo_msg_wa_message ); ?>" class="whatsapp <?php echo ( $cepatlakoo_button_display_icon == 'yes' ) ? $size_classes : 'btn-no-icon ' . $size_classes; ?>">
								<?php if ( $cepatlakoo_button_display_icon == 'yes' ) : ?>
									<img src="<?php echo get_template_directory_uri() ?>/images/whatsapp-icon-a.svg">
								<?php endif; ?>
								<?php echo $cepatlakoo_msg_wa_text; ?>
						</a>
					<?php elseif( $cepatlakoo_button_type == 'sms' ) : ?>
						<?php if ( wp_is_mobile() ) : ?>
								<a fb-pixel="<?php echo $cepatlakoo_button_fbads_event; ?>" href="sms:<?php echo $cepatlakoo_msg_sms_id ?>?body=<?php echo $cepatlakoo_msg_sms_message; ?>" class="sms <?php echo ( $cepatlakoo_button_display_icon == 'yes' ) ? $size_classes : 'btn-no-icon ' . $size_classes; ?>">
									<?php if( $cepatlakoo_button_display_icon == 'yes') : ?>
										<img src="<?php echo get_template_directory_uri() ?>/images/sms-icon-a.svg">
									<?php endif; ?>
									<?php echo $cepatlakoo_msg_sms_text; ?>
								</a>
						<?php else : ?>
								<a fb-pixel="<?php echo $cepatlakoo_button_fbads_event; ?>" href="#" class="sms reveal-link <?php echo ( $cepatlakoo_button_display_icon == 'yes' ) ? $size_classes : 'btn-no-icon ' . $size_classes; ?>" data-open="data-lightbox-sms">
									<?php if( $cepatlakoo_button_display_icon == 'yes') : ?>
										<img src="<?php echo get_template_directory_uri(); ?>/images/sms-icon-a.svg">
									<?php endif; ?>
									<?php echo $cepatlakoo_msg_sms_text; ?>
								</a>

								<div id="data-lightbox-sms" class="reveal" data-reveal>
										<h2 id="modalTitle" class="header"><?php echo $cepatlakoo_desktop_lightbox_heading; ?></h2>
										<p>
										<?php
												$cepatlakoo_lightbox_message = str_replace("[contact_app]","SMS", $cepatlakoo_desktop_lightbox_message);
												$cepatlakoo_lightbox_final_message = str_replace("[contact_id]", $cepatlakoo_msg_sms_id, $cepatlakoo_lightbox_message);
												esc_attr_e($cepatlakoo_lightbox_final_message);
										?>
										</p>
										<a class="close-button close-reveal-modal" data-close>&#215;</a>
								</div>
						<?php endif; ?>
					<?php elseif( $cepatlakoo_button_type == 'line' ) : ?>
						<?php if ( wp_is_mobile() ) : ?>
								<a fb-pixel="<?php echo $cepatlakoo_button_fbads_event; ?>" href="line://ti/p/~<?php echo $cepatlakoo_msg_line_id; ?>" class="line <?php echo ( $cepatlakoo_button_display_icon == 'yes' ) ? $size_classes : 'btn-no-icon ' . $size_classes; ?>">
										<?php if ( $cepatlakoo_button_display_icon == 'yes' ) : ?>
										<img src="<?php echo get_template_directory_uri() ?>/images/line-icon-a.svg">
										<?php endif; ?>
										<?php echo $cepatlakoo_msg_line_text; ?>
								</a>
						<?php else : ?>
								<a fb-pixel="<?php echo $cepatlakoo_button_fbads_event; ?>" href="#" class="line <?php echo ( $cepatlakoo_button_display_icon == 'yes' ) ? $size_classes : 'btn-no-icon ' . $size_classes; ?>" data-open="data-lightbox-line">
									<?php if ( $cepatlakoo_button_display_icon == 'yes' ) : ?>
										<img src="<?php echo get_template_directory_uri(); ?>/images/line-icon-a.svg">
									<?php endif; ?>
									<?php echo $cepatlakoo_msg_line_text; ?>
								</a>

								<div id="data-lightbox-line" class="reveal" data-reveal>
										<h2 id="modalTitle" class="header"><?php echo $cepatlakoo_desktop_lightbox_heading; ?></h2>
										<p>
										<?php
												$cepatlakoo_lightbox_message = str_replace("[contact_app]","LINE", $cepatlakoo_desktop_lightbox_message);
												$cepatlakoo_lightbox_final_message = str_replace("[contact_id]", $cepatlakoo_msg_line_id, $cepatlakoo_lightbox_message);
												esc_attr_e($cepatlakoo_lightbox_final_message);
										?>
										</p>
										<a class="close-button close-reveal-modal" data-close>&#215;</a>
								</div>
						<?php endif; ?>
					<?php elseif( $cepatlakoo_button_type == 'phone' ) : ?>
						<?php if ( wp_is_mobile() ) : ?>
							<a fb-pixel="<?php echo $cepatlakoo_button_fbads_event; ?>" href="tel:<?php echo $cepatlakoo_msg_phone_id ?>" class="phone <?php echo ( $cepatlakoo_button_display_icon == 'yes' ) ? $size_classes : 'btn-no-icon ' . $size_classes; ?>" >
								<?php if ( $cepatlakoo_button_display_icon == 'yes' ) : ?>
									<img src="<?php echo get_template_directory_uri() ?>/images/phone-icon-a.svg">
								<?php endif; ?>
								<?php echo $cepatlakoo_msg_phone_text; ?>
							</a>
						<?php else : ?>
							<a fb-pixel="<?php echo $cepatlakoo_button_fbads_event; ?>" href="#" class="phone reveal-link <?php echo ( $cepatlakoo_button_display_icon == 'yes' ) ? $size_classes : 'btn-no-icon ' . $size_classes; ?>" data-open="data-lightbox-tel">
								<?php if ( $cepatlakoo_button_display_icon == 'yes' ) : ?>
									<img src="<?php echo get_template_directory_uri(); ?>/images/phone-icon-a.svg">
								<?php endif; ?>
								<?php echo $cepatlakoo_msg_phone_text; ?></a>

							<div id="data-lightbox-tel" class="reveal" data-reveal>
									<h2 id="modalTitle" class="header"><?php echo $cepatlakoo_desktop_lightbox_heading; ?></h2>
									<p>
											<?php
													$cepatlakoo_lightbox_message = str_replace("[contact_app]","Phone", $cepatlakoo_desktop_lightbox_message);
													$cepatlakoo_lightbox_final_message = str_replace("[contact_id]", $cepatlakoo_msg_phone_id, $cepatlakoo_lightbox_message);
													esc_attr_e($cepatlakoo_lightbox_final_message);
											?>
									</p>
									<a class="close-button close-reveal-modal" data-close>&#215;</a>
							</div>
					<?php endif; ?>
					<?php elseif( $cepatlakoo_button_type == 'telegram' ) : ?>
						<a fb-pixel="<?php echo $cepatlakoo_button_fbads_event; ?>" href="https://t.me/<?php echo $cepatlakoo_msg_telegram_id; ?>" class="telegram <?php echo ( $cepatlakoo_button_display_icon == 'yes' ) ? $size_classes : 'btn-no-icon ' . $size_classes; ?>">
							<?php if ( $cepatlakoo_button_display_icon == 'yes' ) : ?>
								<img src="<?php echo get_template_directory_uri() ?>/images/telegram-icon-a.svg">
							<?php endif; ?>
							<?php echo $cepatlakoo_msg_telegram_text; ?>
						</a>
					<?php endif; ?>
			</div>
		</div>
<?php
	}

	protected function content_template() {}

	public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new CepatLakoo_Messenger_Buttons_Widget_Elementor() );
