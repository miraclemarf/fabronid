<?php
namespace ElementorLandingPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LP_Image_Video extends Widget_Base {

	public function get_name() {
		return 'image_video';
	}

	public function get_title() {
		return __( 'LP - Image Video Lightbox', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-insert-image';
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

	protected function _register_controls() {
		$this->start_controls_section(
			'section_optin_description',
			[
				'label' => __( 'PENTING!', 'landingpress-wp' ),
			]
		);

		$description = __( 'Anda bisa menggunakan widget ini untuk membuat button yang ketika di-klik akan memutar video dalam bentuk lightbox.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Widget ini bisa digunakan untuk link video dari <strong style="color:#4054b2;">Youtube dan Vimeo</strong> saja, dan bisa juga digunakan untuk link Google Map.', 'landingpress-wp' );

		$this->add_control(
			'optin_description',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$this->add_control(
			'video',
			[
				'label' => __( 'Link Video', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'https://www.youtube.com/watch?v=gT2-dWO7u0Y',
				'placeholder' => 'https://www.youtube.com/watch?v=gT2-dWO7u0Y',
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Image', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'landingpress-wp' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image', // Actually its `image_size`.
				'default' => 'large',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'landingpress-wp' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
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
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
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
			'section_style_image',
			[
				'label' => __( 'Image', 'landingpress-wp' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label' => __( 'Size (%)', 'landingpress-wp' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'opacity',
			[
				'label' => __( 'Opacity (%)', 'landingpress-wp' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'landingpress-wp' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'label' => __( 'Image Border', 'landingpress-wp' ),
				'selector' => '{{WRAPPER}} .elementor-image img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .elementor-image img',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => __( 'Icon', 'landingpress-wp' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-magnific-popup-video i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label' => __( 'Icon Color (Hover)', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-magnific-popup-video:hover i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render image widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-image' );

		if ( ! empty( $settings['shape'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-image-shape-' . $settings['shape'] );
		}

		$this->add_render_attribute( 'link', 'class', 'elementor-clickable' );
		$this->add_render_attribute( 'link', 'class', 'elementor-magnific-popup-video' );

		$youtube_id = $this->get_youtube_id( $settings['video'] );
		if ( !empty( $youtube_id ) ) {
			$this->add_render_attribute( 'link', 'href', 'http://www.youtube.com/watch?v='.$youtube_id );
		}
		else {
			if ( empty( $settings['video'] ) ) {
				$settings['video'] = 'https://www.youtube.com/watch?v=gT2-dWO7u0Y';
			}
			$this->add_render_attribute( 'link', 'href', esc_url( $settings['video'] ) );
		}

		$this->add_render_attribute( 'link', 'class', 'elementor-image-link' );

		if ( $settings['fbevent'] ) {
			if ( $settings['fbevent'] == 'custom' ) {
				if ( $settings['fbcustomevent'] ) {
					$this->add_render_attribute( 'link', 'data-fbcustomevent', $settings['fbcustomevent'] );
				}					
			}
			else {
				$this->add_render_attribute( 'link', 'data-fbevent', $settings['fbevent'] );
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
			$this->add_render_attribute( 'link', 'data-fbdata', json_encode( $fb_data ) );
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

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'link' ); ?>>
				<i class="fa fa-youtube-play" aria-hidden="true"></i>
				<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
			</a>
		</div>
		<?php
	}

	public function get_youtube_id( $url ) {
		$pattern = "#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#";
		$result = preg_match($pattern, $url, $matches);
		if ( false !== $result && isset( $matches[0] ) ) {
			return $matches[0];
		}
		return false;
	}

	protected function _content_template() {
	}

}
