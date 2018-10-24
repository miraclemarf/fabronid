<?php
/**
 * Display Page Title
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_page_title' ) ) {
    function cepatlakoo_page_title() {
        global $wp_query;
        $title = '';
        if ( is_category() ) :
            $title = sprintf( esc_html__( '%s Category Archives', 'cepatlakoo' ), single_cat_title( '', false ));
        elseif ( is_tag() ) :
            $title = sprintf( esc_html__( '%s Tag Archives', 'cepatlakoo' ), single_cat_title( '', false ));
        elseif ( is_day() ) :
            $title = sprintf( esc_html__( '%s Daily Archives', 'cepatlakoo' ), single_cat_title( '', false ));
        elseif ( is_month() ) :
            $title = sprintf( esc_html__( '%s Monthly Archives', 'cepatlakoo' ), single_cat_title( '', false ));
        elseif ( is_year() ) :
            $title = sprintf( esc_html__( '%s Yearly Archives', 'cepatlakoo' ), single_cat_title( '', false ));
        elseif ( is_author() ) :
            $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
            $title = esc_html__( 'Author Archives', 'cepatlakoo' );
        elseif ( is_search() ) :
            if ( $wp_query->found_posts ) {
                $title .= sprintf( esc_html__( 'Search results for: "%s"', 'cepatlakoo' ), esc_attr( get_search_query() ) );
            } else {
                $title .= sprintf( esc_html__( 'Search results for: "%s"', 'cepatlakoo' ), esc_attr( get_search_query() ) );
            }
        elseif ( is_404() ) :
            $title = esc_html__( 'Not Found', 'cepatlakoo' );
        elseif ( is_singular( 'post' ) || is_home() || is_page_template( 'template-blog.php' ) ) :
            $title = get_the_title( get_the_ID() );
        elseif ( is_archive() ) :
            $title = esc_html__( 'Archives', 'cepatlakoo' );
        else :
            if ( has_custom_logo() ) {
                $title = wp_trim_words( get_the_title(), 10, ' ...' );
            } else {
                $title = wp_trim_words( get_the_title(), 10, ' ...' );
            }
        endif;

        $cepatlakoo_page_title = $title;

        echo $cepatlakoo_page_title;
    }
}

/**
 * Function to display custom logo
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_logo') ) {
    function cepatlakoo_logo() {
?>
    <?php if ( ! has_custom_logo() || is_page_template( 'template-simple-checkout.php' ) ) : ?>
        <div id="logo" class="logo-title">
            <h2 class="site-title">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                    <?php echo esc_attr( get_bloginfo( 'name' ) ); ?>
                </a>
            </h2>
        </div>
    <?php elseif ( function_exists( 'the_custom_logo' ) ) : ?>
        <div id="logo" class="custom-logo">
          <?php the_custom_logo(); // custom logo ?>
        </div>
    <?php endif; ?>
<?php
    }
}

/**
 * Display Entry Meta
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_entry_meta') ) {
    function cepatlakoo_entry_meta() {
        global $post;
?>
        <div class="entry-meta">
            <span><a href="<?php echo get_author_posts_url( $post->post_author ); ?>"><i class="icon icon-user"></i> <?php echo get_the_author(); ?></a></span>
            <span><i class="icon icon-calendar"></i> <?php echo date_i18n( 'F j, Y', strtotime( get_the_date('Y-m-d'), false ) ); ?></span>
            <span><i class="icon icon-folder"></i>
            <?php the_category(', '); ?>
            </span>
        </div>
<?php
    }
}

/**
 * Function to load comment list
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_comment_list' ) ) {
    function cepatlakoo_comment_list( $comment, $args, $depth ) {
        global $post;
        $author_post_id = $post->post_author;
        $GLOBALS['comment'] = $comment;

        // Allowed html tags will be display
        $allowed_html = array(
            'a' => array( 'href' => array(), 'title' => array() ),
            'abbr' => array( 'title' => array() ),
            'acronym' => array( 'title' => array() ),
            'strong' => array(),
            'b' => array(),
            'blockquote' => array( 'cite' => array() ),
            'cite' => array(),
            'code' => array(),
            'del' => array( 'datetime' => array() ),
            'em' => array(),
            'i' => array(),
            'q' => array( 'cite' => array() ),
            'strike' => array(),
            'ul' => array(),
            'ol' => array(),
            'li' => array()
        );

        switch ( $comment->comment_type ) :
        case '' :
?>
        <li id="comment-<?php comment_ID() ?>" class="clearfix">
            <div class="thumbnail">
                 <?php echo get_avatar( $comment, 70 ); ?>
            </div>
            <div class="detail">
                <h5><?php comment_author(); ?></h5>
                <?php
                    if ( $comment->comment_approved == '0' ) :
                ?>
                        <p class="moderate"><?php esc_html_e( 'Your comment is now awaiting moderation before it will appear on this post.', 'cepatlakoo' );?></p>
                <?php
                    endif;
                    echo apply_filters( 'comment_text', wp_kses( get_comment_text(), $allowed_html ) );
                ?>

                <div class="comment-footer">
                    <span class="meta"><i class="icon icon-calendar"></i> <?php echo get_comment_date( 'F d, Y - h.i a' ); ?></span>
                    <p class="replies"><span><i class="fa fa-reply"></i> <span><?php echo comment_reply_link( array( 'reply_text' => esc_html__( 'Reply', 'cepatlakoo' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) );  ?></span></p>
                </div>
            </div>
        </li>
<?php
        break;
        case 'pingback'  :
        case 'trackback' :
?>
        <li id="comment-<?php comment_ID() ?>" <?php comment_class(); ?>>
            <div class="detail">
                <div class="author">
                    <a href="<?php comment_author_url()?>"><?php esc_html_e( 'Pingback', 'cepatlakoo' ); ?></a>
                </div>
                <h5>
                    <?php comment_author(); ?>
                </h5>
                <div class="meta">
                    <?php comment_date(); echo ' - '; comment_time(); ?>
                    <span class="edit-link"><i class="fa fa-edit"></i><?php edit_comment_link( esc_html__(' Edit Comment', 'cepatlakoo'), '', '' ); ?></span>
                </div>
                <hr class="comment-line"/>
            </div>
        </li>
<?php
        break;
        endswitch;
    }
}

/**
 * Function to check option FB Pixel, SEO and Google Analytics
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_check_fb_pixel' ) ) {
    function cepatlakoo_check_fb_pixel() {
        global $cl_options;

        $cepatlakoo_facebook_pixel_id = !empty( $cl_options['cepatlakoo_facebook_pixel_id'] ) ? $cl_options['cepatlakoo_facebook_pixel_id'] : '';
        $cepatlakoo_google_analytics_tracking = !empty( $cl_options['cepatlakoo_google_analytics_tracking'] ) ? $cl_options['cepatlakoo_google_analytics_tracking'] : '';
        $cepatlakoo_seo_trigger = !empty( $cl_options['cepatlakoo_seo_trigger'] ) ? $cl_options['cepatlakoo_seo_trigger'] : '';

        if ($cepatlakoo_seo_trigger) {
            add_action( 'wp_head', 'cepatlakoo_search_engine_optimize', 3);
            add_filter( 'pre_get_document_title', 'cepatlakoo_custom_title', 10 );
        }
        if ($cepatlakoo_facebook_pixel_id) {
            add_action( 'wp_footer', 'cepatlakoo_fb_pixel_id', 99);
        }
        if ($cepatlakoo_google_analytics_tracking) {
            add_action( 'wp_head', 'cepatlakoo_google_analytics_tracking', 98);
        }

    }
}
add_action( 'init', 'cepatlakoo_check_fb_pixel' );

/**
 * Function to add class to confirmation page
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_add_class_confirmation' ) ) {
    function cepatlakoo_add_class_confirmation( $classes ) {
        global $cl_options;

        $cepatlakoo_select_confirmation = !empty( $cl_options['cepatlakoo_select_confirmation'] ) ? $cl_options['cepatlakoo_select_confirmation'] : '';
        $cepatlakoo_purchase_confirmation = !empty( $cl_options['cepatlakoo_purchase_confirmation'] ) ? $cl_options['cepatlakoo_purchase_confirmation'] : '';

        if ( !empty( $cepatlakoo_select_confirmation ) ) {
            if ( is_page( $cepatlakoo_select_confirmation ) ) {
                $classes[] = 'confirmation-page wcfb-' . $cepatlakoo_purchase_confirmation;
            }
        }

        return $classes;
    }
}
add_filter( 'body_class', 'cepatlakoo_add_class_confirmation' );

/**
 * Function to check google analytics Tracking
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_google_analytics_tracking' ) ) {
    function cepatlakoo_google_analytics_tracking() {
        global $cl_options;

        $cepatlakoo_google_analytics_tracking = !empty( $cl_options['cepatlakoo_google_analytics_tracking'] ) ? $cl_options['cepatlakoo_google_analytics_tracking'] : '';
?>
            <script>
                (function(i,s,o,g,r,a,m) {i['GoogleAnalyticsObject']=r;i[r]=i[r]||function() {
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                ga('create', '<?php esc_attr_e( $cepatlakoo_google_analytics_tracking ); ?>' , 'auto');
                ga('send', 'pageview');
            </script>
<?php
    }
}

/**
 * Function to Form top
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_comment_form_top' ) ) {
    function cepatlakoo_comment_form_top() {}
}
add_action( 'comment_form_top', 'cepatlakoo_comment_form_top' );

if ( ! function_exists( 'cepatlakoo_comment_form_bottom' ) ) {
    function cepatlakoo_comment_form_bottom() {}
}
add_action( 'comment_form', 'cepatlakoo_comment_form_bottom', 1 );

/**
 * Function to Form Bottom
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_comment_field_to_bottom' ) ) {
    function cepatlakoo_comment_field_to_bottom( $fields ) {
        $comment_field = $fields['comment'];
        unset( $fields['comment'] );
        $fields['comment'] = $comment_field;
        return $fields;
    }
}
add_filter( 'comment_form_fields', 'cepatlakoo_comment_field_to_bottom' );

/**
 * Display Post Pagination in Blog Page
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_display_pagination') ) {
    function cepatlakoo_display_pagination() {
        global $wp_query;
        if ( $wp_query->max_num_pages > 1 ) : ?>
            <div class="pagination older-newer" >
<?php
                if ( function_exists( 'wp_pagenavi' ) ) {
                    wp_pagenavi(); // pagenavi
                } else {
                    previous_posts_link( '&#8592;'. esc_html__( 'Newer post', 'cepatlakoo' ) );
                    next_posts_link( esc_html__( 'Older Posts', 'cepatlakoo' ) .'&#8594;' );
                }
?>
            </div>
<?php
        endif;
    }
}

/**
 * Display Share Buttons
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_display_share_buttons') ) {
    function cepatlakoo_display_share_buttons() {
        global $cl_options;

        $cepatlakoo_share_button = !empty( $cl_options['cepatlakoo_share_button'] ) ? $cl_options['cepatlakoo_share_button'] : '';

        if ( $cepatlakoo_share_button == 1 ) {
?>
            <div class="widget article-widget">
                <div class="social-sharing article-share-widget">
                    <h4 class="widget-title"><?php esc_html_e( 'Share this article','cepatlakoo' ); ?></h4>
                    <ul>
                        <li><a title="<?php esc_html_e( 'Facebook Share', 'cepatlakoo' ); ?>" target="_blank" href="<?php echo esc_url( 'https://www.facebook.com/sharer.php?u=' . urlencode( get_permalink( get_the_ID() ) )); ?>&t=<?php echo esc_attr(get_the_title(get_the_ID())); ?>"><i class="icon icon-facebook"></i></a></li>
                        <li><a title="<?php esc_html_e( 'Twitter Share', 'cepatlakoo' ); ?>" target="_blank" href="<?php echo esc_url( 'http://twitter.com/share?url='. urlencode(get_permalink( get_the_ID() ))); ?>&text=<?php echo esc_attr(get_the_title(get_the_ID())); ?>&count=horizontal"><i class="icon icon-twitter"></i></a></li>
                        <li>
                            <?php $cepatlakoo_pinterestimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); ?>
                            <a title="<?php esc_html_e( 'Pinterest Share', 'cepatlakoo' ); ?>" target="_blank" href="<?php echo esc_url( 'http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink( get_the_ID() ) ) ); ?>&media=<?php echo esc_url($cepatlakoo_pinterestimage[0]); ?>&description=<?php echo esc_attr(get_the_title(get_the_ID())); ?>" count-layout="vertical"><i class="icon icon-pinterest"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
<?php
        }
    }
}

/**
 * Function to display post navigation
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_fb_pixel_id' ) ) {
    function cepatlakoo_fb_pixel_id() {
        global $cl_options;

        $cepatlakoo_facebook_pixel_id = !empty( $cl_options['cepatlakoo_facebook_pixel_id'] ) ? $cl_options['cepatlakoo_facebook_pixel_id'] : '';
?>
        <!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s) {if (f.fbq)return;n=f.fbq=function() {n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if (!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?php echo esc_attr($cepatlakoo_facebook_pixel_id); ?>'); // Insert your pixel ID here.
        </script>
        <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo absint($cepatlakoo_facebook_pixel_id); ?>&ev=PageView&noscript=1"/>
        </noscript>
        <!-- DO NOT MODIFY -->
        <!-- End Facebook Pixel Code -->
<?php
    }
}

/**
 * Cepatlakoo gallery slider function
 *
 * @package WordPress
 * @subpackage Cepatlakoo
 * @since Cepatlakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_gallery' ) ) {
    function cepatlakoo_gallery($content, $attr) {
        $post = get_post();
        static $instance = 0;
        $instance++;

        $html5 = current_theme_supports( 'html5', 'gallery' );
        if ( isset( $attr['orderby'] ) ) :
            $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
            if ( !$attr['orderby'] )
                unset( $attr['orderby'] );
        endif;

        extract(shortcode_atts(array(
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'id'         => $post ? $post->ID : 0,
            'size'       => 'thumbnail',
            'columns'    => 3,
            'include'    => '',
            'exclude'    => ''
        ), $attr));

        $id = intval( $id );
        if ( 'RAND' == $order )
            $orderby = 'none';

        if ( !empty( $include ) ) {
            $_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

            $attachments = array();
            foreach ( $_attachments as $key => $val ) {
                $attachments[ $val->ID ] = $_attachments[ $key ];
            }
        } elseif ( !empty( $exclude ) ) {
            $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
        } else {
            $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
        }

        $size = 'thumbnail';

        if ( empty( $attachments ) )
            return '';

        if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment )
                $output .= wp_get_attachment_image( $att_id, $size ) . "\n";
            return $output;
        }

        if (!empty($attr['link'])) {
            $typelink = "file";
        } else {
            $typelink = "attachment";
        }

        $selector = "gallery-{$instance}";
        $size_class = sanitize_html_class( $size );
        $output = "<div id='gallery-{$instance}' class='gallery cepatlakoo-gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class} $typelink'>";
        $i = 0;
        foreach ( $attachments as $id => $attachment ) {
            if ( ! empty( $attr['link'] ) && 'file' === $attr['link'] )
                $image_output = wp_get_attachment_link( $id, $size );
            elseif ( ! empty( $attr['link'] ) && 'none' === $attr['link'] )
                $image_output = wp_get_attachment_link( $id, $size );
            else
                $image_output =  wp_get_attachment_link( $id, $size, true, false);
            $image_meta  = wp_get_attachment_metadata( $id );
                    $orientation = '';
        if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
            $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
        }
        $output .= "<dl class='gallery-item'>";
        $output .= "
            <dt class='gallery-icon {$orientation}'>
                $image_output
            </dt>";
        $output .= '<figcaption class="wp-caption-text gallery-caption" id="'. $attachment->ID .'">' . $attachment->post_excerpt . '</figcaption>';
        $output .= "</dl>";
        if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
            $output .= '<br style="clear: both" />';
        }
        }
        $output .= "</div>";
        return $output;
    }
}
add_filter( 'post_gallery', 'cepatlakoo_gallery', 10, 2 );

/**
 * Function to display Open Graph
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_open_graph' ) ) {
    function cepatlakoo_open_graph() {
        global $cl_options;

        $cepatlakoo_open_graph_trigger = !empty( $cl_options['cepatlakoo_open_graph_trigger'] ) ? $cl_options['cepatlakoo_open_graph_trigger'] : '';

        // get the values from meta box
        $cepatlakoo_facebook_title_og = !empty( get_post_meta(get_the_ID(), 'cepatlakoo_facebook_title_og', true ) ) ? get_post_meta(get_the_ID(), 'cepatlakoo_facebook_title_og', true ) : '';
        $cepatlakoo_facebook_desc_og = !empty( get_post_meta(get_the_ID(), 'cepatlakoo_facebook_desc_og', true ) ) ? get_post_meta(get_the_ID(), 'cepatlakoo_facebook_desc_og', true ) : '';
        $cepatlakoo_facebook_image_og = !empty( get_post_meta(get_the_ID(), 'cepatlakoo_facebook_image_og', true ) ) ? get_post_meta(get_the_ID(), 'cepatlakoo_facebook_image_og', true ) : '';
?>
        <?php if ( $cepatlakoo_open_graph_trigger == true ) : ?>
                <meta property="og:title" content="<?php echo $cepatlakoo_facebook_title_og; ?>" />
                <meta property="og:url" content="<?php echo get_permalink( get_the_ID() ); ?>" />
            <?php if ( $cepatlakoo_facebook_desc_og ) : ?>
                <meta property="og:description" content="<?php echo $cepatlakoo_facebook_desc_og; ?>" />
            <?php endif; ?>
            <?php if ( $cepatlakoo_facebook_image_og ) : ?>
                <meta property="og:image" content="<?php echo $cepatlakoo_facebook_image_og; ?>" />
            <?php endif; ?>
        <?php endif; ?>
<?php
    }
}
add_action( 'wp_head', 'cepatlakoo_open_graph', 5);

/**
 * Function to Set Search Engine
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_search_engine_optimize' ) ) {
    function cepatlakoo_search_engine_optimize() {
        $cepatlakoo_seo_title = !empty( get_post_meta(get_the_ID(), 'cepatlakoo_seo_title_text', true ) ) ? get_post_meta(get_the_ID(), 'cepatlakoo_seo_title_text', true ) : '';
        $cepatlakoo_seo_desc = !empty( get_post_meta(get_the_ID(), 'cepatlakoo_seo_desc', true ) ) ? get_post_meta(get_the_ID(), 'cepatlakoo_seo_desc', true ) : '';
        $cepatlakoo_seo_keyword = !empty( get_post_meta(get_the_ID(), 'cepatlakoo_seo_keyword', true ) ) ? get_post_meta(get_the_ID(), 'cepatlakoo_seo_keyword', true ) : '';
        $cepatlakoo_seo_robotindex = !empty( get_post_meta(get_the_ID(), 'cepatlakoo_seo_robotindex', true ) ) ? get_post_meta(get_the_ID(), 'cepatlakoo_seo_robotindex', true ) : '';
        $cepatlakoo_seo_robotfollow = !empty( get_post_meta(get_the_ID(), 'cepatlakoo_seo_robotfollow', true ) ) ? get_post_meta(get_the_ID(), 'cepatlakoo_seo_robotfollow', true ) : '';
        $cepatlakoo_trigger_seo = !empty( get_post_meta(get_the_ID(), 'cepatlakoo_trigger_seo', true ) ) ? get_post_meta(get_the_ID(), 'cepatlakoo_trigger_seo', true ) : '0';

        if ($cepatlakoo_trigger_seo):
             if ( $cepatlakoo_seo_desc ) : ?>
                <meta name="description" content="<?php echo esc_attr($cepatlakoo_seo_desc); ?>" />
            <?php endif; ?>
            <?php if ( $cepatlakoo_seo_keyword ) : ?>
                <meta name="keywords" content="<?php echo esc_attr($cepatlakoo_seo_keyword); ?>" />
            <?php endif; ?>
            <?php if ( $cepatlakoo_seo_robotindex && $cepatlakoo_seo_robotfollow) : ?>
                <meta name="robots" content="[<?php echo esc_attr($cepatlakoo_seo_robotindex); ?>],[<?php echo esc_attr($cepatlakoo_seo_robotfollow); ?>]" />
<?php
            endif;
        endif;
    }
}

/**
 * Function to Set Title
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_custom_title' ) ) {
    function cepatlakoo_custom_title($title) {
        $cepatlakoo_trigger_seo = !empty( get_post_meta(get_the_ID(), 'cepatlakoo_trigger_seo', true ) ) ? get_post_meta(get_the_ID(), 'cepatlakoo_trigger_seo', true ) : '0';
        if ($cepatlakoo_trigger_seo):
            $cepatlakoo_seo_title = !empty( get_post_meta(get_the_ID(), 'cepatlakoo_seo_title_text', true ) ) ? get_post_meta(get_the_ID(), 'cepatlakoo_seo_title_text', true ) : '';
            return $cepatlakoo_seo_title;
        endif;
    }
}

/**
 * Function to display post navigation
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_post_navigation' ) ) {
    function cepatlakoo_post_navigation() {
        global $cl_options;

        $cepatlakoo_get__cur_post_type = get_post_type( get_the_ID() );
        $cepatlakoo_post_nav = !empty( $cl_options['cepatlakoo_post_nav'] ) ? $cl_options['cepatlakoo_post_nav'] : '';

        if ( $cepatlakoo_post_nav == 1 && $cepatlakoo_get__cur_post_type == "post"  ) :
            global $post;
            $cepatlakoo_display = '<div class="widget article-widget">';
                $cepatlakoo_display .= '<div class="post-navigation"><ul><li>';

                    $prevPost = get_previous_post(); // START : Previous Post
                    if ($prevPost) {
                        $args = array(
                            'posts_per_page' => 1,
                            'post_type'      => 'post',
                            'include' => absint( $prevPost->ID )
                        );
                        $prevPost = get_posts($args);
                        foreach ($prevPost as $post) {
                            setup_postdata($post);
                            if (has_post_thumbnail()) {
                                $cepatlakoo_display .= '<div class="thumbnail"><a href="'. get_the_permalink() .'">';
                                    $cepatlakoo_display .= get_the_post_thumbnail( get_the_ID(), 'thumbnail', array( 'alt' => get_the_title(), 'title' => get_the_title() ));
                                $cepatlakoo_display .= '</a></div>';
                            }
                            $cepatlakoo_display .= '<div class="detail">';
                                $cepatlakoo_display .= '<a href="' . get_the_permalink() . '">' . esc_html__( 'Previous post ', 'cepatlakoo' ) . '</a>';
                                $cepatlakoo_display .= '<h3><a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . wp_trim_words( get_the_title(), 10, '...') . '</a></h3>';
                            $cepatlakoo_display .= '</div></li>';
                            wp_reset_postdata();
                        } //end foreach
                    } // end if
                    // END : Previous Post

                        $nextPost = get_next_post();  // START : Next Post
                        if ($nextPost) {
                            $args = array(
                                'posts_per_page' => 1,
                                'post_type'      => 'post',
                                'include' => absint( $nextPost->ID )
                            );
                            $nextPost = get_posts($args);
                            foreach ($nextPost as $post) {
                                setup_postdata($post);
                                $cepatlakoo_display .= '<li>';
                                if (has_post_thumbnail()) {
                                    $cepatlakoo_display .= '<div class="thumbnail"><a href="'. get_the_permalink() .'">';
                                        $cepatlakoo_display .= get_the_post_thumbnail( get_the_ID(), 'thumbnail', array( 'alt' => get_the_title(), 'title' => get_the_title() ));
                                    $cepatlakoo_display .= '</a></div>';
                                }
                                $cepatlakoo_display .= '<div class="detail">';
                                    $cepatlakoo_display .= '<a href="' . get_the_permalink() . '">' . esc_html__( 'Next post ','cepatlakoo' ) . '</a>';
                                    $cepatlakoo_display .= '<h3><a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . wp_trim_words( get_the_title(), 10, '...') . '</a></h3>';
                                $cepatlakoo_display .= '</div></li>';
                                wp_reset_postdata();
                            } //end foreach
                        } // end if
                        // END : Next Post

                $cepatlakoo_display .= '</div>';
            $cepatlakoo_display .= '</div>';

            return $cepatlakoo_display;
        endif;
    }
}

/**
 * Change default excerpt more text
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_excerpt_more ') ) {
    function cepatlakoo_excerpt_more( ) {
        return '...';
    }
}
add_filter( 'excerpt_more', 'cepatlakoo_excerpt_more', 999 );

/**
 * Change default excerpt length
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_excerpt_length ') ) {
    function cepatlakoo_excerpt_length( $length ) {
        global $cl_options;

        $cepatlakoo_post_exceprt_length = !empty( $cl_options['cepatlakoo_post_exceprt_length'] ) ? $cl_options['cepatlakoo_post_exceprt_length'] : '';

        if ( $cepatlakoo_post_exceprt_length ) {
            return absint( $cepatlakoo_post_exceprt_length );
        } else {
            return 65;
        }
    }
}
add_filter( 'excerpt_length', 'cepatlakoo_excerpt_length', 999 );

/**
 * Display Cepatlakoo Top Bar
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_topbar ') ) {
    function cepatlakoo_topbar() {
        global $cl_options;

        $cepatlakoo_top_bar = !empty( $cl_options['cepatlakoo_top_bar'] ) ? $cl_options['cepatlakoo_top_bar'] : '';
        $cepatlakoo_fb_profile_url = !empty( $cl_options['cepatlakoo_fb_profile_url'] ) ? $cl_options['cepatlakoo_fb_profile_url'] : '';
        $cepatlakoo_tw_profile_url = !empty( $cl_options['cepatlakoo_tw_profile_url'] ) ? $cl_options['cepatlakoo_tw_profile_url'] : '';
        $cepatlakoo_itg_profile_url = !empty( $cl_options['cepatlakoo_itg_profile_url'] ) ? $cl_options['cepatlakoo_itg_profile_url'] : '';
        $cepatlakoo_customer_care_phone = !empty( $cl_options['cepatlakoo_customer_care_phone'] ) ? $cl_options['cepatlakoo_customer_care_phone'] : '';
        $cepatlakoo_customer_phone_label = !empty( $cl_options['cepatlakoo_customer_phone_label'] ) ? $cl_options['cepatlakoo_customer_phone_label'] : '';
        $cepatlakoo_top_bar_msg = !empty( $cl_options['cepatlakoo_top_bar_msg'] ) ? $cl_options['cepatlakoo_top_bar_msg'] : '';

        $user = wp_get_current_user();
?>

        <?php if ( $cepatlakoo_top_bar == 1 ) : ?>
            <div id="top-bar">
                <div class="container fullwidth clearfix">
                    <div class="row-bar">
                        <div class="contact-info">
                           <?php if ( !empty( $cepatlakoo_fb_profile_url ) || !empty( $cepatlakoo_tw_profile_url ) || !empty( $cepatlakoo_itg_profile_url ) ) : ?>
                                <div class="socials">
                                    <ul>
                                        <?php if ( !empty( $cepatlakoo_fb_profile_url ) ) : ?>
                                            <li><a href="<?php echo esc_url( $cepatlakoo_fb_profile_url ); ?>"><i class="icon icon-facebook"></i></a></li>
                                        <?php endif; ?>
                                        <?php if ( !empty( $cepatlakoo_tw_profile_url ) ) : ?>
                                            <li><a href="<?php echo esc_url( $cepatlakoo_tw_profile_url ); ?>"><i class="icon icon-twitter"></i></a></li>
                                        <?php endif; ?>
                                        <?php if ( !empty( $cepatlakoo_itg_profile_url ) ) : ?>
                                            <li><a href="<?php echo esc_url( $cepatlakoo_itg_profile_url ); ?>"><i class="icon icon-instagram"></i></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <?php if ( !empty( $cepatlakoo_customer_care_phone ) ) : ?>
                                <div class="customer-care">
                                    <p><i class="icon icon-phone"></i><b><?php echo esc_attr( $cepatlakoo_customer_phone_label); ?></b>
                                    <a href="tel:<?php echo esc_attr( $cepatlakoo_customer_care_phone ); ?>">
                                    <?php echo esc_attr( $cepatlakoo_customer_care_phone ); ?></a></p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ( !empty( $cepatlakoo_top_bar_msg ) ) : ?>
                            <div class="flash-info">
                                <?php
                                echo wp_kses(
                                    $cepatlakoo_top_bar_msg,
                                    array(
                                        'a' => array(
                                            'href' => array(),
                                            'title' => array()
                                        ),
                                        'b' => array(),
                                        'em' => array(),
                                        'strong' => array(),
                                        'i' => array(),
                                        'p' => array(),
                                    )
                                );
                                ?>
                            </div>
                        <?php endif; ?>

                        <div class="user-options">
                            <div class="user-account-menu">
                                <div class="avatar">
                                    <label><?php esc_html_e( 'My Account', 'cepatlakoo' ); ?></label>
                                </div>
                                <?php if ( class_exists( 'WooCommerce' ) ) :  ?>
                                <ul class="user-menu-menu">
                                    <?php if ( is_user_logged_in() ) : ?>
                                        <li><a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>" title="<?php echo $user->display_name; ?>"><?php esc_html_e( 'My Account','cepatlakoo' ); ?></a></li>
                                        <li><a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>orders/"><?php esc_html_e( 'My Orders','cepatlakoo' ); ?></a></li>
                                        <li><a href="<?php echo wp_logout_url( get_permalink( 'woocommerce_myaccount_page_id' ) ); ?>"><?php esc_html_e( 'Sign Out', 'cepatlakoo' ); ?></a></li>
                                    <?php else: ?>
                                        <li><a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>"><?php esc_html_e( 'Sign in / Sign Up', 'cepatlakoo' ); ?></a></li>
                                    <?php endif; ?>
                                </ul>
                                <?php endif; ?>
                            </div>

                            <div class="search-tool">
                                <div class="search-widget">
                                    <div class="search-trigger"><i class="icon icon-search"></i></div>
                                </div>
                            </div>

                            <div class="search-widget-header">
                                <?php get_template_part( 'search', 'product' ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
<?php
    }
}

/**
 * Function to add custom classes to the body
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
add_filter( 'body_class', 'cepatlakoo_custom_body_classes' );
if ( ! function_exists( 'cepatlakoo_custom_body_classes ') ) {
    function cepatlakoo_custom_body_classes( $classes ) {
        if ( is_home() || is_front_page() ) {
            $classes[] = 'homepage woocommerce';
        } else {
            $classes[] = 'woocommerce';
        }
        return $classes;
    }
}

/**
 * Function to display Cepatlakoo header style
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
if ( ! function_exists( 'cepatlakoo_header_style_option') ) {
    function cepatlakoo_header_style_option() {
        global $wp_query, $cl_options;

        $cepatlakoo_header_style_opt = !empty( $cl_options['cepatlakoo_header_style_opt'] ) ? $cl_options['cepatlakoo_header_style_opt'] : '';
        $cepatlakoo_header_style = get_post_meta(get_the_ID(), 'cepatlakoo_header_style', true );

        if ( !empty( $cepatlakoo_header_style_opt ) || $cepatlakoo_header_style_opt == 0 ) {
            if ( $cepatlakoo_header_style_opt == 0 ) {
                if ( $cepatlakoo_header_style ) {
                    if ( $cepatlakoo_header_style == 1 ) {
                        get_template_part( 'header-left' );
                    } elseif ( $cepatlakoo_header_style == 2 ) {
                        get_template_part( 'header-middle' );
                    } else {
                        if ( $cepatlakoo_header_style_opt == 1 ) {
                            get_template_part( 'header-left' );
                        } elseif ( $cepatlakoo_header_style_opt == 2 ) {
                            get_template_part( 'header-middle' );
                        } else {
                            get_template_part( 'header-left' );
                        }
                    }
                } else {
                    if ( $cepatlakoo_header_style_opt == 1 ) {
                        get_template_part( 'header-left' );
                    } elseif ( $cepatlakoo_header_style_opt == 2 ) {
                        get_template_part( 'header-middle' );
                    } else {
                        get_template_part( 'header-left' );
                    }
                }
            } elseif ( $cepatlakoo_header_style_opt == 1 ) {
                get_template_part( 'header-left' );
            } elseif ( $cepatlakoo_header_style_opt == 2 ) {
                get_template_part( 'header-middle' );
            } else {
                if ( $cepatlakoo_header_style == 1 ) {
                    get_template_part( 'header-left' );
                } elseif ( $cepatlakoo_header_style == 2 ) {
                    get_template_part( 'header-middle' );
                } else {
                    if ( $cepatlakoo_header_style_opt == 1 ) {
                        get_template_part( 'header-left' );
                    } elseif ( $cepatlakoo_header_style_opt == 2 ) {
                        get_template_part( 'header-middle' );
                    } else {
                        get_template_part( 'header-left' );
                    }
                }
            }
        } else {
            get_template_part( 'header-left' );
        }
    }
}

/**
* Functions to remove querystring from static resource
*
* @package WordPress
* @subpackage CepatLakoo
* @since CepatLakoo 1.0.0
*/
if ( ! function_exists( 'cepatlakoo_remove_script_version') ) {
    function cepatlakoo_remove_script_version( $src ) {
        global $cl_options;

        $cepatlakoo_remove_querystring = !empty( $cl_options['cepatlakoo_remove_querystring'] ) ? $cl_options['cepatlakoo_remove_querystring'] : '';

        if ($cepatlakoo_remove_querystring) {
            $parts = explode( '?ver', $src );
            return $parts[0];
        } else {
            return $src;
        }
    }
}
add_filter( 'script_loader_src', 'cepatlakoo_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'cepatlakoo_remove_script_version', 15, 1 );

/**
* Functions to trigger minify html
*
* @package WordPress
* @subpackage CepatLakoo
* @since CepatLakoo 1.0.0
*/
add_action( 'get_header', 'cepatlakoo_init_minify_html', 1 );
if ( ! function_exists( 'cepatlakoo_init_minify_html') ) {
    function cepatlakoo_init_minify_html() {
        global $cl_options;

        $cepatlakoo_minify_html = !empty( $cl_options['cepatlakoo_minify_html'] ) ? $cl_options['cepatlakoo_minify_html'] : '';

        if ($cepatlakoo_minify_html) {
            ob_start('cepatlakoo_minify_html_output');
        }
    }
}

/**
* Functions to Minify HTML
*
* @package WordPress
* @subpackage CepatLakoo
* @since CepatLakoo 1.0.0
*/
if ( ! function_exists( 'cepatlakoo_minify_html_output') ) {
    function cepatlakoo_minify_html_output($buffer) {
        if ( substr( ltrim( $buffer ), 0, 5) == '<?xml' )
            return ( $buffer );
            $buffer = str_replace(array (chr(13) . chr(10), chr(9)), array (chr(10), ''), $buffer);
            $buffer = str_ireplace(array ('<script', '/script>', '<pre', '/pre>', '<textarea', '/textarea>', '<style', '/style>'), array ('CLAKOO-START<script', '/script>CLAKOO-END', 'CLAKOO-START<pre', '/pre>CLAKOO-END', 'CLAKOO-START<textarea', '/textarea>CLAKOO-END', 'CLAKOO-START<style', '/style>CLAKOO-END'), $buffer);
            $split = explode('CLAKOO-END', $buffer);
            $buffer = '';
            for ($i=0; $i<count($split); $i++) {
                $ii = strpos($split[$i], 'CLAKOO-START');
                if ($ii !== false) {
                    $process = substr($split[$i], 0, $ii);
                    $buffer_data = substr($split[$i], $ii + 12);
                    if (substr($buffer_data, 0, 7) == '<script') {
                        $split2 = explode(chr(10), $buffer_data);
                        $buffer_data = '';
                        for ($iii = 0; $iii < count($split2); $iii ++) {
                            if ($split2[$iii])
                                $buffer_data .= trim($split2[$iii]) . chr(10);
                                if (strpos($split2[$iii], '//') !== false && substr(trim($split2[$iii]), -1) == ';' )
                                    $buffer_data .= chr(10);
                        }
                        if ($buffer_data)
                            $buffer_data = substr($buffer_data, 0, -1);
                            $buffer_data = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer_data);
                    } elseif (substr($buffer_data, 0, 6) == '<style') {
                        $buffer_data = preg_replace(array ('/\>[^\S ]+/u', '/[^\S ]+\</u', '/(\s)+/u'), array('>', '<', '\\1'), $buffer_data);
                        $buffer_data = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer_data);
                        $buffer_data = str_replace(array (chr(10), ' {', '{ ', ' }', '} ', '( ', ' )', ' :', ': ', ' ;', '; ', ' ,', ', ', ';}'), array('', '{', '{', '}', '}', '(', ')', ':', ':', ';', ';', ',', ',', '}'), $buffer_data);
                    }
                } else {
                    $process = $split[$i];
                    $buffer_data = '';
                }
                $process = preg_replace(array ('/\>[^\S ]+/u', '/[^\S ]+\</u', '/(\s)+/u'), array('>', '<', '\\1'), $process);
                $process = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/u', '', $process);
                $buffer .= $process.$buffer_data;
            }
            $buffer = str_replace(array (chr(10) . '<script', chr(10) . '<style', '*/' . chr(10), 'CLAKOO-START'), array('<script', '<style', '*/', ''), $buffer);
            if ( strtolower( substr( ltrim( $buffer ), 0, 15 ) ) == '<!doctype html>' )
                $buffer = str_replace( ' />', '>', $buffer );
            return ($buffer);
    }
}

