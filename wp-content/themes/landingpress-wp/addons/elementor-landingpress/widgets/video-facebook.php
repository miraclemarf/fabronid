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

class LP_Video_Facebook extends Widget_Base {

	public function get_name() {
		return 'lp_video_facebook';
	}

	public function get_title() {
		return __( 'LP - Facebook Video', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-youtube';
	}

	public function get_categories() {
		return [ 'landingpress' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_video',
			[
				'label' => __( 'Facebook Video', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => 'https://www.facebook.com/agusmuhammad84/videos/1784745435186072/',
				'default' => 'https://www.facebook.com/agusmuhammad84/videos/1784745435186072/',
				'label_block' => true,
			]
		);

		$this->add_control(
			'aspect_ratio',
			[
				'label' => __( 'Aspect Ratio', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'169' => '16:9',
					'43' => '4:3',
					'32' => '3:2',
				],
				'default' => '169',
				'prefix_class' => 'elementor-aspect-ratio-',
			]
		);

		// $this->add_control(
		// 	'heading_youtube',
		// 	[
		// 		'label' => __( 'Video Options', 'landingpress-wp' ),
		// 		'type' => Controls_Manager::HEADING,
		// 		'separator' => 'before',
		// 	]
		// );

		// // YouTube
		// $this->add_control(
		// 	'yt_autoplay',
		// 	[
		// 		'label' => __( 'Autoplay', 'landingpress-wp' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'options' => [
		// 			'no' => __( 'No', 'landingpress-wp' ),
		// 			'yes' => __( 'Yes', 'landingpress-wp' ),
		// 		],
		// 		'default' => 'no',
		// 	]
		// );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		$video_link = $settings['link'];

		if ( empty( $video_link ) )
			return;

		$video_width = 750;
		if ( $settings['aspect_ratio'] == '32' ) {
			$video_height = absint( $video_width * 2 / 3 ); 
		}
		elseif ( $settings['aspect_ratio'] == '43' ) {
			$video_height = absint( $video_width * 3 / 4 ); 
		}
		else {
			$video_height = absint( $video_width * 9 / 16 ); 
		}

		$params = [];

		$params['href'] = $video_link;
		$params['width'] = $video_width;
		$params['height'] = $video_height;
		$params['show_text'] = 'false';

		$video_src = add_query_arg( $params, 'https://www.facebook.com/plugins/video.php' );

		?>
		<div class="lp-video-container">
			<iframe src="<?php echo $video_src; ?>" width="<?php echo $video_width; ?>" height="<?php echo $video_height; ?>" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
		</div>
		<?php 
	}

	protected function _content_template() {}
}
