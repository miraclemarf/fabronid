<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor API class.
 *
 * Elementor API handler class is responsible for communicating with Elementor
 * remote servers retrieve templates data and to send uninstall feedback.
 *
 * @since 1.0.0
 */
class Api_Landingpresstemplates {

	/**
	 * API info URL.
	 *
	 * Holds the URL of the info API.
	 *
	 * @access public
	 * @static
	 *
	 * @var string API info URL.
	 */
	public static $api_info_url = 'http://api3.landingpress.net/templates/info/';

	/**
	 * API feedback URL.
	 *
	 * Holds the URL of the feedback API.
	 *
	 * @access private
	 * @static
	 *
	 * @var string API feedback URL.
	 */
	private static $api_feedback_url = 'http://api3.landingpress.net/templates/feedback/';

	/**
	 * API get template content URL.
	 *
	 * Holds the URL of the template content API.
	 *
	 * @access private
	 * @static
	 *
	 * @var string API get template content URL.
	 */
	private static $api_get_template_content_url = 'http://api3.landingpress.net/templates/content/';
	private static $api_get_template_thumbnail_url = 'http://api3.landingpress.net/templates/thumbnail/';

	/**
	 * Get info data.
	 *
	 * This function notifies the user of upgrade notices, new templates and contributors.
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @param bool $force_update Optional. Whether to force the data retrieval or
	 *                                     not. Default is false.
	 *
	 * @return array|false Info data, or false.
	 */
	private static function _get_info_data( $force_update = false ) {
		$theme_name = LANDINGPRESS_THEME_NAME;
		$theme_slug = LANDINGPRESS_THEME_SLUG;
		$theme_version = LANDINGPRESS_THEME_VERSION;

		$license = trim( get_option( $theme_slug . '_license_key' ) );
		if ( !$license ) {
			return false;
		}

		$license_status = get_option( $theme_slug . '_license_key_status', false );
		if ( $license_status != 'valid' ) {
			return false;
		}

		$cache_key = 'landingpresstemplates_info_api_data_' . ELEMENTOR_VERSION;

		$info_data = get_transient( $cache_key );

		if ( $force_update || false === $info_data ) {
			$timeout = ( $force_update ) ? 25 : 8;

			$response = wp_remote_post( self::$api_info_url, [
				'timeout' => $timeout,
				'body' => [
					// Which API version is used.
					'api_version'	=> ELEMENTOR_VERSION,
					// Which language to return.
					'site_lang'		=> get_bloginfo( 'language' ),
					'url'			=> home_url(),
					'license'		=> $license,
					'item_name'		=> urlencode( $theme_name ),
					'theme_version'	=> $theme_version,
				],
			] );

			if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
				set_transient( $cache_key, [], 2 * HOUR_IN_SECONDS );

				return false;
			}

			$response_body = wp_remote_retrieve_body( $response );
			if ( $response_body === 'invalid' ) {
				return false;
			}

			$info_data = json_decode( $response_body, true );

			if ( empty( $info_data ) || ! is_array( $info_data ) ) {
				set_transient( $cache_key, [], 2 * HOUR_IN_SECONDS );

				return false;
			}

			if ( isset( $info_data['templates'] ) ) {
				update_option( 'landingpresstemplates_info_templates_data', $info_data['templates'], 'no' );

				unset( $info_data['templates'] );
			}

			if ( isset( $info_data['feed'] ) ) {
				update_option( 'landingpresstemplates_remote_info_feed_data', $info_data['feed'], 'no' );

				unset( $info_data['feed'] );
			}

			set_transient( $cache_key, $info_data, 12 * HOUR_IN_SECONDS );
		}

