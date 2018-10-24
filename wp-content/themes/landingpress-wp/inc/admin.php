<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'manage_posts_columns', 'landingpress_show_id_column' );
add_action( 'manage_posts_custom_column', 'landingpress_show_id_value', 10, 2 );
add_filter( 'manage_pages_columns', 'landingpress_show_id_column' );
add_action( 'manage_pages_custom_column', 'landingpress_show_id_value', 10, 2 );
add_action( 'admin_head', 'landingpress_show_id_css' );

function landingpress_show_id_column( $cols ) {
	$cols['landingpress-show-id'] = 'ID';
	return $cols;
}

function landingpress_show_id_value( $column_name, $id ) {
	if ( $column_name == 'landingpress-show-id' ) {
		echo $id;
	}
}

function landingpress_show_id_css() {
?>
<style type="text/css">
	#landingpress-show-id {
		width: 40px;
	}
</style>
<?php
}
