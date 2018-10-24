<?php
/**
 * Function to remove and add action hook woocommerce
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */

// Add Countdown
add_action( 'cepatlakoo_summary_product_highlight', function(){
    cepatlakoo_set_countdown_scarcity($ct_id = get_the_ID());
}, 23 );
add_action( 'woocommerce_single_product_summary', function(){
    cepatlakoo_set_countdown_scarcity($ct_id = get_the_ID());
}, 25 );

if ( ! function_exists( 'cepatlakoo_init_wc' ) ) {
    function cepatlakoo_init_wc() {
        // Cepatlakoo Custom Ordering
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
        add_action( 'cepatlakoo_before_shop_order', 'woocommerce_catalog_ordering', 30 );
        add_action( 'cepatlakoo_after_shop_order', 'woocommerce_catalog_ordering', 30 );

        // Cepatlakoo Custom Pagination
        remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
        add_action( 'cepatlakoo_before_shop_pagination', 'woocommerce_pagination', 10 );
        add_action( 'cepatlakoo_after_shop_pagination', 'woocommerce_pagination', 10 );

        // Cepatlakoo Custom Rating
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_rating', 100 );

        // Cepatlakoo Before Quick View Hook
        add_action( 'cepatlakoo_before_quick_view', 'woocommerce_show_product_images', 10 );
        add_action( 'cepatlakoo_before_quick_view', 'cepatlakoo_view_full_detail', 15 );

        // Cepatlakoo Quick View Hook
        add_action( 'cepatlakoo_summary_quick_view', 'woocommerce_template_single_title', 5 );
        add_action( 'cepatlakoo_summary_quick_view', 'woocommerce_template_single_rating', 10 );
        add_action( 'cepatlakoo_summary_quick_view', 'woocommerce_template_single_price', 15 );
        // add_action( 'cepatlakoo_summary_quick_view', function(){
        //     cepatlakoo_set_countdown_scarcity($ct_id = get_the_ID(), 'quickview' );
        // }, 23 );

        // Cepatlakoo Single Product Highlight Hook
        add_action( 'cepatlakoo_summary_product_highlight', 'woocommerce_template_single_title', 5 );
        add_action( 'cepatlakoo_summary_product_highlight', 'woocommerce_template_single_rating', 10 );
        add_action( 'cepatlakoo_summary_product_highlight', 'woocommerce_template_single_price', 15 );
        add_action( 'cepatlakoo_summary_product_highlight', 'woocommerce_template_single_excerpt', 20 );
        
        add_action( 'cepatlakoo_summary_product_highlight', 'woocommerce_template_single_add_to_cart', 25 );
        add_action( 'cepatlakoo_summary_product_highlight', 'woocommerce_template_single_meta', 40 );
        add_action( 'cepatlakoo_summary_product_highlight', 'cepatlakoo_social_sharing_product', 50 );

        add_action( 'cepatlakoo_summary_quick_view', 'woocommerce_template_single_add_to_cart', 25 );
        // add_action( 'cepatlakoo_summary_quick_view', 'cepatlakoo_social_sharing_product', 50 );

        // Add Social Sharing to Single Product Page
        add_action( 'woocommerce_single_product_summary', 'cepatlakoo_social_sharing_product', 50 );

        // Cepatlakoo Remove Upsell
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
        add_action( 'cepatlakoo_button_add_cart', 'woocommerce_template_loop_add_to_cart', 10 );

        // Cepatlakoo Panel Hover
        add_action( 'cepatlakoo_panel_addto_cart', 'cepatlakoo_panel_view_add_to_cart', 5 );

        // Cepatlakoo Remove Taxonomy Description
        remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );

        // Add Function to Hook
        add_action( 'cepatlakoo_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
        add_action( 'woocommerce_before_checkout_form', 'cepatlakoo_stepbystep' );
        add_action( 'woocommerce_before_cart', 'cepatlakoo_stepbystep' );

        // Remove Button in Shop v.1.1.1
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');

    }
}
add_filter( 'init', 'cepatlakoo_init_wc' );

/**
 * Function to set full gallery image size
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.2.1
 */
if ( ! function_exists( 'cepatlakoo_gallery_image_size' ) ) {
    function cepatlakoo_gallery_image_size() {
        return 'full';
    }
}
add_filter( 'woocommerce_gallery_image_size', 'cepatlakoo_gallery_image_size' );

/**
 * Function to set 3 column grid of shop page loop
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_loop_columns' ) ) {
    function cepatlakoo_loop_columns() {
        return 3;
    }
}
add_filter( 'loop_shop_columns', 'cepatlakoo_loop_columns' );

/**
 * Function to get 404 url
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.1
 */
if ( ! function_exists( 'cepatlakoo_get_notfound_url' ) ) {
    function cepatlakoo_get_notfound_url() {
        return get_site_url() . '/404/';
    }
}

/**
 * Function to customize woocomerce product search widget
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_custom_product_searchform' ) ) {
    function cepatlakoo_custom_product_searchform( $form ) {
?>
    <div class="search-widget">
        <div class="search-form">
            <form id="search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <div class="input-group">
                    <input type="text" id="s" class="search-field" placeholder="<?php echo esc_html_e( 'Type search product and hit enter...', 'cepatlakoo' ); ?>" value="<?php esc_attr( the_search_query() ); ?>" name="s" />
                    <input type="submit" class="btn regular-btn submit-btn primary-bg">
                    <input type="hidden" name="post_type" value="product" />
                </div>
            </form>
        </div>
    </div>
<?php
    }
}
add_filter( 'get_product_search_form' , 'cepatlakoo_custom_product_searchform' );

/**
 * Function to display cart & profile menu ajax
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 / * Source : https://gaurangdabhi.wordpress.com/2015/07/24/how-to-update-cart-using-ajax-woocommerce/
 */
if ( ! function_exists( 'cepatlakoo_header_add_to_cart_fragment' ) ) {
    function cepatlakoo_header_add_to_cart_fragment( $fragments ) {
        global $woocommerce;
        ob_start();
        if ( class_exists( 'WooCommerce' ) ) :
?>
            <div class="user-carts">
                <span class="cart-counter">
                    <?php if ($woocommerce->cart->cart_contents_count > 0 ) : ?>
                        <i class="icon icon-cart not-empty"></i>
                        <label>
                            <?php echo sprintf(_n(' %d items', ' %d items', $woocommerce->cart->cart_contents_count, 'cepatlakoo'), $woocommerce->cart->cart_contents_count); ?>
                        </label>
                    <?php else: ?>
                        <i class="icon icon-cart"></i>
                        <label>
                            <?php echo sprintf(_n(' %d item', ' %d item', $woocommerce->cart->cart_contents_count, 'cepatlakoo'), $woocommerce->cart->cart_contents_count); ?>
                        </label>
                    <?php endif; ?>
                </span>
            </div>
<?php

        $fragments['div.user-carts'] = ob_get_clean();
        return $fragments;
        endif;
    }
}
add_filter( 'woocommerce_add_to_cart_fragments', 'cepatlakoo_header_add_to_cart_fragment' );

if ( ! function_exists( 'cepatlakoo_sidebar_cart_fragment' ) ) {
    function cepatlakoo_sidebar_cart_fragment( $fragments ) {
        global $woocommerce;
        ob_start();
        if ( class_exists( 'WooCommerce' ) ) :
?>
            <div class="cart-holders">
                <div id="close-cart-overlay" class="close-cart"></div>
                <div id="close-cart-btn" class="close-cart"></div>
                <?php if ($woocommerce->cart->cart_contents_count > 0) : ?>
                    <div class="cart-header"><?php echo sprintf(_n(' %d items in the bag', ' %d items in the bag', $woocommerce->cart->cart_contents_count, 'cepatlakoo'), $woocommerce->cart->cart_contents_count); ?></div>
                <?php else: ?>
                    <div class="cart-header"><?php echo sprintf(_n(' %d item in the bag', ' %d item in the bag', $woocommerce->cart->cart_contents_count, 'cepatlakoo'), $woocommerce->cart->cart_contents_count); ?></div>
                <?php endif; ?>
                <div class="cart-content">
                    <?php woocommerce_mini_cart(); ?>

                    <div class="cart-footer primary-bg">
                        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-btn btn wc-forward"><i class="icon icon-cart"></i> <?php esc_html_e( 'View Cart', 'cepatlakoo' ); ?></a>
                        <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-btn btn heckout wc-forward"><?php esc_html_e( 'Checkout', 'cepatlakoo' ); ?></a>
                    </div>
                </div>
            </div>
<?php
        $fragments['div.cart-holders'] = ob_get_clean();
        return $fragments;
        endif;
    }
}
add_filter( 'woocommerce_add_to_cart_fragments', 'cepatlakoo_sidebar_cart_fragment' );

