<?php
/**
 * Function to create option in all page with CMB2 metaboxes
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
add_filter( 'cmb2_meta_boxes', 'cepatlakoo_fb_pixel_metaboxes' );
if ( ! function_exists( 'cepatlakoo_fb_pixel_metaboxes') ) {
    function cepatlakoo_fb_pixel_metaboxes( array $meta_boxes ) {
        global $cl_options, $typenow;

        $cepatlakoo_facebook_pixel_id = !empty( $cl_options['cepatlakoo_facebook_pixel_id'] ) ? $cl_options['cepatlakoo_facebook_pixel_id'] : '';
        
        if ($cepatlakoo_facebook_pixel_id){
            $meta_boxes['facebook_settings_metabox'] = array(
                'id'            => 'cepatlakoo_facebook_settings_metabox',
                'title'         => esc_html__( 'Facebook Pixel Settings', 'cepatlakoo' ),
                'object_types'  => array( 'page', 'post', 'product'), // Post type
                'context'       => 'normal',
                'priority'      => 'high',
                'show_names'    => true,
                'fields'        => array(
                    array(
                        'name'    => esc_html__( 'Facebook Pixel Event', 'cepatlakoo' ),
                        'desc'    => esc_html__( 'Note: Main pixel will be loaded in the LAST sequence. This is important to make sure that any button tracking event will be attributed to this main pixel', 'cepatlakoo' ),
                        'id'      => 'cepatlakoo_fbpixel_event',
                        'type'    => 'select',
                        'options' => array(
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
                        ),
                        'default' => 'ViewContent',
                    ),

                    array(
                        'name'    => esc_html__( 'Price', 'cepatlakoo' ),
                        'desc'    => esc_html__( 'This price will be sending to your FB Pixel', 'cepatlakoo' ),
                        'id'      => 'cepatlakoo_pixel_price',
                        'type'    => 'text',
                        'attributes' => array(
                            'data-conditional-id'    => 'cepatlakoo_fbpixel_event',
                            'data-conditional-value' => json_encode(array('AddToCart','InitiateCheckout','Purchase')) ,
                        ),
                    ),

                    array(
                        'name'    => esc_html__( 'Currency', 'cepatlakoo' ),
                        'desc'    => esc_html__( 'This currency will be sending to your FB Pixel', 'cepatlakoo' ),
                        'id'      => 'cepatlakoo_pixel_currency',
                        'type'    => 'select',
                        'options' => array(
                            'ALL' => esc_html__( 'Albania Lek','cepatlakoo' ),
                            'AFN' => esc_html__( 'Afghanistan Afghani','cepatlakoo' ),
                            'ARS' => esc_html__( 'Argentina Peso','cepatlakoo' ),
                            'AWG' => esc_html__( 'Aruba Guilder','cepatlakoo' ),
                            'AUD' => esc_html__( 'Australia Dollar','cepatlakoo' ),
                            'AZN' => esc_html__( 'Azerbaijan New Manat','cepatlakoo' ),
                            'BSD' => esc_html__( 'Bahamas Dollar','cepatlakoo' ),
                            'BBD' => esc_html__( 'Barbados Dollar','cepatlakoo' ),
                            'BDT' => esc_html__( 'Bangladeshi taka','cepatlakoo' ),
                            'BYR' => esc_html__( 'Belarus Ruble','cepatlakoo' ),
                            'BZD' => esc_html__( 'Belize Dollar','cepatlakoo' ),
                            'BMD' => esc_html__( 'Bermuda Dollar','cepatlakoo' ),
                            'BOB' => esc_html__( 'Bolivia Boliviano','cepatlakoo' ),
                            'BAM' => esc_html__( 'Bosnia and Herzegovina Convertible Marka','cepatlakoo' ),
                            'BWP' => esc_html__( 'Botswana Pula','cepatlakoo' ),
                            'BGN' => esc_html__( 'Bulgaria Lev','cepatlakoo' ),
                            'BRL' => esc_html__( 'Brazil Real','cepatlakoo' ),
                            'BND' => esc_html__( 'Brunei Darussalam Dollar','cepatlakoo' ),
                            'KHR' => esc_html__( 'Cambodia Riel','cepatlakoo' ),
                            'CAD' => esc_html__( 'Canada Dollar','cepatlakoo' ),
                            'KYD' => esc_html__( 'Cayman Islands Dollar','cepatlakoo' ),
                            'CLP' => esc_html__( 'Chile Peso','cepatlakoo' ),
                            'CNY' => esc_html__( 'China Yuan Renminbi','cepatlakoo' ),
                            'COP' => esc_html__( 'Colombia Peso','cepatlakoo' ),
                            'CRC' => esc_html__( 'Costa Rica Colon','cepatlakoo' ),
                            'HRK' => esc_html__( 'Croatia Kuna','cepatlakoo' ),
                            'CUP' => esc_html__( 'Cuba Peso','cepatlakoo' ),
                            'CZK' => esc_html__( 'Czech Republic Koruna','cepatlakoo' ),
                            'DKK' => esc_html__( 'Denmark Krone','cepatlakoo' ),
                            'DOP' =>  esc_html__( 'Dominican Republic Peso','cepatlakoo' ),
                            'XCD' => esc_html__( 'East Caribbean Dollar','cepatlakoo' ),
                            'EGP' => esc_html__( 'Egypt Pound','cepatlakoo' ),
                            'SVC' => esc_html__( 'El Salvador Colon','cepatlakoo' ),
                            'EEK' => esc_html__( 'Estonia Kroon','cepatlakoo' ),
                            'EUR' => esc_html__( 'Euro Member Countries','cepatlakoo' ),
                            'FKP' => esc_html__( 'Falkland Islands (Malvinas) Pound','cepatlakoo' ),
                            'FJD' => esc_html__( 'Fiji Dollar','cepatlakoo' ),
                            'GHC' => esc_html__( 'Ghana Cedis','cepatlakoo' ),
                            'GIP' => esc_html__( 'Gibraltar Pound','cepatlakoo' ),
                            'GTQ' => esc_html__( 'Guatemala Quetzal','cepatlakoo' ),
                            'GGP' => esc_html__( 'Guernsey Pound','cepatlakoo' ),
                            'GYD' => esc_html__( 'Guyana Dollar','cepatlakoo' ),
                            'HNL' => esc_html__( 'Honduras Lempira','cepatlakoo' ),
                            'HKD' => esc_html__( 'Hong Kong Dollar','cepatlakoo' ),
                            'HUF' => esc_html__( 'Hungary Forint','cepatlakoo' ),
                            'ISK' => esc_html__( 'Iceland Krona','cepatlakoo' ),
                            'INR' => esc_html__( 'India Rupee','cepatlakoo' ),
                            'IDR' => esc_html__( 'Indonesia Rupiah','cepatlakoo' ),
                            'IRR' => esc_html__( 'Iran Rial','cepatlakoo' ),
                            'IMP' => esc_html__( 'Isle of Man Pound','cepatlakoo' ),
                            'ILS' => esc_html__( 'Israel Shekel','cepatlakoo' ),
                            'JMD' => esc_html__( 'Jamaica Dollar','cepatlakoo' ),
                            'JPY' => esc_html__( 'Japan Yen','cepatlakoo' ),
                            'JEP' => esc_html__( 'Jersey Pound','cepatlakoo' ),
                            'KZT' => esc_html__( 'Kazakhstan Tenge','cepatlakoo' ),
                            'KPW' => esc_html__( 'Korea (North) Won','cepatlakoo' ),
                            'KRW' => esc_html__( 'Korea (South) Won','cepatlakoo' ),
                            'KGS' => esc_html__( 'Kyrgyzstan Som','cepatlakoo' ),
                            'LAK' => esc_html__( 'Laos Kip','cepatlakoo' ),
                            'LVL' => esc_html__( 'Latvia Lat','cepatlakoo' ),
                            'LBP' => esc_html__( 'Lebanon Pound','cepatlakoo' ),
                            'LRD' => esc_html__( 'Liberia Dollar','cepatlakoo' ),
                            'LTL' => esc_html__( 'Lithuania Litas','cepatlakoo' ),
                            'MKD' => esc_html__( 'Macedonia Denar','cepatlakoo' ),
                            'MYR' => esc_html__( 'Malaysia Ringgit','cepatlakoo' ),
                            'MUR' => esc_html__( 'Mauritius Rupee','cepatlakoo' ),
                            'MXN' => esc_html__( 'Mexico Peso','cepatlakoo' ),
                            'MNT' => esc_html__( 'Mongolia Tughrik','cepatlakoo' ),
                            'MZN' => esc_html__( 'Mozambique Metical','cepatlakoo' ),
                            'NAD' => esc_html__( 'Namibia Dollar','cepatlakoo' ),
                            'NPR' => esc_html__( 'Nepal Rupee','cepatlakoo' ),
                            'ANG' => esc_html__( 'Netherlands Antilles Guilder','cepatlakoo' ),
                            'NZD' => esc_html__( 'New Zealand Dollar','cepatlakoo' ),
                            'NIO' => esc_html__( 'Nicaragua Cordoba','cepatlakoo' ),
                            'NGN' => esc_html__( 'Nigeria Naira','cepatlakoo' ),
                            'NOK' => esc_html__( 'Norway Krone','cepatlakoo' ),
                            'OMR' => esc_html__( 'Oman Rial','cepatlakoo' ),
                            'PKR' => esc_html__( 'Pakistan Rupee','cepatlakoo' ),
                            'PAB' => esc_html__( 'Panama Balboa','cepatlakoo' ),
                            'PYG' => esc_html__( 'Paraguay Guarani','cepatlakoo' ),
                            'PEN' => esc_html__( 'Peru Nuevo Sol','cepatlakoo' ),
                            'PHP' => esc_html__( 'Philippines Peso','cepatlakoo' ),
                            'PLN' => esc_html__( 'Poland Zloty','cepatlakoo' ),
                            'QAR' => esc_html__( 'Qatar Riyal','cepatlakoo' ),
                            'RON' => esc_html__( 'Romania New Leu','cepatlakoo' ),
                            'RUB' => esc_html__( 'Russia Ruble','cepatlakoo' ),
                            'SHP' => esc_html__( 'Saint Helena Pound','cepatlakoo' ),
                            'SAR' => esc_html__( 'Saudi Arabia Riyal','cepatlakoo' ),
                            'RSD' => esc_html__( 'Serbia Dinar','cepatlakoo' ),
                            'SCR' => esc_html__( 'Seychelles Rupee','cepatlakoo' ),
                            'SGD' => esc_html__( 'Singapore Dollar','cepatlakoo' ),
                            'SBD' => esc_html__( 'Solomon Islands Dollar','cepatlakoo' ),
                            'SOS' => esc_html__( 'Somalia Shilling','cepatlakoo' ),
                            'ZAR' => esc_html__( 'South Africa Rand','cepatlakoo' ),
                            'LKR' => esc_html__( 'Sri Lanka Rupee','cepatlakoo' ),
                            'SEK' => esc_html__( 'Sweden Krona','cepatlakoo' ),
                            'CHF' => esc_html__( 'Switzerland Franc','cepatlakoo' ),
                            'SRD' => esc_html__( 'Suriname Dollar','cepatlakoo' ),
                            'SYP' => esc_html__( 'Syria Pound','cepatlakoo' ),
                            'TWD' => esc_html__( 'Taiwan New Dollar','cepatlakoo' ),
                            'THB' => esc_html__( 'Thailand Baht','cepatlakoo' ),
                            'TTD' => esc_html__( 'Trinidad and Tobago Dollar','cepatlakoo' ),
                            'TRY' => esc_html__( 'Turkey Lira','cepatlakoo' ),
                            'TRL' => esc_html__( 'Turkey Lira','cepatlakoo' ),
                            'TVD' => esc_html__( 'Tuvalu Dollar','cepatlakoo' ),
                            'UAH' => esc_html__( 'Ukraine Hryvna','cepatlakoo' ),
                            'GBP' => esc_html__( 'United Kingdom Pound','cepatlakoo' ),
                            'USD' => esc_html__( 'United States Dollar','cepatlakoo' ),
                            'UYU' => esc_html__( 'Uruguay Peso','cepatlakoo' ),
                            'UZS' => esc_html__( 'Uzbekistan Som','cepatlakoo' ),
                            'VEF' => esc_html__( 'Venezuela Bolivar','cepatlakoo' ),
                            'VND' => esc_html__( 'Viet Nam Dong','cepatlakoo' ),
                            'YER' => esc_html__( 'Yemen Rial','cepatlakoo' ),
                            'ZWD' => esc_html__( 'Zimbabwe Dollar','cepatlakoo' )
                        ),
                        'default' => 'IDR',
                        'attributes' => array(
                            'data-conditional-id'    => 'cepatlakoo_fbpixel_event',
                            'data-conditional-value' => json_encode(array('AddToCart','InitiateCheckout','Purchase')) ,
                        ),
                    ),
                ),
            );
        }

        return $meta_boxes;
    }
}


add_filter( 'cmb2_meta_boxes', 'cepatlakoo_open_graph_metaboxes' );
if ( ! function_exists( 'cepatlakoo_open_graph_metaboxes') ) {
    function cepatlakoo_open_graph_metaboxes( array $meta_boxes ) {
        global $cl_options;
        $cepatlakoo_open_graph_trigger = !empty( $cl_options['cepatlakoo_open_graph_trigger'] ) ? $cl_options['cepatlakoo_open_graph_trigger'] : '';
 
        if ($cepatlakoo_open_graph_trigger){
            $meta_boxes['opengraph_settings_metabox'] = array(
                'id'            => 'opengraph_settings_metabox',
                'title'         => esc_html__( 'Facebook Sharing (Open Graph) Settings', 'cepatlakoo' ),
                'object_types'  => array( 'post', 'page', 'product'),
                'context'       => 'normal',
                'priority'      => 'default',
                'show_names'    => true,
                'fields'        => array(
                    array(
                        'name'    => esc_html__( 'Facebook Image', 'cepatlakoo' ),
                        'desc'    => esc_html__( 'Upload an image.', 'cepatlakoo' ),
                        'id'      => 'cepatlakoo_facebook_image_og',
                        'type'    => 'file',
                        'options' => array(
                            'url' => false,
                        ),
                        'text'    => array(
                            'add_upload_file_text' => esc_html__( 'Add Image', 'cepatlakoo' ),
                        ),
                        'query_args' => array(
                            'type' => 'application/jpg',
                        ),
                    ),
                    array(
                        'name'    => esc_html__( 'Facebook Title', 'cepatlakoo' ),
                        'id'      => 'cepatlakoo_facebook_title_og',
                        'type'    => 'text',
                        'default' => '',
                    ),
                    array(
                        'name'    => esc_html__( 'Facebook Description', 'cepatlakoo' ),
                        'id'      => 'cepatlakoo_facebook_desc_og',
                        'type'    => 'textarea',
                        'default' => '',
                    ),
                ),
            );
        }

        return $meta_boxes;
    }
}

add_filter( 'cmb2_meta_boxes', 'cepatlakoo_search_engine_optimization' );
if ( ! function_exists( 'cepatlakoo_search_engine_optimization') ) {
    function cepatlakoo_search_engine_optimization( array $meta_boxes ) {
        global $cl_options;
        $cepatlakoo_seo_trigger = !empty( $cl_options['cepatlakoo_seo_trigger'] ) ? $cl_options['cepatlakoo_seo_trigger'] : '';

        if ($cepatlakoo_seo_trigger){
            $meta_boxes['seo_settings_metabox'] = array(
                'id'            => 'seo_settings_metabox',
                'title'         => esc_html__( 'Search Engine Optimization Settings', 'cepatlakoo' ),
                'object_types'  => array( 'post', 'page', 'product'),
                'context'       => 'normal',
                'priority'      => 'default',
                'show_names'    => true,
                'fields'        => array(
                    array(
                        'name'    => esc_html__( 'Turn On SEO Option', 'cepatlakoo' ),
                        'id'      => 'cepatlakoo_trigger_seo',
                        'type'    => 'checkbox',
                        'default' => '0',
                    ),
                    array(
                        'name'    => esc_html__( 'Title', 'cepatlakoo' ),
                        'id'      => 'cepatlakoo_seo_title_text',
                        'type'    => 'text',
                        'default' => '',
                    ),
                    array(
                        'name'    => esc_html__( 'Description', 'cepatlakoo' ),
                        'id'      => 'cepatlakoo_seo_desc',
                        'type'    => 'textarea',
                        'default' => '',
                    ),
                    array(
                        'name'    => esc_html__( 'Keywords', 'cepatlakoo' ),
                        'id'      => 'cepatlakoo_seo_keyword',
                        'type'    => 'textarea',
                        'default' => '',
                    ),
                    array(
                        'name'    => esc_html__( 'Meta Robots Index', 'cepatlakoo' ),
                        'id'      => 'cepatlakoo_seo_robotindex',
                        'type'    => 'select',
                        'options' => array(
                            'index' => esc_html__('Index', 'cepatlakoo'),
                            'noindex' => esc_html__('No Index', 'cepatlakoo'),
                        ),
                    ),
                    array(
                        'name'    => esc_html__( 'Meta Robots Follow', 'cepatlakoo' ),
                        'id'      => 'cepatlakoo_seo_robotfollow',
                        'type'    => 'select',
                        'options' => array(
                            'follow' => esc_html__('Follow','cepatlakoo'),
                            'nofollow' => esc_html__('No Follow','cepatlakoo'),
                        ),
                    ),
                ),
            );
        }
    
        return $meta_boxes;
    }
}

add_filter( 'cmb2_meta_boxes', 'cepatlakoo_product_options_metaboxes' );
if ( ! function_exists( 'cepatlakoo_product_options_metaboxes') ) {
    function cepatlakoo_product_options_metaboxes( array $meta_boxes ) {

        $meta_boxes['product_settings_metabox'] = array(
            'id'            => 'product_settings_metabox',
            'title'         => esc_html__( 'Additional Product Options', 'cepatlakoo' ),
            'object_types'  => array( 'product' ),
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true,
            'fields'        => array(
                array(
                    'name'    => esc_html__( 'Sidebar Options', 'cepatlakoo' ),
                    'id'      => 'cepatlakoo_sidebar_options',
                    'type'    => 'select',
                    'options' => array(
                        '1' => esc_html__('Use Sidebar', 'cepatlakoo'),
                        '2' => esc_html__("Don't Use Sidebar", 'cepatlakoo'),
                    ),
                    'default' => '2',
                ),
                array(
                    'name'    => esc_html__( 'Tab Options', 'cepatlakoo' ),
                    'id'      => 'cepatlakoo_tab_options',
                    'type'    => 'select',
                    'options' => array(
                        '1' => esc_html__('Vertical Tab', 'cepatlakoo'),
                        '2' => esc_html__('Horizontal Tab', 'cepatlakoo'),
                    ),
                    'default' => '2',
                ),
                // array(
                //     'name'    => esc_html__( 'Variation Options', 'cepatlakoo' ),
                //     'id'      => 'cepatlakoo_variation_options',
                //     'type'    => 'select',
                //     'options' => array(
                //         '1' => esc_html__('Use Selectbox', 'cepatlakoo'),
                //         '2' => esc_html__('Use Bullet List', 'cepatlakoo'),
                //     ),
                //     'default' => '1',
                // ),
            ),
        );
        return $meta_boxes;
    }
}

if ( ! function_exists( 'cepatlakoo_get_post_options') ) {
    function cepatlakoo_get_post_options( $query_args ) {
        $args = wp_parse_args( $query_args, array(
            'post_type' => 'cl_countdown_timer',
            'post_status' => 'publish',
            'posts_per_page' => -1
        ) );

        $posts = get_posts( $args );

        $post_options = array();
        if ( $posts ) {
            foreach ( $posts as $post ) {
              $post_options[ $post->ID ] = $post->post_title;
            }
        }
        return $post_options;
    }
}

/**
 * Gets 5 posts for your_post_type and displays them as options
 * @return array An array of options that matches the CMB2 options array
 */