		return $info_data;
	}

	/**
	 * Get upgrade notice.
	 *
	 * Retrieve the upgrade notice if one exists, or false otherwise.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return array|false Upgrade notice, or false none exist.
	 */
	public static function get_upgrade_notice() {
		$data = self::_get_info_data();

		if ( empty( $data['upgrade_notice'] ) ) {
			return false;
		}

		return $data['upgrade_notice'];
	}

	/**
	 * Get templates data.
	 *
	 * Retrieve the templates data from a remote server.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @param bool $force_update Optional. Whether to force the data update or
	 *                                     not. Default is false.
	 *
	 * @return array The templates data.
	 */
	public static function get_templates_data( $force_update = false ) {
		self::_get_info_data( $force_update );

		$templates = get_option( 'landingpresstemplates_info_templates_data' );

		if ( empty( $templates ) ) {
			return [];
		}

		return $templates;
	}

	/**
	 * Get template content.
	 *
	 * Retrieve the templates content recieved from a remote server.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return array The template content.
	 */
	public static function get_template_content( $template_id ) {
		$theme_name = LANDINGPRESS_THEME_NAME;
		$theme_slug = LANDINGPRESS_THEME_SLUG;
		$theme_version = LANDINGPRESS_THEME_VERSION;

		$license = trim( get_option( $theme_slug . '_license_key' ) );
		if ( !$license ) {
			return new \WP_Error( 'license_error', 'Your license is missing' );
		}

		$license_status = get_option( $theme_slug . '_license_key_status', false );
		if ( $license_status != 'valid' ) {
			return new \WP_Error( 'license_status_error', 'Your license status is not valid' );
		}

		$response = wp_remote_post( self::$api_get_template_content_url, [
			'timeout' => 40,
			'body' => [
				// Which API version is used
				'api_version'	=> ELEMENTOR_VERSION,
				// Which language to return
				'site_lang'		=> get_bloginfo( 'language' ),
				'template_id'	=> $template_id,
				'url'			=> home_url(),
				'license'		=> $license,
				'item_name'		=> urlencode( $theme_name ),
				'theme_version'	=> $theme_version,
			],
		] );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$response_code = (int) wp_remote_retrieve_response_code( $response );

		if ( 200 !== $response_code ) {
			return new \WP_Error( 'response_code_error', 'The request returned with a status code of ' . $response_code );
		}

		$template_content = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( isset( $template_content['error'] ) ) {
			return new \WP_Error( 'response_error', $template_content['error'] );
		}

		if ( empty( $template_content['data'] ) && empty( $template_content['content'] ) ) {
			return new \WP_Error( 'template_data_error', 'An invalid data was returned' );
		}

		return $template_content;
	}

	/**
	 * Send Feedback.
	 *
	 * Fires a request to Elementor server with the feedback data.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @param string $feedback_key  Feedback key.
	 * @param string $feedback_text Feedback text.
	 *
	 * @return array The response of the request.
	 */
	public static function send_feedback( $feedback_key, $feedback_text ) {
		return wp_remote_post( self::$api_feedback_url, [
			'timeout' => 30,
			'body' => [
				'api_version' => ELEMENTOR_VERSION,
				'site_lang' => get_bloginfo( 'language' ),
				'feedback_key' => $feedback_key,
				'feedback' => $feedback_text,
			],
		] );
	}

	/**
	 * Ajax reset API data.
	 *
	 * Reset Elementor library API data using an ajax call.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 */
	public static function ajax_reset_api_data() {
		check_ajax_referer( 'landingpresstemplates_reset_library', '_nonce' );

		self::_get_info_data( true );

		wp_send_json_success();
	}

	/**
	 * Init.
	 *
	 * Initialize Elementor API.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 */
	public static function init() {
		add_action( 'wp_ajax_landingpresstemplates_reset_library', [ __CLASS__, 'ajax_reset_api_data' ] );
	}

	/**
	 * @static
	 * @since 1.0.0
	 * @access public
	*/
	public static function get_template_thumbnail( $template_data ) {
		if ( isset( $template_data['thumbnail'] ) && $template_data['thumbnail'] ) {
			$thumbnail = $template_data['thumbnail'];
		}
		else {
			$thumbnail = self::$api_get_template_thumbnail_url.$template_data['id'].'.png';
		}
		return $thumbnail;
	}

}