/**
* Functions to set countdown scarcity
*
* @package WordPress
* @subpackage CepatLakoo
* @since CepatLakoo 1.0.0
*/
if ( ! function_exists( 'cepatlakoo_set_countdown_scarcity') ) {
    function cepatlakoo_set_countdown_scarcity($ct_id , $ct_position = 'woo' ) {
        global $cl_options;
        wp_enqueue_script( 'cl-countdown' );
        $countdown_id = get_post_meta( $ct_id, 'cepatlakoo_countdown_timer_opt', true );
        $countdown_type = get_post_meta( $countdown_id, 'cl_countdown_type', true );
        $arr_ip = array();

        if ($countdown_type == "Evergreen Countdown") {
            $countdown_day = !empty(get_post_meta( $countdown_id, 'cl_countdown_day', true )) ? get_post_meta( $countdown_id, 'cl_countdown_day', true ) : 0;
            $countdown_hour = !empty(get_post_meta( $countdown_id, 'cl_countdown_hour', true )) ? get_post_meta( $countdown_id, 'cl_countdown_hour', true ) : 0;
            $countdown_minute = !empty(get_post_meta( $countdown_id, 'cl_countdown_minute', true )) ? get_post_meta( $countdown_id, 'cl_countdown_minute', true ) : 0;
            $countdown_second = !empty(get_post_meta( $countdown_id, 'cl_countdown_second', true )) ? get_post_meta( $countdown_id, 'cl_countdown_second', true ) : 0;
            $countdown_detection = get_post_meta( $countdown_id, 'cl_countdown_detection', true );
            $expiry = time() + (86400 * 365); // 86400 = 1 day expires
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $host = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST);

            $set_curr_time = date( 'Y/m/d H:i:s e' );
            $curr_time = new DateTime($set_curr_time);
            $add = '+'.$countdown_day.' days +'.$countdown_hour.' hours +'.$countdown_minute.' minutes +'.$countdown_second.' seconds';
            // $set_new_date = date('Y-m-d', strtotime("+".$countdown_day." days"));
            $set_new_date = date('Y-m-d H:i:s e',strtotime($add, strtotime($set_curr_time)));
            // var_dump($curr_time); var_dump($set_new_date); exit();
            // $set_countdown_time = $set_new_date.' '.$countdown_hour.':'.$countdown_minute.':'.$countdown_second;
            $set_countdown_time = $set_new_date;
            // $countdown_time = date_create_from_format('Y-m-d H:i:s', $set_countdown_time);
            $countdown_time = $set_countdown_time;

            if ($countdown_detection == 'Cookie') {
                if ($countdown_id != '') :
                        $cookie_countdown_date_time_name = 'scarcity_countdown_date_time_'.$ct_id.'_'.$countdown_id;
                        $get_cookie_countdown_date_time = $set_countdown_time;
                        
                        wp_localize_script('cepatlakoo-functions', '_cepatlakoo', array(
                            'scarcity_countdown_date_time'  => $get_cookie_countdown_date_time,
                            'scarcity_cookies_name'         => $cookie_countdown_date_time_name,
                            'scarcity_start_date_time'      => $set_curr_time,
                            'scarcity_countdown_type'       => $countdown_type,
                            'scarcity_countdown_timer'      => $add
                        )); ?>
                        
                        <div class="sc-time" style="display:none;"><?php echo esc_attr($get_cookie_countdown_date_time) ?></div>
                        <div class="sc-cookies" style="display:none;"><?php echo esc_attr($cookie_countdown_date_time_name) ?></div>
                        <div class="sc-type" style="display:none;"><?php echo esc_attr($countdown_type) ?></div>
                        <div class="sc-timer" style="display:none;"><?php echo esc_attr($add) ?></div>
                <?php endif;
            } else {
                $ipaddress = '';
                if (getenv('HTTP_CLIENT_IP'))
                    $ipaddress = getenv('HTTP_CLIENT_IP');
                elseif (getenv('HTTP_X_FORWARDED_FOR'))
                    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
                elseif (getenv('HTTP_X_FORWARDED'))
                    $ipaddress = getenv('HTTP_X_FORWARDED');
                elseif (getenv('HTTP_FORWARDED_FOR'))
                    $ipaddress = getenv('HTTP_FORWARDED_FOR');
                elseif (getenv('HTTP_FORWARDED'))
                    $ipaddress = getenv('HTTP_FORWARDED');
                elseif (getenv('REMOTE_ADDR'))
                    $ipaddress = getenv('REMOTE_ADDR');
                else
                    $ipaddress = 'UNKNOWN';

                $ipaddress = ($ipaddress == '::1') ? '127.0.0.1' : $ipaddress;
                
                $ct_old = get_post_meta( $ct_id, 'cl_countdown_ip_'.$countdown_id, true );
                
                if ($countdown_id != '') :
                    
                    if( isset($ct_old[$ipaddress]) && $ct_old[$ipaddress]['timer'] == $add ){
                        $get_cookie_countdown_date_time = $ct_old[$ipaddress]['value'];
                    }
                    else{
                        if( $ct_old == '' ){
                            $arr_ip = array( $ipaddress => array(
                                'value' => $set_countdown_time,
                                'timer' => $add
                            ));
                            add_post_meta($ct_id, 'cl_countdown_ip_'.$countdown_id, $arr_ip, true);
                        }
                        else{
                            $ct_old[$ipaddress] = array(
                                'value' => $set_countdown_time,
                                'timer' => $add
                            );
                            update_post_meta($ct_id, 'cl_countdown_ip_'.$countdown_id, $ct_old);
                        }
                        $get_cookie_countdown_date_time = $set_countdown_time;
                    }
                    
                    wp_localize_script('cepatlakoo-functions', '_cepatlakoo', array(
                        'scarcity_countdown_date_time' => $get_cookie_countdown_date_time,
                        'scarcity_countdown_type' => $countdown_type
                    )); ?>

                    <div class="sc-time" style="display:none;"><?php echo esc_attr($get_cookie_countdown_date_time) ?></div>
                    <div class="sc-type" style="display:none;"><?php echo esc_attr($countdown_type) ?></div>
                <?php endif;
            }
            
        } else {
            $countdown_date = get_post_meta( $countdown_id, 'cl_normal_countdown_date', true );
            $countdown_hour = get_post_meta( $countdown_id, 'cl_normal_countdown_hour', true );
            $countdown_minute = get_post_meta( $countdown_id, 'cl_normal_countdown_minute', true );
            $countdown_second = get_post_meta( $countdown_id, 'cl_normal_countdown_second', true );
            $countdown_detection = get_post_meta( $countdown_id, 'cl_normal_countdown_detection', true );
            $expiry = time() + (86400 * 360); // 86400 = 1 day expires
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $host = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST);

            $set_curr_time = date( 'Y/m/d H:i:s', current_time( 'timestamp', 0 ) );
            $curr_time = new DateTime($set_curr_time);

            $set_countdown_time = $countdown_date.' '.$countdown_hour.':'.$countdown_minute.':'.$countdown_second;
            $countdown_time = date_create_from_format('Y-m-d H:i:s', $set_countdown_time);

            wp_localize_script('cepatlakoo-functions', '_cepatlakoo', array(
                'scarcity_countdown_date_time' => $set_countdown_time,
                'scarcity_countdown_type' => $countdown_type
            ));

            echo '<div class="sc-time" style="display:none;">'.$set_countdown_time.'</div>';
            echo '<div class="sc-type" style="display:none;">'.$countdown_type.'</div>';
        }

        if (!empty($get_cookie_countdown_date_time) || !empty($countdown_id) || !empty($countdown_type)) {
            $cepatlakoo_countdown_heading_cart = !empty( $cl_options['cepatlakoo_countdown_heading_cart'] ) ? $cl_options['cepatlakoo_countdown_heading_cart'] : '';
            $cepatlakoo_countdown_subheading_cart = !empty( $cl_options['cepatlakoo_countdown_subheading_cart'] ) ? $cl_options['cepatlakoo_countdown_subheading_cart'] : '';
        }else{
            $cepatlakoo_countdown_heading_cart = null;
            $cepatlakoo_countdown_subheading_cart = null;
        }
        
        if( $cepatlakoo_countdown_heading_cart !== null && $cepatlakoo_countdown_subheading_cart !== null && !empty($countdown_id) ) {
?>
        <div id="countdown-widget">
            <div id="countdown-container">
                <?php if ( $cepatlakoo_countdown_heading_cart || $cepatlakoo_countdown_subheading_cart ) : ?>
                    <div class="coutndown-head">
                        <?php if( $cepatlakoo_countdown_heading_cart ) : ?>
                            <h3><?php echo $cepatlakoo_countdown_heading_cart; ?></h3>
                        <?php endif; ?>

                        <?php if( $cepatlakoo_countdown_subheading_cart ) : ?>
                            <h4 class="subheading"><?php echo $cepatlakoo_countdown_subheading_cart; ?></h4>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div id="<?php echo ( $ct_position == 'woo' ) ? 'countdown' : 'countdown_qv'; ?>" data-stellar-ratio="0.5">
                    <div id="timer">
                        <div class="number-container month"><div class="number"></div><div class="text"></div></div>
                        <div class="number-container day"><div class="number"></div><div class="text"></div></div>
                        <div class="number-container hour"><div class="number"></div><div class="text"></div></div>
                        <div class="number-container minute"><div class="number"></div><div class="text"></div></div>
                        <div class="number-container second"><div class="number"></div><div class="text"></div></div>
                    </div>
                </div>
            </div>
        </div>
<?php
        }
    }
}