/**
 * Function to display cart & profile menu
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_display_cart_profile_menu' ) ) {
    function cepatlakoo_display_cart_profile_menu() {
        global $woocommerce, $cl_options;

        $cepatlakoo_cart_option = !empty( $cl_options['cepatlakoo_shoping_cart'] ) ? $cl_options['cepatlakoo_shoping_cart'] : '';

        if ( ! $cepatlakoo_cart_option ) : // shopping cart is disable
            if ( class_exists( 'WooCommerce' ) ) :
?>
                <div class="user-carts">
                    <span class="cart-counter">
                        <?php if ($woocommerce->cart->cart_contents_count > 0 ) : ?>
                            <i class="icon icon-cart"></i>
                            <label>
                                <?php echo sprintf(_n(' %d items', ' %d items', $woocommerce->cart->cart_contents_count, 'cepatlakoo'), $woocommerce->cart->cart_contents_count); ?>
                            </label>
                        <?php else: ?>
                            <i class="icon icon-cart"></i>
                            <label>
                                <?php echo sprintf(_n(' %d item', ' %d item', $woocommerce->cart->cart_contents_count, 'cepatlakoo'), $woocommerce->cart->cart_contents_count); ?>
                            </label>
                        <?php endif; ?>
                    </span>
                </div>
<?php
            endif;
        endif;
?>

<?php
    }
}

/**
 * Function to display fragment cart
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_sidebar_cart_content' ) ) {
    function cepatlakoo_sidebar_cart_content() {
        global $woocommerce;

        ?>
        <?php if ( class_exists( 'WooCommerce' ) ) :  ?>
            <div class="cart-holders">
                <?php if ($woocommerce->cart->cart_contents_count > 0) : ?>
                    <div class="cart-header"><?php echo sprintf(_n(' %d items in the bag', ' %d items in the bag', $woocommerce->cart->cart_contents_count, 'cepatlakoo'), $woocommerce->cart->cart_contents_count); ?></div>
                <?php else: ?>
                    <div class="cart-header"><?php echo sprintf(_n(' %d item in the bag', ' %d item in the bag', $woocommerce->cart->cart_contents_count, 'cepatlakoo'), $woocommerce->cart->cart_contents_count); ?></div>
                <?php endif; ?>
                <div class="cart-content">
                    <?php woocommerce_mini_cart(); ?>
                    <div class="cart-footer primary-bg">
                        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-btn btn wc-forward"><i class="icon icon-cart"></i> <?php esc_html_e( 'View Cart', 'cepatlakoo' ); ?></a>
                        <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-btn btn heckout wc-forward"><?php esc_html_e( 'Checkout', 'cepatlakoo' ); ?></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php
    }
}


/**
 * Function to hide default page title woocommerce
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_hide_page_title' ) ) {
    function cepatlakoo_hide_page_title() {
        return false;
    }
}
add_filter( 'woocommerce_show_page_title' , 'cepatlakoo_hide_page_title' );

/**
 * Function to setup woocommerce page title
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_shop_page_title' ) ) {
    function cepatlakoo_shop_page_title( $page_title ) {
        if ( $page_title ) {
            if ( is_product_category() ){
                global $wp_query;
                $cat = $wp_query->get_queried_object();
                $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
                $image = wp_get_attachment_url( $thumbnail_id );
                echo '<div id="page-title" style="background-image: url('.$image.')">';
                echo '<h2>'. $page_title .'</h2>';
                if ( is_tax( array( 'product_cat', 'product_tag' ) ) && 0 === absint( get_query_var( 'paged' ) ) ) {
                    $description = wc_format_content( term_description() );
                    if ( $description ) {
                        echo '<div class="term-description">' . $description . '</div>';
                    }
                }
                echo '</div>';
            }
        }
    }
}
add_filter( 'woocommerce_page_title', 'cepatlakoo_shop_page_title');

/**
 * Change number of related products on product page
 * Set your own value for 'posts_per_page'
 *
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
//Related products limit
if ( ! function_exists( 'cepatlakoo_related_products_limit' ) ) {
    function cepatlakoo_related_products_limit() {
        global $product, $cepatlakoo_option;
        $orderby = '';
        $columns = $cepatlakoo_option['cepatlakoo_related_product_limit'];
        $related = $product->get_related( $cepatlakoo_option['cepatlakoo_related_product_limit'] );
        $args = array(
            'post_type'           => 'product',
            'no_found_rows'       => 1,
            'posts_per_page'      => $cepatlakoo_option['cepatlakoo_related_product_limit'],
            'ignore_sticky_posts' => 1,
            'orderby'             => $orderby,
            'post__in'            => $related,
            'post__not_in'        => array($product->get_id())
        );
        return $args;
    }
}
add_filter( 'woocommerce_related_products_args', 'cepatlakoo_related_products_limit' );

/**
 * Function to define product image sizes
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_woocommerce_image_dimensions' ) ) {
    function cepatlakoo_woocommerce_image_dimensions() {
        global $pagenow;

        if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
            return;
        }
        $catalog = array(
            'width'     => '300',   // px
            'height'    => '300',   // px
            'crop'      => 1        // true
        );
        $single = array(
            'width'     => '600',   // px
            'height'    => '600',   // px
            'crop'      => 1        // true
        );
        $thumbnail = array(
            'width'     => '180',   // px
            'height'    => '180',   // px
            'crop'      => 1        // true
        );
        // Image sizes
        update_option( 'shop_catalog_image_size', $catalog );       // Product category thumbs
        update_option( 'shop_single_image_size', $single );         // Single product image
        update_option( 'shop_thumbnail_image_size', $thumbnail );   // Image gallery thumbs
    }
}
add_action( 'after_switch_theme', 'cepatlakoo_woocommerce_image_dimensions', 1 );

/**
 * Function to display featured product
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_featured_product' ) ) {
    function cepatlakoo_featured_product() {
?>
        <section id="feature-brands-widget" class="homepage-widget shopping-widget">
            <div class="container fullwidth clearfix">
                <div id="feature-brands">
                    <ul>
                    <?php
                        $args_featured_product = array(
                            'post_type'      => 'product',
                            'post_status'    => 'publish',
                            'order'          => 'DESC',
                            'orderby'        => 'meta_value',
                            'meta_key'       => '_featured',
                            'posts_per_page' => 5
                        );
                        $cepatlakoo_count = 1;

                        $cepatlakoo_featured_product = new WP_Query();
                        $cepatlakoo_featured_product->query( $args_featured_product );

                        if ( $cepatlakoo_featured_product->have_posts() ) :
                            while( $cepatlakoo_featured_product->have_posts() ) : $cepatlakoo_featured_product->the_post();
                    ?>
                            <li>
                                <div class="thumbnail">
                                <?php
                                    if ( $cepatlakoo_count == 1 ){
                                        the_post_thumbnail( 'cepatlakoo-featured-post-big', array( 'alt' => get_the_title(), 'title' => get_the_title() ) );
                                    } else {
                                        the_post_thumbnail( 'cepatlakoo-featured-post', array( 'alt' => get_the_title(), 'title' => get_the_title() ) );
                                    }
                                ?>
                                </div>
                                <div class="detail">
                                    <div class="table">
                                        <div class="tablecell">
                                            <div class="brand-wrap">
                                                <h3><a href="<?php the_permalink(); ?>" class="brand-icon"><?php the_title(); ?></a></h3>
                                                <a href="<?php the_permalink(); ?>" class="btn regular-btn no-fill-btn"><?php esc_html_e( 'Shop now','cepatlakoo' ); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="overlay-link" href="<?php the_permalink(); ?>"></a>
                                </div>
                            </li>
                    <?php
                            $cepatlakoo_count++;
                            endwhile;;
                        endif;

                        wp_reset_postdata();
                    ?>
                    </ul>
                </div>
            </div>
        </section>
<?php
    }
}

/**
 * Function to display button View Full Details
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_view_full_detail' ) ) {
    function cepatlakoo_view_full_detail() { ?>
        <p class="buttons">
            <a href="<?php the_permalink(); ?>" class="button checkout wc-forward"><?php esc_html_e( 'View Full Details', 'cepatlakoo' ); ?></a>
        </p>
<?php
    }
}

/**
 * Function to display cepatlakoo single style
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( !function_exists( 'cepatlakoo_single_style') ) {
    function cepatlakoo_single_style( $id ) {
        global $cl_options;

        $cepatlakoo_single_sidebar_opt = !empty( $cl_options['cepatlakoo_single_sidebar_opt'] ) ? $cl_options['cepatlakoo_single_sidebar_opt'] : '';

        $cepatlakoo_sidebar_options = ! empty( get_post_meta(get_the_ID(), 'cepatlakoo_sidebar_options', true ) ) ? esc_attr(get_post_meta(get_the_ID(), 'cepatlakoo_sidebar_options', true )) : '1';

        if ( !empty( $cepatlakoo_single_sidebar_opt ) || $cepatlakoo_single_sidebar_opt == 0 ) :
            if ( $cepatlakoo_single_sidebar_opt == 0 ) :
                if ( $cepatlakoo_sidebar_options == 1 ) :
                    get_sidebar( 'woocommerce-detail' );
                    add_filter( 'woocommerce_output_related_products_args', 'cepatlakoo_related_products_count' );
                    function cepatlakoo_related_products_count( $args ) {
                        $args['posts_per_page'] = 3;
                        $args['columns'] = 3;
                        return $args;
                    }
                    ?>
                    <div id="contentarea">
                        <div id="products-area">
                            <div class="product-content-area">
                                <div class="product-list">
                                <?php
                                    if ( have_posts() ) {
                                        woocommerce_content();
                                    } else {
                                        echo '<p>';
                                        esc_html_e( 'The page you\'re looking for is not available. The page may have been deleted or unpublished.', 'cepatlakoo' );
                                        echo '</p>';
                                    }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
<?php
                elseif ( $cepatlakoo_sidebar_options == 2 ): ?>
                    <div class="no-sidebar">
                        <div id="products-area">
                            <div class="product-content-area">
                                <div class="product-list">
                                <?php
                                    if ( have_posts() ) {
                                        woocommerce_content();
                                    } else {
                                        echo '<p>';
                                        esc_html_e( 'The page you\'re looking for is not available. The page may have been deleted or unpublished.', 'cepatlakoo' );
                                        echo '</p>';
                                    }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
<?php
                endif;
            elseif ( $cepatlakoo_single_sidebar_opt == 1 ) :// With Sidebar
                get_sidebar( 'woocommerce-detail' );
                add_filter( 'woocommerce_output_related_products_args', 'cepatlakoo_related_products_count' );
                function cepatlakoo_related_products_count( $args ) {
                    $args['posts_per_page'] = 3;
                    $args['columns'] = 3;
                    return $args;
                }
            ?>
                <div id="contentarea">
                    <div id="products-area">
                        <div class="product-content-area">
                            <div class="product-list">
                            <?php
                                if ( have_posts() ) {
                                    woocommerce_content();
                                } else {
                                    echo '<p>';
                                    esc_html_e( 'The page you\'re looking for is not available. The page may have been deleted or unpublished.', 'cepatlakoo' );
                                    echo '</p>';
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
<?php
            elseif ( $cepatlakoo_single_sidebar_opt == 2 ) : // Without SIidebar
?>
                <div class="no-sidebar">
                    <div id="products-area">
                        <div class="product-content-area">
                            <div class="product-list">
                            <?php
                                if ( have_posts() ) {
                                    woocommerce_content();
                                } else {
                                    echo '<p>';
                                    esc_html_e( 'The page you\'re looking for is not available. The page may have been deleted or unpublished.', 'cepatlakoo' );
                                    echo '</p>';
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
<?php
            endif;
        else :
            get_sidebar( 'woocommerce-detail' );
            add_filter( 'woocommerce_output_related_products_args', 'cepatlakoo_related_products_count' );
            function cepatlakoo_related_products_count( $args ) {
                 $args['posts_per_page'] = 3;
                 $args['columns'] = 3;
                 return $args;
            }
?>
            <div id="contentarea">
                <div id="products-area">
                    <div class="product-content-area">
                        <div class="product-list">
                        <?php
                            if ( have_posts() ) {
                                woocommerce_content();
                            } else {
                                echo '<p>';
                                esc_html_e( 'The page you\'re looking for is not available. The page may have been deleted or unpublished.', 'cepatlakoo' );
                                echo '</p>';
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
<?php
        endif;
    }
}

/**
 * Function to display add to cart ajax in quick view
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_quick_view_add_to_cart' ) ) {
    function cepatlakoo_quick_view_add_to_cart() {
        global $product;

        do_action( 'woocommerce_before_add_to_cart_form' );

        /**
         * @since 3.0.0.
         */
        do_action( 'woocommerce_before_add_to_cart_quantity' );

        // Quantity
        if ( ! $product->is_sold_individually() && ! $product->is_type( 'variable' ) ) {
            woocommerce_quantity_input( array(
                'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
                'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product ),
                'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 )
            ) );
        }

        /**
         * @since 3.0.0.
         */
        do_action( 'woocommerce_after_add_to_cart_quantity' );

        // Button
        if ( $product->is_type( 'simple' ) ) { // Single Type Product
            echo apply_filters( 'woocommerce_loop_add_to_cart_link',
            sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
                esc_url( $product->add_to_cart_url() ),
                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                esc_attr( $product->get_id() ),
                esc_attr( $product->get_sku() ),
                esc_attr( isset( $class ) ? $class : 'add_to_cart_button ajax_add_to_cart' ),
                esc_html( $product->add_to_cart_text() )
            ),$product );
        } elseif ( $product->is_type( 'grouped' ) ) { // Variable Type Product
            echo '<a href="'. esc_url( $product->get_product_url() ) .'" rel="nofollow" class="single_add_to_cart_button button alt">'. esc_html( $product->get_button_text() ) .'</a>';
        } elseif ( $product->is_type( 'external' ) ) { // External Type Product
            echo '<a href="'. esc_url( $product->get_product_url() ) .'" rel="nofollow" class="single_add_to_cart_button button alt">';
                if($product->get_button_text()){
                    esc_html_e( $product->get_button_text() );
                }else{
                    esc_html_e( 'Buy Product', 'cepatlakoo' );
                }
            echo '</a>';
        } else { // Else Product Type
            echo apply_filters( 'woocommerce_loop_add_to_cart_link',
            sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
                esc_url( $product->add_to_cart_url() ),
                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                esc_attr( $product->get_id() ),
                esc_attr( $product->get_sku() ),
                esc_attr( isset( $class ) ? $class : 'add_to_cart_button' ),
                esc_html( $product->add_to_cart_text() )
            ),$product );
        }

        do_action( 'woocommerce_after_add_to_cart_form' );
    }
}

