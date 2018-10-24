<?php
namespace Elementor\TemplateLibrary;

use Elementor\Api_Landingpresssections;
use Elementor\PageSettings\Page;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Source_Landingpresssections extends Source_Base {

	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function get_id() {
		return 'landingpresssections';
	}

	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function get_title() {
		return __( 'LandingPress Sections', 'elementor' );
	}

	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function register_data() {}

	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function get_items( $args = [] ) {
		$templates_data = Api_Landingpresssections::get_templates_data();

		$templates = [];

		if ( ! empty( $templates_data ) ) {
			foreach ( $templates_data as $template_data ) {
				$templates[] = $this->get_item( $template_data );
			}
		}

		if ( ! empty( $args ) ) {
			$templates = wp_list_filter( $templates, $args );
		}

		return $templates;
	}

	/**
	 * @since 1.0.0
	 * @access public
	 * @param array $template_data
	 *
	 * @return array
	 */
	public function get_item( $template_data ) {
		$favorite_templates = $this->get_user_meta( 'favorites' );

		return [
			'template_id' => $template_data['id'],
			'source' => $this->get_id(),
			'title' => $template_data['title'],
			'thumbnail' => Api_Landingpresssections::get_template_thumbnail( $template_data ),
			'date' => isset( $template_data['tmpl_created'] ) ? $template_data['tmpl_created'] : '',
			'author' => 'LandingPress',
			'categories' => [],
			'keywords' => [],
			'isPro' => 0,
			'hasPageSettings' => ( isset( $template_data['has_page_settings'] ) && '1' === $template_data['has_page_settings'] ),
			'url' => $template_data['url'],
			'favorite' => ! empty( $favorite_templates[ $template_data['id'] ] ),
		];
	}

	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function save_item( $template_data ) {
		return false;
	}

	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function update_item( $new_data ) {
		return false;
	}

	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function delete_template( $template_id ) {
		return false;
	}

	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function export_template( $template_id ) {
		return false;
	}

	/**
	 * @since 1.5.0
	 * @access public
	*/
	public function get_data( array $args, $context = 'display' ) {
		$data = Api_Landingpresssections::get_template_content( $args['template_id'] );

		if ( is_wp_error( $data ) ) {
			return $data;
		}

		// TODO: since 1.5.0 to content container named `content` instead of `data`.
		if ( ! empty( $data['data'] ) ) {
			$data['content'] = $data['data'];
			unset( $data['data'] );
		}

		$data['content'] = $this->replace_elements_ids( $data['content'] );
		$data['content'] = $this->process_export_import_content( $data['content'], 'on_import' );

		if ( ! empty( $args['page_settings'] ) && ! empty( $data['page_settings'] ) ) {
			$page = new Page( [
				'settings' => $data['page_settings'],
			] );

			$page_settings_data = $this->process_element_export_import_content( $page, 'on_import' );
			$data['page_settings'] = $page_settings_data['settings'];
		}

		return $data;
	}
}
