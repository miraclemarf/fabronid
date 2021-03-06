<?php
namespace Elementor\Core\Settings\Page;

use Elementor\CSS_File;
use Elementor\Core\Settings\Base\Manager as BaseManager;
use Elementor\Core\Settings\Manager as SettingsManager;
use Elementor\Core\Settings\Base\Model as BaseModel;
use Elementor\Post_CSS_File;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Manager extends BaseManager {

	const TEMPLATE_CANVAS = 'elementor_canvas';

	const META_KEY = '_elementor_page_settings';

	/**
	 * @since 1.6.0
	 * @access public
	 */
	public function __construct() {
		parent::__construct();

		add_action( 'init', [ $this, 'init' ] );

		add_filter( 'template_include', [ $this, 'template_include' ] );
	}

	/**
	 * @since 1.6.0
	 * @access public
	 * @static
	 * @deprecated since 1.6.0
	 *
	 * @param int $id
	 *
	 * @return BaseModel
	 */
	public static function get_page( $id ) {
		return SettingsManager::get_settings_managers( 'page' )->get_model( $id );
	}

	/**
	 * @since 1.6.0
	 * @access public
	 * @static
	 */
	public static function add_page_templates( $post_templates ) {
		$post_templates = [
			self::TEMPLATE_CANVAS => __( 'Elementor', 'elementor' ) . ' ' . __( 'Canvas', 'elementor' ),
		] + $post_templates;

		return $post_templates;
	}

	/**
	 * @since 1.6.0
	 * @access public
	 * @static
	 */
	public static function is_cpt_custom_templates_supported() {
		require_once ABSPATH . '/wp-admin/includes/theme.php';

		return method_exists( wp_get_theme(), 'get_post_templates' );
	}

	/**
	 * @since 1.6.0
	 * @access public
	 */
	public function template_include( $template ) {
		if ( is_singular() ) {
			$page_template = get_post_meta( get_the_ID(), '_wp_page_template', true );

			if ( self::TEMPLATE_CANVAS === $page_template ) {
				$template = ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
			}
		}

		return $template;
	}

	/**
	 * @since 1.6.0
	 * @access public
	 */
	public function init() {
		$post_types = get_post_types_by_support( 'elementor' );

		foreach ( $post_types as $post_type ) {
			add_filter( "theme_{$post_type}_templates", [ __CLASS__, 'add_page_templates' ], 10, 4 );
		}
	}

	/**
	 * @since 1.6.0
	 * @access public
	 */
	public function get_name() {
		return 'page';
	}

	/**
	 * @since 1.6.0
	 * @access public
	 * @return BaseModel
	 */
	public function get_model_for_config() {
		return $this->get_model( get_the_ID() );
	}

	/**
	 * @since 1.6.0
	 * @access protected
	 */
	protected function ajax_before_save_settings( array $data, $id ) {
		$post = get_post( $id );

		if ( empty( $post ) ) {
			wp_send_json_error( 'Invalid Post' );
		}

		if ( ! current_user_can( 'edit_post', $id ) ) {
			wp_send_json_error( __( 'Access Denied.', 'elementor' ) );
		}

		// Avoid save empty post title.
		if ( ! empty( $data['post_title'] ) ) {
			$post->post_title = $data['post_title'];
		}

		if ( isset( $data['post_excerpt'] ) && post_type_supports( $post->post_type, 'excerpt' ) ) {
			$post->post_excerpt = $data['post_excerpt'];
		}

		$allowed_post_statuses = get_post_statuses();

		if ( isset( $data['post_status'] ) && isset( $allowed_post_statuses[ $data['post_status'] ] ) ) {
			$post_type_object = get_post_type_object( $post->post_type );
			if ( 'publish' !== $data['post_status'] || current_user_can( $post_type_object->cap->publish_posts ) ) {
				$post->post_status = $data['post_status'];
			}
		}

		wp_update_post( $post );

		if ( self::is_cpt_custom_templates_supported() ) {
			$template = 'default';

			if ( isset( $data['template'] ) ) {
				$template = $data['template'];
			}

			update_post_meta( $post->ID, '_wp_page_template', $template );
		}

		if ( isset( $data['_landingpress_hide_sidebar'] ) ) {
			update_post_meta( $post->ID, '_landingpress_hide_sidebar', $data['_landingpress_hide_sidebar'] );
		}
		else {
			delete_post_meta( $post->ID, '_landingpress_hide_sidebar' );
		}
		if ( isset( $data['_landingpress_hide_header'] ) ) {
			update_post_meta( $post->ID, '_landingpress_hide_header', $data['_landingpress_hide_header'] );
		}
		else {
			delete_post_meta( $post->ID, '_landingpress_hide_header' );
		}
		if ( isset( $data['_landingpress_hide_menu'] ) ) {
			update_post_meta( $post->ID, '_landingpress_hide_menu', $data['_landingpress_hide_menu'] );
		}
		else {
			delete_post_meta( $post->ID, '_landingpress_hide_menu' );
		}
		if ( isset( $data['_landingpress_hide_footerwidgets'] ) ) {
			update_post_meta( $post->ID, '_landingpress_hide_footerwidgets', $data['_landingpress_hide_footerwidgets'] );
		}
		else {
			delete_post_meta( $post->ID, '_landingpress_hide_footerwidgets' );
		}
		if ( isset( $data['_landingpress_hide_footer'] ) ) {
			update_post_meta( $post->ID, '_landingpress_hide_footer', $data['_landingpress_hide_footer'] );
		}
		else {
			delete_post_meta( $post->ID, '_landingpress_hide_footer' );
		}
		if ( isset( $data['_landingpress_hide_breadcrumb'] ) ) {
			update_post_meta( $post->ID, '_landingpress_hide_breadcrumb', $data['_landingpress_hide_breadcrumb'] );
		}
		else {
			delete_post_meta( $post->ID, '_landingpress_hide_breadcrumb' );
		}
		if ( isset( $data['_landingpress_hide_title'] ) ) {
			update_post_meta( $post->ID, '_landingpress_hide_title', $data['_landingpress_hide_title'] );
		}
		else {
			delete_post_meta( $post->ID, '_landingpress_hide_title' );
		}
		if ( isset( $data['_landingpress_hide_comments'] ) ) {
			update_post_meta( $post->ID, '_landingpress_hide_comments', $data['_landingpress_hide_comments'] );
		}
		else {
			delete_post_meta( $post->ID, '_landingpress_hide_comments' );
		}
		if ( isset( $data['_landingpress_page_width'] ) ) {
			update_post_meta( $post->ID, '_landingpress_page_width', $data['_landingpress_page_width'] );
		}
		else {
			delete_post_meta( $post->ID, '_landingpress_page_width' );
		}
		if ( isset( $data['_landingpress_page_header_custom'] ) ) {
			update_post_meta( $post->ID, '_landingpress_page_header_custom', $data['_landingpress_page_header_custom'] );
		}
		else {
			delete_post_meta( $post->ID, '_landingpress_page_header_custom' );
		}
		if ( isset( $data['_landingpress_page_header_elementor'] ) ) {
			update_post_meta( $post->ID, '_landingpress_page_header_elementor', $data['_landingpress_page_header_elementor'] );
		}
		else {
			delete_post_meta( $post->ID, '_landingpress_page_header_elementor' );
		}
		if ( isset( $data['_landingpress_page_footer_custom'] ) ) {
			update_post_meta( $post->ID, '_landingpress_page_footer_custom', $data['_landingpress_page_footer_custom'] );
		}
		else {
			delete_post_meta( $post->ID, '_landingpress_page_footer_custom' );
		}
		if ( isset( $data['_landingpress_page_footer_elementor'] ) ) {
			update_post_meta( $post->ID, '_landingpress_page_footer_elementor', $data['_landingpress_page_footer_elementor'] );
		}
		else {
			delete_post_meta( $post->ID, '_landingpress_page_footer_elementor' );
		}
	}

	/**
	 * @since 1.6.0
	 * @access protected
	 */
	protected function save_settings_to_db( array $settings, $id ) {
		if ( ! empty( $settings ) ) {
			update_post_meta( $id, self::META_KEY, $settings );
		} else {
			delete_post_meta( $id, self::META_KEY );
		}
	}

	/**
	 * @since 1.6.0
	 * @access protected
	 */
	protected function get_css_file_for_update( $id ) {
		return new Post_CSS_File( $id );
	}

	/**
	 * @since 1.6.0
	 * @access protected
	 */
	protected function get_saved_settings( $id ) {
		$settings = get_post_meta( $id, self::META_KEY, true );

		if ( ! $settings ) {
			$settings = [];
		}

		if ( self::is_cpt_custom_templates_supported() ) {
			$saved_template = get_post_meta( $id, '_wp_page_template', true );

			if ( $saved_template ) {
				$settings['template'] = $saved_template;
			}
		}

		$settings['_landingpress_hide_sidebar'] = get_post_meta( $id, '_landingpress_hide_sidebar', true );
		$settings['_landingpress_hide_header'] = get_post_meta( $id, '_landingpress_hide_header', true );
		$settings['_landingpress_hide_menu'] = get_post_meta( $id, '_landingpress_hide_menu', true );
		$settings['_landingpress_hide_footerwidgets'] = get_post_meta( $id, '_landingpress_hide_footerwidgets', true );
		$settings['_landingpress_hide_footer'] = get_post_meta( $id, '_landingpress_hide_footer', true );
		$settings['_landingpress_hide_breadcrumb'] = get_post_meta( $id, '_landingpress_hide_breadcrumb', true );
		$settings['_landingpress_hide_title'] = get_post_meta( $id, '_landingpress_hide_title', true );
		$settings['_landingpress_hide_comments'] = get_post_meta( $id, '_landingpress_hide_comments', true );
		$settings['_landingpress_page_width'] = get_post_meta( $id, '_landingpress_page_width', true );

		$settings['_landingpress_page_header_custom'] = get_post_meta( $id, '_landingpress_page_header_custom', true );
		$settings['_landingpress_page_header_elementor'] = get_post_meta( $id, '_landingpress_page_header_elementor', true );
		$settings['_landingpress_page_footer_custom'] = get_post_meta( $id, '_landingpress_page_footer_custom', true );
		$settings['_landingpress_page_footer_elementor'] = get_post_meta( $id, '_landingpress_page_footer_elementor', true );

		return $settings;
	}

	/**
	 * @since 1.6.0
	 * @access protected
	 */
	protected function get_css_file_name() {
		return 'post';
	}

	/**
	 * @since 1.6.0
	 * @access protected
	 * @param CSS_File $css_file
	 *
	 * @return BaseModel
	 */
	protected function get_model_for_css_file( CSS_File $css_file ) {
		if ( ! $css_file instanceof Post_CSS_File ) {
			return null;
		}

		return $this->get_model( $css_file->get_post_id() );
	}

	/**
	 * @since 1.6.0
	 * @access protected
	 */
	protected function get_special_settings_names() {
		return [
			'id',
			'post_title',
			'post_status',
			'template',
			'template',
			'_landingpress_hide_sidebar',
			'_landingpress_hide_header',
			'_landingpress_hide_menu',
			'_landingpress_hide_footerwidgets',
			'_landingpress_hide_footer',
			'_landingpress_hide_breadcrumb',
			'_landingpress_hide_title',
			'_landingpress_hide_comments',
			'_landingpress_page_width',
			'_landingpress_page_header_custom',
			'_landingpress_page_header_elementor',
			'_landingpress_page_footer_custom',
			'_landingpress_page_footer_elementor',
		];
	}
}
