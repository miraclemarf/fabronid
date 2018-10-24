<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if ( ! class_exists( 'Redux' ) ) {
    return;
}

// This is your option name where all the Redux data is stored.
$opt_name = "cl_options";

// This line is only for altering the demo. Can be easily removed.
// $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

/*
 *
 * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
 *
 */

$sampleHTML = '';
if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
    Redux_Functions::initWpFilesystem();

    global $wp_filesystem;

    $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
}

// Background Patterns Reader
$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
$sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
$sample_patterns      = array();

if ( is_dir( $sample_patterns_path ) ) {

    if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
        $sample_patterns = array();

        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

            if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                $name              = explode( '.', $sample_patterns_file );
                $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                $sample_patterns[] = array(
                    'alt' => $name,
                    'img' => $sample_patterns_url . $sample_patterns_file
                );
            }
        }
    }
}

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'         => $theme->get( 'Name' ),
    // Name that appears at the top of your panel
    'display_version'      => $theme->get( 'Version' ),
    // Version that appears at the top of your panel
    'menu_type'            => 'menu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => true,
    // Show the sections below the admin menu item or not
    'menu_title'           => __( 'Theme Options', 'cepatlakoo' ),
    'page_title'           => __( 'Theme Options', 'cepatlakoo' ),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'       => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => true,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => true,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 50,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => false,
    // Show the time the page took to load, etc
    'show_options_object'  => false,
    'update_notice'        => false,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => true,
    // Enable basic customizer support
    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

    // OPTIONAL -> Give you extra features
    'page_priority'        => 61,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => 'themes.php',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'     => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'            => get_template_directory_uri() .'/images/icon-cepatlakoo.png',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => 'cepatlakoo',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

    // HINTS
    'hints'                => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'red',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ),
            'hide' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ),
        ),
    )
);

// ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
$args['admin_bar_links'][] = array(
    'id'    => 'cl-member',
    'href'  => 'https://cepatlakoo.com/dashboard/',
    'title' => __( 'Member Area', 'cepatlakoo' ),
);

$args['admin_bar_links'][] = array(
    'id'    => 'cl-kb',
    'href'  => 'https://cepatlakoo.com/knowledgebase/',
    'title' => __( 'Knowledge Base', 'cepatlakoo' ),
);

// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
$args['share_icons'][] = array(
    'url'   => 'https://cepatlakoo.com',
    'title' => 'Visit our website',
    'icon'  => 'el el-link'
    //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
);

// Panel Intro text -> before the form
if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
    if ( ! empty( $args['global_variable'] ) ) {
        $v = $args['global_variable'];
    } else {
        $v = str_replace( '-', '_', $args['opt_name'] );
    }
    $args['intro_text'] = wp_kses( __( '<b>Need help?</b> Login to the member area and join our Facebook support group and watch the video tutorials. <a href="https://cepatlakoo.com/dashboard/" target="_blank">Click here</a>', 'cepatlakoo' ), array(
                    'a' => array( 'href' => array(), 'target' => array() ),
                    'b' => array() )
                );
} else {
    $args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'cepatlakoo' );
}

// Add content after the form.
// $args['footer_text'] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'cepatlakoo' );

Redux::setArgs( $opt_name, $args );

/*
 * ---> END ARGUMENTS
 */


/*
 * ---> START HELP TABS
 */

$tabs = array(
    array(
        'id'      => 'redux-help-tab-1',
        'title'   => __( 'Theme Information 1', 'cepatlakoo' ),
        'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'cepatlakoo' )
    ),
    array(
        'id'      => 'redux-help-tab-2',
        'title'   => __( 'Theme Information 2', 'cepatlakoo' ),
        'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'cepatlakoo' )
    )
);
Redux::setHelpTab( $opt_name, $tabs );

// Set the help sidebar
$content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'cepatlakoo' );
Redux::setHelpSidebar( $opt_name, $content );


/*
 * <--- END HELP TABS
 */


/*
 *
 * ---> START SECTIONS
 *
 */

/*
    As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for
 */

// Set Facebook Pixel Events
$fb_pixel_events = array(
    'PageView' => esc_html( 'PageView' ),
    'ViewContent' => esc_html( 'ViewContent' ),
    'AddToWishlist' => esc_html( 'AddToWishlist' ),
    'AddToCart' => esc_html( 'AddToCart' ),
    'InitiateCheckout' => esc_html( 'InitiateCheckout' ),
    'AddCustomerInfo' => esc_html( 'AddCustomerInfo' ),
    'Purchase' => esc_html( 'Purchase' ),
    'AddPaymentInfo' => esc_html( 'AddPaymentInfo' ),
    'Lead' => esc_html( 'Lead' ),
    'CompleteRegistration' => esc_html( 'CompleteRegistration' ),
);

// GENERAL SETTINGS
Redux::setSection( $opt_name, array(
    'title'            => __( 'General Settings', 'cepatlakoo' ),
    'id'               => 'general_settings',
    'customizer_width' => '450px',
    'desc'             => __( 'General settings for the theme.', 'cepatlakoo' ),
    'icon'             => 'el el-cog',
    'fields'           => array(
        array(
            'id'                        => 'cepatlakoo_post_exceprt_length',
            'type'                      => 'slider',
            'title'                     => esc_html__('Post Excerpt Length', 'cepatlakoo'),
            'desc'                      => esc_html__( 'Excerpt lenght on blog and archives page.', 'cepatlakoo' ),
            'default'                   => 65,
            'min'                       => 5,
            'step'                      => 1,
            'max'                       => 100,
            'display_value'             => 'text'
        ),
        array(
            'id'                        => 'cepatlakoo_share_button',
            'type'                      => 'switch',
            'title'                     => esc_html__('Share Buttons', 'cepatlakoo'),
            'desc'                      => esc_html__( 'Enable or disable share buttons on detail page.', 'cepatlakoo' ),
            'default'                   => true,
        ),

        array(
            'id'                        => 'cepatlakoo_post_nav',
            'type'                      => 'switch',
            'title'                     => esc_html__('Post Navigation', 'cepatlakoo'),
            'desc'                      => esc_html__( 'Enable or disable post navigation on detail page.', 'cepatlakoo' ),
            'default'                   => true,
        ),
        array(
            'id'                        => 'cepatlakoo_header_style_opt',
            'type'                      => 'select',
            'title'                     => esc_html__('Header Layout Style', 'cepatlakoo'),
            'desc'                      => esc_html__('Override header layout style for all pages.', 'cepatlakoo'),
            'options'                   => array(
                                             '1' => esc_html__( 'Logo Left', 'cepatlakoo' ),
                                             '2' => esc_html__( 'Logo Middle', 'cepatlakoo' ),
                                          ),
            'default'  => '1',
        ),
        array(
            'id'                        => 'cepatlakoo_google_analytics_tracking',
            'type'                      => 'text',
            'title'                     => esc_html__('Google Analytics Tracking ID', 'cepatlakoo'),
            'desc'                      => esc_html__('Set Google Analytics Tracking ID.', 'cepatlakoo'),
            'default'                   => ''
        ),

        array(
            'id'                      => 'cepatlakoo_open_graph_trigger',
            'type'                    => 'switch',
            'title'                   => esc_html__('Open Graph', 'cepatlakoo'),
            'desc'                    => esc_html__('Enable Open Graph for Post, Page and Product post type.', 'cepatlakoo'),
            'default'                 => true,
        ),

        array(
            'id'                      => 'cepatlakoo_seo_trigger',
            'type'                    => 'switch',
            'title'                   => esc_html__('SEO Feature', 'cepatlakoo'),
            'desc'                    => esc_html__('Enable SEO feature in Post, Page and Product post type.', 'cepatlakoo'),
            'default'                 => true,
        ),
    ),
) );

Redux::setSection( $opt_name, array(
    'title'            => __( 'Top Bar', 'cepatlakoo' ),
    'id'               => 'cepatlakoo_general_info_topbar',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => array(
        array(
            'id'                        => 'cepatlakoo_top_bar',
            'type'                      => 'switch',
            'title'                     => esc_html__('Top Bar', 'cepatlakoo'),
            'desc'                      => esc_html__( 'Enable or disable top bar.', 'cepatlakoo' ),
            'default'                   => true,
        ),

        array(
            'id'                        => 'cepatlakoo_fb_profile_url',
            'type'                      => 'text',
            'title'                     => esc_html__('Facebook Profile Url', 'cepatlakoo'),
            'placeholder'               => 'https://www.facebook.com/cepatlakoo',
            'default'                   => '#'
        ),

        array(
            'id'                        => 'cepatlakoo_tw_profile_url',
            'type'                      => 'text',
            'title'                     => esc_html__('Twitter Profile Url', 'cepatlakoo'),
            'placeholder'               => 'https://twitter.com/cepatlakoo',
            'default'                   => '#'
        ),

        array(
            'id'                        => 'cepatlakoo_itg_profile_url',
            'type'                      => 'text',
            'title'                     => esc_html__('Instagram Profile Url', 'cepatlakoo'),
            'placeholder'               => 'https://instagram.com/cepatlakoo',
            'default'                   => '#'
        ),

        array(
            'id'                        => 'cepatlakoo_customer_phone_label',
            'type'                      => 'text',
            'title'                     => esc_html__('Phone Label', 'cepatlakoo'),
            'desc'                      => esc_html__( 'Text label on the left hand side of the phone number on top header.', 'cepatlakoo' ),
            'placeholder'               => 'Call Center :  ',
            'default'                   => 'CS:'
        ),

        array(
            'id'                        => 'cepatlakoo_customer_care_phone',
            'type'                      => 'text',
            'title'                     => esc_html__('Phone Number', 'cepatlakoo'),
            'desc'                      => esc_html__( 'Phone number on top header.', 'cepatlakoo' ),
            'placeholder'               => '021-67219821',
            'default'                   => '021-67219821'
        ),

        array(
            'id'                        => 'cepatlakoo_top_bar_msg',
            'type'                      => 'textarea',
            'title'                     => esc_html__('Top Bar Message', 'cepatlakoo'),
            'desc'                      => esc_html__( 'Message to be displayed on the top bar. Allowed HTML tags: <a>, <br />, <p>, <b>, <i>, <em>,<strong>', 'cepatlakoo' ),
            'default'                   => 'Diskon besar di banyak kategori produk.'
        ),
    ),
) );