/**
* Functions to get slug from URL
*
* @package WordPress
* @subpackage CepatLakoo
* @since CepatLakoo 1.0.0
*/
if ( ! function_exists( 'cepatlakoo_getslug_url') ) {
    function cepatlakoo_getslug_url() {
        return substr($_SERVER['REQUEST_URI'], 1);
    }
}

/**
* Functions to extract image size
*
* @package WordPress
* @subpackage CepatLakoo
* @
*/
if ( ! function_exists( 'cepatlakoo_extract_image_size') ) {
    function cepatlakoo_extract_image_size() {
        $array = get_intermediate_image_sizes();
        foreach ($array as $key=>$value) {
            $out[$value] = $value;
        }
        return $out;
    }
}

/**
* Functions to get attachment ID
*
* @package WordPress
* @subpackage CepatLakoo
* @since CepatLakoo 1.0.0
*/
if ( ! function_exists( 'cepatlakoo_get_image_id' ) ) {
    function cepatlakoo_get_image_id( $image_url ) {
        global $wpdb;

        $attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );

        if( ! $attachment ) {
            return '';
        }

        return $attachment[0];
    }
}

/**
* Functions to extract cpt slideshow
*
* @package WordPress
* @subpackage CepatLakoo
* @
*/
if ( ! function_exists( 'cepatlakoo_extract_cpt_slideshow') ) {
    function cepatlakoo_extract_cpt_slideshow() {
        $post_list = get_posts( array(
            'post_type'             => 'cl_slideshow',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
        ) );

        $posts = array();

        foreach ( $post_list as $post ) {
            $posts += array( esc_html('-- Choose Slideshow --', 'cepatlakoo'), $post->ID => $post->post_title);
        }
        return $posts;
    }
}

