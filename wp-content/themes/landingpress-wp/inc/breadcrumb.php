<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function landingpress_get_breadcrumb( $args = array() ) {

	if ( get_theme_mod( 'landingpress_breadcrumb_hide' ) ) {
		return;
	}

	if ( !landingpress_is_breadcrumb_active() )	
		return;

	if ( is_front_page() && !is_paged() ) {
		return;
	}

	$defaults = apply_filters( 'landingpress_breadcrumb_defaults', array(
		'delimiter'   => '',
		'wrap_before' => '<nav class="breadcrumb clearfix"><ul vocab="http://schema.org/" typeof="BreadcrumbList">',
		'wrap_after'  => '</ul></nav>',
		'before'      => '<li property="itemListElement" typeof="ListItem">',
		'after'       => '</li>',
		'before_last' => '<li>',
		'after_last'  => '</li>',
		'home'        => esc_html__( 'Home', 'landingpress-wp' ),
	) );

	$args = wp_parse_args( $args, $defaults );

	extract( $args );

	global $post, $wp_query;

	$html = '';
	$count = 0;

	$html .= $wrap_before;

	$paged = '';
	if ( get_query_var( 'paged' ) ) {
		$paged = ' '.sprintf( esc_html__( '(Page %s)', 'landingpress-wp' ), get_query_var( 'paged' ) );
	}

	if ( ! empty( $home ) ) {
		$count++;
		$html .= sprintf( '%s<a href="%s" property="item" typeof="WebPage"><span property="name">%s</span><meta property="position" content="%s"></a>%s%s', $before, apply_filters( 'landingpress_breadcrumb_home_url', home_url() ), $home, $count, $after, $delimiter );
	}

	if ( is_front_page() ) {
		if ( is_paged() ) {
			$html .= $before_last . sprintf( esc_html__( 'Page %s', 'landingpress-wp' ), get_query_var( 'paged' ) ) . $after_last;
		}
	} 
	elseif ( is_home() && !is_front_page() ) {
		$queried_object = $wp_query->get_queried_object();
		if ( isset( $queried_object->post_title ) && $queried_object->post_title ) {
			$html .= $before_last .$queried_object->post_title . $paged . $after_last;
		}
	} 
	elseif ( is_single() && !is_attachment() ) {
		if ( get_post_type() != 'post' ) {
			if ( get_post_type_archive_link( get_post_type() ) ) {
				$post_type = get_post_type_object( get_post_type() );
				$slug = $post_type->rewrite;
				$count++;
				$html .= sprintf( '%s<a href="%s" property="item" typeof="WebPage"><span property="name">%s</span><meta property="position" content="%s"></a>%s%s', $before, get_post_type_archive_link( get_post_type() ), $post_type->labels->singular_name, $count, $after, $delimiter );
			}
		} 
		else {
			$cat = current( get_the_category() );
			if ( isset( $cat->term_id ) && $cat->term_id ) {
				$parent_id  = $cat->term_id;
				$breadcrumbs = array();
				while ( $parent_id ) {
					$cat = get_term( $parent_id, 'category' );
					if ( ! is_wp_error( $cat ) ) {
						$breadcrumbs[] = sprintf( '%s<a href="%s" property="item" typeof="WebPage"><span property="name">%s</span><metaposition></a>%s%s', $before, get_category_link( $cat->term_id ), $cat->name, $after, $delimiter );
						$parent_id = $cat->parent;
					}
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				foreach ( $breadcrumbs as $crumb ) {
					$count++;
					$crumb = str_replace( '<metaposition>', '<meta property="position" content="'.$count.'">', $crumb );
					$html .= $crumb;
				}
			}
		}
		$html .= $before_last . get_the_title() . $paged . $after_last;
	} 
	elseif ( is_attachment() ) {
		if ( isset($post->post_parent) && $post->post_parent ) {
			$parent = get_post( $post->post_parent );
			$count++;
			$html .= sprintf( '%s<a href="%s" property="item" typeof="WebPage"><span property="name">%s</span><meta property="position" content="%s"></a>%s%s', $before, get_permalink( $parent ), $parent->post_title, $count, $after, $delimiter );
		}
		$html .= $before_last . get_the_title() . $paged . $after_last;
	} 
	elseif ( is_page() ) {
		if ( isset($post->post_parent) && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ( $parent_id ) {
				$page = get_page( $parent_id );
				$breadcrumbs[] = sprintf( '%s<a href="%s" property="item" typeof="WebPage"><span property="name">%s</span><metaposition></a>%s%s', $before, get_permalink($page->ID), get_the_title( $page->ID ), $after, $delimiter );
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_reverse( $breadcrumbs );
			foreach ( $breadcrumbs as $crumb ) {
				$count++;
				$crumb = str_replace( '<metaposition>', '<meta property="position" content="'.$count.'">', $crumb );
				$html .= $crumb;
			}
		}
		$html .= $before_last . get_the_title() . $paged . $after_last;
	} 
	elseif ( is_post_type_archive() ) {
		$html .= $before_last . post_type_archive_title( '', false ) . $paged . $after_last;
	} 
	elseif ( is_category() ) {
		$cat_obj = $wp_query->get_queried_object();
		if ( $cat_obj->category_parent ) {
			$parent_id  = $cat_obj->category_parent;
			$breadcrumbs = array();
			while ( $parent_id ) {
				$cat = get_term( $parent_id, 'category' );
				if ( ! is_wp_error( $cat ) ) {
					$breadcrumbs[] = sprintf( '%s<a href="%s" property="item" typeof="WebPage"><span property="name">%s</span><metaposition></a>%s%s', $before, get_category_link( $cat->term_id ), $cat->name, $after, $delimiter );
					$parent_id = $cat->parent;
				}
			}
			$breadcrumbs = array_reverse( $breadcrumbs );
			foreach ( $breadcrumbs as $crumb ) {
				$count++;
				$crumb = str_replace( '<metaposition>', '<meta property="position" content="'.$count.'">', $crumb );
				$html .= $crumb;
			}
		}
		$html .= $before_last . single_cat_title( '', false ) . $paged . $after_last;
	} 
	elseif ( is_tax() ) {
		$queried_object = $wp_query->get_queried_object();
		$html .= $before_last . $queried_object->name . $paged . $after_last;
	}
	elseif ( is_day() ) {
		$count++;
		$html .= sprintf( '%s<a href="%s" property="item" typeof="WebPage"><span property="name">%s</span><meta property="position" content="%s"></a>%s%s', $before, get_year_link(get_the_time('Y')), get_the_time('Y'), $count, $after, $delimiter );
		$count++;
		$html .= sprintf( '%s<a href="%s" property="item" typeof="WebPage"><span property="name">%s</span><meta property="position" content="%s"></a>%s%s', $before, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F'), $count, $after, $delimiter );
		$html .= $before_last . get_the_time('d') . $paged . $after_last;
	} 
	elseif ( is_month() ) {
		$count++;
		$html .= sprintf( '%s<a href="%s" property="item" typeof="WebPage"><span property="name">%s</span><meta property="position" content="%s"></a>%s%s', $before, get_year_link(get_the_time('Y')), get_the_time('Y'), $count, $after, $delimiter );
		$html .= $before_last . get_the_time('F') . $paged . $after_last;
	} 
	elseif ( is_year() ) {
		$html .= $before_last . get_the_time('Y') . $paged . $after_last;
	} 
	elseif ( is_search() ) {
		$html .= $before_last . esc_html__( 'Search results for &ldquo;', 'landingpress-wp' ) . get_search_query() . '&rdquo;' . $paged . $after_last;
	} 
	elseif ( is_tag() ) {
		$html .= $before_last . esc_html__( 'Posts tagged &ldquo;', 'landingpress-wp' ) . single_tag_title('', false) . '&rdquo;' . $paged . $after_last;
	} 
	elseif ( is_author() ) {
		$userdata = get_userdata($author);
		$html .= $before_last . esc_html__( 'Author:', 'landingpress-wp' ) . ' ' . $userdata->display_name . $paged . $after_last;
	}
	elseif ( is_404() ) {
		$html .= $before_last . esc_html__( 'Error 404', 'landingpress-wp' ) . $paged . $after_last;
	} 

	$html .= $wrap_after.PHP_EOL;

	return apply_filters( "landingpress_breadcrumb", $html );

}