// if ( ! function_exists( 'cepatlakoo_get_post_type_post_options') ) {
//     function cepatlakoo_get_post_type_post_options() {
//         return cepatlakoo_get_post_options( array( 'post_type' => 'cl_countdown_timer', 'post_status' => 'publish' ) );
//     }
// }

add_filter( 'cmb2_meta_boxes', 'cepatlakoo_countdown_timer_metaboxes' );
if ( ! function_exists( 'cepatlakoo_countdown_timer_metaboxes') ) {
    function cepatlakoo_countdown_timer_metaboxes( array $meta_boxes ) {
        $opts = cepatlakoo_get_post_type_post_options();
        $meta_boxes['cl_countdown_timer_settings_metabox'] = array(
            'id'            => 'cl_countdown_timer_settings_metabox',
            'title'         => esc_html__( 'Countdown Timer Settings', 'cepatlakoo' ),
            'object_types'  => array( 'product' ),
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true,
            'fields'        => array(
                array(
                    'name'    => esc_html__( 'Countdown Timer', 'cepatlakoo' ),
                    'id'      => 'cepatlakoo_countdown_timer_opt',
                    'type'    => 'select',
                    'options' => $opts,
                ),
            ),
        );
        return $meta_boxes;
    }
}

add_filter( 'cmb2_meta_boxes', 'cepatlakoo_slideshow' );
if ( ! function_exists( 'cepatlakoo_slideshow') ) {
    function cepatlakoo_slideshow( array $meta_boxes ) {

        $meta_boxes['slideshow_settings_metabox'] = array(
            'id'            => 'slideshow_settings_metabox',
            'title'         => esc_html__( 'Slideshow Settings', 'cepatlakoo' ),
            'object_types'  => array( 'cl_slideshow'),
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true,
            'fields'        => array(
                array(
                    'name'    => esc_html__( 'Choose Slideshow Type', 'cepatlakoo' ),
                    'id'      => 'cepatlakoo_choose_slideshow',
                    'type'    => 'select',
                    'options' => array(
                        'carousel' => esc_html__('Carousel Slideshow','cepatlakoo'),
                        'fullwidth' => esc_html__('Full Width Slideshow','cepatlakoo'),
                    ),
                ),
                array(
                    'name'    => esc_html__( 'Number of item per Slider', 'cepatlakoo' ),
                    'desc'    => esc_html__( 'This is number of item per slider for display', 'cepatlakoo' ),
                    'id'      => 'cepatlakoo_slideshow_item',
                    'type'    => 'select',
                    'options' => array(
                        '3' => esc_html__('3','cepatlakoo'),
                        '4' => esc_html__('4','cepatlakoo'),
                    ),
                    'attributes' => array(
                        'data-conditional-id'    => 'cepatlakoo_choose_slideshow',
                        'data-conditional-value' => 'carousel' ,
                    ),
                ),
                array(
                    'name'    => esc_html__( 'Auto Slide', 'cepatlakoo' ),
                    'desc'    => esc_html__( 'Enable slide to auto play to the next slide.', 'cepatlakoo' ),
                    'id'      => 'cepatlakoo_slideshow_autoplay',
                    'type'    => 'checkbox',
                ),
                array(
                    'name'    => esc_html__( 'Delay', 'cepatlakoo' ),
                    'desc'    => esc_html__( 'Delay in seconds before the slide move the next one.', 'cepatlakoo' ),
                    'id'      => 'cepatlakoo_slideshow_delay',
                    'type'    => 'text_small',
                    'default' => 8,
                    'attributes' => array(
                        'data-conditional-id'    => 'cepatlakoo_slideshow_autoplay',
                        'data-conditional-value' => 'on' ,
                        'type'                   => 'number',
                    ),
                ),
                array(
                    'name'    => esc_html__( 'Looping Auto Slide', 'cepatlakoo' ),
                    'desc'    => esc_html__( 'Slide will restart from the first slide when it reaches the last slide.', 'cepatlakoo' ),
                    'id'      => 'cepatlakoo_slideshow_loop',
                    'type'    => 'checkbox',
                    'attributes' => array(
                        'data-conditional-id'    => 'cepatlakoo_slideshow_autoplay',
                        'data-conditional-value' => 'on' ,
                    ),
                ),
                array(
                    'id'          => 'cepatlakoo_slideshow_image_group',
                    'type'        => 'group',
                    'repeatable'   => true,
                    'description' => esc_html__( 'Slideshow Image Group', 'cepatlakoo' ),
                    'options'     => array(
                        'group_title'   => esc_html__( 'Image {#}', 'cepatlakoo' ),
                        'add_button'    => esc_html__( 'Add Another Image', 'cepatlakoo' ),
                        'remove_button' => esc_html__( 'Remove Image', 'cepatlakoo' ),
                        'sortable'      => true,
                    ),
                    'fields'      => array(
                        array(
                            'name' => esc_html__( 'File Image', 'cepatlakoo' ),
                            'id'   => 'cepatlakoo_slideshow_image',
                            'type' => 'file',
                            'description' => esc_html__( 'Recommended Image Size 396x550 for Carousel Slideshow', 'cepatlakoo' ),
                        ),
                        array(
                            'name'    => esc_html__( 'Enable text & Button', 'cepatlakoo' ),
                            'id'      => 'cepatlakoo_slideshow_enable_text',
                            'type'    => 'checkbox',
                        ),
                            array(
                                'name' => esc_html__( 'Heading', 'cepatlakoo' ),
                                'id'   => 'cepatlakoo_slideshow_heading',
                                'type' => 'text',
                            ),
                            array(
                                'name' => esc_html__( 'Short Description', 'cepatlakoo' ),
                                'id'   => 'cepatlakoo_slideshow_desc',
                                'type' => 'text',
                            ),
                            array(
                                'name' => esc_html__( 'Button Text', 'cepatlakoo' ),
                                'id'   => 'cepatlakoo_slideshow_button_text',
                                'type' => 'text',
                            ),
                            array(
                                'name' => esc_html__( 'Button Url', 'cepatlakoo' ),
                                'id'   => 'cepatlakoo_slideshow_button_url',
                                'type' => 'text',
                            ),
                            array(
                                'name'    => esc_html__( 'Open Link in New Window', 'cepatlakoo' ),
                                'id'      => 'cepatlakoo_slideshow_open_link',
                                'type'    => 'checkbox',
                            ),
                        ),

                    ),
                ),
        );
        return $meta_boxes;
    }
}

