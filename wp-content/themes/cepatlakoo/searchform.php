<?php
/**
 * The template for displaying search form.
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
?>
<div class="search-widget">
	<div class="search-form">
		<form id="search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div class="input-group">
				<input type="text" id="s" class="search-field" placeholder="<?php echo esc_html_e( 'Type search and hit enter...', 'cepatlakoo' ); ?>" value="<?php esc_attr( the_search_query() ); ?>" name="s" />
				<input type="submit" class="btn regular-btn submit-btn primary-bg">
				<?php  if(  class_exists( 'WooCommerce' ) && is_woocommerce()) : ?>
					<input type="hidden" name="post_type" value="product" />
				<?php else : ?>
					<input type="hidden" name="post_type" value="post" />
				<?php endif; ?>
			</div>	
		</form>	
	</div>
</div>