/**
* Functions to extract thumnail cpt Elementor Lib
*
* @package WordPress
* @subpackage CepatLakoo
* @
*/
if ( ! function_exists( 'cepatlakoo_extract_el_library') ) {
    function cepatlakoo_extract_el_library() {
        $post_list = get_posts( array(
            'post_type'             => 'elementor_library',
            'post_status'           => 'publish',
            'posts_per_page'        => -1,
        ) );

        $imagelist = array();
        if ( $post_list ) {
            foreach ( $post_list as $post ) {
                $imagelist += array( $post->ID => get_the_post_thumbnail_url($post->ID, 'cepatlakoo-featured-post'));
            }
        }
        return $imagelist;
    }
}

/**
* Functions to get last ID in cpt slideshow
*
* @package WordPress
* @subpackage CepatLakoo
* @
*/
if ( ! function_exists( 'cepatlakoo_lastid_slideshow') ) {
    function cepatlakoo_lastid_slideshow() {
        $latest_cpt = get_posts("post_type=cl_slideshow&numberposts=1");
        if ( $latest_cpt ) {
            return absint( $latest_cpt[0]->ID );
        } else {
            return;
        }

    }
}

/**
* Functions to get last ID in cpt slideshow
*
* @package WordPress
* @subpackage CepatLakoo
* @
*/
if ( ! function_exists( 'cepatlakoo_fb_pixel_data') ) {
    function cepatlakoo_fb_pixel_data( ) {
        global $cl_options;

        $cepatlakoo_facebook_pixel_id = !empty( $cl_options['cepatlakoo_facebook_pixel_id'] ) ? $cl_options['cepatlakoo_facebook_pixel_id'] : '';
        $pixel = get_post_meta(get_the_ID(), 'cepatlakoo_fbpixel_event', true );
        $pixel_currency = get_post_meta(get_the_ID(), 'cepatlakoo_pixel_currency', true );
        $pixel_price = get_post_meta(get_the_ID(), 'cepatlakoo_pixel_price', true );

            if ( $cepatlakoo_facebook_pixel_id ) {
                if ( $pixel ) {
                    if ( $pixel == 'AddToCart' || $pixel == 'InitiateCheckout' || $pixel == 'Purchase' ){
                        return 'fb-pixel="' . esc_attr( $pixel ) .'" fb-currency="'. esc_attr( !empty( $pixel_currency ) ? $pixel_currency : 'IDR' ) .'" fb-price="'. esc_attr( !empty( $pixel_price ) ? $pixel_price : '0' ) .'"';
                    } else {
                        return 'fb-pixel="' . esc_attr( $pixel ) .'"';
                    }
                }else{
                    return 'fb-pixel="ViewContent"';
                }
            } else {
                return;
            }
    }
}
/**
* Functions to extract cpt slideshow
*
* @package WordPress
* @subpackage CepatLakoo
* @
*/
if ( ! function_exists( 'cepatlakoo_get_post_type_post_options') ) {
    function cepatlakoo_get_post_type_post_options() {
        $post_list = get_posts( array(
            'post_type'             => 'cl_countdown_timer',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
        ) );

        $posts = array();

        foreach ( $post_list as $post ) {
           $posts += array( esc_html('-- Choose Countdown --', 'cepatlakoo'), $post->ID => $post->post_title);
        }
        return $posts;
    }
}