add_filter( 'cmb2_meta_boxes', 'cepatlakoo_countdown_timer_opt_metaboxes' );
if ( ! function_exists( 'cepatlakoo_countdown_timer_opt_metaboxes') ) {
    function cepatlakoo_countdown_timer_opt_metaboxes( array $meta_boxes ) {

        $meta_boxes['cl_countdown_timer_opt_settings_metabox'] = array(
            'id'            => 'cl_countdown_timer_opt_settings_metabox',
            'title'         => esc_html__( 'Countdown Timer Settings', 'cepatlakoo' ),
            'object_types'  => array( 'cl_countdown_timer'),
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true,
            'fields'        => array(
                array(
                    'name'    => esc_html__( 'Countdown Type', 'cepatlakoo' ),
                    'id'      => 'cl_countdown_type',
                    'type'    => 'select',
                    'options' => array(
                        'Normal Countdown' => esc_html__('Normal Countdown', 'cepatlakoo'),
                        'Evergreen Countdown' => esc_html__('Evergreen Countdown', 'cepatlakoo'),
                    ),
                ),

                array(
                    'name'    => esc_html__( 'Detection Type', 'cepatlakoo' ),
                    'id'      => 'cl_countdown_detection',
                    'type'    => 'select',
                    'options' => array(
                        'Cookie' => esc_html__('Cookie', 'cepatlakoo'),
                        'IP Address' => esc_html__('IP Address', 'cepatlakoo'),
                    ),
                ),
                array(
                    'name' => esc_html__( 'Day', 'cepatlakoo' ),
                    'id'   => 'cl_countdown_day',
                    'type' => 'text_small',
                ),
                array(
                    'name' => esc_html__( 'Hour', 'cepatlakoo' ),
                    'id'   => 'cl_countdown_hour',
                    'type'    => 'text_small',
                ),

                array(
                    'name' => esc_html__( 'Minute', 'cepatlakoo' ),
                    'id'   => 'cl_countdown_minute',
                    'type'    => 'text_small',
                ),

                array(
                    'name' => esc_html__( 'Second', 'cepatlakoo' ),
                    'id'   => 'cl_countdown_second',
                    'type'    => 'text_small',
                ),

                array(
                    'name' => esc_html__( 'Date', 'cepatlakoo' ),
                    'id'   => 'cl_normal_countdown_date',
                    'type' => 'text_date',
                ),
                array(
                    'name' => esc_html__( 'Hour', 'cepatlakoo' ),
                    'id'   => 'cl_normal_countdown_hour',
                    'type'    => 'text_small',
                ),

                array(
                    'name' => esc_html__( 'Minute', 'cepatlakoo' ),
                    'id'   => 'cl_normal_countdown_minute',
                    'type'    => 'text_small',
                ),

                array(
                    'name' => esc_html__( 'Second', 'cepatlakoo' ),
                    'id'   => 'cl_normal_countdown_second',
                    'type'    => 'text_small',
                ),

                array(
                    'name' => esc_html__( 'Shortcode', 'cepatlakoo' ),
                    'id'   => 'cl_countdown_shortcode',
                    'type' => 'text',
                    'default' => get_post_meta( get_the_ID(), 'cl_countdown_shortcode', true),
                )
            ),
        );
        return $meta_boxes;
    }
}
?>