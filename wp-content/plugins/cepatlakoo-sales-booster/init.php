<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/***************
*
* Initiliaze Our Plugin Here

 _ |. _ _ | _  _  _ _ '~)L~'~)
(_|||_\(_||(/_(/_| | | /__) /_

****************/

/* Add Menu and Stuff */
add_action( 'admin_menu','cl_salesbooster_options' );
function cl_salesbooster_options() {
	add_submenu_page( 'woocommerce', 'CL Sales Booster Options', 'CL Sales Booster', 'manage_options', 'cl_sales_booster', 'cl_sales_booster_manage_options' );
} //close function


/**
 * Add new setting group
 */
add_action( 'admin_init', 'cl_salesbooster_init' );
function cl_salesbooster_init() {
	// register_setting( 'cl_salesbooster', 'cl_salesbooster_setting' );
	add_option( 'cl_salesbooster_setting', array() );
}


/**
 * Validation
 */

function cl_salesbooster_input_validation( $input ) {
	return $input;
}

function cl_sales_booster_options_success() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php esc_html_e( 'Setting Saved.', 'cl-sales-booster' ) ?></p>
    </div>
    <?php
}
// add_action( 'admin_notices', 'cl_sales_booster_options_success' );

function cl_sales_booster_manage_options() {
	if ( isset($_POST['wooboaster_submit'] ) ) {
		$enable = isset( $_POST['cl_enable_salesbooster'] ) ? ( $_POST['cl_enable_salesbooster'] == 'yes' ? 'yes' : '' ) : '';
		update_option( 'cl_enable_salesbooster', $enable );
		// Or generate the Original Json File

		cl_create_salesbooster();

		$option_array = array();
		$option_array['display-name'] = '0';
		$option_array['sales-limit'] = 15;
		$option_array['sales-min-delay'] = 5;
		$option_array['sales-max-delay'] = 10;
		$option_array['display-random'] = '0';

		if ( isset( $_POST['cl_salesbooster_setting']['display-name'] ) ) {
        	$option_array['display-name'] = '1';
		}

		if ( isset( $_POST['cl_salesbooster_setting']['sales-limit'] ) ) {
        	$option_array['sales-limit'] = $_POST['cl_salesbooster_setting']['sales-limit'];
		}

		if ( isset( $_POST['cl_salesbooster_setting']['sales-min-delay'] ) ) {
        	$option_array['sales-min-delay'] = $_POST['cl_salesbooster_setting']['sales-min-delay'];
		}

		if ( isset( $_POST['cl_salesbooster_setting']['sales-max-delay'] ) ) {
        	$option_array['sales-max-delay'] = $_POST['cl_salesbooster_setting']['sales-max-delay'];
		}

		if ( isset( $_POST['cl_salesbooster_setting']['display-random'] ) ) {
        	$option_array['display-random'] = $_POST['cl_salesbooster_setting']['display-random'];
		}
      	
		  update_option('cl_salesbooster_setting', $option_array);
		  cl_sales_booster_options_success();
	}
?>

	<div id="wrap">
		<h2><?php esc_html_e( 'Cepatlakoo Sales Booster for WooCommerce', 'cl-sales-booster' ) ?></h2>
		<p><?php esc_html_e( 'Notify store visitors about the recent WooCommerce sales', 'cl-sales-booster' ) ?></p>
		
		<form method="post" action="">
			<?php
			settings_fields( 'cl_salesbooster' );
			$options = get_option('cl_salesbooster_setting');
			?>

			<table class="form-table">
				<tr>
                	<th scope="row"><label for="blogname"><?php esc_html_e( 'Enable Sales Booster', 'cl-sales-booster' ) ?></label>
	                </th>
	                <td>
	                	<input type="radio" name="cl_enable_salesbooster" id="salesbooster_yes" value="yes" <?php $option = get_option( 'cl_enable_salesbooster' ); echo ( $option == 'yes' ? 'checked' : '' );?>/>
	                	<label for="salesbooster_yes"><?php esc_html_e( 'Yes','cl-sales-booster' ) ?></label>
	                    <input type="radio" name="cl_enable_salesbooster" id="salesbooster_no" value="no" <?php $option = get_option( 'cl_enable_salesbooster' ); echo ( $option == '' ? 'checked' : '' );?>/>
	                    <label for="salesbooster_no"><?php esc_html_e( 'No', 'cl-sales-booster' ) ?></label>
					</td>
				</tr>

				<tr>
					<th scope="row"><?php esc_html_e( 'Display buyer\'s name?', 'cl-sales-booster' ); ?></th>
					<td>
						<label for="display-name">
							<input type="checkbox" id="display-name" name="cl_salesbooster_setting[display-name]" value="1" <?php checked( '1', @$options['display-name'] ); ?> />
							<?php esc_html_e( 'Yes', 'cl-sales-booster' ); ?>
						</label>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="sales-limit"><?php esc_html_e( 'Number of sales displayed:', 'cl-sales-booster' ); ?></label>
					</th>
					<td>
						<?php
						$limit = 15;
						if ( isset( $options['sales-limit'] ) ) {
							$limit = $options['sales-limit'];
						}
						?>
						<input type="number" id="sales-limit" name="cl_salesbooster_setting[sales-limit]" value="<?php echo esc_attr( $limit ); ?>" step="1" min="1" style="width:80px;" />
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="sales-min-delay"><?php esc_html_e( 'Set minimal delay', 'cl-sales-booster' ); ?></label>
					</th>
					<td>
						<?php
						$min_delay = 5;
						if ( isset( $options['sales-min-delay'] ) ) {
							$min_delay = $options['sales-min-delay'];
						}
						?>
						<input type="number" id="sales-min-delay" name="cl_salesbooster_setting[sales-min-delay]" value="<?php echo esc_attr( $min_delay ); ?>" step="1" min="5" max="20" style="width:80px;" />
						<?php esc_html_e( 'seconds', 'cl-sales-booster' ); ?>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="sales-max-delay"><?php esc_html_e( 'Set maxmimum delay', 'cl-sales-booster' ); ?></label>
					</th>
					<td>
						<?php
						$max_delay = 10;
						if ( isset( $options['sales-max-delay'] ) ) {
							$max_delay = $options['sales-max-delay'];
						}
						?>
						<input type="number" id="sales-max-delay" name="cl_salesbooster_setting[sales-max-delay]" value="<?php echo esc_attr( $max_delay ); ?>" step="1" min="10" max="60" style="width:80px;" />
						<?php esc_html_e( 'seconds', 'cl-sales-booster' ); ?>
						<span class='cl-sales-delay-error' style="display:none; color:red"> <br><?php esc_html_e( 'Max value must greater than min value', 'cl-sales-booster' ); ?> </span>
					</td>
				</tr>

				<tr>
					<th scope="row"><?php esc_html_e('Display randomly?', 'cl-sales-booster'); ?></th>
					<td>
						<label for="display-random">
							<input type="checkbox" id="display-random" name="cl_salesbooster_setting[display-random]" value="1" <?php checked( '1', @$options['display-random'] ); ?> />
							<?php esc_html_e( 'Yes', 'cl-sales-booster' ); ?>
						</label>
					</td>
				</tr>

	            <tr>
	             	<td></td>
	             	<td><input type="submit" name="wooboaster_submit" class="button-primary cl-sales-submit" value="Save and Generate" /></td>
	            </tr>
				
        	</table>
    	</form>
	</div>
	<script>
		jQuery('#sales-max-delay, #sales-min-delay').change(function(){
			if ( parseInt(jQuery('#sales-min-delay').val()) >= parseInt(jQuery('#sales-max-delay').val()) ){
				jQuery('.cl-sales-delay-error').show();
				jQuery('.cl-sales-submit').prop('disabled', true);
			}
			else{
				jQuery('.cl-sales-submit').prop('disabled', false);
				jQuery('.cl-sales-delay-error').hide();
			}
		});
	</script>
<?php
}