/**
 * Function to display panel hover
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_panel_view_add_to_cart') ) {
    function cepatlakoo_panel_view_add_to_cart() {
       global $product;
       ?>
            <a href="<?php echo esc_url( get_template_directory_uri() ) . '/includes/quick-view.php' ?>" onclick="return false;" class="quick-view-btn cepatlakoo-ajax-quick-view" data-product="<?php echo $product->get_id() ?>"  title="<?php esc_html_e( 'Quick view product', 'woocommerce' ); ?>"><?php esc_html_e( 'Quick view', 'woocommerce' ); ?></a>
        <?php
    }
}

/**
 * Function to display social sharing product
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_social_sharing_product') ) {
    function cepatlakoo_social_sharing_product() {
?>
    <div class="social-sharing">
        <ul>
            <li class="facebook"><a title="<?php esc_html_e( 'Facebook Share', 'cepatlakoo' ); ?>" target="_blank" href="<?php echo esc_url( 'https://www.facebook.com/sharer.php?u=' . urlencode( get_permalink( get_the_ID() ) )); ?>&amp;t=<?php echo str_replace( ' ', '%20', get_the_title() ); ?>"><i class="icon icon-facebook"></i></a></li>
            <li class="twitter"><a title="<?php esc_html_e( 'Twitter Share', 'cepatlakoo' ); ?>" target="_blank" href="<?php echo esc_url( 'http://twitter.com/share?url='. urlencode(get_permalink( get_the_ID() ))); ?>&amp;text=<?php echo str_replace( ' ', '%20', get_the_title() ); ?>&count=horizontal"><i class="icon icon-twitter"></i></a></li>
            <li class="pinterest"><?php $cepatlakoo_pinterestimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); ?><a title="<?php esc_html_e( 'Pinterest Share', 'cepatlakoo' ); ?>" target="_blank" href="<?php echo esc_url( 'http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink( get_the_ID() ) ) ); ?>&media=<?php echo esc_url($cepatlakoo_pinterestimage[0]); ?>&description=<?php echo str_replace( ' ', '%20', get_the_title() ); ?>" count-layout="vertical"><i class="icon icon-pinterest"></i></a>
            </li>
            <li class="gplus"><a title="<?php esc_html_e( 'Google Plus Share', 'cepatlakoo' ); ?>" target="_blank" href="<?php echo esc_url( 'https://plus.google.com/share?url='. urlencode(get_permalink( get_the_ID() ))); ?>&amp;text=<?php echo str_replace( ' ', '%20', get_the_title() ); ?>"><i class="icon icon-google-plus"></i></a></li>
        </ul>
    </div>
<?php
    }
}

/**
 * Function to get custom image size
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_get_product_thumbnail' ) ) {
    function cepatlakoo_get_product_thumbnail( $size = 'large' ) {
        global $post, $woocommerce;
        $output = '<div class="col-lg-4">';
            if ( has_post_thumbnail() ) {
                $output .= get_the_post_thumbnail( $post->ID, $size );
            } else {
                $output .= wc_placeholder_img( $size );
            }
        $output .= '</div>';
        return $output;
    }
}

if ( !function_exists( 'cepatlakoo_cart_custom_button') ) {
    function cepatlakoo_cart_custom_button() {
        global $cl_options;

        $cepatlakoo_cart_option = !empty( $cl_options['cepatlakoo_shoping_cart'] ) ? $cl_options['cepatlakoo_shoping_cart'] : '';
        $cepatlakoo_cart_bbm = !empty( $cl_options['cepatlakoo_cart_bbm'] ) ? $cl_options['cepatlakoo_cart_bbm'] : '';
        $cepatlakoo_cart_bbm_text = !empty( $cl_options['cepatlakoo_cart_bbm_text'] ) ? $cl_options['cepatlakoo_cart_bbm_text'] : '';
        $cepatlakoo_cart_bbm_event = !empty( $cl_options['cepatlakoo_cart_bbm_event'] ) ? $cl_options['cepatlakoo_cart_bbm_event'] : '';
        $cepatlakoo_cart_wa = !empty( $cl_options['cepatlakoo_cart_wa'] ) ? $cl_options['cepatlakoo_cart_wa'] : '';
        $cepatlakoo_cart_wa_text = !empty( $cl_options['cepatlakoo_cart_wa_text'] ) ? $cl_options['cepatlakoo_cart_wa_text'] : '';
        $cepatlakoo_cart_wa_message = !empty( $cl_options['cepatlakoo_cart_wa_message'] ) ? $cl_options['cepatlakoo_cart_wa_message'] : '';
        $cepatlakoo_cart_wa_event = !empty( $cl_options['cepatlakoo_cart_wa_event'] ) ? $cl_options['cepatlakoo_cart_wa_event'] : '';
        $cepatlakoo_cart_sms = !empty( $cl_options['cepatlakoo_cart_sms'] ) ? $cl_options['cepatlakoo_cart_sms'] : '';
        $cepatlakoo_cart_sms_message = !empty( $cl_options['cepatlakoo_cart_sms_message'] ) ? $cl_options['cepatlakoo_cart_sms_message'] : '';
        $cepatlakoo_cart_sms_text = !empty( $cl_options['cepatlakoo_cart_sms_text'] ) ? $cl_options['cepatlakoo_cart_sms_text'] : '';
        $cepatlakoo_cart_sms_event = !empty( $cl_options['cepatlakoo_cart_sms_event'] ) ? $cl_options['cepatlakoo_cart_sms_event'] : '';
        $cepatlakoo_cart_line = !empty( $cl_options['cepatlakoo_cart_line'] ) ? $cl_options['cepatlakoo_cart_line'] : '';
        $cepatlakoo_cart_line_text = !empty( $cl_options['cepatlakoo_cart_line_text'] ) ? $cl_options['cepatlakoo_cart_line_text'] : '';
        $cepatlakoo_cart_line_event = !empty( $cl_options['cepatlakoo_cart_line_event'] ) ? $cl_options['cepatlakoo_cart_line_event'] : '';
        $cepatlakoo_cart_phone = !empty( $cl_options['cepatlakoo_cart_phone'] ) ? $cl_options['cepatlakoo_cart_phone'] : '';
        $cepatlakoo_cart_phone_text = !empty( $cl_options['cepatlakoo_cart_phone_text'] ) ? $cl_options['cepatlakoo_cart_phone_text'] : '';
        $cepatlakoo_cart_phone_event = !empty( $cl_options['cepatlakoo_cart_phone_event'] ) ? $cl_options['cepatlakoo_cart_phone_event'] : '';
        $cepatlakoo_cart_telegram = !empty( $cl_options['cepatlakoo_cart_telegram'] ) ? $cl_options['cepatlakoo_cart_telegram'] : '';
        $cepatlakoo_cart_telegram_text = !empty( $cl_options['cepatlakoo_cart_telegram_text'] ) ? $cl_options['cepatlakoo_cart_telegram_text'] : '';
        $cepatlakoo_cart_telegram_event = !empty( $cl_options['cepatlakoo_cart_telegram_event'] ) ? $cl_options['cepatlakoo_cart_telegram_event'] : '';
        $cepatlakoo_cart_message = !empty( $cl_options['cepatlakoo_message_above_contact'] ) ? $cl_options['cepatlakoo_message_above_contact'] : '';
        $cepatlakoo_contact_button_larger = !empty( $cl_options['cepatlakoo_contact_button_larger'] ) ? $cl_options['cepatlakoo_contact_button_larger'] : '';
        $cepatlakoo_message_popup_heading = !empty( $cl_options['cepatlakoo_message_popup_heading'] ) ? $cl_options['cepatlakoo_message_popup_heading'] : '';
        $cepatlakoo_contact_button_message = !empty( $cl_options['cepatlakoo_message_popup'] ) ? $cl_options['cepatlakoo_message_popup'] : '';
        $cepatlakoo_sticky_button_trigger = !empty( $cl_options['cepatlakoo_sticky_button_trigger'] ) ? $cl_options['cepatlakoo_sticky_button_trigger'] : '';

        $product_name = get_the_title( get_the_ID() );
        $product_url = urlencode( get_permalink( get_the_ID() ) );
        $cepatlakoo_cart_wa_message = str_replace( '%lakoo_product_name%', $product_name, $cepatlakoo_cart_wa_message);
        $cepatlakoo_cart_wa_message = str_replace( '%lakoo_product_url%', $product_url, $cepatlakoo_cart_wa_message);
        $cepatlakoo_cart_wa_message = cepatlakoo_replace_hexcode( $cepatlakoo_cart_wa_message );

        $cepatlakoo_cart_sms_message = str_replace( '%lakoo_product_name%', $product_name, $cepatlakoo_cart_sms_message);
        $cepatlakoo_cart_sms_message = str_replace( '%lakoo_product_url%', $product_url, $cepatlakoo_cart_sms_message);
        $cepatlakoo_cart_sms_message = cepatlakoo_replace_hexcode( $cepatlakoo_cart_sms_message );

        if (is_singular('product')) {
        $style = '';

        // cepatlakoo_set_countdown_scarcity($ct_id = get_the_ID());
?>
        <div class="quick-contact-info <?php echo ( $cepatlakoo_sticky_button_trigger && wp_is_mobile() ) ? 'sticky-button' : ''; ?>">
        

            <?php if( $cepatlakoo_cart_message ) : ?>
                <p class="contact-message"><?php echo $cepatlakoo_cart_message; ?></p>
            <?php endif; ?>
            
            <?php if ($cepatlakoo_cart_wa) : ?>
                <?php
                    if( is_array($cepatlakoo_cart_wa) ) {
                        $cepatlakoo_cart_wa = $cepatlakoo_cart_wa[array_rand($cepatlakoo_cart_wa)];
                    }

                    if($cepatlakoo_cart_wa) {
                        if ( preg_match('[^\+62]', $cepatlakoo_cart_wa ) ) {
                            $cepatlakoo_cart_wa = str_replace('+62', '62', $cepatlakoo_cart_wa);
                        }else if ( $cepatlakoo_cart_wa[0] == '0' ) {
                            $cepatlakoo_cart_wa = ltrim( $cepatlakoo_cart_wa, '0' );
                            $cepatlakoo_cart_wa = '62'. $cepatlakoo_cart_wa;
                        }else if ( $cepatlakoo_cart_wa[0] == '8' ) {
                            $cepatlakoo_cart_wa = '62'. $cepatlakoo_cart_wa;
                        } else {
                           $cepatlakoo_cart_wa = $cepatlakoo_cart_wa;
                        }
                    }
                ?>
                    <a <?php echo $style ?> fb-pixel="<?php echo $cepatlakoo_cart_wa_event; ?>" href="https://api.whatsapp.com/send?l=id&phone=<?php echo $cepatlakoo_cart_wa; ?>&text=<?php echo esc_attr($cepatlakoo_cart_wa_message); ?>" class="whatsapp">
                        <img src="<?php echo get_template_directory_uri() ?>/images/whatsapp-icon-a.svg"><?php echo $cepatlakoo_cart_wa_text; ?>
                    </a>
            <?php endif; ?>

            <?php if ($cepatlakoo_cart_bbm) : ?>
                <?php if ( wp_is_mobile() ) : ?>
                    <a <?php echo $style ?> fb-pixel="<?php echo $cepatlakoo_cart_bbm_event; ?>" href="bbmi://<?php echo $cepatlakoo_cart_bbm ?>" class="blackberry" >
                        <img src="<?php echo get_template_directory_uri() ?>/images/bbm-icon-a.svg"><?php echo $cepatlakoo_cart_bbm_text; ?>
                    </a>
                <?php else : ?>
                    <a <?php echo $style; ?> fb-pixel="<?php echo $cepatlakoo_cart_bbm_event; ?>" href="#" class="blackberry" data-open="data-lightbox-bbm"><img src="<?php echo get_template_directory_uri(); ?>/images/bbm-icon-a.svg"><?php echo $cepatlakoo_cart_bbm_text; ?></a>
                    <div id="data-lightbox-bbm" class="reveal" data-reveal>
                        <h2 id="modalTitle" class="header"><?php echo $cepatlakoo_message_popup_heading; ?></h2>
                        <p>
                        <?php
                            $cepatlakoo_lightbox_message = str_replace("[contact_app]","BBM", $cepatlakoo_contact_button_message);
                            $cepatlakoo_lightbox_final_message = str_replace("[contact_id]", $cepatlakoo_cart_bbm, $cepatlakoo_lightbox_message);
                            esc_attr_e($cepatlakoo_lightbox_final_message);
                        ?>
                        </p>
                        <a class="close-button close-reveal-modal" data-close>&#215;</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($cepatlakoo_cart_sms) : ?>
                <?php
                    if( is_array($cepatlakoo_cart_sms)){
                        $cepatlakoo_cart_sms = $cepatlakoo_cart_sms[array_rand($cepatlakoo_cart_sms)];
                    }
                ?>
                <?php if ( wp_is_mobile() ) : ?>
                    <a <?php echo $style ?> fb-pixel="<?php echo $cepatlakoo_cart_sms_event; ?>" href="sms:<?php echo $cepatlakoo_cart_sms ?>?body=<?php echo $cepatlakoo_cart_sms_message; ?>" class="sms" >
                        <img src="<?php echo get_template_directory_uri() ?>/images/sms-icon-a.svg"><?php echo $cepatlakoo_cart_sms_text; ?>
                    </a>
                <?php else : ?>
                    <a <?php echo $style; ?> fb-pixel="<?php echo $cepatlakoo_cart_sms_event; ?>" href="#" class="sms reveal-link" data-open="data-lightbox-sms"><img src="<?php echo get_template_directory_uri(); ?>/images/sms-icon-a.svg"><?php echo $cepatlakoo_cart_sms_text; ?></a>

                    <div id="data-lightbox-sms" class="reveal" data-reveal>
                        <h2 id="modalTitle" class="header"><?php echo $cepatlakoo_message_popup_heading; ?></h2>
                        <p>
                        <?php
                            $cepatlakoo_lightbox_message = str_replace("[contact_app]","SMS", $cepatlakoo_contact_button_message);
                            $cepatlakoo_lightbox_final_message = str_replace("[contact_id]", $cepatlakoo_cart_sms, $cepatlakoo_lightbox_message);
                            esc_attr_e($cepatlakoo_lightbox_final_message);
                        ?>
                        </p>
                        <a class="close-button close-reveal-modal" data-close>&#215;</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($cepatlakoo_cart_line) : ?>
                <?php
                    if( is_array($cepatlakoo_cart_line)){
                        $cepatlakoo_cart_line = $cepatlakoo_cart_line[array_rand($cepatlakoo_cart_line)];
                    }
                ?>
                <?php if ( wp_is_mobile() ) : ?>
                    <a <?php echo $style ?> fb-pixel="<?php echo $cepatlakoo_cart_line_event; ?>" href="line://ti/p/~<?php echo $cepatlakoo_cart_line; ?>" class="line">
                        <img src="<?php echo get_template_directory_uri() ?>/images/line-icon-a.svg"><?php echo $cepatlakoo_cart_line_text; ?>
                    </a>
                <?php else : ?>
                    <a <?php echo $style; ?> fb-pixel="<?php echo $cepatlakoo_cart_line_event; ?>" href="#" class="line" data-open="data-lightbox-line"><img src="<?php echo get_template_directory_uri(); ?>/images/line-icon-a.svg"><?php echo $cepatlakoo_cart_line_text; ?></a>

                    <div id="data-lightbox-line" class="reveal" data-reveal>
                        <h2 id="modalTitle" class="header"><?php echo $cepatlakoo_message_popup_heading; ?></h2>
                        <p>
                        <?php
                            $cepatlakoo_lightbox_message = str_replace("[contact_app]","LINE", $cepatlakoo_contact_button_message);
                            $cepatlakoo_lightbox_final_message = str_replace("[contact_id]", $cepatlakoo_cart_line, $cepatlakoo_lightbox_message);
                            esc_attr_e($cepatlakoo_lightbox_final_message);
                        ?>
                        </p>
                        <a class="close-button close-reveal-modal" data-close>&#215;</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($cepatlakoo_cart_phone) : ?>
                <?php
                    if( is_array($cepatlakoo_cart_phone)){
                        $cepatlakoo_cart_phone = $cepatlakoo_cart_phone[array_rand($cepatlakoo_cart_phone)];
                    }
                ?>
                <?php if ( wp_is_mobile() ) : ?>
                    <a <?php echo $style ?> fb-pixel="<?php echo $cepatlakoo_cart_phone_event; ?>" href="tel:<?php echo $cepatlakoo_cart_phone ?>" class="phone" >
                        <img src="<?php echo get_template_directory_uri() ?>/images/phone-icon-a.svg"><?php echo $cepatlakoo_cart_phone_text; ?>
                    </a>
                <?php else : ?>
                    <a <?php echo $style; ?> fb-pixel="<?php echo $cepatlakoo_cart_phone_event; ?>" href="#" class="phone" data-open="data-lightbox-tel"><img src="<?php echo get_template_directory_uri(); ?>/images/phone-icon-a.svg"><?php echo $cepatlakoo_cart_phone_text; ?></a>

                    <div id="data-lightbox-tel" class="reveal" data-reveal>
                        <h2 id="modalTitle" class="header"><?php echo $cepatlakoo_message_popup_heading; ?></h2>
                        <p>
                            <?php
                                $cepatlakoo_lightbox_message = str_replace("[contact_app]","Phone", $cepatlakoo_contact_button_message);
                                $cepatlakoo_lightbox_final_message = str_replace("[contact_id]", $cepatlakoo_cart_phone, $cepatlakoo_lightbox_message);
                                esc_attr_e($cepatlakoo_lightbox_final_message);
                            ?>
                        </p>
                        <a class="close-button close-reveal-modal" data-close>&#215;</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($cepatlakoo_cart_telegram) : ?>
                <?php
                    if( is_array($cepatlakoo_cart_telegram)){
                        $cepatlakoo_cart_telegram = $cepatlakoo_cart_telegram[array_rand($cepatlakoo_cart_telegram)];
                    }
                ?>
                <a <?php echo $style; ?>  fb-pixel="<?php echo $cepatlakoo_cart_telegram_event; ?>" href="https://t.me/<?php echo $cepatlakoo_cart_telegram; ?>" class="telegram">
                    <img src="<?php echo get_template_directory_uri() ?>/images/telegram-icon-a.svg"><?php echo $cepatlakoo_cart_telegram_text; ?>
                </a>
            <?php endif; ?>
        </div>
<?php
        }
    }
}

/**
 * Function to Set Option in Init
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( !function_exists( 'cepatlakoo_init_base') ) {
    function cepatlakoo_init_base() {
        global $cl_options;

        $cepatlakoo_cart_option = !empty( $cl_options['cepatlakoo_shoping_cart'] ) ? $cl_options['cepatlakoo_shoping_cart'] : '';
        $cepatlakoo_contact_button_trigger = !empty( $cl_options['cepatlakoo_contact_button_trigger'] ) ? $cl_options['cepatlakoo_contact_button_trigger'] : '';
        $cepatlakoo_quickview_product_description = !empty( $cl_options['cepatlakoo_quickview_product_description'] ) ? $cl_options['cepatlakoo_quickview_product_description'] : '';
        $cepatlakoo_quickview_product_catergoryandtag = !empty( $cl_options['cepatlakoo_quickview_product_catergoryandtag'] ) ? $cl_options['cepatlakoo_quickview_product_catergoryandtag'] : '';

        if ( $cepatlakoo_cart_option ) { // checked
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
            remove_action( 'cepatlakoo_summary_quick_view', 'woocommerce_template_single_add_to_cart', 25);
            remove_action( 'cepatlakoo_summary_quick_view', 'cepatlakoo_quick_view_add_to_cart', 30);
            remove_action( 'cepatlakoo_summary_product_highlight', 'cepatlakoo_quick_view_add_to_cart', 30);

            update_option( 'woocommerce_cart_redirect_after_add', 'no' );
            update_option( 'woocommerce_enable_ajax_add_to_cart', 'no' );

            add_action( 'template_redirect', function() {
                if ( is_checkout() || is_cart() ) {
                    wp_redirect( cepatlakoo_get_notfound_url(), '301' );
                    exit;
                } else {
                    return;
                }
            } );

            remove_action( 'init', 'woocommerce_add_to_cart_action', 10);
            remove_action( 'init', 'woocommerce_checkout_action', 10 );
            remove_action( 'init', 'woocommerce_pay_action', 10 );

            add_filter( 'woocommerce_before_cart', function(){
                return 'cabbbss';
            } );
        } else {
            update_option( 'woocommerce_enable_ajax_add_to_cart', 'yes' );
        }

        if( $cepatlakoo_contact_button_trigger ) {
            add_action( 'woocommerce_single_product_summary', 'cepatlakoo_cart_custom_button', 30 );
        }

        if( $cepatlakoo_quickview_product_description ) {
            add_action( 'cepatlakoo_summary_quick_view', 'woocommerce_template_single_excerpt', 20 );
        }

        if( $cepatlakoo_quickview_product_catergoryandtag ) {
            add_action( 'cepatlakoo_summary_quick_view', 'woocommerce_template_single_meta', 40 );
        }
    }
}
add_action('init','cepatlakoo_init_base');

/**
 * Function to Check Current Version Woocommerce
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( !function_exists( 'cepatlakoo_check_version_threshold') ) {
    function cepatlakoo_check_version_threshold() {
        global $woocommerce;
        if ( version_compare( $woocommerce->version, '3.0.0', ">=" )) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Function to get the id from woocommerce
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_WC_ID') ) {
    function cepatlakoo_WC_ID(){
        if (is_shop()) {
            $wc_id = get_option( 'woocommerce_shop_page_id' );
        } elseif (is_cart()) {
            $wc_id = get_option( 'woocommerce_cart_page_id' );
        } elseif (is_checkout()) {
            $wc_id = get_option( 'woocommerce_checkout_page_id' );
        } elseif (is_wc_endpoint_url( 'order-pay' )) {
            $wc_id = get_option( 'woocommerce_pay_page_id' );
        } elseif (is_wc_endpoint_url( 'order-received')) {
            $wc_id = get_option( 'woocommerce_thanks_page_id' );
        } elseif (is_wc_endpoint_url( 'edit-address')) {
            $wc_id = get_option( 'woocommerce_edit_address_page_id' );
        } elseif (is_wc_endpoint_url( 'view-order')) {
            $wc_id = get_option( 'woocommerce_view_order_page_id' );
        } elseif (is_account_page()) {
            $wc_id = get_option( 'woocommerce_myaccount_page_id' );
        } else {
            $wc_id = get_the_ID();
        }

        return $wc_id;
    }
}

/**
 * Function to Add to cart by AJAX
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_add_tocart_product') ) {
    function cepatlakoo_add_tocart_product() {
        $product_id = sanitize_text_field( $_POST['product_id'] );
        $variation_id = sanitize_text_field( $_POST['variation_id'] );
        $variation = sanitize_text_field( $_POST['variation_data'] );
        $submit_type = sanitize_text_field( $_POST['submit_type'] );
        $data_product = $_POST['data_product'];

        $variations = explode(",", $variation);
        $attr = array();
        $val = array();
        foreach($variations as $k=>$v){
            if( $k % 2 == 0 ) {
                array_push($attr,$v);
            }else{
                array_push($val,$v);
            }
        }
        $list = array_combine($attr, $val);

        $quantity = absint( $_POST['quantity'] );
        global $woocommerce;

        if ($variation_id) {
            WC()->cart->add_to_cart( $product_id, $quantity, wc_get_product_variation_attributes( $variation_id ), $list );
        } else {
            if( $submit_type == 'multiple' ){
                $data_product = explode(",",$data_product);
                foreach ($data_product as $key => $value) {
                    $data_val = explode("q",$value);
                    WC()->cart->add_to_cart( $data_val[0], $data_val[1]);
                }
            }else{
                WC()->cart->add_to_cart( $product_id, $quantity);
            }
        }

        wp_die();
    };
};
add_action('wp_ajax_cepatlakoo_wc_add_cart', 'cepatlakoo_add_tocart_product');
add_action('wp_ajax_nopriv_cepatlakoo_wc_add_cart', 'cepatlakoo_add_tocart_product');

/**
 * Function to remove product by AJAX
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_product_remove') ) {
    function cepatlakoo_product_remove() {
        $cart = WC()->instance()->cart;
        $id = sanitize_text_field( $_POST['product_id'] );
        $cart_item_id = $cart->find_product_in_cart( $id );

        if( $cart_item_id ){
           $cart->set_quantity( $cart_item_id, 0 );
        }

        wp_die();
    }
}
add_action( 'wp_ajax_my_wc_remove_product', 'cepatlakoo_product_remove' );
add_action( 'wp_ajax_nopriv_my_wc_remove_product', 'cepatlakoo_product_remove' );

/**
 * Function to update product by AJAX
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_update_item_cart') ) {
    function cepatlakoo_update_item_cart() {
        $cart = WC()->instance()->cart;
        $id = sanitize_text_field( $_POST['product_id'] );
        $cart_item_id = $cart->find_product_in_cart( $id );
        $quantity = absint( $_POST['quantity'] );

        if( $cart_item_id ){
           $cart->set_quantity( $cart_item_id, $quantity );
        }

        wp_die();
    }
}
add_action( 'wp_ajax_update_item_cart', 'cepatlakoo_update_item_cart' );
add_action( 'wp_ajax_nopriv_update_item_cart', 'cepatlakoo_update_item_cart' );

/**
 * Function step by step Checkout
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_stepbystep') ) {
    function cepatlakoo_stepbystep() {
        echo '<div class="ui ordered steps">';
            if( is_cart() ) {
                echo '<div class="active current step">';
            } else if( is_checkout() ) {
                echo '<div class="completed step">';
            }
                    echo '<div class="content">
                        <div class="title">' . esc_html( 'Shopping Cart', 'cepatlakoo' ) . '</div>
                        <div class="description">' . esc_html( 'Confirm your ordered items', 'cepatlakoo' ) . '</div>
                    </div>
                </div>';
            if( is_cart() ) {
                echo '<div class="active step">';
            } else if( is_checkout() ) {
                echo '<div class="active current step">';
            }
                    echo '<div class="content">
                          <div class="title">' . esc_html( 'Checkout', 'cepatlakoo' ) . '</div>
                          <div class="description">' . esc_html( 'Enter billing information', 'cepatlakoo' ) . '</div>
                     </div>
                </div>';
            if( is_cart() ) {
                echo '<div class="active step">';
            } else if( is_checkout() ) {
                echo '<div class="active step">';
            }
                    echo '<div class="content">
                        <div class="title">' . esc_html( 'Order Completed', 'cepatlakoo' ) . '</div>
                        <div class="description">' . esc_html( 'Your order is completed', 'cepatlakoo' ) . '</div>
                    </div>
                </div>
            </div>';
    }
}

/**
 * Function step by step Thankyou page
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_stepbystep_thankyou') ) {
    function cepatlakoo_stepbystep_thankyou() {
        echo '<div class="ui ordered steps">
                <div class="completed step">
                    <div class="content">
                        <div class="title">'. esc_html__('Shopping Cart','cepatlakoo') . '</div>
                        <div class="description">'. esc_html__('Confirm your ordered items','cepatlakoo') .'</div>
                    </div>
                </div>
                <div class="completed step">
                    <div class="content">
                        <div class="title">' . esc_html__('Checkout','cepatlakoo') . '</div>
                        <div class="description">' . esc_html__('Enter billing information','cepatlakoo') . '</div>
                    </div>
                </div>
                <div class="completed step">
                    <div class="content">
                        <div class="title">' . esc_html__('Order Completed','cepatlakoo') . '</div>
                        <div class="description">' . esc_html__('Your order is completed','cepatlakoo') . '</div>
                    </div>
                </div>
            </div>';
    }
}

/**
 * Function to trigger FB Pixel Purchase
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.2.2
 */
