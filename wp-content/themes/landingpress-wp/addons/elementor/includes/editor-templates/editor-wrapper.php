<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $wp_version;

$body_classes = [
	'elementor-editor-active',
	'wp-version-' . str_replace( '.', '-', $wp_version ),
];

if ( is_rtl() ) {
	$body_classes[] = 'rtl';
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php echo __( 'Elementor', 'elementor' ) . ' | ' . get_the_title(); ?></title>
	<?php wp_head(); ?>
	<script>
		var ajaxurl = '<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>';
	</script>
	<style type="text/css">
		.elementor-template-library-template-remote:nth-child(4n+1),
		.elementor-template-library-template-landingpresstemplates:nth-child(4n+1),
		.elementor-template-library-template-landingpresssections:nth-child(4n+1) {
			clear: both;
		}
		#elementor-template-library-header-logo-area {
			width: 20%;
		}
		#elementor-template-library-header-items-area  {
			width: 20%;
		}
		.elementor-template-library-menu-item {
			padding-left: 10px;
			padding-right: 10px;
		}
		.elementor-template-library-template-landingpresssections .elementor-template-library-template-body {
			height: 136px;
		}
		.elementor-template-library-template-landingpresssections .elementor-template-library-template-preview {
			height: 70px;
		}
		#insert-wuoyMember-shortcode {
			display: none;
		}
		<?php if ( ! in_array( 'elementor-pro/elementor-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) : ?>
			.elementor-panel .elementor-panel-nerd-box {
				display: none;
			}
			#elementor-panel-elements-navigation-global {
				display: none;
			}
			.elementor-control-custom_css_pro, .elementor-control-section_custom_css_pro {
				display: none;
			}
		<?php endif; ?>
	</style>
</head>
<body class="<?php echo implode( ' ', $body_classes ); ?>">
<div id="elementor-editor-wrapper">
	<div id="elementor-preview">
		<div id="elementor-loading">
			<div class="elementor-loader-wrapper">
				<div class="elementor-loader">
					<div class="elementor-loader-box"></div>
					<div class="elementor-loader-box"></div>
					<div class="elementor-loader-box"></div>
					<div class="elementor-loader-box"></div>
				</div>
				<div class="elementor-loading-title"><?php _e( 'Loading', 'elementor' ); ?></div>
			</div>
		</div>
		<div id="elementor-preview-responsive-wrapper" class="elementor-device-desktop elementor-device-rotate-portrait">
			<div id="elementor-preview-loading">
				<i class="fa fa-spin fa-circle-o-notch" aria-hidden="true"></i>
			</div>
			<?php
			// IFrame will be create here by the Javascript later.
			?>
		</div>
	</div>
	<div id="elementor-panel" class="elementor-panel"></div>
</div>
<?php
	wp_footer();
	/** This action is documented in wp-admin/admin-footer.php */
	do_action( 'admin_print_footer_scripts' );
?>
<!--[if LandingPress]></body></html><![endif]-->
<!-- </body></html> -->
</body>
</html>