function cl_salesbooster_async_scripts( $url ) {
    if ( strpos( $url, '#asyncload') === false ) {
        return $url;
    } else if ( is_admin() ) {
        return str_replace( '#asyncload', '', $url );
    } else {
    	return str_replace( '#asyncload', '', $url )."' async=async";
    }
}
add_filter( 'clean_url', 'cl_salesbooster_async_scripts', 11, 1 );

function cl_salesbooster_theme_scripts() {
    $showNotify = get_post_meta( get_the_ID(), 'notify_meta_checkbox' ) ? get_post_meta( get_the_ID(), 'notify_meta_checkbox' )[0] : '';

    if ( is_woocommerce() || $showNotify == 'on' ) {
		$notify_enabled = get_option( 'cl_enable_salesbooster' );
		
		if ( $notify_enabled != 'yes' ) {
			return;
		}

		$cs_options = get_option( 'cl_salesbooster_setting' );
		$display_name = @$cs_options['display-name'];
		$min_delay = @$cs_options['sales-min-delay'];
		$max_delay = @$cs_options['sales-max-delay'];
		$display_random = @$cs_options['display-random'];

		// $booster = 'booster.dev.js';
		$booster = 'booster.min.js';

		// if ( $display_random == '1' ) {
		// 	$booster = 'booster-random.dev.js';
		// }

		// wp_enqueue_script( 'cepatlakoo_sales', plugin_dir_url( __FILE__ ) . 'js/booster.min.js#asyncload', 'jquery', '', true );
		wp_enqueue_script( 'cepatlakoo_sales', plugin_dir_url( __FILE__ ) . 'js/'.$booster.'#asyncload', 'jquery', '', true );
      	wp_localize_script( 'cepatlakoo_sales', 'cl_sales', array(
            'folder' => plugins_url( '/json/',__FILE__),
            'translation' => array(
                                esc_html__('Someone in', 'cl-sales-booster'),
                                esc_html__('purchase a', 'cl-sales-booster'),
                                esc_html__('ago', 'cl-sales-booster'),
                                esc_html__('from now', 'cl-sales-booster'),
                                esc_html__('less than a minute', 'cl-sales-booster'),
                                esc_html__('about a minute', 'cl-sales-booster'),
                                esc_html__('minutes', 'cl-sales-booster'),
                                esc_html__('about an hour', 'cl-sales-booster'),
                                esc_html__('about', 'cl-sales-booster'),
                                esc_html__('hours', 'cl-sales-booster'),
                                esc_html__('a day', 'cl-sales-booster'),
                                esc_html__('days', 'cl-sales-booster'),
                                esc_html__('about a month', 'cl-sales-booster'),
                                esc_html__('months', 'cl-sales-booster'),
                                esc_html__('about a year', 'cl-sales-booster'),
                                esc_html__('years', 'cl-sales-booster'),
								esc_html__('in', 'cl-sales-booster'),
                              ),
			'display_name' => $display_name,
			'display_random' => $display_random,
			'min_delay'        => $min_delay,
			'max_delay'        => $max_delay,
      	));
    };
}
add_action( 'wp_enqueue_scripts', 'cl_salesbooster_theme_scripts');