if ( ! function_exists( 'cepatlakoo_trigger_fbpixel_purchase') ) {
    function cepatlakoo_trigger_fbpixel_purchase($order) {
        $ids = array();
        $total = 0;
        $items = $order->get_items();
        foreach ( $items as $item ) {
            $item_id = $item['product_id'];
            $total = $total + $item['qty'];
            // $ids[] = 'wc_post_id_'.$item_id;
            $ids[] = $item_id;
        }

        if($order->get_status() == 'pending' || $order->get_status() == 'processing'){
            wp_localize_script( 'cepatlakoo-functions', '_fbpixel_purchase', array(
                'prod_ids'  => $ids,
                'total'     => $order->get_total(),
                'items'     => $total,
                'type'      => 'Purchase',
                'currency'  => $order->get_currency()
            ));
        }

        wp_localize_script( 'cepatlakoo-functions', '_fbpixel_initCheckout', array(
            'prod_ids'  => $ids,
            'total'     => $order->get_total(),
            'items'     => $total,
            'type'      => 'InitiateCheckout',
            'currency'  => $order->get_currency()
        ));

    }
}



/**
* Functions to add Custom Column in Shop Order Posttype
*
* @package WordPress
* @subpackage CepatLakoo
* @source : www.deluxeblogtips.com/add-custom-column/
*
*/
add_filter('manage_edit-shop_order_columns', 'cepatlakoo_add_column_shop_order');
if ( ! function_exists( 'cepatlakoo_add_column_shop_order' ) ) {
    function cepatlakoo_add_column_shop_order( $columns ) {
        $columns['contact'] = esc_html( 'Contact Buyer', 'cepatlakoo' );
        return $columns;
    }
}