Redux::setSection( $opt_name, array(
    'title'            => __( 'Footer', 'cepatlakoo' ),
    'id'               => 'cepatlakoo_general_info_footer',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => array(
        array(
            'id'                        => 'cepatlakoo_copyright_text',
            'type'                      => 'textarea',
            'title'                     => esc_html__('Copyright Text', 'cepatlakoo'),
            'desc'                      => esc_html__('Copyright text in footer. Allowed HTML tags: <a>, <br />, <p>, <strong>', 'cepatlakoo'),
            'default'                   => 'Copyright 2018. All Rights Reserved <br /> Designed by <a href="http://cepatlakoo.com" target="_blank">Cepatlakoo</a>'
        ),
    ),
) );

Redux::setSection( $opt_name, array(
    'title'            => __( 'Quick View', 'cepatlakoo' ),
    'id'               => 'cepatlakoo_general_info_quickview',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => array(
        array(
            'id'                        => 'cepatlakoo_quickview_product_description',
            'type'                      => 'switch',
            'title'                     => esc_html__('Quick View Product Description', 'cepatlakoo'),
            'desc'                      => esc_html__( 'Enable or disable product description in quick view.', 'cepatlakoo' ),
            'default'                   => true,
        ),

        array(
            'id'                        => 'cepatlakoo_quickview_product_catergoryandtag',
            'type'                      => 'switch',
            'title'                     => esc_html__('Quick View Product Category & Tag', 'cepatlakoo'),
            'desc'                      => esc_html__( 'Enable or disable product category and tag in quick view.', 'cepatlakoo' ),
            'default'                   => true,
        ),
    ),
) );

Redux::setSection( $opt_name, array(
    'title'            => __( 'Countdown', 'cepatlakoo' ),
    'desc'            => __( 'Countdown settings for WooCommerce Product Detail Page.', 'cepatlakoo' ),
    'id'               => 'cepatlakoo_general_info_countdown',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => array(
        array(
            'id'                        => 'cepatlakoo_countdown_heading_cart',
            'type'                      => 'text',
            'title'                     => esc_html__('Countdown Timer Heading', 'cepatlakoo'),
            'desc'                      => esc_html__('Countdown heading in product detail page.', 'cepatlakoo'),
            'default'                   => esc_html__('Kesempatan Terbatas', 'cepatlakoo'),
        ),
        array(
            'id'                        => 'cepatlakoo_countdown_subheading_cart',
            'type'                      => 'text',
            'title'                     => esc_html__('Countdown Timer Sub Heading', 'cepatlakoo'),
            'desc'                      => esc_html__('Countdown sub heading in product detail page.', 'cepatlakoo'),
            'default'                   => 'Hanya dijual terbatas, cepat amankan produk ini agar kamu tidak kehabisan.'
        ),
        array(
           'id'                         => 'cepatlakoo_countdown_order_received_section',
           'type'                       => 'section',
           'title'                      => esc_html__('Countdown on Order Received Page', 'cepatlakoo'),
           'subtitle'                   => esc_html__('Order received page is the page after someone completing checkout.', 'cepatlakoo'),
           'indent' => false 
        ),
        array(
            'id'                        => 'cepatlakoo_countdown_timer_order_received',
            'type'                      => 'switch', 
            'title'                     => esc_html__('Countdown Timer on Order Received Page', 'cepatlakoo'),
            'default'                   => true,
        ),
        array(
            'id'                        => 'cepatlakoo_countdown_order_received',
            'type'                      => 'select',
            'title'                     => esc_html__( 'Select Countdown Timer', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'Select the countdown timer you want to use for order-received page. Leave it empty if you don\'t want to display it.', 'cepatlakoo' ),
            'required'                  => array('cepatlakoo_countdown_timer_order_received', 'equals', '1'),
            'data'                      => 'post',
            'args'                      => array(
                                            'post_type'     => 'cl_countdown_timer'
                                        ),
        ),
        array(
            'id'                        => 'cepatlakoo_countdown_order_received_text',
            'type'                      => 'textarea',
            'title'                     => esc_html__('Text Near the Countdown', 'cepatlakoo'),
            'desc'                      => esc_html__('Write a text that will be displayed near the countdown timer. Support HTML tags.', 'cepatlakoo'),
            'required'                  => array('cepatlakoo_countdown_timer_order_received', 'equals', '1'),
            'default'                   => esc_html__('Segera Lakukan Pembayaran', 'cepatlakoo'),
            'validate'                  => 'html',
        ),
    ),
) );

Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Optimization', 'cepatlakoo' ),
    'desc'             => esc_html__( 'This feature is still experimental. Please use these settings wisely, it could break your site.', 'cepatlakoo' ),
    'id'               => 'cepatlakoo_general_info_optimize',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => array(
        array(
            'id'                        => 'cepatlakoo_minify_html',
            'type'                      => 'switch',
            'title'                     => esc_html__('Minify HTML & JS', 'cepatlakoo'),
            'desc'                      => esc_html__( 'Minify HTML to help speed up your website.', 'cepatlakoo' ),
            'default'                   => false,
        ),
        array(
            'id'                        => 'cepatlakoo_remove_querystring',
            'type'                      => 'switch',
            'title'                     => esc_html__('Remove JS & CSS Version', 'cepatlakoo'),
            'desc'                      => esc_html__( 'Remove JS & CSS version.', 'cepatlakoo' ),
            'default'                   => false,
        ),
    ),
) );





// SHOPPING CART
Redux::setSection( $opt_name, array(
    'title'            => __( 'Shop Settings', 'cepatlakoo' ),
    'id'               => 'shoppping_cart',
    'customizer_width' => '450px',
    'desc'             => __( 'Configure settings related to shopping functionality.', 'cepatlakoo' ),
    'icon'             => 'el el-shopping-cart',
    'fields'           => array(
        array(
            'id'                      => 'cepatlakoo_shoping_cart',
            'type'                    => 'switch',
            'title'                   => esc_html__('Disable Shoping Cart', 'cepatlakoo'),
            'desc'                    => esc_html__('Disable shopping cart feature.', 'cepatlakoo'),
            'default'                 => '0',
        ),
        array(
            'id'                        => 'cepatlakoo_single_sidebar_opt',
            'type'                      => 'select',
            'title'                     => esc_html__('Single Product Sidebar', 'cepatlakoo'),
            'desc'                      => esc_html__('Override Product Detail Sidebar for all Products.', 'cepatlakoo'),
            'options'                   => array(
                                            '0' => esc_html__( 'Default', 'cepatlakoo' ),
                                            '1' => esc_html__( 'With Sidebar', 'cepatlakoo' ),
                                            '2' => esc_html__( 'Without Sidebar', 'cepatlakoo' ),
                                          ),
            'default'  => '2',
        ),
        array(
            'id'                      => 'cepatlakoo_product_badges',
            'type'                    => 'sortable',
            'title'                   => __('Display Product Badges', 'cepatlakoo'),
            'desc'                    => __('Display additional small badges to product detail page, above product title.', 'cepatlakoo'),
            'mode'                    => 'text',
            'options'                 => array(
                                         '1' => '',
                                         '2' => '',
                                        ),
        ),
        array(
            'id'                      => 'cepatlakoo_wc_product_tabs',
            'type'                    => 'switch',
            'title'                   => esc_html__('Display WooCommerce Product Tabs', 'cepatlakoo'),
            'desc'                    => esc_html__('Display or hide WooComerce product tabs on product page.', 'cepatlakoo'),
            'default'                 => '1',
        ),
        array(
            'id'                      => 'cepatlakoo_coupon_code',
            'type'                    => 'switch',
            'title'                   => esc_html__('Display Coupon Code', 'cepatlakoo'),
            'desc'                    => esc_html__('Turn on or off coupon code in cart & checkout page.', 'cepatlakoo'),
            'default'                 => '1',
        ),
        array(
            'id'                      => 'cepatlakoo_checkout_product_image',
            'type'                    => 'switch',
            'title'                   => esc_html__('Product Image on Checkout Page', 'cepatlakoo'),
            'desc'                    => esc_html__('Display or hide product image on checkout page.', 'cepatlakoo'),
            'default'                 => '1',
        ),
        array(
            'id'                        => 'cepatlakoo_checkout_shipping_style',
            'type'                      => 'select',
            'title'                     => esc_html__('Checkout Shipping Style', 'cepatlakoo'),
            'desc'                      => esc_html__('Select shipping method display style on checkout page.', 'cepatlakoo'),
            'options'                   => array(
                                            'radiobutton' => esc_html__( 'Default (Radio Button)', 'cepatlakoo' ),
                                            'select' => esc_html__( 'Dropdown Selectbox', 'cepatlakoo' )
                                        ),
            'default'                 => 'radiobutton',
        ),
        array(
            'id'                        => 'cepatlakoo_select_confirmation',
            'type'                      => 'select',
            'title'                     =>  esc_html__( 'Select Payment Confirmation Page', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'Select payment confirmation page.', 'cepatlakoo' ),
            'data'                      => 'pages',
            'default'                   => '',
        ),
    ),
) );

