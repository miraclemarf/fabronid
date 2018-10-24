<?php
/**
 * The template for displaying footer part.
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
?>
<!-- Start : Footer -->
<?php if ( ! isset( $_GET['elementor_library'] ) ) : ?>
	<footer id="colofon">
	    <?php if ( has_nav_menu( 'cepatlakoo-footer-navigation' ) ) : ?>
	    	<div id="footer-menu-area">
	    		<div class="container clearfix">
		            <nav id="footer-menu" class="footer-menu site-navigation">
		                <?php wp_nav_menu( array( 'theme_location' => 'cepatlakoo-footer-navigation', 'container' => null, 'menu_class' => 'footer-menu', 'depth' => 1 ) ); ?>
		            </nav>
		        </div>
	        </div>
        <?php endif; ?>

		<?php if ( is_active_sidebar( 'cepatlakoo-footer-widget' ) ) : ?>
			<div id="footer-widgets-area">
				<div class="container clearfix">
					<div class="footer-widgets row column-4">
					<?php
						if ( is_active_sidebar('cepatlakoo-footer-widget') ) {
							dynamic_sidebar( 'cepatlakoo-footer-widget' );
						} else {
							echo '<div class="container"><p class="no-widget">';
							printf( wp_kses( __('There is no widget assigned. You can start assigning widgets to "Footer Widgets" widget area from the <a href="%s" target="_blank">Widgets</a>.', 'cepatlakoo'), array(  'a' => array( 'href' => array() ) ) ), admin_url('/widgets.php') );
							echo '</p></div>';
						}
					?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div id="footer-info">
			<div class="container clearfix">
				<div class="site-infos">
					<?php
					// Copyright text
			        global $cl_options;
			        $cepatlakoo_copyright_text = !empty( $cl_options['cepatlakoo_copyright_text'] ) ? $cl_options['cepatlakoo_copyright_text'] : '';

					printf( wp_kses( html_entity_decode( $cepatlakoo_copyright_text ), array(  'a' => array( 'href' => array(), 'target' => array() ), 'p' => array(), 'br' => array(), 'strong' => array(), 'i' => array() ) ) );
				 	?>
				</div>
			</div>
		</div>
		<?php if( ! is_page_template('blank') ) : ?>
			<div id="backtotop"><i class="icon icon-arrow-up"></i></div>
		<?php endif; ?>
	</footer>
<?php endif; ?>
<!-- End : Footer -->

<?php wp_footer(); ?>
</body>
</html>