function get_variation_data_from_variation_id($item_id) {

    $_product = new WC_Product_Variation($item_id);
    $variation_data = $_product->get_variation_attributes(); // variation data in array
    // $variation_detail = woocommerce_get_formatted_variation($variation_data, true);  // this will give all variation detail in one line
    // $variation_detail = woocommerce_get_formatted_variation( $variation_data, false);  // this will give all variation detail one by one
    return $variation_data; // $variation_detail will return string containing variation detail which can be used to print on website
    // return $variation_data; // $variation_data will return only the data which can be used to store variation data
}

/**
* Functions to add Custom Column in Shop Order Posttype
*
* @package WordPress
* @subpackage CepatLakoo
* @source : www.deluxeblogtips.com/add-custom-column/
*
*/

add_filter( 'woocommerce_admin_order_preview_get_order_details', 'cepatlakoo_preview_order_action' );
function cepatlakoo_preview_order_action( $datas ) {

    $contact    = '<div class="wc-action-button-group">
    <label>Contact : </label>
    <span class="wc-action-button-group__items">
    '.cepatlakoo_render_order_contact( $datas['data']['id'] ).'
    </span>
    </div>';
    $datas['actions_html'] .= $contact;
        
    return $datas;
}

add_action('manage_posts_custom_column',  'cepatlakoo_show_column_shop_order');
if ( ! function_exists( 'cepatlakoo_show_column_shop_order' ) ) {
    function cepatlakoo_show_column_shop_order( $name ) {
        switch ( $name ) {
            case 'contact':
                global $post;
                echo cepatlakoo_render_order_contact($post->ID);
        }
    }
}

