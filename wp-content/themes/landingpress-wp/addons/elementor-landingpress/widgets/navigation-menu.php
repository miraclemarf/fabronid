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

class LP_Navigation_Menu extends Widget_Base {

	public function get_name() {
		return 'lp_navigation_menu';
	}

	public function get_title() {
		return __( 'LP - Navigation Menu', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-menu-bar';
	}

	public function get_categories() {
		return [ 'landingpress' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_menu',
			[
				'label' => __( 'PENTING!', 'landingpress-wp' ),
			]
		);

		$description = __( 'Anda bisa menggunakan widget ini untuk membuat navigation menu yang sederhana, cocok untuk <strong style="color:#4054b2;">standalone landing page</strong> ataupun <strong style="color:#4054b2;">one page website</strong>.', 'landingpress-wp' );
		$description .= '<br><br>';
		$description .= __( 'Widget ini <strong style="color:#9b0a46;">tidak bisa untuk dropdown menu (submenu)</strong> karena keterbatasan control Repeater di Elementor.', 'landingpress-wp' );

		$description .= '<br><br>';
		$description .= __( 'Jika Anda membutuhkan multilevel dropdown menu, silahkan gunakan page template lain seperti <strong style="color:#4054b2;">Blank Canvas + Header&Footer</strong>.', 'landingpress-wp' );

		$this->add_control(
			'menu_description',
			[
				'raw' => $description,
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menu_sticky',
			[
				'label' => __( 'Sticky Menu', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'sticky',
			[
				'label' => __( 'Sticky Menu', 'landingpress-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => __( 'Yes', 'landingpress-wp' ),
				'label_off' => __( 'No', 'landingpress-wp' ),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menu_logo',
			[
				'label' => __( 'Menu Logo', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'logo_image',
			[
				'label' => __( 'Logo Image', 'landingpress-wp' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => get_template_directory_uri().'/assets/images/logo.png',
				],
			]
		);

		$this->add_control(
			'logo_link',
			[
				'label' => __( 'Logo Link', 'landingpress-wp' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'http://your-link.com', 'landingpress-wp' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menu_items',
			[
				'label' => __( 'Menu Items', 'landingpress-wp' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'menu_label',
			[
				'label' => __( 'Label', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Menu Label', 'landingpress-wp' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'menu_link',
			[
				'label' => __( 'Link', 'landingpress-wp' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'http://your-link.com', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'menus',
			[
				'label' => __( 'Menu Items', 'landingpress-wp' ),
				'type' => Controls_Manager::REPEATER,
				'show_label' => true,
				'default' => [
					[
						'menu_label' => __( 'Menu 1', 'landingpress-wp' ),
						'menu_link' => '#',
					],
					[
						'menu_label' => __( 'Menu 2', 'landingpress-wp' ),
						'menu_link' => '#',
					],
					[
						'menu_label' => __( 'Menu 3', 'landingpress-wp' ),
						'menu_link' => '#',
					],
					[
						'menu_label' => __( 'Menu 4', 'landingpress-wp' ),
						'menu_link' => '#',
					],
					[
						'menu_label' => __( 'Menu 5', 'landingpress-wp' ),
						'menu_link' => '#',
					],
				],
				'fields' => array_values( $repeater->get_controls() ),
				'title_field' => '{{{ menu_label }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menu_sticky_style',
			[
				'label' => __( 'Sticky Menu', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'sticky!' => '',
				],
			]
		);

		$this->add_control(
			'menu_sticky_background',
			[
				'label' => __( 'Sticky Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .is-sticky .lp-navmenu-wrapper.lp-navmenu-sticky' => 'background: {{VALUE}};',
				],
				'condition' => [
					'sticky!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menus_style',
			[
				'label' => __( 'Menu Items', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_menus_style' );

		$this->start_controls_tab(
			'tab_menus_normal',
			[
				'label' => __( 'Normal', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'menus_text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lp-navmenu-items li a, {{WRAPPER}} .lp-navmenu-items li a:visited, {{WRAPPER}} .lp-navmenu-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lp-navmenu-items, {{WRAPPER}} .lp-navmenu-items li' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menus_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .lp-navmenu-items li a, {{WRAPPER}} .lp-navmenu-items li a:visited, {{WRAPPER}} .lp-navmenu-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menus_hover',
			[
				'label' => __( 'Hover', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'menus_text_hover_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lp-navmenu-items li a:hover, {{WRAPPER}} .lp-navmenu-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();
		if ( empty( $settings['menus'] ) ) {
			return;
		}
		$menus_data = array();
		$menus_count = 0;
		foreach ( $settings['menus'] as $menu ) {
			$menu_label = $menu['menu_label'];
			$menu_link = $menu['menu_link']['url'] ? $menu['menu_link']['url'] : '#';
			$menu_target = $menu['menu_link']['is_external'] ? ' target="_blank"' : '';
			$menus_data[] = sprintf( '<li><a href="%s" %s>%s</a></li>', $menu_link, $menu_target, $menu_label );
			$menus_count++;
		}
		$menu_logo = '';
		if ( $settings['logo_image']['url'] ) {
			$menu_logo = '<img src="'.$settings['logo_image']['url'].'" alt="" />';
			if ( $settings['logo_link']['url'] ) {
				$menu_log_target = $settings['logo_link']['is_external'] ? ' target="_blank"' : '';
				$menu_logo = '<a href="'.$settings['logo_link']['url'].'" '.$menu_log_target.'>'.$menu_logo.'</a>';
			}
		}
		if ( $menu_logo ) {
			$menu_logo = '<div class="lp-navmenu-logo">'.$menu_logo.'</div>';
		}
		?>
		<div class="lp-navmenu-wrapper <?php if ( isset( $settings['sticky'] ) && $settings['sticky'] == 'yes' ) echo 'lp-navmenu-sticky'; ?>">
			<?php echo $menu_logo; ?>
			<div class="lp-navmenu-button">
				<i class="fa fa-bars"></i>
			</div>
			<ul class="lp-navmenu-items">
				<?php echo implode( '', $menus_data ); ?>
			</ul>
			<div style="clear:both;"></div>
		</div>
		<?php 
	}

	protected function _content_template() {
	}
}