/**
* Functions to set logo in Admin Dashboard
*
* @package WordPress
* @subpackage CepatLakoo
* @source : code.tutsplus.com/articles/customizing-the-wordpress-dashboard-for-your-clients--wp-21513
*
*/
if ( ! function_exists( 'cepatlakoo_custom_login_logo' ) ) {
    function cepatlakoo_custom_login_logo() {
        global $cl_options;

        $cepatlakoo_logo_login_dashboard = !empty( $cl_options['cepatlakoo_logo_login_dashboard'] ) ? $cl_options['cepatlakoo_logo_login_dashboard'] : '';
        $attachment = wp_get_attachment_image_src($cepatlakoo_logo_login_dashboard, 'large');

        if($attachment){
            $attachment = $attachment[0];
            echo '
                <style type="text/css">
                    .login h1 a {
                        background-image:url(' . esc_url( $attachment ) .') !important;
                        height: 44px;
                        background-size: 150px;
                        width: auto;
                    }
                </style>
            ';
        }
    }
}
add_action('login_head',  'cepatlakoo_custom_login_logo');

/**
* Functions to  CUSTOM ADMIN DASHBOARD HEADER LOGO
*
* @package WordPress
* @subpackage CepatLakoo
* @source : www.wpbeginner.com/wp-themes/adding-a-custom-dashboard-logo-in-wordpress-for-branding/
*
*/
if ( ! function_exists( 'cepatlakoo_custom_admin_logo' ) ) {
    function cepatlakoo_custom_admin_logo() {
        global $cl_options;

        $cepatlakoo_icon_admin_dashboard = !empty( $cl_options['cepatlakoo_icon_admin_dashboard'] ) ? $cl_options['cepatlakoo_icon_admin_dashboard']['id'] : '';
        $cepatlakoo_logo_login_dashboard = !empty( $cl_options['cepatlakoo_logo_login_dashboard'] ) ? $cl_options['cepatlakoo_logo_login_dashboard']['id'] : '';

        $attachment_icon = null;
        $attachment_logo = null;

        if( $cepatlakoo_logo_login_dashboard || $cepatlakoo_icon_admin_dashboard ){
            $attachment_logo = wp_get_attachment_image_src($cepatlakoo_logo_login_dashboard, 'full');
            $attachment_icon = wp_get_attachment_image_src($cepatlakoo_icon_admin_dashboard, 'full');
        }

        if( $attachment_logo ) {
            $attachment_logo = $attachment_logo[0];
            echo '
            <style type="text/css">
                .wrap h1:before {
                    background-image: url(' . esc_url( $attachment_logo ) .') !important;
                    background-size: contain;
                    background-repeat: no-repeat;
                    display: block;
                    width: 300px;
                    height: 50px;
                    content: "";
                    margin-bottom: 20px;
                }
            </style>
            ';
        }

        if( $attachment_icon ) {
            $attachment_icon = $attachment_icon[0];
            echo '
            <style type="text/css">
                #wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
                    background-image: url(' . esc_url( $attachment_icon ) .') !important;
                    background-position: top center;
                    background-size: contain;
                    color:rgba(0, 0, 0, 0);
                }
                #wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
                    background-position: 0 0;
                }
            </style>
            ';
        }
    }
}
add_action('wp_before_admin_bar_render',  'cepatlakoo_custom_admin_logo');
add_action('admin_head',  'cepatlakoo_custom_admin_logo');