/**
* Functions to add follow up contact buttons on WooCommerce orders page
*
* @package WordPress
* @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
*
*/
function cepatlakoo_render_order_contact( $post_id ) {
    global $woocommerce, $post, $cl_options;
    $returns = '';
    
    $cepatlakoo_followup_wa_message = !empty( $cl_options['cepatlakoo_followup_wa_message'] ) ? $cl_options['cepatlakoo_followup_wa_message'] : '';
    $cepatlakoo_followup_sms_message = !empty( $cl_options['cepatlakoo_followup_sms_message'] ) ? $cl_options['cepatlakoo_followup_sms_message'] : '';

    $order = new WC_Order( $post_id );
    $order_id = trim(str_replace('#', '', $order->get_order_number()));

    // Get an instance of the WC_Order object
    $order = wc_get_order( $order_id );
    $items = $order->get_items();
    $data_product = array();

    foreach ( $items as $item ) {
        $data_variation = array();
        foreach ( get_variation_data_from_variation_id($item['variation_id']) as $variation ) {
            array_push( $data_variation, $variation );
        }
        if( count($data_variation) > 2 ){
            $data_variation = implode(", ",$data_variation);
            $data_variation = ' - ' . $data_variation;
        }else{
            $data_variation = null;
        }
        array_push( $data_product, $item['name']  . $data_variation .' ('. $item['quantity'] .')' );
    }
    
    $data_products = implode(",\n",$data_product);

    $order_data = $order->get_data(); // The Order data

    $order_id = $order_data['id'];

    ## Creation and modified WC_DateTime Object date string ##

    // Using a timestamp ( with php getTimestamp() function as method)
    $order_shipping_total = strip_tags( wc_price( $order_data['shipping_total'] ) );
    $order_shipping_tax = $order_data['shipping_tax'];
    $order_total = $order_data['cart_tax'];
    $order_total_tax = $order_data['total_tax'];

    ## BILLING INFORMATION:
    $order_billing_first_name = $order_data['billing']['first_name'];
    $order_billing_last_name = isset($order_data['billing']['last_name']) ? $order_data['billing']['last_name'] : '';

    $order_total = strip_tags( wc_price( $order->get_total() ) );

    $full_name = get_post_meta( $post_id, '_billing_first_name' )[0] . ' ' . get_post_meta( $post_id, '_billing_last_name' )[0];

    $full_name = esc_html( $full_name );

    $cl_base_order_status = $order->get_status();
    $cl_status_list = array(
        'pending' => __('Pending', 'cepatlakoo'),
        'processing' => __('Processing', 'cepatlakoo'),
        'on-hold' => __('On Hold', 'cepatlakoo'),
        'completed' => __('Completed', 'cepatlakoo'),
        'cancelled' => __('Cancelled', 'cepatlakoo'),
        'refunded' => __('Refunded', 'cepatlakoo'),
        'failed' => __('Failed', 'cepatlakoo'),
    );

    foreach ($cl_status_list as $cl_status_lists => $translate){
        if ($cl_base_order_status == $cl_status_lists){
            $cl_order_status = $translate;
        }
    }
    
    if ( is_plugin_active( 'cepatlakoo-input-resi/cepatlakoo-input-resi.php' ) ) {
        if( $cl_order_status ==__('Completed', 'cepatlakoo') ){
            $cepatlakoo_followup_wa_message = !empty( $cl_options['cepatlakoo_followup_wa_message_success'] ) ? $cl_options['cepatlakoo_followup_wa_message_success'] : $cepatlakoo_followup_wa_message;
            $cepatlakoo_followup_sms_message = !empty( $cl_options['cepatlakoo_followup_sms_message_success'] ) ? $cl_options['cepatlakoo_followup_sms_message_success'] : $cepatlakoo_followup_sms_message;
        }
        $cl_resi_code = !empty(get_post_meta( $order_id, '_cepatlakoo_resi', true )) ? get_post_meta( $order_id, '_cepatlakoo_resi', true ) : '';
        $cl_resi_date = !empty(get_post_meta( $order_id, '_cepatlakoo_resi_date', true )) ? date( get_option('date_format'), strtotime(get_post_meta( $order_id, '_cepatlakoo_resi_date', true )) ) : '';
        $cl_resi_courier = !empty(get_post_meta( $order_id, '_cepatlakoo_ekspedisi', true )) ? get_post_meta( $order_id, '_cepatlakoo_ekspedisi', true ) : '';

        $cepatlakoo_followup_wa_message = str_replace( '%lakoo_courier%', $cl_resi_courier, $cepatlakoo_followup_wa_message);
        $cepatlakoo_followup_wa_message = str_replace( '%lakoo_tracking_code%', $cl_resi_code, $cepatlakoo_followup_wa_message);
        $cepatlakoo_followup_wa_message = str_replace( '%lakoo_tracking_date%', $cl_resi_date, $cepatlakoo_followup_wa_message);

        $cepatlakoo_followup_sms_message = str_replace( '%lakoo_courier%', $cl_resi_courier, $cepatlakoo_followup_sms_message);
        $cepatlakoo_followup_sms_message = str_replace( '%lakoo_tracking_code%', $cl_resi_code, $cepatlakoo_followup_sms_message);
        $cepatlakoo_followup_sms_message = str_replace( '%lakoo_tracking_date%', $cl_resi_date, $cepatlakoo_followup_sms_message);
    }

    // WhatsApp
    $cepatlakoo_followup_wa_message = str_replace( '%lakoo_name%', $full_name, $cepatlakoo_followup_wa_message);
    $cepatlakoo_followup_wa_message = str_replace( '%lakoo_order_id%', $order_id, $cepatlakoo_followup_wa_message);
    $cepatlakoo_followup_wa_message = str_replace( '%lakoo_order_total%', $order_total, $cepatlakoo_followup_wa_message);
    $cepatlakoo_followup_wa_message = str_replace( '%lakoo_products%', $data_products, $cepatlakoo_followup_wa_message);
    $cepatlakoo_followup_wa_message = str_replace( '%lakoo_shipping_cost%', $order_shipping_total, $cepatlakoo_followup_wa_message);
    $cepatlakoo_followup_wa_message = str_replace( "&nbsp;", '', $cepatlakoo_followup_wa_message);
    $cepatlakoo_followup_wa_message = str_replace( "\n", '%0A', $cepatlakoo_followup_wa_message);
    $cepatlakoo_followup_wa_message = str_replace( "#", '%23', $cepatlakoo_followup_wa_message);
    $cepatlakoo_followup_wa_message = str_replace( "-", '%2D', $cepatlakoo_followup_wa_message);
    $cepatlakoo_followup_wa_message = str_replace( "&",'%26', $cepatlakoo_followup_wa_message);

    // SMS
    $cepatlakoo_followup_sms_message = str_replace( '%lakoo_name%', $full_name, $cepatlakoo_followup_sms_message);
    $cepatlakoo_followup_sms_message = str_replace( '%lakoo_order_id%', $order_id, $cepatlakoo_followup_sms_message);
    $cepatlakoo_followup_sms_message = str_replace( '%lakoo_products%', $data_products, $cepatlakoo_followup_sms_message);
    $cepatlakoo_followup_sms_message = str_replace( '%lakoo_order_total%', $order_total, $cepatlakoo_followup_sms_message);
    $cepatlakoo_followup_sms_message = str_replace( '%lakoo_shipping_cost%', $order_shipping_total, $cepatlakoo_followup_sms_message);
    $cepatlakoo_followup_sms_message = str_replace( "&nbsp;", '', $cepatlakoo_followup_sms_message);
    $cepatlakoo_followup_sms_message = str_replace( "\n", '%0A', $cepatlakoo_followup_sms_message);
    $cepatlakoo_followup_sms_message = str_replace( "#", '%23', $cepatlakoo_followup_sms_message);
    $cepatlakoo_followup_sms_message = str_replace( "-", '%2D', $cepatlakoo_followup_sms_message);
    $cepatlakoo_followup_sms_message = str_replace( "&",'%26', $cepatlakoo_followup_sms_message);
// var_dump($cepatlakoo_followup_sms_message); exit();

    $phone_number = get_post_meta( $post_id, '_billing_phone' )[0];

    // Update v.1.0.1
    if ( preg_match('[^\+62]', $phone_number ) ) {
        $phone_number = str_replace('+62', '62', $phone_number);
    }else if ( $phone_number[0] == '0' ) {
        $phone_number = ltrim( $phone_number, '0' );
        $phone_number = '62'. $phone_number;
    }else if ( $phone_number[0] == '8' ) {
        $phone_number = '62'. $phone_number;
    } else {
        $phone_number = $phone_number;
    }

    $returns .= '<a class="button wc-action-button whatsapp"
                href="https://api.whatsapp.com/send?l=id&phone=' . $phone_number . '&text=' .  $cepatlakoo_followup_wa_message . '">' . esc_html__( 'WhatsApp' , 'cepatlakoo' ) . '</a>';

    $returns .= '<a class="button wc-action-button sms"
                href="sms:' . $phone_number . '?body=' . $cepatlakoo_followup_sms_message . '">' . esc_html__( 'SMS' , 'cepatlakoo' ) . '</a>';

    $returns .= "<script type='text/javascript'>
            document.addEventListener('DOMContentLoaded', (function () {
                link = new SMSLink.link();
                link.replaceAll();
            }), false);
        </script>";
    return $returns;
}

