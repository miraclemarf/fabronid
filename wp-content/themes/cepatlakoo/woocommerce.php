<?php
/**
 * The template for displaying product page from woocommerce
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
get_header();
?>

<!-- Start : Main Content -->
<?php
global $cl_options;
$cepatlakoo_facebook_pixel_id = !empty( $cl_options['cepatlakoo_facebook_pixel_id'] ) ? $cl_options['cepatlakoo_facebook_pixel_id'] : '';
?>

<?php if ( $cepatlakoo_facebook_pixel_id ) : ?>
	<div id="main" fb-campaign-url="<?php echo esc_url( cepatlakoo_getslug_url() ); ?>" fb-content-name="<?php echo get_the_title() ?>" fb-product-id="<?php echo get_the_ID() ?>" <?php echo cepatlakoo_fb_pixel_data(); ?>>
<?php endif; ?>

<?php
if ( ! is_shop() && ! is_single() ) {
	woocommerce_page_title();
}
?>
		<div id="maincontent">
			<div class="container clearfix">
				<!-- Start : Breadcrumb -->
				<?php
				if ( function_exists( 'woocommerce_breadcrumb' ) ) {
					$args = array(
						'delimiter' => ' / ',
						'wrap_before' => '<div id="breadcrumbs">',
						'wrap_after' => '</div>'
					);
				 	woocommerce_breadcrumb( $args );
				}
				?>
				<!-- End : Breadcrumb -->
				<?php
				if ( is_single() ) :
					cepatlakoo_single_style( get_the_ID() );
				else :
					get_sidebar( 'woocommerce' );
				?>
					<div id="contentarea">
						<div id="products-area">

							<?php if( ! is_search() ) : ?>
								<div class="shop-product-nav">
									<div class="product-sorter">
										<?php do_action( 'cepatlakoo_before_shop_order' ); ?>
									</div>
									<?php do_action( 'cepatlakoo_before_shop_pagination' ); ?>
								</div>
							<?php endif; ?>

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

							<div class="shop-product-nav">
								<?php if( ! is_search() ) : ?>
									<div class="product-sorter">
										<?php do_action( 'cepatlakoo_after_shop_order' ); ?>
									</div>
								<?php endif; ?>
								<?php do_action( 'cepatlakoo_after_shop_pagination' ); ?>
							</div>

						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<!-- End : Main Content -->
<?php get_footer(); ?>