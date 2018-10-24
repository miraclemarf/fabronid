<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'cmb_meta_boxes', 'landingpress_cmb_meta_boxes' );
function landingpress_cmb_meta_boxes( array $meta_boxes ) {

	// _elementor_edit_mode = builder

	$fields = array(
		array( 
			'id' => '_landingpress_heading_page_layout', 
			'name' => '', 
			'desc' => esc_html__( 'Silahkan gunakan opsi berikut untuk menyembunyikan sidebar, header, footer, dan lain-lain di halaman ini saja.', 'landingpress-wp'), 
			'type' => 'title' 
		),
		array( 
			'id' => '_landingpress_hide_sidebar',  
			'name' => esc_html__( 'Hide Sidebar', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
		array( 
			'id' => '_landingpress_hide_header',  
			'name' => esc_html__( 'Hide Header', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
		array( 
			'id' => '_landingpress_hide_menu',  
			'name' => esc_html__( 'Hide Header Menu', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
		array( 
			'id' => '_landingpress_hide_footerwidgets',  
			'name' => esc_html__( 'Hide Footer Widgets', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
		array( 
			'id' => '_landingpress_hide_footer',  
			'name' => esc_html__( 'Hide Footer', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
		array( 
			'id' => '_landingpress_hide_breadcrumb',  
			'name' => esc_html__( 'Hide Breadcrumb', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
		array( 
			'id' => '_landingpress_hide_title',  
			'name' => esc_html__( 'Hide Title', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
		array( 
			'id' => '_landingpress_hide_comments',  
			'name' => esc_html__( 'Hide Comments', 'landingpress-wp' ), 
			'type' => 'radio', 
			'options' => array( 
				'' => esc_html__( 'default', 'landingpress-wp' ), 
				'yes' => esc_html__( 'yes', 'landingpress-wp' ), 
			) 
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-layout',
		'title' => esc_html__( 'Page Layout Settings', 'landingpress-wp' ),
		'pages' => array( 'post', 'page' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
		'hide_on' => array( 
			'page-template' => array( 
				'page_landingpress.php', 
				'page_landingpress_boxed.php', 
				'page_landingpress_slim.php',
				'elementor_canvas',
			) 
		),
	);

	$fields = array(
		array( 
			'id' => '_landingpress_heading_page_width', 
			'name' => '', 
			'desc' => esc_html__( 'Silahkan gunakan opsi berikut untuk merubah lebar halaman, dalam satuan pixel, di halaman ini saja.', 'landingpress-wp'), 
			'type' => 'title' 
		),
		array( 
			'id' => '_landingpress_page_width',  
			'name' => esc_html__( 'Page Width', 'landingpress-wp' ), 
			'type' => 'select', 
			'options' => array( 
				'0' => esc_html__( 'default', 'landingpress-wp' ), 
				'500' => '500px', 
				'600' => '600px', 
				'700' => '700px', 
				'800' => '800px',
				'900' => '900px',
				'960' => '960px',
				'1000' => '1000px',
				'1100' => '1100px',
				'1140' => '1140px',
				'1200' => '1200px',
			) 
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-page-width',
		'title' => esc_html__( 'Page Width', 'landingpress-wp' ),
		'pages' => array( 'post', 'page' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
		'hide_on' => array( 
			'page-template' => array( 
				'page_landingpress.php', 
				'page_landingpress_hf.php', 
				'page_landingpress_slim.php',
				'page_landingpress_slim_hf.php',
				'elementor_canvas',
			) 
		),
	);

	$fbevents = array(
		'PageView' => 'PageView '.esc_html__( '(default)', 'landingpress-wp' ),
		'ViewContent' => 'ViewContent',
		'AddToCart' => 'AddToCart',
		'InitiateCheckout' => 'InitiateCheckout',
		'AddPaymentInfo' => 'AddPaymentInfo',
		'Purchase' => 'Purchase',
		'AddToWishlist' => 'AddToWishlist',
		'Lead' => 'Lead',
		'CompleteRegistration' => 'CompleteRegistration',
		'custom' => 'Custom Event',
	);
	$fields = array(
		array( 
			'id' => '_landingpress_heading_facebook-event', 
			'name' => '', 
			'desc' => '<p>'.esc_html__( 'Silahkan gunakan opsi ini untuk memilih Facebook Pixel event yang akan dijalankan di halaman ini, khususnya untuk "conversion tracking" di website.', 'landingpress-wp').'</p><p>'.esc_html__( 'Beberapa event memiliki banyak parameter tambahan, khususnya "value" supaya kita bisa track "conversion value" di Facebook Ads Manager.', 'landingpress-wp').'</p><p>'.esc_html__( 'Catatan: parameter "content_ids" dibutuhkan untuk Product Catalog, tidak wajib di-isi jika Anda tidak menggunakan fitur product catalog di Facebook Ads.', 'landingpress-wp').'</p>',
			'type' => 'title' 
		),
		array( 
			'id' => '_landingpress_facebook-event',  
			'name' => esc_html__( 'Facebook Pixel Event', 'landingpress-wp'), 
			'desc' => '', 
			'type' => 'select', 
			'options' => $fbevents, 
		),
		array( 
			'id' => '_landingpress_facebook-custom-event', 
			'name' => esc_html__( 'Facebook Pixel Custom Event Name', 'landingpress-wp'), 
			'type' => 'text', 
			'cols' => 12, 
		),
		array( 
			'id' => '_landingpress_facebook-param-value', 
			'name' => 'value', 
			'type' => 'text', 
			'cols' => 6, 
		),
		array( 
			'id' => '_landingpress_facebook-param-currency', 
			'name' => 'currency', 
			'type' => 'select', 
			'options' => array(
				'IDR' => 'IDR',
				'USD' => 'USD',
			), 
			'cols' => 6, 
		),
		array( 
			'id' => '_landingpress_facebook-param-content_name', 
			'name' => 'content_name', 
			'type' => 'text', 
			'cols' => 4, 
		),
		array( 
			'id' => '_landingpress_facebook-param-content_ids', 
			'name' => 'content_ids', 
			'type' => 'text', 
			'cols' => 4, 
		),
		array( 
			'id' => '_landingpress_facebook-param-content_type', 
			'name' => 'content_type', 
			'type' => 'select', 
			'options' => array(
				'product' => 'product',
				'product_group' => 'product_group',
			), 
			'cols' => 4, 
		),
		array( 
			'id' => '_landingpress_heading_facebook-custom-params', 
			'name' => '', 
			'desc' => '<p>'.esc_html__( 'Silahkan gunakan opsi "Facebook Pixel Custom Parameters" untuk memasukkan custom parameter di Facebook Pixel seperti "campaign_url" misalnya.', 'landingpress-wp').'</p><p>'.esc_html__( 'Penggunaan custom parameter merupakan tingkat advanced dalam Facebook Pixel, sehingga tidak semua orang membutuhkannya.', 'landingpress-wp').'</p>',
			'type' => 'title' 
		),
		array( 
			'id' => '_landingpress_facebook-custom-params', 
			'name' => esc_html__( 'Facebook Pixel Custom Parameters', 'landingpress-wp'), 
			'desc' => '', 
			'type' => 'group', 'cols' => 12, 
			'fields' => array(
				array( 
					'id' => 'custom_param_key',  
					'name' => esc_html__( 'Parameter Key', 'landingpress-wp'), 
					'type' => 'text', 
					'cols' => 6 
				),
				array( 
					'id' => 'custom_param_value',  
					'name' => esc_html__( 'Parameter Value', 'landingpress-wp'), 
					'type' => 'text', 
					'cols' => 6 
				),
			), 
			'repeatable' => true, 
			'repeatable_max' => 10, 
			'sortable' => true, 
			'string-repeat-field' => esc_html__( 'Add Custom Parameter', 'landingpress-wp'), 
			'string-delete-field' => esc_html__( 'Delete Custom Parameter' , 'landingpress-wp'),
		),
		array( 
			'id' => '_landingpress_heading_facebook-pixels', 
			'name' => '', 
			'desc' => '<p>'.esc_html__( 'Silahkan gunakan opsi "Multiple Facebook Pixel IDs" untuk menambahkan Facebook Pixel ID yang lain (bisa lebih dari satu) di halaman ini saja.', 'landingpress-wp').'</p><p>'.esc_html__( 'Jika Anda ingin memasukkan Facebook Pixel di semua halaman, silahkan masukkan Facebook Pixel ID di halaman Appearance - Customize - LandingPress - Facebook Pixel.', 'landingpress-wp').'</p>',
			'type' => 'title' 
		),
		array( 
			'id' => '_landingpress_facebook-pixels', 
			'name' => esc_html__( 'Multiple Facebook Pixel IDs', 'landingpress-wp'), 
			'desc' => '', 
			'type' => 'group', 'cols' => 12, 
			'fields' => array(
				array( 
					'id' => 'pixel_id',  
					'name' => esc_html__( 'Facebook Pixel ID', 'landingpress-wp'), 
					'type' => 'text', 
					'cols' => 12 
				),
			), 
			'repeatable' => true, 
			'repeatable_max' => 10, 
			'sortable' => true, 
			'string-repeat-field' => esc_html__( 'Add Facebook Pixel ID', 'landingpress-wp'), 
			'string-delete-field' => esc_html__( 'Delete Facebook Pixel ID' , 'landingpress-wp'),
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-facebook-pixel',
		'title' => esc_html__( 'Facebook Pixel Settings', 'landingpress-wp'),
		'pages' => array( 'post', 'page' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
	);

	$fields = array(
		array( 
			'id' => '_landingpress_heading_adwords', 
			'name' => '', 
			'desc' => '<p>'.esc_html__( 'Jika Anda menggunakan Google Adwords yang baru (beta), silahkan gunakan opsi ini untuk memasukkan conversion tracking di halaman ini.', 'landingpress-wp').'</p><p>'.esc_html__( 'Silahkan login ke akun Google AdWords, kemudian silahkan masuk ke menu Measurement - Conversions untuk membuat Conversion Actions untuk halaman ini.', 'landingpress-wp').'</p><p>'.esc_html__( 'Namun, jika Anda menggunakan Google Adwords versi lama, silahkan gunakan opsi Custom Header Script di bawah untuk memasukkan kode conversion tracking.', 'landingpress-wp').'</p>',
			'type' => 'title' 
		),
		array( 
			'id' => '_landingpress_adwords-conversions', 
			'name' => esc_html__( 'AdWords Conversion Tracking', 'landingpress-wp'), 
			'desc' => '',
			'type' => 'group', 'cols' => 12, 
			'fields' => array(
				array( 
					'id' => 'send_to',  
					'name' => 'send_to', 
					'type' => 'text', 
					'cols' => 3 
				),
				array( 
					'id' => 'value',  
					'name' => 'value', 
					'type' => 'text', 
					'cols' => 3 
				),
				array( 
					'id' => 'currency',  
					'name' => 'currency',  
					'type' => 'text', 
					'cols' => 3 
				),
				array( 
					'id' => 'transaction_id',  
					'name' => 'transaction_id',  
					'type' => 'text', 
					'cols' => 3 
				),
			), 
			'repeatable' => true, 
			'repeatable_max' => 10, 
			'sortable' => true, 
			'string-repeat-field' => esc_html__( 'Add Conversion Tracking', 'landingpress-wp'), 
			'string-delete-field' => esc_html__( 'Delete Conversion Tracking' , 'landingpress-wp'),
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-adwords-conversion',
		'title' => esc_html__( 'Google AdWords Settings', 'landingpress-wp'),
		'pages' => array( 'post', 'page' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
	);

	// _yoast_wpseo_opengraph-title
	// _yoast_wpseo_opengraph-description
	// _yoast_wpseo_opengraph-image
	$fields = array(
		array( 
			'id' => '_landingpress_heading_facebook_og', 
			'name' => '', 
			'desc' => '<p>'.esc_html__( 'Silahkan gunakan opsi berikut untuk mengatur tampilan halaman ini ketika di-share di Facebook.', 'landingpress-wp').'</p><p>'.esc_html__( 'Harap kosongkan opsi ini jika Anda menggunakan plugin lain dengan fitur ini.', 'landingpress-wp').'</p><p>'.sprintf( esc_html__( 'Gunakan %s jika tampilan hasil sharing di Facebook belum update setelah mengisi opsi ini.', 'landingpress-wp'), '<a href="https://developers.facebook.com/tools/debug/sharing/" target="_blank">Facebook Sharing Debug</a>' ).'</p>', 
			'type' => 'title' 
		),
		array( 
			'id' => '_landingpress_facebook-image', 
			'name' => esc_html__( 'Facebook Image', 'landingpress-wp'), 
			'type' => 'image' 
		),
		array( 
			'id' => '_landingpress_facebook-title', 
			'name' => esc_html__( 'Facebook Title', 'landingpress-wp'), 
			'type' => 'text' 
		),
		array( 
			'id' => '_landingpress_facebook-description', 
			'name' => esc_html__( 'Facebook Description', 'landingpress-wp'), 
			'type' => 'textarea' 
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-facebook-sharing',
		'title' => esc_html__( 'Facebook Sharing (Open Graph) Settings', 'landingpress-wp'),
		'pages' => array( 'post', 'page', 'product' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
	);

	if ( defined('WPSEO_VERSION') ) {
		$fields = array(
			array( 
				'id' => '_landingpress_heading_seo_onpage', 
				'name' => '', 
				'desc' => sprintf( esc_html__( 'Anda sedang menggunakan plugin %s, sehingga opsi On-Page SEO di LandingPress dimatikan secara otomatis untuk menghindari double output.', 'landingpress-wp'), '<strong>Yoast WordPress SEO</strong>' ), 
				'type' => 'title' 
			),
		);
	}
	elseif ( defined('All_in_One_SEO_Pack') || class_exists('All_in_One_SEO_Pack_p') ) {
		$fields = array(
			array( 
				'id' => '_landingpress_heading_seo_onpage', 
				'name' => '', 
				'desc' => sprintf( esc_html__( 'Anda sedang menggunakan plugin %s, sehingga opsi On-Page SEO di LandingPress dimatikan secara otomatis untuk menghindari double output.', 'landingpress-wp'), '<strong>All-In-One SEO</strong>' ), 
				'type' => 'title' 
			),
		);
	}
	elseif ( defined('HeadSpace_Plugin') ) {
		$fields = array(
			array( 
				'id' => '_landingpress_heading_seo_onpage', 
				'name' => '', 
				'desc' => sprintf( esc_html__( 'Anda sedang menggunakan plugin %s, sehingga opsi On-Page SEO di LandingPress dimatikan secara otomatis untuk menghindari double output.', 'landingpress-wp'), '<strong>Head Space</strong>' ), 
				'type' => 'title' 
			),
		);
	}
	elseif ( defined('Platinum_SEO_Pack') ) {
		$fields = array(
			array( 
				'id' => '_landingpress_heading_seo_onpage', 
				'name' => '', 
				'desc' => sprintf( esc_html__( 'Anda sedang menggunakan plugin %s, sehingga opsi On-Page SEO di LandingPress dimatikan secara otomatis untuk menghindari double output.', 'landingpress-wp'), '<strong>Platinum SEO Pack</strong>' ), 
				'type' => 'title' 
			),
		);
	}
	elseif ( defined('SEO_Ultimate') ) {
		$fields = array(
			array( 
				'id' => '_landingpress_heading_seo_onpage', 
				'name' => '', 
				'desc' => sprintf( esc_html__( 'Anda sedang menggunakan plugin %s, sehingga opsi On-Page SEO di LandingPress dimatikan secara otomatis untuk menghindari double output.', 'landingpress-wp'), '<strong>SEO Ultimate</strong>' ), 
				'type' => 'title' 
			),
		);
	}
	else {
		// _yoast_wpseo_meta-robots-noindex
		// _yoast_wpseo_meta-robots-nofollow
		// _yoast_wpseo_title
		// _yoast_wpseo_metadesc
		$fields = array(
			array( 
				'id' => '_landingpress_heading_seo_onpage', 
				'name' => '', 
				'desc' => esc_html__( 'Silahkan gunakan opsi berikut untuk mengatur tampilan halaman ini di hasil pencarian search engine, misalnya Google. Perlu diingat, update tampilan hasil pencarian bisa cepat, bisa lambat, tergantung seberapa sering spider Google mengunjungi halaman ini.', 'landingpress-wp'), 
				'type' => 'title' 
			),
			array( 
				'id' => '_landingpress_meta-title', 
				'name' => esc_html__( 'Meta Title', 'landingpress-wp'), 
				'type' => 'text' 
			),
			array( 
				'id' => '_landingpress_meta-description', 
				'name' => esc_html__( 'Meta Description', 'landingpress-wp'), 
				'type' => 'textarea' 
			),
			array( 
				'id' => '_landingpress_meta-keywords', 
				'name' => esc_html__( 'Meta Keywords', 'landingpress-wp'), 
				'type' => 'text' 
			),
			array( 
				'id' => '_landingpress_meta-index', 
				'name' => esc_html__( 'Meta Robots Index', 'landingpress-wp'), 
				'type' => 'select', 
				'options' => array( 
					'index' => 'index', 
					'noindex' => 'noindex' 
				), 
				'allow_none' => false, 
				'cols' => 6 
			),
			array( 
				'id' => '_landingpress_meta-follow', 
				'name' => esc_html__( 'Meta Robots Follow', 'landingpress-wp'), 
				'type' => 'select', 
				'options' => array( 
					'follow' => 'follow', 
					'nofollow' => 'nofollow' 
				), 
				'allow_none' => false, 
				'cols' => 6 
			),
		);
	}
	$meta_boxes[] = array(
		'id' => 'landingpress-seo',
		'title' => esc_html__( 'On-Page SEO Settings', 'landingpress-wp'),
		'pages' => array( 'post', 'page', 'product' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
	);

	$fields = array(
		array( 
			'id' => '_landingpress_header_script', 
			'name' => esc_html__( 'Custom Header Script', 'landingpress-wp'), 
			'desc' => esc_html__( 'Silahkan gunakan opsi ini untuk memasukkan kode html/javascript yang akan dijalankan di halaman ini saja di bagian <head>.', 'landingpress-wp'), 
			'type' => 'textarea_code' 
		),
		array( 
			'id' => '_landingpress_footer_script', 
			'name' => esc_html__( 'Custom Footer Script', 'landingpress-wp'), 
			'desc' => esc_html__( 'Silahkan gunakan opsi ini untuk memasukkan kode html/javascript yang akan dijalankan di halaman ini saja di bagian bawah sebelum </body>.', 'landingpress-wp'), 
			'type' => 'textarea_code' 
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-scripts',
		'title' => esc_html__( 'Header and Footer Scripts', 'landingpress-wp'),
		'pages' => array( 'post', 'page' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
	);

	$fields = array(
		array( 
			'id' => '_landingpress_redirect', 
			'name' => esc_html__( 'Redirect URL', 'landingpress-wp'), 
			'type' => 'text' 
		),
		array( 
			'id' => '_landingpress_redirect_type', 
			'name' => esc_html__( 'Redirect Type', 'landingpress-wp'), 
			'type' => 'select', 
			'options' => array( 
				'301' => '301 - Moved Permanently',
				'302' => '302 - Moved Temporarily',
				'meta' => 'Meta Tag Redirect (Support FB Pixel, Analytics, AdWords, GTM)',
				'javascript' => 'JavaScript Redirect (Support FB Pixel, Analytics, AdWords, GTM)',
				'iframe' => 'Iframe (Support FB Pixel, Analytics, AdWords, GTM)',
			), 
			'allow_none' => false, 
		),
		array( 
			'id' => '_landingpress_redirect_delay', 
			'name' => esc_html__( 'Delay Time', 'landingpress-wp'), 
			'desc' => esc_html__( 'Jika Anda pakai Facebook Pixel di halaman ini, harap gunakan delay minimal 2 detik untuk memakstikan pixel sudah terekam dengan baik.', 'landingpress-wp'), 
			'type' => 'select', 
			'options' => array( 
				'0' => 'no delay',
				'1' => '1 second',
				'2' => '2 seconds',
				'3' => '3 seconds',
				'4' => '4 seconds',
				'5' => '5 seconds',
			), 
			'allow_none' => true, 
		),
		array( 
			'id' => '_landingpress_redirect_message', 
			'name' => esc_html__( 'Loading Message', 'landingpress-wp'), 
			'type' => 'text' 
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-redirect',
		'title' => esc_html__( 'Redirect & Short Link Settings', 'landingpress-wp'),
		'pages' => array( 'post', 'page', 'product' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
	);

	$fields = array(
		array( 
			'id' => '_landingpress_page_header_custom', 
			'name' => esc_html__( 'Custom Header From Elementor Library', 'landingpress-wp'), 
			'desc' => '', 
			'type' => 'select', 
			'options' => array( 
				'default' => 'default',
				'disable' => 'disable',
				'custom' => 'custom',
			), 
			'allow_none' => false, 
		),
		array( 
			'id' => '_landingpress_page_header_elementor', 
			'name' => esc_html__( 'Choose Header...', 'landingpress-wp'), 
			'desc' => '', 
			'type' => 'post_select', 
			'use_ajax' => false,
			'allow_none' => true,
			'query' => array( 
				'post_type' => 'elementor_library',
				'posts_per_page' => '-1',
				'orderby' => 'title',
				'order' => 'ASC',
			),
		),
		array( 
			'id' => '_landingpress_page_footer_custom', 
			'name' => esc_html__( 'Custom Footer From Elementor Library', 'landingpress-wp'), 
			'desc' => '', 
			'type' => 'select', 
			'options' => array( 
				'default' => 'default',
				'disable' => 'disable',
				'custom' => 'custom',
			), 
			'allow_none' => false, 
		),
		array( 
			'id' => '_landingpress_page_footer_elementor', 
			'name' => esc_html__( 'Choose Footer...', 'landingpress-wp'), 
			'desc' => '', 
			'type' => 'post_select', 
			'use_ajax' => false,
			'allow_none' => true,
			'query' => array( 
				'post_type' => 'elementor_library',
				'posts_per_page' => '-1',
				'orderby' => 'title',
				'order' => 'ASC',
			),
		),
	);
	$meta_boxes[] = array(
		'id' => 'landingpress-header-footer',
		'title' => esc_html__( 'Custom Header / Footer From Elementor', 'landingpress-wp'),
		'pages' => array( 'post', 'page' ),
		'fields' => $fields,
		'context' => 'normal',
		'priority' => 'default',
	);

	return $meta_boxes;

}

add_action( 'admin_head-post.php', 'landingpress_cmb_meta_boxes_scripts' );
add_action( 'admin_head-post-new.php', 'landingpress_cmb_meta_boxes_scripts' );
function landingpress_cmb_meta_boxes_scripts() {
    ?>
    <style type="text/css">
    .CMB_Title {
		margin-top: 0 !important;
		padding-top: 0 !important;
		padding-bottom: 0 !important;
    }
	.cmb_metabox .CMB_Group_Field>.field-title {
		font-size: 13px;
		font-weight: bold;
		margin-top: 0;
	}
    </style>
	<script type="text/javascript">
	/*<![CDATA[*/
	jQuery(document).ready(function($){
		if ( $('#_landingpress_facebook-event').length ) {
			var lp_fb_event = $('#_landingpress_facebook-event select').val();
			// console.log( 'lp_fb_event = ' + lp_fb_event );
			if ( lp_fb_event == 'custom' ) {
				$('#_landingpress_facebook-custom-event').show();
			}
			else {
				$('#_landingpress_facebook-custom-event').hide();
			}
			if ( lp_fb_event != '' && lp_fb_event != 'PageView' && lp_fb_event != 'custom' ) {
				$('#_landingpress_facebook-param-value').show();
				$('#_landingpress_facebook-param-currency').show();
				$('#_landingpress_facebook-param-content_name').show();
			}
			else {
				$('#_landingpress_facebook-param-value').hide();
				$('#_landingpress_facebook-param-currency').hide();
				$('#_landingpress_facebook-param-content_name').hide();
			}
			if ( lp_fb_event != '' && lp_fb_event != 'PageView' && lp_fb_event != 'custom' && lp_fb_event != 'Lead' && lp_fb_event != 'CompleteRegistration' ) {
				$('#_landingpress_facebook-param-content_ids').show();
				$('#_landingpress_facebook-param-content_type').show();
			}
			else {
				$('#_landingpress_facebook-param-content_ids').hide();
				$('#_landingpress_facebook-param-content_type').hide();
			}
			if ( lp_fb_event != '' && lp_fb_event != 'PageView' ) {
				$('#_landingpress_facebook-custom-params').show();
				$('#_landingpress_heading_facebook-custom-params').show();
			}
			else {
				$('#_landingpress_facebook-custom-params').hide();
				$('#_landingpress_heading_facebook-custom-params').hide();
			}
			$(document).on('change', '#_landingpress_facebook-event select', function() {
				lp_fb_event = $(this).find('option:selected').val();
				// console.log( 'lp_fb_event = ' + lp_fb_event );
				if ( lp_fb_event == 'custom' ) {
					$('#_landingpress_facebook-custom-event').show();
				}
				else {
					$('#_landingpress_facebook-custom-event').hide();
				}
				if ( lp_fb_event != '' && lp_fb_event != 'PageView' && lp_fb_event != 'custom' ) {
					$('#_landingpress_facebook-param-value').show();
					$('#_landingpress_facebook-param-currency').show();
					$('#_landingpress_facebook-param-content_name').show();
				}
				else {
					$('#_landingpress_facebook-param-value').hide();
					$('#_landingpress_facebook-param-currency').hide();
					$('#_landingpress_facebook-param-content_name').hide();
				}
				if ( lp_fb_event != '' && lp_fb_event != 'PageView' && lp_fb_event != 'custom' && lp_fb_event != 'Lead' && lp_fb_event != 'CompleteRegistration' ) {
					$('#_landingpress_facebook-param-content_ids').show();
					$('#_landingpress_facebook-param-content_type').show();
				}
				else {
					$('#_landingpress_facebook-param-content_ids').hide();
					$('#_landingpress_facebook-param-content_type').hide();
				}
				if ( lp_fb_event != '' && lp_fb_event != 'PageView' ) {
					$('#_landingpress_facebook-custom-params').show();
					$('#_landingpress_heading_facebook-custom-params').show();
				}
				else {
					$('#_landingpress_facebook-custom-params').hide();
					$('#_landingpress_heading_facebook-custom-params').hide();
				}
			});
			var lp_header_custom = $('#_landingpress_page_header_custom select').val();
			if ( lp_header_custom == 'custom' ) {
				$('#_landingpress_page_header_elementor').show();
			}
			else {
				$('#_landingpress_page_header_elementor').hide();
			}
			$(document).on('change', '#_landingpress_page_header_custom select', function() {
				lp_header_custom = $(this).find('option:selected').val();
				if ( lp_header_custom == 'custom' ) {
					$('#_landingpress_page_header_elementor').show();
				}
				else {
					$('#_landingpress_page_header_elementor').hide();
				}
			});
			var lp_footer_custom = $('#_landingpress_page_footer_custom select').val();
			if ( lp_footer_custom == 'custom' ) {
				$('#_landingpress_page_footer_elementor').show();
			}
			else {
				$('#_landingpress_page_footer_elementor').hide();
			}
			$(document).on('change', '#_landingpress_page_footer_custom select', function() {
				lp_footer_custom = $(this).find('option:selected').val();
				if ( lp_footer_custom == 'custom' ) {
					$('#_landingpress_page_footer_elementor').show();
				}
				else {
					$('#_landingpress_page_footer_elementor').hide();
				}
			});
			var lp_redirect_type = $('#_landingpress_redirect_type select').val();
			if ( lp_redirect_type == 'meta' || lp_redirect_type == 'javascript' ) {
				$('#_landingpress_redirect_delay').show();
				$('#_landingpress_redirect_message').show();
			}
			else {
				$('#_landingpress_redirect_delay').hide();
				$('#_landingpress_redirect_message').hide();
			}
			$(document).on('change', '#_landingpress_redirect_type select', function() {
				lp_redirect_type = $(this).find('option:selected').val();
				if ( lp_redirect_type == 'meta' || lp_redirect_type == 'javascript' ) {
					$('#_landingpress_redirect_delay').show();
					$('#_landingpress_redirect_message').show();
				}
				else {
					$('#_landingpress_redirect_delay').hide();
					$('#_landingpress_redirect_message').hide();
				}
			});
		}
	});
	/*]]>*/
	</script>
	<?php 
}