/**
* Functions to inject button in email & view order page in my account
*
* @package WordPress
* @subpackage CepatLakoo
* @since Cepatlakoo 1.1.3
*
*/
function cepatlakoo_confirmation_button( $order_id ) {
    global $cl_options;

    $cepatlakoo_confirmation_page = !empty( $cl_options['cepatlakoo_select_confirmation'] ) ? $cl_options['cepatlakoo_select_confirmation'] : '';
    $cepatlakoo_general_bg_theme_color = !empty( $cl_options['cepatlakoo_general_bg_theme_color']['background-color'] ) ? $cl_options['cepatlakoo_general_bg_theme_color']['background-color'] : '';

    $order = new WC_Order( $order_id );
    $order_status = $order->get_status();
    $order_status = $order->get_status();

    // only show confirmation button only if order status is on-hold or pending
    if ( 'on-hold' == $order_status || 'pending' == $order_status ) {
        echo '<p style="margin:30px 0;"><a style="background-color: '. $cepatlakoo_general_bg_theme_color .'; padding: 13px 30px; font-size: 14px; color: #ffffff !important; text-decoration: none;" href="'. get_permalink( $cepatlakoo_confirmation_page ) .'">'. esc_html__('Confirm Payment', 'cepatlakoo') .'</a></p>';
    }
}
add_action( 'woocommerce_email_after_order_table', 'cepatlakoo_confirmation_button', 10, 2 );
add_action( 'woocommerce_view_order', 'cepatlakoo_confirmation_button', 9 );