/**
* Functions to replace hexcode for sms and whatsapp
*
* @package WordPress
* @subpackage CepatLakoo
*
*/
if ( ! function_exists( 'cepatlakoo_replace_hexcode' ) ) {
    function cepatlakoo_replace_hexcode( $string ){
        $cepatlakoo_replace_hexcode = str_replace( '&#8211;', '%2D', $string);
        $cepatlakoo_replace_hexcode = str_replace( '&', '%26', $cepatlakoo_replace_hexcode);
        $cepatlakoo_replace_hexcode = str_replace( "\n", '%0A', $cepatlakoo_replace_hexcode);
        $cepatlakoo_replace_hexcode = str_replace( '%26amp;', '%26', $cepatlakoo_replace_hexcode);
        $cepatlakoo_replace_hexcode = str_replace( '%26#038;', '%26', $cepatlakoo_replace_hexcode);
        $cepatlakoo_replace_hexcode = str_replace( '&#8211;', '%26', $cepatlakoo_replace_hexcode);
        $cepatlakoo_replace_hexcode = str_replace( '%26#038;', '%26', $cepatlakoo_replace_hexcode);
        $cepatlakoo_replace_hexcode = str_replace( "#", '%23', $cepatlakoo_replace_hexcode);
        return $cepatlakoo_replace_hexcode;
    }
}