$follows = array(
    array(
        'id'                        => 'cepatlakoo_followup_wa_message',
        'type'                      => 'textarea',
        'title'                     => esc_html__( 'WhatsApp Message', 'cepatlakoo' ),
        'desc'                      => esc_html__( 'Enter your WhatsApp message. You can use %lakoo_name%, %lakoo_order_id%, %lakoo_products%, %lakoo_shipping_cost%, %lakoo_order_total% to display order detail.', 'cepatlakoo' ),
        'default'   => esc_html( 'Halo %lakoo_name%,
ID Pesanan Anda: #%lakoo_order_id%

Detail Pesanan:
%lakoo_products%

Ongkir: %lakoo_shipping_cost%
*Total:* %lakoo_order_total%

Pesanan Anda sudah kami terima, jika ada kendala dalam pemesanan bisa menghubungi kami via WA.' ),
    ),
    array(
        'id'                        => 'cepatlakoo_followup_sms_message',
        'type'                      => 'textarea',
        'title'                     => esc_html__( 'SMS Message', 'cepatlakoo' ),
        'desc'                      => esc_html__( 'Enter your SMS message. You can use %lakoo_name%, %lakoo_order_id%, %lakoo_products%, %lakoo_shipping_cost%, %lakoo_order_total% to display order detail.', 'cepatlakoo' ),
        'default'   => esc_html( 'Halo %lakoo_name%,
ID Pesanan Anda: #%lakoo_order_id%

Detail Pesanan:
%lakoo_products%

Ongkir: %lakoo_shipping_cost%
Total: %lakoo_order_total%

Pesanan Anda sudah kami terima, jika ada kendala dalam pemesanan bisa menghubungi kami via SMS.' ),
    )
);

if ( is_plugin_active( 'cepatlakoo-input-resi/cepatlakoo-input-resi.php' ) ) {
    array_push( $follows, 
array(
    'id'                        => 'cepatlakoo_followup_wa_message_success',
    'type'                      => 'textarea',
    'title'                     => esc_html__( 'WhatsApp Message Complete', 'cepatlakoo' ),
    'desc'                      => esc_html__( 'Enter your WhatsApp message. You can use %lakoo_name%, %lakoo_order_id%, %lakoo_products%, %lakoo_shipping_cost% to display order detail. If you use CL Input Resi plugin, you can also use %lakoo_courier%, %lakoo_tracking_code%, %lakoo_tracking_date%, %lakoo_order_total% .', 'cepatlakoo' ),
    'default'   => esc_html( 'Halo %lakoo_name%,
ID Pesanan Anda: #%lakoo_order_id%

Detail Pesanan:
%lakoo_products%

Ongkir: %lakoo_shipping_cost%
*Total:* %lakoo_order_total%

Pesanan Anda sudah kami kirimkan dengan %lakoo_courier% pada tgl %lakoo_tracking_date% dengan no resi: %lakoo_tracking_code%, jika ada kendala dalam pemesanan bisa menghubungi kami via WA.' ),
),
array(
    'id'                        => 'cepatlakoo_followup_sms_message_success',
    'type'                      => 'textarea',
    'title'                     => esc_html__( 'SMS Message Complete', 'cepatlakoo' ),
    'desc'                      => esc_html__( 'Enter your SMS message. You can use %lakoo_name%, %lakoo_order_id%, %lakoo_products%, %lakoo_shipping_cost% to display order detail. If you use CL Input Resi plugin, you can also use %lakoo_courier%, %lakoo_tracking_code%, %lakoo_tracking_date%, %lakoo_order_total% .', 'cepatlakoo' ),
    'default'   => esc_html( 'Halo %lakoo_name%,
ID Pesanan Anda: #%lakoo_order_id%

Detail Pesanan:
%lakoo_products%

Ongkir: %lakoo_shipping_cost%
Total: %lakoo_order_total%

Pesanan Anda sudah kami kirimkan dengan %lakoo_courier% pada tgl %lakoo_tracking_date% dengan no resi: %lakoo_tracking_code%, jika ada kendala dalam pemesanan bisa menghubungi kami via SMS.' ),
) );
}

Redux::setSection( $opt_name, array(
    'title'            => __( 'Follow Up Buttons', 'cepatlakoo' ),
    'id'               => 'cepatlakoo_shopping_cart_info_followup',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => $follows
) );

Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Contact Buttons on Product Page', 'cepatlakoo' ),
    'id'               => 'cepatlakoo_shopping_cart_info_message',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => array(

        array(
            'id'                      => 'cepatlakoo_contact_button_trigger',
            'type'                    => 'switch',
            'title'                   => esc_html__('Contact Buttons', 'cepatlakoo'),
            'desc'                    => esc_html__('Enable Contact Buttons', 'cepatlakoo'),
            'default'                 => true,
        ),

        array(
            'id'                        => 'cepatlakoo_message_above_contact',
            'type'                      => 'textarea',
            'title'                     => esc_html__('Message Above Contact Buttons', 'cepatlakoo'),
            'desc'                      => esc_html__('This message will be displayed on top of the contact buttons.', 'cepatlakoo'),
            'default'                   => esc_html__( 'Untuk pemesanan, silahkan klik tombol di bawah ini:' , 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_message_popup_heading',
            'type'                      => 'text',
            'title'                     => esc_html__('Contact Button Desktop Heading', 'cepatlakoo'),
            'desc'                      => esc_html__( 'This message will be displayed on popup when clicking contact buttons on desktop.', 'cepatlakoo' ),
            'default'                   => esc_html__( 'Cara Membeli' , 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_message_popup',
            'type'                      => 'textarea',
            'title'                     => esc_html__( 'Contact Button Desktop Message', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'This message will be displayed on popup when clicking contact buttons on desktop.', 'cepatlakoo' ),
            'default'                   => esc_html__( 'Silahkan menghubungi kami via [contact_app] di [contact_id] pada perangkat handphone Anda.' , 'cepatlakoo' ),
        ),
        
        array(
            'id'                      => 'cepatlakoo_sticky_button_trigger',
            'type'                    => 'switch',
            'title'                   => esc_html__('Sticky WhatsApp Button', 'cepatlakoo'),
            'desc'                    => esc_html__('Make WhatsApp button sticky.', 'cepatlakoo'),
            'default'                 => '1',
        ),

        array(
            'id'                        => 'cepatlakoo_cart_wa',
            'type'                      => 'text',
            'title'                     => esc_html__('WhatsApp Number', 'cepatlakoo'),
            'desc'                      => esc_html__( 'Enter your WhatsApp number (example: 628596663021). Leave it blank to hide the button.', 'cepatlakoo'),
            'default'                   => esc_html__( '6285966634332' , 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_cart_wa_text',
            'type'                      => 'text',
            'title'                     => esc_html__('WhatsApp Button Text', 'cepatlakoo'),
            'desc'                      => esc_html__( 'Text on WhatsApp button.', 'cepatlakoo'),
            'default'                   => esc_html__( 'Beli via WhatsApp' , 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_cart_wa_message',
            'type'                      => 'textarea',
            'title'                     => esc_html__( 'WhatsApp Message', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'Enter your WhatsApp message. Use %lakoo_product_name% to display the product name and %lakoo_product_url% to add product url', 'cepatlakoo' ),
            'default'                   => esc_html__( 'Hai, saya berminat dengan %lakoo_product_name% %lakoo_product_url%' , 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_cart_wa_event',
            'type'                      => 'select',
            'title'                     => esc_html__( 'WhatsApp FB Ads Event', 'cepatlakoo' ),
            'options'                   => $fb_pixel_events,
            'default'                   => 'AddToWishlist',
        ),

        //-------------------------------

        array(
            'id'                        => 'cepatlakoo_cart_bbm',
            'type'                      => 'text',
            'title'                     => esc_html__('BBM', 'cepatlakoo'),
            'desc'                      => esc_html__( 'Enter your BBM Pin.  Leave it blank to hide the button.', 'cepatlakoo' ),
            'default'                   => esc_html__( 'E09K98' , 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_cart_bbm_text',
            'type'                      => 'text',
            'title'                     => esc_html__( 'BBM Button Text', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'Text on BBM button.', 'cepatlakoo' ),
            'default'                   => esc_html__( 'Chat di BBM' , 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_cart_bbm_event',
            'type'                      => 'select',
            'title'                     => esc_html__( 'BBM FB Ads Event', 'cepatlakoo' ),
            'options'                   => $fb_pixel_events,
            'default'                   => 'AddToWishlist',
        ),

        //----------------------------------

        array(
            'id'                        => 'cepatlakoo_cart_sms',
            'type'                      => 'text',
            'title'                     => esc_html__( 'SMS', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'Enter your Phone Number. Leave it blank to hide the button.', 'cepatlakoo'),
            'default'                   => esc_html__( '0812000912' , 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_cart_sms_text',
            'type'                      => 'text',
            'title'                     => esc_html__( 'SMS Button Text', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'Text on the SMS button.', 'cepatlakoo' ),
            'default'                   => esc_html__( 'Beli via SMS', 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_cart_sms_message',
            'type'                      => 'textarea',
            'title'                     => esc_html__( 'SMS Message', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'Enter your SMS Message display. Use %lakoo_product_name% to display the product name and %lakoo_product_url% to add product url.', 'cepatlakoo' ),
            'default'                   => esc_html__( 'Hai, saya berminat dengan %lakoo_product_name% %lakoo_product_url%', 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_cart_sms_event',
            'type'                      => 'select',
            'title'                     => esc_html__( 'SMS FB Ads Event', 'cepatlakoo' ),
            'options'                   => $fb_pixel_events,
            'default'                   => 'AddToWishlist',
        ),

         //----------------------------------

        array(
            'id'                        => 'cepatlakoo_cart_line',
            'type'                      => 'text',
            'title'                     => esc_html__( 'LINE', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'Enter your LINE ID. Leave it blank to hide the button.', 'cepatlakoo' ),
            'default'                   => esc_html__( 'agnezmos', 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_cart_line_text',
            'type'                      => 'text',
            'title'                     => esc_html__( 'LINE Button Text', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'Text on LINE button.', 'cepatlakoo' ),
            'default'                   => esc_html__( 'Chat di LINE', 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_cart_line_event',
            'type'                      => 'select',
            'title'                     => esc_html__( 'LINE FB Ads Event', 'cepatlakoo' ),
            'options'                   => $fb_pixel_events,
            'default'                   => 'AddToWishlist',
        ),

        //----------------------------------

        array(
            'id'                        => 'cepatlakoo_cart_phone',
            'type'                      => 'text',
            'title'                     => esc_html__( 'Phone', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'Enter your Phone Number. Leave it blank to hide the button.', 'cepatlakoo' ),
            'default'                   => esc_html__('+628127776622', 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_cart_phone_text',
            'type'                      => 'text',
            'title'                     => esc_html__( 'Phone Button Text', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'Text on phone button.', 'cepatlakoo' ),
            'default'                   => esc_html__( 'Telepon Kami', 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_cart_phone_event',
            'type'                      => 'select',
            'title'                     => esc_html__( 'Phone FB Ads Event', 'cepatlakoo' ),
            'options'                   => $fb_pixel_events,
            'default'                   => 'AddToWishlist',
        ),

        //----------------------------------

        array(
            'id'                        => 'cepatlakoo_cart_telegram',
            'type'                      => 'text',
            'title'                     => esc_html__( 'Telegram', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'Enter your Telegram ID. Leave it blank to hide the button.', 'cepatlakoo' ),
            'default'                   => esc_html__( 'telegram' , 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_cart_telegram_text',
            'type'                      => 'text',
            'title'                     => esc_html__( 'Telegram Button Text', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'Text on Telegram button.', 'cepatlakoo' ),
            'default'                   => esc_html__( 'Beli via Telegram' , 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_cart_telegram_event',
            'type'                      => 'select',
            'title'                     => esc_html__( 'Telegram FB Ads Event', 'cepatlakoo' ),
            'options'                   => $fb_pixel_events,
            'default'                   => 'AddToWishlist',
        ),
    ),
) );




// FACEBOOK PIXEL
Redux::setSection( $opt_name, array(
    'title'            => __( 'Facebook Pixel', 'cepatlakoo' ),
    'id'               => 'facebook_pixel',
    'customizer_width' => '450px',
    'desc'             => __( 'Configure settings related to Facebook pixel.', 'cepatlakoo' ),
    'icon'             => 'el el-facebook',
    'fields'           => array(
        array(
            'id'                        => 'cepatlakoo_facebook_pixel_id',
            'type'                      => 'text',
            'title'                     => esc_html__( 'Facebook Pixel ID', 'cepatlakoo' ),
            'desc'                      => sprintf( wp_kses( __('Enter your Facebook Pixel ID. you can create your Pixel ID by following this <a href="%s" target="_blank"> article</a>.', 'cepatlakoo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://www.facebook.com/business/help/952192354843755?helpref=faq_content#createpixel' ) ),
            'default'                   => '',
        ),
        array(
            'id'                        => 'cepatlakoo_purchase_confirmation',
            'type'                      => 'select',
            'title'                     =>  esc_html__( 'WooCommerce Purchase Confirmation', 'cepatlakoo' ),
            'options'                   => $fb_pixel_events,
            'default'                   => 'Purchase',
            'desc'                      => esc_html__('Select pixel event for payment confirmed using automatic payment gateway .', 'cepatlakoo'),
        ),
    ),
) );





// SMS NOTIFICATION
Redux::setSection( $opt_name, array(
    'title'            => __( 'SMS Notification', 'cepatlakoo' ),
    'id'               => 'sms_notification',
    'customizer_width' => '450px',
    'desc'             => __( 'Configure settings related WooCommerce SMS Notification using smsgateway.me service.', 'cepatlakoo' ),
    'icon'             => 'el el-comment',
    'fields'           => array(
        $fields = array(
            'id'    => 'info_warning',
            'type'  => 'info',
            'title' => __('PERHATIAN', 'cepatlakoo'),
            'style' => 'warning',
            'desc'  => __('Pastikan Anda sudah memiliki akun <a href="https://smsgateway.me" target="_blank">smsgateway.me</a> dan sudah menginstal aplikasi <a href="https://play.google.com/store/apps/details?id=networked.solutions.sms.gateway.api&hl=en" target="_blank">SMS Gateway API</a> di handphone Android Anda.', 'cepatlakoo')
        ),
        array(
            'id'                        => 'cepatlakoo_sms_gateway_token',
            'type'                      => 'text',
            'title'                     => esc_html__( 'SMS Gateway API Token', 'cepatlakoo' ),
            'desc'                      => sprintf( esc_html__( 'Enter smsgateway.me website API token. You can get it from %s .', 'cepatlakoo' ), '<a href="https://smsgateway.me/dashboard/settings" target="_blank">https://smsgateway.me/dashboard/settings</a>' ),
            'default'                   => '',
        ),
        array(
            'id'                        => 'cepatlakoo_sms_gateway_deviceID',
            'type'                      => 'text',
            'title'                     => esc_html__( 'SMS Gateway DeviceID', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'Your device ID registered to smsgateway.me, for example: 526345.', 'cepatlakoo' ),
            'default'                   => '',
        ),
        array(
            'id'                        => 'cepatlakoo_sms_gateway_phone',
            'type'                      => 'text',
            'title'                     => esc_html__( 'SMS Gateway Phone Number', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'Your phone number which you have install smsgateway.me Android app. For example: 085613242215.', 'cepatlakoo' ),
            'default'                   => '',
        ),

        array(
            'id'                        => 'cepatlakoo_smsnotification_admin',
            'type'                      => 'section',
            'title'                     => esc_html__('SMS Notification for Admin', 'cepatlakoo'),
            'subtitle'                  => esc_html__('Set notification message for admin', 'cepatlakoo'),
            'indent'                    => true,
        ),

        array(
            'id'                        => 'cepatlakoo_sms_new_order_admin_info',
            'type'                      => 'info',
            'style'                     => 'success',
            'title'                     => esc_html__('Gunakan Shortcode Ini Untuk Merangkai Pesan', 'cepatlakoo'),
            'desc'                      => __('<br /> <strong>%lakoo_order_id%</strong> : Nomor Pemesanan <br /> <strong>%lakoo_order_status%</strong> : Status Pemesanan <br /> <strong>%lakoo_shop_name%</strong> : Nama Toko', 'cepatlakoo'),
        ),

        array(
            'id'                        => 'cepatlakoo_sms_new_order_admin',
            'type'                      => 'textarea',
            'title'                     => esc_html__( 'New Order Alert ', 'cepatlakoo' ),
            'default'                   => esc_attr__( 'Ada orderan baru dengan nomor #%lakoo_order_id% di %lakoo_shop_name%. Segera proses.' , 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_smsnotification_customer',
            'type'                      => 'section',
            'title'                     => esc_html__( 'SMS Notification for Customer', 'cepatlakoo' ),
            'subtitle'                  => esc_html__('Set notification message for your customer', 'cepatlakoo'),
            'indent'                    => true,
        ),

        array(
            'id'                        => 'cepatlakoo_smsnotification_customer_info',
            'type'                      => 'info',
            'style'                     => 'success',
            'title'                     => esc_html__('Gunakan Shortcode Ini Untuk Merangkai Pesan', 'cepatlakoo'),
            'desc'                      => __('<br /> <strong>%lakoo_order_id%</strong> : Nomor Pemesanan <br /> <strong>%lakoo_order_status%</strong> : Status Pemesanan <br /> <strong>%lakoo_shop_name%</strong> : Nama Toko <br /> <strong>%lakoo_fullname%</strong> : Nama Lengkap Buyer <br /> </br> <strong>%lakoo_email%</strong> : Email Buyer <br /> <strong>%lakoo_phone_number%</strong> : Nomor Telepon Buyer <br /> <strong>%lakoo_shipping_price%</strong> : Biaya Ongkos Kirim <br /> <strong>%lakoo_total_price%</strong> : Total Harga Pemesanan <br /> <strong>%lakoo_tracking_code%</strong> : Kode Resi <br /> <strong>%lakoo_tracking_date%</strong> : Tanggal Pengiriman <br /> <strong>%lakoo_courier%</strong> : Nama Ekspedisi <br /> <strong>%lakoo_payment_code%</strong> : Kode Pembayaran', 'cepatlakoo'),
        ),

        array(
            'id'                        => 'cepatlakoo_sms_new_order',
            'type'                      => 'textarea',
            'title'                     => esc_html__( 'New Order Alert', 'cepatlakoo' ),
            'default'                   => esc_attr__( 'Order Anda #%lakoo_order_id% sudah kami terima mohon segera melakukan pembayaran. Terimakasih sudah berbelanja di %lakoo_shop_name%.', 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_sms_order_process',
            'type'                      => 'textarea',
            'title'                     => esc_html__( 'Order is Being Processed', 'cepatlakoo' ),
            'default'                   => esc_attr__( 'Order Anda #%lakoo_order_id% sudah kami terima dan akan segera kami proses. Terimakasih sudah berbelanja di %lakoo_shop_name%.', 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_sms_order_complete',
            'type'                      => 'textarea',
            'title'                     => esc_html__( 'Order Completed', 'cepatlakoo' ),
            'default'                   => esc_attr__( '%lakoo_shop_name% - Status order #%lakoo_order_id% diubah menjadi: Sudah Dikirim dengan %lakoo_courier%, tgl: %lakoo_tracking_date%, nomor resi: %lakoo_tracking_code%', 'cepatlakoo' ),

        ),

        array(
            'id'                        => 'cepatlakoo_sms_order_pending',
            'type'                      => 'textarea',
            'title'                     => esc_html__( 'Order is Pending Payment', 'cepatlakoo' ),
            'default'                   => esc_attr__( '%lakoo_shop_name% - Order Anda no. #%lakoo_order_id% status: Pending Payment.', 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_sms_order_failed',
            'type'                      => 'textarea',
            'title'                     => esc_html__( 'Order Failed', 'cepatlakoo' ),
            'default'                   => esc_attr__( '%lakoo_shop_name% - Order Anda no. #%lakoo_order_id% status: Gagal.','cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_sms_order_refunded',
            'type'                      => 'textarea',
            'title'                     =>  esc_html__( 'Order Refunded', 'cepatlakoo' ),
            'default'                   => esc_attr__( '%lakoo_shop_name% - Order Anda no. #%lakoo_order_id% status: Refund Uang.', 'cepatlakoo' ),

        ),

        array(
            'id'                        => 'cepatlakoo_sms_order_cancel',
            'type'                      => 'textarea',
            'title'                     => esc_html__( 'Order Cancelled', 'cepatlakoo' ),
            'default'                   => esc_attr__( '%lakoo_shop_name% - Order Anda no. #%lakoo_order_id% status: Dibatalkan.', 'cepatlakoo' ),
        ),

        array(
            'id'                        => 'cepatlakoo_sms_order_note',
            'type'                      => 'textarea',
            'title'                     => esc_html__( 'When a Note for Customer Added to Order', 'cepatlakoo' ),
            'default'                   =>  esc_attr__( '%lakoo_shop_name% - Catatan ditambahkan pada order #%lakoo_order_id%: %lakoo_note%', 'cepatlakoo' ),
            'desc'                      => esc_html__( 'You can use this code to display the note message: %lakoo_note%' ),
        ),
    ),
) );




// TYPOGRAPHY
Redux::setSection( $opt_name, array(
    'title'            => __( 'Typography', 'cepatlakoo' ),
    'id'               => 'typography',
    'customizer_width' => '450px',
    'desc'             => __( 'Configure settings related typograhy.', 'cepatlakoo' ),
    'icon'             => 'el el-text-width',
    'fields'           => array(

        array(
            'id'                => 'cepatlakoo_main_font_typo',
            'type'              => 'typography',
            'title'             => esc_html__( 'Main Typography', 'cepatlakoo' ),
            'google'            => true,
            'subsets'           => false,
            'preview'           => true,
            'text-align'        => false,
            'output'            => array('body, #top-bar, label'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '16px',
                'font-weight'       => '400',
                'line-height'       => '28px',
                'color'             => '#555555',
            )
        ),

        array(
            'id'                => 'cepatlakoo_site_title_typography',
            'type'              => 'typography',
            'title'             => esc_html__(  'Site title typography', 'cepatlakoo' ),
            'google'            => true,
            'subsets'           => false,
            'preview'           => true,
            'text-align'        => false,
            'output'            => array('#main-header h2 a'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '30px',
                'font-weight'       => '400',
                'line-height'       => '35px',
                'color'             => '#ffffff',
            )
        ),
        array(
            'id'                => 'cepatlakoo_heading_h1_typo',
            'type'              => 'typography',
            'title'             => esc_html__( 'H1', 'cepatlakoo' ),
            'google'            => true,
            'subsets'           => false,
            'preview'           => true,
            'text-align'        => false,
            'output'            => array('h1, article.hentry h1'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '35px',
                'font-weight'       => '700',
                'line-height'       => '40px',
                'color'             => '#333333',
            )
        ),

        array(
            'id'                => 'cepatlakoo_heading_h2_typo',
            'type'              => 'typography',
            'title'             => esc_html__( 'H2', 'cepatlakoo' ),
            'google'            => true,
            'subsets'           => false,
            'preview'           => true,
            'text-align'        => false,
            'output'            => array('h2, article.hentry h2'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '30px',
                'font-weight'       => '700',
                'line-height'       => '35px',
                'color'             => '#333333',
            )
        ),

        array(
            'id'                => 'cepatlakoo_heading_h3_typo',
            'type'              => 'typography',
            'title'             => esc_html__( 'H3', 'cepatlakoo' ),
            'google'            => true,
            'subsets'           => false,
            'preview'           => true,
            'text-align'        => false,
            'output'            => array('h3, article.hentry h3'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '20px',
                'font-weight'       => '700',
                'line-height'       => '25px',
                'color'             => '#333333',
            )
        ),

        array(
            'id'                => 'cepatlakoo_heading_h4_typo',
            'type'              => 'typography',
            'title'             => esc_html__( 'H4', 'cepatlakoo' ),
            'google'            => true,
            'subsets'           => false,
            'preview'           => true,
            'text-align'        => false,
            'output'            => array('h4, article.hentry h4'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '16px',
                'font-weight'       => '400',
                'line-height'       => '25px',
                'color'             => '#333333',
            )
        ),

        array(
            'id'                => 'cepatlakoo_heading_h5_typo',
            'type'              => 'typography',
            'title'             => esc_html__( 'H5', 'cepatlakoo' ),
            'google'            => true,
            'subsets'           => false,
            'preview'           => true,
            'text-align'        => false,
            'output'            => array('h5, article.hentry h5'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '12px',
                'font-weight'       => '400',
                'line-height'       => '20px',
                'color'             => '#333333',
            )
        ),

        array(
            'id'                => 'cepatlakoo_heading_h6_typo',
            'type'              => 'typography',
            'title'             => esc_html__( 'H6', 'cepatlakoo' ),
            'google'            => true,
            'subsets'           => false,
            'preview'           => true,
            'text-align'        => false,
            'output'            => array('h6, article.hentry h6'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '10px',
                'font-weight'       => '400',
                'line-height'       => '16px',
                'color'             => '#333333',
            )
        ),

        array(
            'id'                => 'cepatlakoo_menu_text_typography',
            'type'              => 'typography',
            'title'             => esc_html__( 'Menu text typography', 'cepatlakoo' ),
            'google'            => true,
            'subsets'           => false,
            'preview'           => true,
            'text-align'        => false,
            'output'            => array('.site-navigation ul li, .site-navigation ul li'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '12px',
                'font-weight'       => '700',
                'line-height'       => '18px',
                'color'             => '#ffffff',
            )
        ),

        array(
            'id'                => 'cepatlakoo_submenu_text_typography',
            'type'              => 'typography',
            'title'             => esc_html__( 'Sub menu text typography', 'cepatlakoo' ),
            'google'            => true,
            'text-transform'     => true,
            'preview'           => true,
            'text-align'        => false,
            'subsets'           => false,
            'output'            => array('.site-navigation ul li > ul.sub-menu li'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '12px',
                'font-weight'       => '400',
                'line-height'       => '18px',
                'color'             => '#000000',
                'text-transform'     => 'none',
            )
        ),

        array(
            'id'                => 'cepatlakoo_submenu_2nd_text_typography',
            'type'              => 'typography',
            'title'             => esc_html__( 'Sub menu 2nd text typography', 'cepatlakoo' ),
            'google'            => true,
            'text-transform'     => true,
            'subsets'           => false,
            'preview'           => true,
            'text-align'        => false,
            'output'            => array('.site-navigation ul li > ul.sub-menu li ul.sub-menu li'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '12px',
                'font-weight'       => '400',
                'line-height'       => '18px',
                'color'             => '#000000',
                'text-transform'     => 'none',
            )
        ),

        array(
            'id'                => 'cepatlakoo_footer_typography',
            'type'              => 'typography',
            'title'             => esc_html__( 'Footer typography', 'cepatlakoo' ),
            'google'            => true,
            'text-transform'     => true,
            'preview'           => true,
            'subsets'           => false,
            'text-align'        => false,
            'output'            => array('footer#colofon, .site-infos'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '14px',
                'font-weight'       => '400',
                'line-height'       => '18px',
                'color'             => '#bababa',
                'text-transform'     => 'none',
            )
        ),
    ),
) );

Redux::setSection( $opt_name, array(
    'title'            => __( 'Blog', 'cepatlakoo' ),
    'id'               => 'cepatlakoo_typography_blog',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => array(
        array(
            'id'                => 'cepatlakoo_page_title_typography',
            'type'              => 'typography',
            'title'             => esc_html__( 'Page Title', 'cepatlakoo' ),
            'google'            => true,
            'subsets'           => false,
            'preview'           => true,
            'text-align'        => false,
            'output'            => array('#page-title h2, #page-title h1'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '35px',
                'font-weight'       => '700',
                'line-height'       => '40px',
                'color'             => '#333333',
            )
        ),

        array(
            'id'                => 'cepatlakoo_post_title_typography',
            'type'              => 'typography',
            'title'             => esc_html__( 'Post Title', 'cepatlakoo' ),
            'google'            => true,
            'subsets'           => false,
            'preview'           => true,
            'text-align'        => false,
            'output'            => array('article h1.post-title, .postlist article.hentry h3.post-title'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '35px',
                'font-weight'       => '700',
                'line-height'       => '40px',
                'color'             => '#333333',
            )
        ),

        array(
            'id'                => 'cepatlakoo_paragraf_typography',
            'type'              => 'typography',
            'title'             => esc_html__( 'Paragraph Text', 'cepatlakoo' ),
            'google'            => true,
            'subsets'           => false,
            'preview'           => true,
            'text-align'        => false,
            'output'            => array('article.hentry p'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '16px',
                'font-weight'       => '400',
                'line-height'       => '24px',
                'color'             => '#555555',
            )
        ),
    ),
) );

Redux::setSection( $opt_name, array(
    'title'            => __( 'WooCommerce', 'cepatlakoo' ),
    'id'               => 'cepatlakoo_typography_woocommerce',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => array(
        array(
            'id'                => 'cepatlakoo_woo_product_title_typography',
            'type'              => 'typography',
            'title'             => esc_html__( 'WooCommerce Product Title', 'cepatlakoo' ),
            'google'            => true,
            'subsets'           => false,
            'preview'           => true,
            'text-align'        => false,
            'output'            => array('.woocommerce .summary h1.product_title'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '35px',
                'font-weight'       => '700',
                'line-height'       => '40px',
                'color'             => '#000000',
            )
        ),

        array(
            'id'                => 'cepatlakoo_woo_paragraf_typography',
            'type'              => 'typography',
            'title'             => esc_html__( 'WooCommerce Paragraph Text', 'cepatlakoo' ),
            'google'            => true,
            'subsets'           => false,
            'preview'           => true,
            'text-align'        => false,
            'output'            => array('.woocommerce .summary p:not(a)', '.woocommerce .woocommerce-tabs p', '.quick-contact-info p.contact-message, .reveal-overlay p, .woocommerce-product-details__short-description, .woocommerce .entry-content.woocommerce-Tabs-panel'),
            'default'           => array(
                'font-family'       => 'Roboto',
                'font-size'         => '16px',
                'font-weight'       => '400',
                'line-height'       => '24px',
                'color'             => '#555555',
            )
        ),
    ),
) );




// COLORS
Redux::setSection( $opt_name, array(
    'title'            => __( 'Colors', 'cepatlakoo' ),
    'id'               => 'colors',
    'customizer_width' => '450px',
    'desc'             => __( 'Configure settings related to colors.', 'cepatlakoo' ),
    'icon'             => 'el el-brush',
    'fields'           => array(
        array(
            'id'                    => 'cepatlakoo_general_theme_color',
            'type'                  => 'color',
            'title'                 => esc_html__('General Theme Color', 'cepatlakoo'),
            'desc'                  => esc_html__( 'Border color, link color', 'cepatlakoo' ),
            'transparent'           => false,
            'output'                => array('.widget li.recentcomments span, .wp-pagenavi span.current, .post-navigation ul li .detail > a,.products-pagination span.current, .woocommerce .products li .custom-shop-buttons a:nth-child(2), #contentarea .woocommerce-Price-amount.amount, #contentarea span.amount, .widget ul.product_list_widget li .quantity span, .woocommerce-MyAccount-navigation ul li.is-active a, .product_meta span.posted_in:before, .woocommerce .product_meta span.tagged_as:before, .woocommerce div.product .out-of-stock, #sidebar .entry-meta span, fieldset legend, #backtotop, ul.product-categories li:hover a:before, .price_slider_amount button, .ui.steps .step.active .title'),
            'default'               => '#372248',
        ),
        array(
            'id'                    => 'cepatlakoo_general_bg_theme_color',
            'type'                  => 'background',
            'title'                 => esc_html__( 'General Background Theme Color', 'cepatlakoo' ),
            'desc'                  => esc_html__( 'Background color for header and most part of the theme.', 'cepatlakoo' ),
            'output'                => array('.custom-shop-buttons #contentarea a.btn, li.product .custom-shop-buttons, .btn.cepatlakoo-ajax-quick-view:hover, .woocommerce .products li .custom-shop-buttons a:nth-child(2):hover, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt, .woocommerce a.btn:hover, .woocommerce .widget_price_filter .ui-slider-horizontal .ui-slider-range, a.add_to_wishlist:hover, .woocommerce ul.products li.product .ribbons, .woocommerce .product-list .ribbons, .woocommerce .product .ribbons, .woocommerce .summary .add_to_cart_button, .owl-dots .owl-dot.active, .woocommerce #respond input#submit, .size-select-widget ul li.selected, .primary-bg, a.cart-btn.btn.wc-forward, #dialog:before, #main-header, .page-template-template-blog #contentarea a.btn, table.shop_table.cart td.actions .button, .woocommerce a.btn'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'transparent'       => false,
            'default'               => array(
                                        'background-color' => '#372248',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_link_theme_color',
            'type'                  => 'link_color',
            'title'                 => esc_html__( 'General Link Color', 'cepatlakoo' ),
            'active'                 => false,
            'output'                => array('a, .entry-content a, .entry-summary a'),
            'default'               => array(
                                        'regular'  => '#1e73be',
                                        'hover'  => '#318e1c',
                                    ),
        ),

        array(
            'id'                    => 'cepatlakoo_backtotop_bg_color',
            'type'                  => 'background',
            'title'                 => esc_html__( 'Back to Top Background Color', 'cepatlakoo' ),
            'output'                => array('#backtotop'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'default'               => array(
                                        'background-color' => '#ffffff',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_backtotop_bg_hover_color',
            'type'                  => 'background',
            'title'                 => esc_html__( 'Back to Top Background Hover Color', 'cepatlakoo' ),
            'output'                => array('#backtotop:hover'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'default'               => array(
                                        'background-color' => '#d64933',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_form_field_bg_color',
            'type'                  => 'background',
            'title'                 => esc_html__( 'Form Field Background Color', 'cepatlakoo' ),
            'output'                => array('input:not([type]), input[type=date], input[type=datetime-local], input[type=email], input[type=file], input[type=number], input[type=password], input[type=search], input[type=tel], input[type=text], input[type=time], input[type=url], textarea, .select2-container .select2-selection--single, select'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'transparent'           => false,
            'default'               => array(
                                        'background-color' => '#fafafa',
            )
        ),
    ),
) );

Redux::setSection( $opt_name, array(
    'title'            => __( 'Top Bar', 'cepatlakoo' ),
    'id'               => 'cepatlakoo_colors_topbar',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => array(
        array(
            'id'                    => 'cepatlakoo_topbar_text_color',
            'type'                  => 'color',
            'title'                 => esc_html__( 'Top Bar Text Color', 'cepatlakoo' ),
            'transparent'           => false,
            'output'                => array('#top-bar, #top-bar label, #top-bar ul.user-menu-menu li, #top-bar .socials li, .customer-care, .flash-info, #top-bar a, .customer-care b', '.user-options i'),
            'default'               => '#ffffff',
        ),
        array(
            'id'                    => 'cepatlakoo_topbar_link_color',
            'type'                  => 'link_color',
            'title'                 => esc_html__( 'Top Bar Link Color', 'cepatlakoo' ),
            'active'                => false,
            'important'             => true,
            'output'                => array('#top-bar ul.user-menu-menu li, #top-bar .socials li a, .customer-care a, .flash-info a, #top-bar .cart-counter, #top-bar .avatar:after, .customer-care i, user-account-menu'),
            'default'               => array(
                                        'regular'  => '#ffffff',
                                        'hover'  => '#928da8',
            ),
        )
    ),
) );

Redux::setSection( $opt_name, array(
    'title'            => __( 'Header', 'cepatlakoo' ),
    'id'               => 'cepatlakoo_colors_header',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => array(
        array(
            'id'                    => 'cepatlakoo_header_text_color',
            'type'                  => 'color',
            'title'                 => esc_html__( 'Header Text Color', 'cepatlakoo' ),
            'transparent'           => false,
            'output'                => array('#main-header, .cart-counter label, .user-account-menu .avatar label, .mobile-menu-trigger label'),
            'default'               => '#ffffff',
        ),
        array(
            'id'                    => 'cepatlakoo_main_menu_hover_color',
            'type'                  => 'link_color',
            'title'                 => esc_html__( 'Main Menu Link Color', 'cepatlakoo' ),
            'active'                => false,
            'output'                => array('.site-navigation ul li a'),
            'default'               => array(
                                        'regular'  => '#ffffff',
                                        'hover'  => '#f0cf65',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_sub_menu_hover_color',
            'type'                  => 'link_color',
            'title'                 => esc_html__( 'Sub Menu Link Hover Color', 'cepatlakoo' ),
            'active'                => false,
            'output'                => array('.site-navigation ul li > ul.sub-menu li a'),
            'default'               => array(
                                        'regular'  => '#555555',
                                        'hover'  => '#d64933',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_sub_menu_bg_hover_color',
            'type'                  => 'background',
            'title'                 => esc_html__( 'Sub Menu Hover Background Color', 'cepatlakoo' ),
            'output'                => array('.site-navigation ul li > ul.sub-menu li a:hover'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'default'               => array(
                                        'background-color' => '#ededed',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_header_empty_cart_icon_color',
            'type'                  => 'color',
            'title'                 => esc_html__( 'Empty Cart Icon Color', 'cepatlakoo' ),
            'active'                => false,
            'output'                => array('.user-carts .cart-counter .icon.not-empty'),
            'default'               => '#ffffff',
            'validate'              => "color",
        ),

        array(
            'id'                    => 'cepatlakoo_header_filled_cart_icon_color',
            'type'                  => 'color',
            'title'                 => esc_html__( 'Not Empty Cart Icon Color', 'cepatlakoo' ),
            'active'                => false,
            'output'                => array('.user-carts .cart-counter .icon.not-empty'),
            'default'               => '#c7ac7f',
            'validate'              => "color",
        ),
    ),
) );

Redux::setSection( $opt_name, array(
    'title'            => __( 'Footer', 'cepatlakoo' ),
    'id'               => 'cepatlakoo_colors_footer',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => array(
        array(
            'id'                    => 'cepatlakoo_footer_widget_background_color',
            'type'                  => 'background',
            'title'                 => esc_html__( 'Footer Widget Background Color', 'cepatlakoo' ),
            'output'                => array('#footer-widgets-area'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'default'               => array(
                                        'background-color' => '#372248',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_footer_background_color',
            'type'                  => 'background',
            'title'                 => esc_html__( 'Footer Background Color', 'cepatlakoo' ),
            'output'                => array('#footer-info'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'default'               => array(
                                        'background-color' => '#2e1c3b',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_footer_hover_link_color',
            'type'                  => 'link_color',
            'title'                 => esc_html__( 'Footer Link Color', 'cepatlakoo' ),
            'output'                => array('#colofon a, .widget_categories ul li:hover a, .widget_categories ul li:hover a:before'),
            'active'                => false,
            'default'               => array(
                                        'regular'  => '#ffffff',
                                        'hover'    => '#c1c1c1',
                                    ),
        ),
    ),
) );

Redux::setSection( $opt_name, array(
    'title'            => __( 'Widgets', 'cepatlakoo' ),
    'id'               => 'cepatlakoo_colors_widgets',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => array(
        array(
            'id'                    => 'cepatlakoo_widget_footer_link_color',
            'type'                  => 'link_color',
            'title'                 => esc_html__( 'Widget Footer Link Color', 'cepatlakoo' ),
            'active'                => false,
            'output'                => array('div#footer-widgets-area a, .site-infos a'),
            'default'               => array(
                                        'regular'  => '#ffffff',
                                        'hover'    => '#c1c1c1',
                                    ),
        ),

        array(
            'id'                    => 'cepatlakoo_widget_link_color',
            'type'                  => 'link_color',
            'title'                 => esc_html__( 'Sidebar Widget Link Color', 'cepatlakoo' ),
            'active'                => false,
            'output'                => array('#sidebar a'),
            'default'               => array(
                                        'regular'  => '#1e73be',
                                        'hover'  => '#318e1c',
            )
        ),
    ),
) );

Redux::setSection( $opt_name, array(
    'title'            => __( 'WooCommerce', 'cepatlakoo' ),
    'desc'             => esc_html__('WooCommerce color settings.', 'cepatlakoo'),
    'id'               => 'cepatlakoo_colors_woocommerce',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => array(
        array(
            'id'                    => 'cepatlakoo_woocommerce_button_bg_color',
            'type'                  => 'background',
            'title'                 => esc_html__( 'WooCommerce Button Background Color', 'cepatlakoo' ),
            'output'                => array('.wc-proceed-to-checkout a.checkout-button, #dialog:before, .form-row.place-order input#place_order, .woocommerce div.product form.cart .button, .woocommerce #payment #place_order, .woocommerce-page #payment #place_order, .woocommerce-cart .wc-proceed-to-checkout a.button, .cart-content a.checkout-btn, .cart-content a.checkout-btn:hover, .woocommerce ul.products li.product a.add_to_cart_button, ul.products li.product a.button.product_type_variable, ul.products li.product a.button.product_type_grouped, .woocommerce ul.products li.product a.button.product_type_external, .woocommerce a.single_add_to_cart_button, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt:disabled[disabled], .woocommerce button.button.alt:disabled[disabled]:hover'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'transparent'           => false,
            'default'               => array(
                                        'background-color' => '#399E5A',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_woocommerce_price_color',
            'type'                  => 'color',
            'title'                 => esc_html__( 'WooCommerce Price Color', 'cepatlakoo' ),
            'transparent'           => false,
            'output'                => array('#contentarea ins .woocommerce-Price-amount.amount, #contentarea ins span.woocommerce-Price-currencySymbol, .woocommerce .summary p.price ins .woocommerce-Price-amount, #contentarea .woocommerce-Price-amount.amount, #contentarea span.amount, .woocommerce-Price-currencySymbol, .woocommerce-Price-amount.amount'),
            'default'               => '#27ae60',
        ),

        array(
            'id'                    => 'cepatlakoo_woocommerce_striketrough_price_color',
            'type'                  => 'link_color',
            'title'                 => esc_html__( 'WooCommerce Striketrough Price Color', 'cepatlakoo' ),
            'active'                => false,
            'hover'                 => false,
            'output'                => array('#contentarea del .woocommerce-Price-amount.amount, #contentarea del span.woocommerce-Price-currencySymbol, .woocommerce .summary p.price del .woocommerce-Price-amount, del .woocommerce-Price-amount.amount, del .woocommerce-Price-currencySymbol'),
            'default'               => array(
                                        'regular'  => '#7e7e7e',
            )
        ),

        array(
            'id'                        => 'cepatlakoo_header_cart_icon',
            'type'                      => 'section',
            'title'                     => esc_html__('Header Cart Icon', 'cepatlakoo'),
            'subtitle'                  => esc_html__('Header cart icon color setting.', 'cepatlakoo'),
            'indent'                    => false,
        ),

        array(
            'id'                    => 'cepatlakoo_cart_color',
            'type'                  => 'color',
            'title'                 => esc_html__( 'Shopping Cart Empty Color', 'cepatlakoo' ),
            'transparent'           => false,
            'output'                => array('.user-carts .cart-counter .icon'),
            'default'               => '#ffffff',
        ),

        array(
            'id'                    => 'cepatlakoo_cart_not_empty_color',
            'type'                  => 'color',
            'title'                 => esc_html__( 'Shopping Cart Not Empty Color', 'cepatlakoo' ),
            'transparent'           => false,
            'output'                => array('.user-carts .cart-counter .icon.not-empty'),
            'default'               => '#c7ac7f',
        ),

        array(
            'id'                        => 'cepatlakoo_discount_badge',
            'type'                      => 'section',
            'title'                     => esc_html__('WooCommerce Discount Badge', 'cepatlakoo'),
            'subtitle'                  => esc_html__('Product discount badge on product detail page.', 'cepatlakoo'),
            'indent'                    => false,
        ),

        array(
            'id'                    => 'cepatlakoo_discount_badge_background',
            'type'                  => 'background',
            'title'                 => esc_html__( 'Discount Badge Background Color', 'cepatlakoo' ),
            'output'                => array('.woocommerce span.onsale, .woocommerce ul.products li.product .onsale, .woocommerce .product .onsale, .woocommerce .product-list .onsale'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'transparent'           => false,
            'default'               => array(
                                        'background-color' => '#372248',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_discount_badge_text_color',
            'type'                  => 'color',
            'title'                 => esc_html__( 'Discount Badge Text Color', 'cepatlakoo' ),
            'transparent'           => false,
            'output'                => array('.woocommerce span.onsale, .woocommerce #main .onsale'),
            'default'               => '#ffffff',
        ),

        array(
            'id'                        => 'cepatlakoo_product_badges_section',
            'type'                      => 'section',
            'title'                     => esc_html__('Product Badges', 'cepatlakoo'),
            'subtitle'                  => esc_html__('Product badges on product detail page.', 'cepatlakoo'),
            'indent'                    => false,
        ),

        array(
            'id'                    => 'cepatlakoo_product_badge_bg_color_1',
            'type'                  => 'background',
            'title'                 => esc_html__( 'Product Badge 1 Background Color', 'cepatlakoo' ),
            'output'                => array('.woocommerce .cl-product-badges span'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'transparent'           => false,
            'default'               => array(
                                        'background-color' => '#dedede',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_product_badge_text_color_1',
            'type'                  => 'color',
            'title'                 => esc_html__( 'Product Badge 1 Text Color', 'cepatlakoo' ),
            'transparent'           => false,
            'output'                => array('.woocommerce .cl-product-badges span'),
            'default'               => '#555555',
        ),

        array(
            'id'                    => 'cepatlakoo_product_badge_bg_color_2',
            'type'                  => 'background',
            'title'                 => esc_html__( 'Product Badge 2 Background Color', 'cepatlakoo' ),
            'output'                => array('.woocommerce .cl-product-badges span:nth-child(even)'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'transparent'           => false,
            'default'               => array(
                                        'background-color' => '#ab4e68',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_product_badge_text_color_2',
            'type'                  => 'color',
            'title'                 => esc_html__( 'Product Badge 2 Text Color', 'cepatlakoo' ),
            'transparent'           => false,
            'output'                => array('.woocommerce .cl-product-badges span:nth-child(even)'),
            'default'               => '#ffffff',
        ),
    ),
) );



Redux::setSection( $opt_name, array(
    'title'            => __( 'Blog', 'cepatlakoo' ),
    'id'               => 'cepatlakoo_colors_blog',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => array(
        array(
            'id'                    => 'cepatlakoo_page_title_bg_color',
            'type'                  => 'background',
            'title'                 => esc_html__( 'Page Title Background Color', 'cepatlakoo' ),
            'output'                => array('#page-title'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'default'               => array(
                                        'background-color' => '#faf9fc',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_post_title_link_color',
            'type'                  => 'link_color',
            'title'                 => esc_html__( 'Post Title Link Color', 'cepatlakoo' ),
            'active'                => false,
            'output'                => array('.postlist article.hentry h3.post-title a'),
            'default'               => array(
                                        'regular'  => '#333333',
                                        'hover'  => '#1e73be',
                                    ),
        ),

        array(
            'id'                    => 'cepatlakoo_post_meta_text_color',
            'type'                  => 'color',
            'title'                 => esc_html__( 'Post Meta Text Color', 'cepatlakoo' ),
            'output'                => array('.page-template .entry-meta span, .single .entry-meta span'),
            'transparent'           => false,
            'default'               => '#aaaaaa',
            'validate'              => "color",
        ),

        array(
            'id'                    => 'cepatlakoo_postmeta_link_color',
            'type'                  => 'link_color',
            'title'                 => esc_html__( 'Post Meta Link Color', 'cepatlakoo' ),
            'active'                => false,
            'output'                => array('.entry-meta a'),
            'default'               => array(
                                        'regular'  => '#aaaaaa',
                                        'hover'  => '#d64933',
                                    ),
        ),

        array(
            'id'                    => 'cepatlakoo_post_btn_color',
            'type'                  => 'link_color',
            'title'                 => esc_html__( 'Read More Button Color', 'cepatlakoo' ),
            'active'                => false,
            'output'                => array('.page-template-template-blog #contentarea a.btn'),
            'default'               => array(
                                        'regular'  => '#ffffff',
                                        'hover'  => '#aaaaaa',
                                    ),
        ),

        array(
            'id'                    => 'cepatlakoo_sharing_btn_color',
            'type'                  => 'link_color',
            'title'                 => esc_html__( 'Share Buttons Color', 'cepatlakoo' ),
            'active'                => false,
            'output'                => array('.share-article-widget a i'),
            'default'               => array(
                                        'regular'  => '#b4b4b4',
                                        'hover'  => '#d64933',
                                    ),
        ),
    ),
) );

Redux::setSection( $opt_name, array(
    'title'            => __( 'Contact Buttons', 'cepatlakoo' ),
    'id'               => 'cepatlakoo_colors_contact_buttons',
    'customizer_width' => '450px',
    'subsection'       => true,
    'fields'           => array(
        array(
            'id'                    => 'cepatlakoo_custom_bg_bbm',
            'type'                  => 'background',
            'title'                 => esc_html__( 'BBM Background Color', 'cepatlakoo' ),
            'output'                => array('.quick-contact-info a.blackberry'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'transparent'           => false,
            'default'               => array(
                                        'background-color' => '#019cde',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_custom_bg_wa',
            'type'                  => 'background',
            'title'                 => esc_html__( 'WhatsApp Background Color', 'cepatlakoo' ),
            'output'                => array('.quick-contact-info a.whatsapp'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'transparent'           => false,
            'default'               => array(
                                        'background-color' => '#26d367',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_custom_bg_sms',
            'type'                  => 'background',
            'title'                 => esc_html__( 'SMS Background Color', 'cepatlakoo' ),
            'output'                => array('.quick-contact-info a.sms'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'transparent'           => false,
            'default'               => array(
                                        'background-color' => '#efc33c',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_custom_bg_line',
            'type'                  => 'background',
            'title'                 => esc_html__( 'LINE Background Color', 'cepatlakoo' ),
            'output'                => array('.quick-contact-info a.line'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'transparent'           => false,
            'default'               => array(
                                        'background-color' => '#44b654',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_custom_bg_phone',
            'type'                  => 'background',
            'title'                 => esc_html__( 'Phone Background Color', 'cepatlakoo' ),
            'output'                => array('.quick-contact-info a.phone'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'transparent'           => false,
            'default'               => array(
                                        'background-color' => '#1ad0dd',
            )
        ),

        array(
            'id'                    => 'cepatlakoo_custom_bg_telegram',
            'type'                  => 'background',
            'title'                 => esc_html__( 'Telegram Background Color', 'cepatlakoo' ),
            'output'                => array('.quick-contact-info a.telegram'),
            'preview'               => false,
            'preview_media'         => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-gradient'   => false,
            'background-clip'       => false,
            'background-origin'     => false,
            'background-size'       => false,
            'transparent'           => false,
            'default'               => array(
                                        'background-color' => '#38afe2',
            )
        ),
    ),
) );

if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
    $section = array(
        'icon'   => 'el el-list-alt',
        'title'  => __( 'Documentation', 'cepatlakoo' ),
        'fields' => array(
            array(
                'id'       => '17',
                'type'     => 'raw',
                'markdown' => true,
                'content_path' => dirname( __FILE__ ) . '/../README.md', // FULL PATH, not relative please
                //'content' => 'Raw content here',
            ),
        ),
    );
    Redux::setSection( $opt_name, $section );
}
/*
 * <--- END SECTIONS
 */


/*
 *
 * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
 *
 */

/*
*
* --> Action hook examples
*
*/

// If Redux is running as a plugin, this will remove the demo notice and links
//add_action( 'redux/loaded', 'remove_demo' );

// Function to test the compiler hook and demo CSS output.
// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
//add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

// Change the arguments after they've been declared, but before the panel is created
//add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

// Change the default value of a field after it's been set, but before it's been useds
//add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

// Dynamically add a section. Can be also used to modify sections/fields
//add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

/**
 * This is a test function that will let you see when the compiler hook occurs.
 * It only runs if a field    set with compiler=>true is changed.
 * */
if ( ! function_exists( 'compiler_action' ) ) {
    function compiler_action( $options, $css, $changed_values ) {
        echo '<h1>The compiler hook has run!</h1>';
        echo "<pre>";
        print_r( $changed_values ); // Values that have changed since the last save
        echo "</pre>";
        //print_r($options); //Option values
        //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
    }
}

/**
 * Custom function for the callback validation referenced above
 * */
if ( ! function_exists( 'redux_validate_callback_function' ) ) {
    function redux_validate_callback_function( $field, $value, $existing_value ) {
        $error   = false;
        $warning = false;

        //do your validation
        if ( $value == 1 ) {
            $error = true;
            $value = $existing_value;
        } elseif ( $value == 2 ) {
            $warning = true;
            $value   = $existing_value;
        }

        $return['value'] = $value;

        if ( $error == true ) {
            $field['msg']    = 'your custom error message';
            $return['error'] = $field;
        }

        if ( $warning == true ) {
            $field['msg']      = 'your custom warning message';
            $return['warning'] = $field;
        }

        return $return;
    }
}

/**
 * Custom function for the callback referenced above
 */
if ( ! function_exists( 'redux_my_custom_field' ) ) {
    function redux_my_custom_field( $field, $value ) {
        print_r( $field );
        echo '<br/>';
        print_r( $value );
    }
}

/**
 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
 * so you must use get_template_directory_uri() if you want to use any of the built in icons
 * */
if ( ! function_exists( 'dynamic_section' ) ) {
    function dynamic_section( $sections ) {
        //$sections = array();
        $sections[] = array(
            'title'  => __( 'Section via hook', 'cepatlakoo' ),
            'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'cepatlakoo' ),
            'icon'   => 'el el-paper-clip',
            // Leave this as a blank section, no options just some intro text set above.
            'fields' => array()
        );

        return $sections;
    }
}

/**
 * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
 * */
if ( ! function_exists( 'change_arguments' ) ) {
    function change_arguments( $args ) {
        //$args['dev_mode'] = true;

        return $args;
    }
}

/**
 * Filter hook for filtering the default value of any given field. Very useful in development mode.
 * */
if ( ! function_exists( 'change_defaults' ) ) {
    function change_defaults( $defaults ) {
        $defaults['str_replace'] = 'Testing filter hook!';

        return $defaults;
    }
}

/**
 * Removes the demo link and the notice of integrated demo from the redux-framework plugin
 */
if ( ! function_exists( 'remove_demo' ) ) {
    function remove_demo() {
        // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            remove_filter( 'plugin_row_meta', array(
                ReduxFrameworkPlugin::instance(),
                'plugin_metalinks'
            ), null, 2 );

            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
        }
    }
}