function cl_salesbooster_custom_meta() {
    add_meta_box( 'sales_notify', esc_html__( 'Cepatlakoo Sales Booster', 'cl-sales-booster' ), 'cl_salesbooster_meta_callback', 'page' );
}
add_action( 'add_meta_boxes', 'cl_salesbooster_custom_meta' );

function cl_salesbooster_meta_callback() {
    // $post is already set, and contains an object: the WordPress post
    global $post;

    $check = get_post_meta( $post->ID , 'notify_meta_checkbox' ) ? esc_attr( get_post_meta( $post->ID , 'notify_meta_checkbox' )[0] ) : '';

    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <p>
        <input type="checkbox" id="notify_meta_checkbox" name="notify_meta_checkbox" <?php checked( $check, 'on' ); ?> />
        <label for="notify_meta_checkbox"><?php esc_html_e( 'Display sales booster notification in this page', 'cl-sales-booster' ) ?></label>
    </p>
    <?php
}

add_action( 'save_post', 'cl_salesbooster_meta_box_save' );
function cl_salesbooster_meta_box_save( $post_id ) {
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;

    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;

    // This is purely my personal preference for saving check-boxes
    $chk = isset( $_POST['notify_meta_checkbox'] ) ? 'on' : 'off';
    update_post_meta( $post_id, 'notify_meta_checkbox', $chk );
}

// var_dump(dirname(plugin_basename(__FILE__)) . '/languages/'); exit();
load_plugin_textdomain( 'cl-sales-booster', false, dirname(plugin_basename(__FILE__)) . '/languages/' );