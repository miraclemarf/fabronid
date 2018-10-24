<?php
/**
 * The template for displaying header part.
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.0
 */
?>

<?php ob_start(); // Initiate the output buffer ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php 
$datas = get_post_meta(get_the_ID(), '_elementor_data', true);

if( strpos($datas, 'cepatlakoo') || strpos($datas, 'wc-elements'))
    cepatlakoo_sidebar_cart_content();

?>