/**
* Functions to register migration menu
*
* @package WordPress
* @subpackage CepatLakoo
*
*/
if ( ! function_exists( 'cepatlakoo_migration_page' ) ) {
    function cepatlakoo_migration_page() {

    echo '<h2>'. __('Bingung? Tonton video tutorial migrasi theme options sekarang. <a href="https://cepatlakoo.com/video-tutorial/tutorial-migrasi-theme-options-cepatlakoo/" target="_blank">Klik di sini</a>', 'cepatlakoo') .'</h2>';
    $i = 0;
    $s1 = 'disabled'; $s2 = 'disabled'; $s3 = 'disabled';
        if ( !file_exists( WP_PLUGIN_DIR . '/redux-framework/redux-framework.php') ) {
            $i=1; $s1 = 'active';
            if ( get_option('cepatlakoo_migration_themeoption' ) ) {
                update_option( 'cepatlakoo_migration_themeoption',  '0' );
            }
        }

        if  ( ! is_plugin_active( 'redux-framework/redux-framework.php' ) ) {
            if ( get_option('cepatlakoo_migration_themeoption' ) ) {
                update_option( 'cepatlakoo_migration_themeoption',  '0' );
            }
            $s2 = ($i == 0) ? 'active' : 'disabled'; $i=2;
        }
        
        if( ! get_option('cepatlakoo_migration_themeoption') ){
            $s3 = ($i == 0) ? 'active' : 'disabled';
        }
        echo'
        <div class="container">
            <div class="row form-group">
                <div class="col-xs-12">
                    <ul class="nav step-migration setup-panel">
                        <li class="'.$s1.'"><a href="#step-1">
                            <p>'.esc_html__('Pasang Plugin Redux Framework', 'cepatlakoo').'</p>
                        </a></li>
                        <li class="'.$s2.'"><a href="#step-2">
                            <p>'.esc_html__('Aktifkan Plugin Redux Framework', 'cepatlakoo').'</p>
                        </a></li>
                        <li class="'.$s3.'"><a href="#step-3">
                            <p>'.esc_html__('Mulai Migrasi', 'cepatlakoo').'</p>
                        </a></li>
                    </ul>
                </div>
            </div>
            <div class="row setup-content" id="step-1">
                <div class="col-xs-12">
                    <div class="col-md-12 well text-center">
                        <h1> '.esc_html__('LANGKAH 1 - Pasang Plugin Redux Framework', 'cepatlakoo').'</h1>
                        <p>'.esc_html__('Cepatlakoo mengalami perubahan pada theme options,  Anda diwajibkan untuk menginstall plugin Redux Framework. Klik tombol Install Redux Framework untuk mulai menginstall plugin tersebut.', 'cepatlakoo').'</p>
                        <a href="'. get_admin_url() . 'themes.php?page=tgmpa-install-plugins&plugin_status=install' .'" class="button-primary cl-install-redux">' . esc_html__('Install Redux Framework', 'cepatlakoo') . '</a>
                    </div>
                </div>
            </div>
            <div class="row setup-content" id="step-2">
                <div class="col-xs-12">
                    <div class="col-md-12 well">
                        <h1> '.esc_html__('LANGKAH 2 - Aktifkan Plugin Redux Framework', 'cepatlakoo').'</h1>
                        <p>'.esc_html__('Cepatlakoo mengalami perubahan pada theme options,  Anda diwajibkan untuk menginstall plugin Redux Framework. Klik tombol Install Redux Framework untuk mulai menginstall plugin tersebut pada halaman berikutnya.', 'cepatlakoo').'</p>
                        <a href="#active_redux" class="button-primary cl-active-redux">' . esc_html__('Aktifkan Redux Framework', 'cepatlakoo') . '</a>
                        <img src='.get_template_directory_uri().'/images/loader.gif class="migration-loader" style="display:none">
                    </div>
                </div>
            </div>
            <div class="row setup-content" id="step-3">
                <div class="col-xs-12">
                    <div class="col-md-12 well">
                    <h1> '.esc_html__('LANGKAH 3 - Mulai Migrasi', 'cepatlakoo').'</h1>
                    <p>'.esc_html__('Klik tombol Migrasi Sekarang untuk melakukan proses migrasi theme options ke Redux Framework.', 'cepatlakoo').'</p>
                    <a href="#migration_themeoption" class="button-primary cl-migration">' . esc_html__('Migrasi Sekarang', 'cepatlakoo') . '</a>
                    <img src='.get_template_directory_uri().'/images/loader.gif class="migration-loader" style="display:none">
                    </div>
                </div>
            </div>
        </div>';
    }
}

add_action('admin_menu', 'cepatlakoo_migration_menu');
if ( ! function_exists( 'cepatlakoo_migration_menu' ) ) {
    function cepatlakoo_migration_menu() {
        if (  !file_exists( WP_PLUGIN_DIR . '/redux-framework/redux-framework.php') ||
        !is_plugin_active( 'redux-framework/redux-framework.php' ) ||
        !get_option('cepatlakoo_migration_themeoption') ) {
            add_submenu_page( 'options-general.php', 'Update Themes Options', 'Update Themes Options', 'manage_options', 'cepatlakoo_migration_menu', 'cepatlakoo_migration_page' );
        }
    }
}
?>