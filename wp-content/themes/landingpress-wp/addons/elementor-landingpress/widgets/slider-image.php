<?php
namespace ElementorLandingPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LP_Slider_Image extends Widget_Base {

	public function get_name() {
		return 'lp_slider_image';
	}

	public function get_title() {
		return __( 'LP - Image Slider', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-slideshow';
	}

	public function get_categories() {
		return [ 'landingpress' ];
	}

	public function get_script_depends() {
		return [ 'jquery-slick' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_slider',
			[
				'label' => __( 'Slider Items', 'landingpress-wp' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'slider_image',
			[
				'label' => __( 'Image', 'landingpress-wp' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'slider_caption',
			[
				'label' => __( 'Caption', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Slider Caption', 'landingpress-wp' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slider_link',
			[
				'label' => __( 'Link', 'landingpress-wp' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'http://your-link.com', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'slider',
			[
				'label' => __( 'Slider Items', 'landingpress-wp' ),
				'type' => Controls_Manager::REPEATER,
				'show_label' => true,
				'default' => [
					[
						'slider_image' => [ 'url' => Utils::get_placeholder_image_src() ],
						'slider_caption' => __( 'Slider 1 Caption', 'landingpress-wp' ),
						'slider_link' => '#',
					],
					[
						'slider_image' => [ 'url' => Utils::get_placeholder_image_src() ],
						'slider_caption' => __( 'Slider 2 Caption', 'landingpress-wp' ),
						'slider_link' => '#',
					],
					[
						'slider_image' => [ 'url' => Utils::get_placeholder_image_src() ],
						'slider_caption' => __( 'Slider 3 Caption', 'landingpress-wp' ),
						'slider_link' => '#',
					],
				],
				'fields' => array_values( $repeater->get_controls() ),
				'title_field' => '{{{ slider_caption }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => __( 'Slider Options', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'adaptive_height',
			[
				'label' => __( 'Adaptive Height', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'landingpress-wp' ),
					'no' => __( 'No', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'image_stretch',
			[
				'label' => __( 'Image Stretch', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'landingpress-wp' ),
					'no' => __( 'No', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'navigation',
			[
				'label' => __( 'Navigation', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'both',
				'options' => [
					'both' => __( 'Arrows and Dots', 'landingpress-wp' ),
					'arrows' => __( 'Arrows', 'landingpress-wp' ),
					'dots' => __( 'Dots', 'landingpress-wp' ),
					'none' => __( 'None', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => __( 'Pause on Hover', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'landingpress-wp' ),
					'no' => __( 'No', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'landingpress-wp' ),
					'no' => __( 'No', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => __( 'Autoplay Speed', 'landingpress-wp' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
			]
		);

		$this->add_control(
			'infinite',
			[
				'label' => __( 'Infinite Loop', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'landingpress-wp' ),
					'no' => __( 'No', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'effect',
			[
				'label' => __( 'Effect', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => __( 'Slide', 'landingpress-wp' ),
					'fade' => __( 'Fade', 'landingpress-wp' ),
				],
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => __( 'Animation Speed', 'landingpress-wp' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label' => __( 'Image Caption', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'caption_background',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lp-slider-wrapper .lp-slide-image-caption' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lp-slider-wrapper .lp-slide-image-caption' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'caption_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .lp-slider-wrapper .lp-slide-image-caption',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label' => __( 'Navigation', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_arrows',
			[
				'label' => __( 'Arrows', 'landingpress-wp' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label' => __( 'Arrows Position', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => [
					'inside' => __( 'Inside', 'landingpress-wp' ),
					'outside' => __( 'Outside', 'landingpress-wp' ),
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Arrows Size', 'landingpress-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-slider-image-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .elementor-slider-image-wrapper .slick-slider .slick-next:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label' => __( 'Arrows Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slider-image-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .elementor-slider-image-wrapper .slick-slider .slick-next:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_dots',
			[
				'label' => __( 'Dots', 'landingpress-wp' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label' => __( 'Dots Position', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => [
					'inside' => __( 'Inside', 'landingpress-wp' ),
					'outside' => __( 'Outside', 'landingpress-wp' ),
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => __( 'Dots Size', 'landingpress-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-slider-image-wrapper .elementor-slider-image .slick-dots li button:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label' => __( 'Dots Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slider-image-wrapper .elementor-slider-image .slick-dots li button:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		if ( empty( $settings['slider'] ) )
			return;

		$slides = [];
		foreach ( $settings['slider'] as $slider ) {
			$slide_html = '';
			if ( $slide_image = $slider['slider_image']['url'] ) {
				$slide_html = '<img class="slick-slide-image" src="' . esc_url( $slide_image ) . '" alt="" />';
			}
			if ( $slide_caption = $slider['slider_caption'] ) {
				$slide_html .= '<span class="lp-slide-image-caption">'.$slide_caption.'</span>'; 
			}			
			if ( $slide_link = $slider['slider_link']['url'] ) {
				$target = '';
				if ( ! empty( $slider['slider_link']['is_external'] ) ) {
					$target = ' target="_blank"';
				}
				$slide_html = sprintf( '<a href="%s"%s>%s</a>', esc_url( $slide_link ), $target, $slide_html );
			}
			if ( $slide_html ) {
				$slides[] = '<div class="slick-slide"><div class="slick-slide-inner">' . $slide_html . '</div></div>';
			}
		}

		if ( empty( $slides ) ) {
			return;
		}

		$direction = function_exists('is_rtl') && is_rtl() ? 'rtl' : 'ltr';

		$slider_classes = [ 'lp-slider' ];

		if ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) ) {
			$slider_classes[] = 'slick-arrows-' . $settings['arrows_position'];
		}

		if ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) ) {
			$slider_classes[] = 'slick-dots-' . $settings['dots_position'];
		}

		if ( 'yes' === $settings['image_stretch'] ) {
			$slider_classes[] = 'slick-image-stretch';
		}

		$slider_options = [
			'autoplaySpeed' => absint( $settings['autoplay_speed'] ),
			'autoplay' => ( 'no' !== $settings['autoplay'] ? true : false ),
			'infinite' => ( 'no' !== $settings['infinite'] ? true : false ),
			'pauseOnHover' => ( 'no' !== $settings['pause_on_hover'] ? true : false ),
			'speed' => absint( $settings['speed'] ),
			'arrows' => ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) ? true : false ),
			'dots' => ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) ? true : false ),
			'fade' => ( 'slide' !== $settings['effect'] ? true : false ),
			'adaptiveHeight' => ( 'no' !== $settings['adaptive_height'] ? true : false ),
			'rtl' => ( is_rtl() ? true : false ),
		];

		$this->add_render_attribute( 'slider', [
			'class' => implode( ' ', $slider_classes ),
			'data-slider_options' => wp_json_encode( $slider_options ),
		] );

		$this->add_render_attribute( 'slider_wrapper', [
			'class' => 'lp-slider-wrapper elementor-slick-slider',
			'dir' => $direction,
		] );

		?>
		<div <?php echo $this->get_render_attribute_string( 'slider_wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'slider' ); ?>>
				<?php echo implode( '', $slides ); ?>
			</div>
		</div>
		<?php
	}

	protected function _content_template() {
	}
}