/**
* Functions to add site logo to checkout page
*
* @package WordPress
* @subpackage CepatLakoo
* @since Cepatlakoo 1.2.5
*
*/
if ( ! function_exists( 'cl_checkout_logo ') ) {
    function cl_checkout_logo() {
        if ( is_page_template( 'template-simple-checkout.php' ) ) {
            cepatlakoo_logo();
        }
    }
}
add_action( 'woocommerce_before_checkout_form', 'cl_checkout_logo' );

// Move coupon field
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
add_action( 'woocommerce_after_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

/**
* Functions to modify number of products per page
*
* @package WooCommerce
* @subpackage Cepatlakoo
* @since Cepatlakoo 1.3.0
*
*/
function cepatlakoo_loop_shop_per_page( $cols ) {
    // $cols contains the current number of products per page based on the value stored on Options -> Reading
    // Return the number of products you wanna show per page.
    $cols = 12;
    return $cols;
}
add_filter( 'loop_shop_per_page', 'cepatlakoo_loop_shop_per_page', 20 );

/**
* Functions to hide coupon code in cart & checkout page
*
* @package WooCommerce
* @subpackage Cepatlakoo
* @since Cepatlakoo 1.3.3
*
*/
if ( ! function_exists( 'cepatlakoo_disable_coupon' ) ) {
    function cepatlakoo_disable_coupon( $enabled ) {
        global $cl_options;

        if ( $cl_options['cepatlakoo_coupon_code'] == '0' ) {
            if ( is_cart() || is_checkout() ) {
                $enabled = false;
            }
        }
        return $enabled;
    }
}
add_filter( 'woocommerce_coupons_enabled', 'cepatlakoo_disable_coupon' );


/**
* Functions to display countdown timer & payment confirmation button in order-received page
*
* @package WordPress
* @subpackage CepatLakoo
* @since Cepatlakoo 1.3.3
*
*/
if ( ! function_exists( 'cepatlakoo_countdown_order_received ') ) {
    function cepatlakoo_countdown_order_received() {
        global $cl_options;

        // check if countdown for order received page is activated in theme options
        if ( $cl_options['cepatlakoo_countdown_timer_order_received'] ) {
            $cepatlakoo_countdown_timer = !empty( $cl_options['cepatlakoo_countdown_order_received'] ) ? $cl_options['cepatlakoo_countdown_order_received'] : '';
            $cepatlakoo_confirmation_page = !empty( $cl_options['cepatlakoo_select_confirmation'] ) ? $cl_options['cepatlakoo_select_confirmation'] : '';
            $cepatlakoo_countdown_text = !empty( $cl_options['cepatlakoo_countdown_order_received_text'] ) ? $cl_options['cepatlakoo_countdown_order_received_text'] : '';

            if ( $cepatlakoo_countdown_text ) {
                echo '<div class="countdown-text">'. nl2br( $cepatlakoo_countdown_text ) .'</div>';
            }

            if ( $cepatlakoo_countdown_timer ) {
                echo do_shortcode( '[cepatlakoo-countdown id="'. $cepatlakoo_countdown_timer .'"]');
            }

            if ( $cepatlakoo_confirmation_page ) {
                echo '<p class="confirmation-button"><a href="'. get_permalink( $cepatlakoo_confirmation_page ) .'" class="button">'. esc_html__('Confirm Payment', 'cepatlakoo') .'</a></p>';
            }
        }
    }
}
add_action( 'woocommerce_thankyou', 'cepatlakoo_countdown_order_received', 9 );


/**
* Functions to display product image on checkout page
*
* @package WordPress
* @subpackage CepatLakoo
* @since Cepatlakoo 1.3.4
*
*/
if ( ! function_exists( 'cepatlakoo_product_image_checkout ') ) {
    function cepatlakoo_product_image_checkout( $cart_item_name, $cart_item ) {
        global $cl_options;

        if ( $cl_options['cepatlakoo_checkout_product_image'] ) {
            return ( is_checkout() ) ? $cart_item['data']->get_image() . $cart_item_name : $cart_item_name;
        } else {
            return ( is_checkout() ) ? $cart_item_name : $cart_item_name;
        }
    }
}
add_action('woocommerce_cart_item_name', 'cepatlakoo_product_image_checkout', 10, 2 );


/**
* Functions to hide product tabs info in WooCommerce single product page
*
* @package WordPress
* @subpackage CepatLakoo
* @since Cepatlakoo 1.3.4
*
*/
if ( ! function_exists( 'cepatlakoo_remove_wc_product_tabs ') ) {
    function cepatlakoo_remove_wc_product_tabs( $tabs ) {
        global $cl_options;

        if ( empty ( $cl_options['cepatlakoo_wc_product_tabs'] ) ) {
            unset( $tabs['description'] );
            unset( $tabs['reviews'] );
            unset( $tabs['additional_information'] );
        }
        return $tabs;
    }
}
add_filter( 'woocommerce_product_tabs', 'cepatlakoo_remove_wc_product_tabs', 98 );

/**
* Functions to display additional badge to product page
*
* @package WordPress
* @subpackage CepatLakoo
* @since Cepatlakoo 1.3.4
*
*/
function cepatlakoo_add_badge_wc_product_page() {
    global $cl_options;
    $badges = $cl_options['cepatlakoo_product_badges'];

    if ( array_filter( $badges ) ) {
        echo '<div class="cl-product-badges">';
        foreach ($badges as $key => $value) {
            $value = trim($value);
            if (!empty($value)) {
                echo '<span>'. $value .'</span>';
            }
        }
        echo '</div>';
    }

    // print_r( $badges );
}
add_action( 'woocommerce_single_product_summary' , 'cepatlakoo_add_badge_wc_product_page', 1 );
?>