<?php
namespace ElementorLandingPress;

use ElementorLandingPress\Widgets\LP_Navigation_Menu;
use ElementorLandingPress\Widgets\LP_Posts_Grid;
use ElementorLandingPress\Widgets\LP_Contact_Form;
use ElementorLandingPress\Widgets\LP_Confirmation_Form;
use ElementorLandingPress\Widgets\LP_Slider_Image;
use ElementorLandingPress\Widgets\LP_Slider_Content;
use ElementorLandingPress\Widgets\LP_Video_Youtube;
use ElementorLandingPress\Widgets\LP_Video_Facebook;
use ElementorLandingPress\Widgets\LP_Button_SMS;
use ElementorLandingPress\Widgets\LP_Button_Tel;
use ElementorLandingPress\Widgets\LP_Button_BBM;
use ElementorLandingPress\Widgets\LP_Button_Line;
use ElementorLandingPress\Widgets\LP_Button_Whatsapp;
use ElementorLandingPress\Widgets\LP_Button_WAGroup;
use ElementorLandingPress\Widgets\LP_Button_Messenger;
use ElementorLandingPress\Widgets\LP_Button_Telegram;
use ElementorLandingPress\Widgets\LP_Button_Instagram;
use ElementorLandingPress\Widgets\LP_Button_Video;
use ElementorLandingPress\Widgets\LP_Image_Video;
use ElementorLandingPress\Widgets\LP_Countdown_Pro;
use ElementorLandingPress\Widgets\LP_Countdown_Simple;
use ElementorLandingPress\Widgets\LP_Optin;
use ElementorLandingPress\Widgets\LP_Optin_2steps;
use ElementorLandingPress\Widgets\LP_FB_Comments;
use ElementorLandingPress\Widgets\LP_WC_Products;
use ElementorLandingPress\Widgets\LP_WC_Products_On_Sale;
use ElementorLandingPress\Widgets\LP_WC_Products_Best_Selling;
use ElementorLandingPress\Widgets\LP_WC_Product_Categories;
use ElementorLandingPress\Widgets\LP_WC_Product_AddToCart;
use ElementorLandingPress\Widgets\LP_Wuoy_Buy_Button;
use ElementorLandingPress\Widgets\LP_Wuoy_Content_Protection;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class Plugin {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {
		add_action( 'elementor/init', [ $this, 'on_init' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
		add_filter( 'landingpress_customize_controls', [ $this, 'customize_controls' ], 20 );
		add_action( 'wp_head', [ $this, 'custom_header_footer_config' ] );
		add_filter( 'wp_enqueue_scripts', [ $this, 'custom_header_footer_css' ] );
		add_action( 'landingpress_page_before', [ $this, 'custom_header_elementor' ] );
		add_action( 'landingpress_page_after', [ $this, 'custom_footer_elementor' ] );
		add_action( 'admin_action_elementor', [ $this, 'register_wc_hooks' ], 9 );
		add_action( 'wp', [ $this, 'wuoymembership_wp' ] );
		add_action( 'after_setup_theme', [ $this, 'wuoymembership_after_setup_theme' ] );
		add_filter( 'body_class', [ $this, 'body_class' ] );
		// add_filter( 'wp', [ $this, 'button_sms_wp' ] );
		// add_filter( 'wp_head', [ $this, 'button_sms_wp_head' ] );
		// add_action( 'wp', [ $this, 'hide_scripts_on_edit' ] );
	}

	/**
	 * On Init
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_init() {
		\Elementor\Plugin::$instance->elements_manager->add_category(
			'landingpress',
			[
				'title' => __( 'LandingPress', 'landingpress-wp' ),
				'icon' => 'font',
			],
			1
		);
		if ( function_exists( 'WC' ) ) {
			\Elementor\Plugin::$instance->elements_manager->add_category(
				'landingpress-woocommerce',
				[
					'title' => __( 'LandingPress WooCommerce', 'landingpress-wp' ),
					'icon' => 'font',
				],
				2
			);
		}
		if ( function_exists( 'wuoyMemberSetupGlobalVar' ) ) {
			\Elementor\Plugin::$instance->elements_manager->add_category(
				'landingpress-wuoymembership',
				[
					'title' => __( 'LandingPress WuoyMembership', 'landingpress-wp' ),
					'icon' => 'font',
				],
				2
			);
		}
		\Elementor\Plugin::$instance->elements_manager->add_category(
			'landingpress-slow',
			[
				'title' => __( 'Slow Widgets', 'landingpress-wp' ),
				'icon' => 'font',
			],
			3
		);
	}

	/**
	 * On Widgets Registered
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}

	/**
	 * Includes
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function includes() {
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/navigation-menu.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/posts-grid.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/contact-form.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/confirmation-form.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/slider-image.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/slider-content.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/video-youtube.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/video-facebook.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/button-sms.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/button-tel.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/button-bbm.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/button-line.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/button-whatsapp.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/button-wagroup.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/button-messenger.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/button-telegram.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/button-instagram.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/button-video.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/image-video.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/countdown-pro.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/countdown-simple.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/optin.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/optin-2steps.php' );
		require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/fb-comments.php' );
		if ( function_exists( 'WC' ) ) {
			require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/wc-products.php' );
			require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/wc-products-on-sale.php' );
			require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/wc-products-best-sellings.php' );
			require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/wc-product-categories.php' );
			require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/wc-product-addtocart.php' );
		}
		if ( function_exists( 'wuoyMemberSetupGlobalVar' ) ) {
			require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/wuoy-buy-button.php' );
			require_once ( ADDONS_PATH . 'elementor-landingpress/widgets/wuoy-content-protection.php' );
		}
	}

	/**
	 * Register Widget
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_widget() {
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Navigation_Menu() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Posts_Grid() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Contact_Form() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Confirmation_Form() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Slider_Image() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Slider_Content() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Video_Youtube() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Video_Facebook() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Button_SMS() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Button_Tel() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Button_BBM() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Button_Line() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Button_Whatsapp() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Button_WAGroup() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Button_Messenger() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Button_Telegram() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Button_Instagram() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Button_Video() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Image_Video() );
		// \Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Countdown_Pro() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Countdown_Simple() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Optin() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Optin_2steps() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_FB_Comments() );
		if ( function_exists( 'WC' ) ) {
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_WC_Products() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_WC_Products_On_Sale() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_WC_Products_Best_Selling() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_WC_Product_Categories() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_WC_Product_AddToCart() );
		}
		if ( function_exists( 'wuoyMemberSetupGlobalVar' ) ) {
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Wuoy_Buy_Button() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new LP_Wuoy_Content_Protection() );
		}
	}

	public function customize_controls( $controls ) {
		if ( did_action( 'elementor/loaded' )  ) {
			$templates_local = \Elementor\Plugin::$instance->templates_manager->get_source( 'local' );
			$templates = $templates_local->get_items();
			$options_header = array( '' => esc_html__( 'No Custom Header', 'landingpress-wp' ) );
			$options_footer = array( '' => esc_html__( 'No Custom Footer', 'landingpress-wp' ) );
			foreach ( $templates as $template ) {
				$template_id = $template['template_id'];
				$options_header[$template_id] = $template['title'].' ('.$template['type'].')';
				$options_footer[$template_id] = $template['title'].' ('.$template['type'].')';
			}
			$controls[] = array(
				'type'     => 'heading',
				'setting'  => 'landingpress_heading_page_header',
				'label'    => esc_html__( 'Custom Header/Footer', 'landingpress-wp' ),
				'description' => 'Anda bisa juga menampilkan header / footer custom yang dibuat di Elementor Library. Sangat cocok untuk layout halaman tipe "Full Width".',
				'section'  => 'landingpress_pagelayout',
			);
			$controls[] = array(
				'type'     => 'select',
				'setting'  => 'landingpress_page_header_elementor',
				'label'    => esc_html__( 'Custom Header From Elementor Library', 'landingpress-wp' ),
				'section'  => 'landingpress_pagelayout',
				'choices'  => $options_header,
			);
			$controls[] = array(
				'type'     => 'select',
				'setting'  => 'landingpress_page_footer_elementor',
				'label'    => esc_html__( 'Custom Footer From Elementor Library', 'landingpress-wp' ),
				'section'  => 'landingpress_pagelayout',
				'choices'  => $options_footer,
			);
		}
		return $controls;
	}

	public function custom_header_footer_config() {
		global $landingpress_page_header_elementor_id, $landingpress_page_footer_elementor_id;
		$landingpress_page_header_elementor_id = get_theme_mod('landingpress_page_header_elementor');
		$landingpress_page_footer_elementor_id = get_theme_mod('landingpress_page_footer_elementor');
		if ( is_singular('post') || is_page() ) {
			$id = get_queried_object_id();
			$custom_header = get_post_meta( $id, '_landingpress_page_header_custom', true );
			if ( $custom_header == 'disable' ) {
				$landingpress_page_header_elementor_id = '';
			}
			elseif ( $custom_header == 'custom' ) {
				$landingpress_page_header_elementor_id = get_post_meta( $id, '_landingpress_page_header_elementor', true );
			}
			$custom_footer = get_post_meta( $id, '_landingpress_page_footer_custom', true );
			if ( $custom_footer == 'disable' ) {
				$landingpress_page_footer_elementor_id = '';
			}
			elseif ( $custom_footer == 'custom' ) {
				$landingpress_page_footer_elementor_id = get_post_meta( $id, '_landingpress_page_footer_elementor', true );
			}
		}
	}

	public function custom_header_footer_css() {
		if ( did_action( 'elementor/loaded' )  ) {
			global $landingpress_page_header_elementor_id, $landingpress_page_footer_elementor_id;
			if ( $id = $landingpress_page_header_elementor_id ) {
				if ( 'publish' == get_post_status( $id ) ) {
					$meta = get_post_meta( $id, '_elementor_css', true );
					if ( isset( $meta['css'] ) ) {
						wp_add_inline_style( 'elementor-frontend', $meta['css'] );
					}
				}
			}
			if ( $id = $landingpress_page_footer_elementor_id ) {
				if ( 'publish' == get_post_status( $id ) ) {
					$meta = get_post_meta( $id, '_elementor_css', true );
					if ( isset( $meta['css'] ) ) {
						wp_add_inline_style( 'elementor-frontend', $meta['css'] );
					}
				}
			}
		}
	}

	public function custom_header_elementor() {
		if ( did_action( 'elementor/loaded' )  ) {
			global $landingpress_page_header_elementor_id;
			if ( $id = $landingpress_page_header_elementor_id ) {
				if ( 'publish' == get_post_status( $id ) ) {
					echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $id );
				}
			}
		}
	}

	public function custom_footer_elementor() {
		if ( did_action( 'elementor/loaded' )  ) {
			global $landingpress_page_footer_elementor_id;
			if ( $id = $landingpress_page_footer_elementor_id ) {
				if ( 'publish' == get_post_status( $id ) ) {
					echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $id );
				}
			}
		}
	}

	public function register_wc_hooks() {
		if ( ! class_exists('woocommerce') ) {
			return;
		}
		wc()->frontend_includes();
	}

	public function wuoymembership_wp() {
		if ( class_exists('wuoyMemberPageProtection') ) {
			wp_enqueue_script('jquery');
			if ( is_singular() ) {
				if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
					landingpress_remove_filters_for_anonymous_class( 'template_redirect', 'wuoyMemberPageProtection', 'check', 10000 );
					remove_shortcode('wuoyMember-content-protection');
				}
			}
		}
	}

	public function wuoymembership_after_setup_theme() {
		if ( class_exists('wuoyMemberPageProtection') ) {
			landingpress_remove_filters_for_anonymous_class( 'save_post', 'wuoyMemberPageProtection', 'saveMetabox', 10000 );
			add_action( 'save_post' , array( $this, 'wuoymembership_savepost' ), 10000 );
		}
	}

	public function wuoymembership_savepost($postID) {
		if ( class_exists('wuoyMemberPageProtection') && function_exists('wuoyMemberCustomField') ) {
			global $wuoyMember;

			if ( ! isset( $_POST['wuoyMember-metabox-save'] ) )
				return $postID;

			$nonce = $_POST['wuoyMember-metabox-save'];

			if ( ! wp_verify_nonce( $nonce, 'wuoyMember-metabox' ) )
				return $postID;

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $postID;

			$protection 	= wuoyMemberCustomField('product_connect',$postID);

			if( (!isset($_POST['wuoym_product_connect']) || empty($_POST['wuoym_product_connect'])) && is_array($protection) && count($protection) > 0) {
				update_post_meta($postID,'product_connect',NULL);
			}
		}
	}

	public function button_sms_wp() {
		global $landingpress_button_sms_active;
		if ( is_singular() ) {
			$id = get_the_ID();
			if ( 'builder' === get_post_meta( $id, '_elementor_edit_mode', true ) ) {
				$data = get_post_meta( $id, '_elementor_data', true );
				if ( false !== strpos( $data, '"button_sms"' ) ) {
					$landingpress_button_sms_active = true;
				}
			}
		}
	}

	public function button_sms_wp_head() {
		global $landingpress_button_sms_active;
		if ( $landingpress_button_sms_active ) {
?>
<script type='text/javascript'>
//<![CDATA[
var userAgent = navigator.userAgent;
if( userAgent.search("FBAN") > 1 || userAgent.search("FB_IAB") > 1) {
	window.location.assign( "googlechrome://navigate?url=" + window.location.href );
}
//]]>
</script>
<?php 
		}
	}

	public function body_class( $classes ) {
		global $landingpress_button_sms_active;
		if ( $landingpress_button_sms_active ) {
			$classes[] = 'elementor-button-sms-active';
		}
		return $classes;
	}

	public function hide_scripts_on_edit() {
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			remove_action( 'wp_head', 'landingpress_script_header', 99 );
			remove_action( 'wp_footer', 'landingpress_script_footer', 99 );

			remove_action( 'wp_head', 'landingpress_wp_head_singular_script', 100 );
			remove_action( 'wp_footer', 'landingpress_wp_footer_singular_script', 100 );

			remove_action( 'wp_head', 'landingpress_wp_head_facebook_pixels_set_event', 5 );
			remove_action( 'wp_head', 'landingpress_wp_head_facebook_pixels', 100 );
			remove_action( 'wp_footer', 'landingpress_wp_footer_facebook_pixels', 100 );

			remove_action( 'wp_head', 'landingpress_wp_head_google_tag_manager', 105 );
			remove_action( 'wp_head', 'landingpress_wp_head_google_analytics', 107 );
			remove_action( 'wp_footer', 'landingpress_wp_footer_adwords_remarketing', 100 );
		}
	}
}

new Plugin();
