<?php
/*
* Plugin Name: CepatLakoo Input Resi
* Plugin URI: http://www.themewarrior.com
* Description: Input Resi plugin by CepatLakoo.
* Author: CepatLakoo
* Author URI: http://cepatlakoo.com
* Version: 1.1.0
* Text Domain: cl-input-resi
* Domain Path: /lang
*/

add_action('admin_menu', 'cepatlakoo_input_resi'); // Add Menu
	if( ! function_exists('cepatlakoo_input_resi') ) {
	function cepatlakoo_input_resi() { //Function Add Menu
		add_submenu_page( 'woocommerce', 'CL Input Resi Options', 'CL Input Resi', 'manage_options', 'cepatlakoo_input_resi', 'cepatlakoo_input_resi_init' );
	}}

add_action( 'admin_init', 'cepatlakoo_input_resi_settings' ); // Function Register WP Settings
	if( ! function_exists('cepatlakoo_input_resi_settings') ) {
	function cepatlakoo_input_resi_settings() {
		register_setting( 'cepatlakoo-input-resi', 'cepatlakoo_ekspedisi' );
		register_setting( 'cepatlakoo-input-resi', 'cepatlakoo_resi_link' );
	}}

if( ! function_exists('cepatlakoo_input_resi_init') ){
    function cepatlakoo_input_resi_init() { // Function Add Interface Backend Setting
        settings_errors();
	?>
	<div class="wrap">
	<h2><?php esc_html_e( 'CepatLakoo Input Resi','cl-input-resi' ); ?></h2><hr>
		<p><?php esc_html_e( 'You can add courrier list in here','cl-input-resi' ); ?></p>
		<form method="post" action="options.php" id="myForm">
		    <?php settings_fields( 'cepatlakoo-input-resi' ); ?>
		    <?php do_settings_sections( 'cepatlakoo-input-resis' ); ?>
		    <table class="form-table">
		    	<tbody>
		    		<input type="hidden" name="cepatlakoo_ekspedisi" value="<?php echo esc_attr(get_option('cepatlakoo_ekspedisi')); ?>"></input>
                    <tr>
		    			<th scope="row"><?php esc_html_e( 'Link Halaman Cek Resi','cl-input-resi' ); ?></th>
		    			<td>
                            <div>
                                <input type="text" name="cepatlakoo_resi_link" value="<?php echo esc_attr(get_option('cepatlakoo_resi_link')); ?>" placeholder="https://cekresi.com/?noresi=%lakoo_no_resi%" style="width: 50%;">
                                <br>
                                <?php echo __( 'Default Halaman cek resi : https://cekresi.com/?noresi=%lakoo_no_resi%.<br> Silahkan ganti dengan halaman link lain jika anda memiliki halaman cek resi sendiri.','cl-input-resi' ); ?>
                            </div>
		    			</td>
		    		</tr>
		    		<tr>
		    			<th scope="row"><?php esc_html_e( 'Add Courrier List','cl-input-resi' ); ?></th>
		    			<td>
							<div data-repeater-list="data-ekspedisi">
								<div data-repeater-item class="data-item">
									<input type="text" name="data-ekspedisi[0][text-input]" value="">
									<input data-repeater-delete="" type="button" class="hapus" value="<?php esc_html_e( 'Delete','cl-input-resi' ); ?>">
								</div>
						    </div>
							<input data-repeater-create type="button" value="<?php esc_html_e( 'Add','cl-input-resi' ); ?>"/>
		    			</td>
		    		</tr>
                    
		    	</tbody>
		    </table>
		    <?php submit_button(); ?>
		</form>
	</div>
	<?php
	}}
//---------------------------- Add Options -----------------------------------------//

add_action( 'plugins_loaded', 'cepatlakoo_load_plugin_textdomain' ); //Function Load Text Domain
if( ! function_exists('cepatlakoo_load_plugin_textdomain') ) {
function cepatlakoo_load_plugin_textdomain() {
	load_plugin_textdomain( 'cl-input-resi', FALSE, basename( dirname( __FILE__ ) ) . '/languages' );
}}

//---------------------------- Text Domain -----------------------------------------//

if ( ! function_exists( 'cepatlakoo_input_resi_scripts' ) ) {
	function cepatlakoo_input_resi_scripts() {
        wp_enqueue_script( 'jquery-repeater', plugins_url('assets/js/jquery.repeater.js', __FILE__), array('jquery') );
        wp_enqueue_script( 'cepatlakoo-input-resi', plugins_url('assets/js/cepatlakoo-input-resi.js', __FILE__), array('jquery') );
        wp_enqueue_style( 'cepatlakoo-input-resi', plugins_url('assets/css/cepatlakoo-input-resi.css', __FILE__), array(), false, 'all' );
        wp_localize_script('cepatlakoo-input-resi', '_cl_inputresi', array(
            'translation' => esc_html__( 'Delete', 'cl-input-resi' )
        ));
	}
}
add_action( 'admin_enqueue_scripts', 'cepatlakoo_input_resi_scripts' );

//---------------------------- Enquene Script -----------------------------------------//

//Adding Meta container admin shop_order pages
add_action( 'add_meta_boxes', 'cepatlakoo_meta_box' );
if ( ! function_exists( 'cepatlakoo_meta_box' ) ){
    function cepatlakoo_meta_box(){
        global $woocommerce, $order, $post;
        add_meta_box( 'cepatlakoo_resi_field', __( 'CepatLakoo - Input Resi','cl-input-resi' ), 'cepatlakoo_field_for_resi', 'shop_order', 'side', 'core' );
    }
}

//adding Meta field in the meta container admin shop_order pages
if ( ! function_exists( 'cepatlakoo_field_for_resi' ) ){
    function cepatlakoo_field_for_resi(){
        global $woocommerce, $order, $post;
        $cepatlakoo_resi = get_post_meta( get_the_ID(), '_cepatlakoo_resi', true );
        $cepatlakoo_resi_date = get_post_meta( get_the_ID(), '_cepatlakoo_resi_date', true );
        $cepatlakoo_ekspedisi_meta = get_post_meta( get_the_ID(), '_cepatlakoo_ekspedisi', true );
        $cepatlakoo_ekspedisi = get_option('cepatlakoo_ekspedisi');
        $dataExp[] = explode(',', $cepatlakoo_ekspedisi);

        echo '<input type="hidden" name="cepatlakoo_meta_field_nonce" value="' . wp_create_nonce() . '"><p>' . esc_html__( 'Choose Courrier' ,'cl-input-resi' ) . '</p>';
        echo '<select style="width:250px;" name="_cepatlakoo_ekspedisi" id="cepatlakoo_ekspedisi">'; ?>
        <?php if ( empty( $cepatlakoo_ekspedisi ) ) : ?>
            <option disabled selected value=""><?php esc_html_e( 'Please add courrier list in settings' , 'cl-input-resi' ); ?></option>
        <?php else: ?>
            <option value=""><?php esc_html_e( 'Choose Courrier' , 'cl-input-resi' ); ?></option>
            <?php foreach($dataExp[0] as $node ){ ?>
                 <option value="<?php esc_attr_e( $node ); ?>" <?php if (  $cepatlakoo_ekspedisi_meta == $node ) echo 'selected="selected"'; ?>><?php esc_attr_e( $node ); ?></option>
            <?php } ?>
        <?php endif; ?>
        <?php
		 echo '</select>';
		 echo '<p>' . esc_html__( 'Tracking Code' ,'cl-input-resi' ) . '</p>
            <input type="text" style="width:250px;" name="_cepatlakoo_resi" placeholder="' . esc_attr( $cepatlakoo_resi ) . '" value="' . esc_attr ( $cepatlakoo_resi ). '"></p>';
        
		 echo '<p>' . esc_html__( 'Shipping Date' ,'cl-input-resi' ) . '</p>
         <input type="text" class="date-picker" style="width:250px;" name="_cepatlakoo_resi_date" maxlength="10" value="' . esc_attr ( $cepatlakoo_resi_date ). '" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])"></p>';
        
    }
}

add_action( 'woocommerce_email', 'unhook_those_pesky_emails' );
function unhook_those_pesky_emails( $email_class ) {
    /**
     * Hooks for sending emails during store events
     **/

    // New order emails
    remove_action( 'woocommerce_order_status_pending_to_processing_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_pending_to_completed_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_pending_to_on-hold_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_failed_to_processing_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_failed_to_completed_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_failed_to_on-hold_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );

    // Processing order emails
    remove_action( 'woocommerce_order_status_pending_to_processing_notification', array( $email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_pending_to_on-hold_notification', array( $email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger' ) );

    // Completed order emails
    remove_action( 'woocommerce_order_status_completed_notification', array( $email_class->emails['WC_Email_Customer_Completed_Order'], 'trigger' ) );

    // Note emails
    remove_action( 'woocommerce_new_customer_note_notification', array( $email_class->emails['WC_Email_Customer_Note'], 'trigger' ) );
}

// Saving Meta Data
add_action( 'post_updated', 'cepatlakoo_save_data', 10, 1 );
if ( ! function_exists( 'cepatlakoo_save_data' ) ){
    function cepatlakoo_save_data( $post_id ) {

        // We need to verify this with the proper authorization (security stuff).

        // Check if our nonce is set.
        if ( ! isset( $_POST[ 'cepatlakoo_meta_field_nonce' ] ) ) {
            return $post_id;
        }
        $nonce = $_REQUEST[ 'cepatlakoo_meta_field_nonce' ];

        //Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce ) ) {
            return $post_id;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        // Check the user's permissions.
        if ( 'page' == $_POST[ 'post_type' ] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {

            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }
        // --- Its safe for us to save the data ! --- //

        // Sanitize user input  and update the meta field in the database.
        update_post_meta( $post_id, '_cepatlakoo_resi', $_POST[ '_cepatlakoo_resi' ] );
        update_post_meta( $post_id, '_cepatlakoo_resi_date', $_POST[ '_cepatlakoo_resi_date' ] );
        update_post_meta( $post_id, '_cepatlakoo_ekspedisi', $_POST[ '_cepatlakoo_ekspedisi' ] );
    }
}

add_action( 'woocommerce_email', 'add_hook_email' );
function add_hook_email( $email_class ) {
    /**
     * Hooks for sending emails during store events
     **/

    // New order emails
    add_action( 'woocommerce_order_status_pending_to_processing_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    add_action( 'woocommerce_order_status_pending_to_completed_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    add_action( 'woocommerce_order_status_pending_to_on-hold_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    add_action( 'woocommerce_order_status_failed_to_processing_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    add_action( 'woocommerce_order_status_failed_to_completed_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    add_action( 'woocommerce_order_status_failed_to_on-hold_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );

    // Processing order emails
    add_action( 'woocommerce_order_status_pending_to_processing_notification', array( $email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger' ) );
    add_action( 'woocommerce_order_status_pending_to_on-hold_notification', array( $email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger' ) );

    // Completed order emails
    add_action( 'woocommerce_order_status_completed_notification', array( $email_class->emails['WC_Email_Customer_Completed_Order'], 'trigger' ) );

    // Note emails
    add_action( 'woocommerce_new_customer_note_notification', array( $email_class->emails['WC_Email_Customer_Note'], 'trigger' ) );
}

//---------------------------- Metabox -----------------------------------------//

//Inject Code In Order Detail, Admin Order Details Page
function wc_extra_admin_shipping_fields( $order ) {
  $cepatlakoo_resi = get_post_meta( get_the_ID(), '_cepatlakoo_resi', true );
  $cepatlakoo_resi_date = date( get_option('date_format'), strtotime(get_post_meta( get_the_ID(), '_cepatlakoo_resi_date', true )) );
  $cepatlakoo_ekspedisi = get_post_meta( get_the_ID(), '_cepatlakoo_ekspedisi', true );
  $cepatlakoo_link = get_option('cepatlakoo_resi_link');
  $cepatlakoo_link = str_replace( '%lakoo_no_resi%', $cepatlakoo_resi, $cepatlakoo_link);

  if( $cepatlakoo_ekspedisi && $cepatlakoo_resi ){
?>
    <div class="order_data_column" style="width:250px;">
        <h4><?php esc_html_e( 'Delivery details' , 'cl-input-resi'  ); ?></h4><br>
        <?php
            echo '<strong>' . esc_html__( 'Shipped via ', 'cl-input-resi'  ) . ': </strong>' . esc_attr( $cepatlakoo_ekspedisi ) . '<br>';
            echo '<strong>' . esc_html__( 'Date ', 'cl-input-resi'  ) . ': </strong>' . esc_attr( $cepatlakoo_resi_date ) . '<br>';
            echo '<strong>' . esc_html__( 'Tracking Code' , 'cl-input-resi' ) . ': </strong><a target="_blank" href="'. esc_attr( $cepatlakoo_link ) .'">' . esc_attr( $cepatlakoo_resi ) . '</a>'; ?>
    </div>
<?php
  }
}
add_filter( 'woocommerce_admin_order_data_after_order_details', 'wc_extra_admin_shipping_fields' );

//Inject Code In View Order My account page
function action_woocommerce_order_details_after_customer_details( $id ) {
  $cepatlakoo_resi = get_post_meta( $id, '_cepatlakoo_resi', true );
  $cepatlakoo_resi_date = date( get_option('date_format'), strtotime(get_post_meta( $id, '_cepatlakoo_resi_date', true )) );
  $cepatlakoo_ekspedisi = get_post_meta( $id, '_cepatlakoo_ekspedisi', true );
  
  $cepatlakoo_link = get_option('cepatlakoo_resi_link');
  $cepatlakoo_link = str_replace( '%lakoo_no_resi%', $cepatlakoo_resi, $cepatlakoo_link);

  if( $cepatlakoo_ekspedisi || $cepatlakoo_resi ){
  	echo '<div class="cepatlakoo-message">'. esc_html__('Your order has been shipped via ', 'cl-input-resi') .' <strong>'. esc_attr( $cepatlakoo_ekspedisi ) .'</strong> '. esc_html__('On', 'cl-input-resi') .'<strong> '. esc_attr( $cepatlakoo_resi_date ) .'</strong>'. esc_html__(' with Tracking Code : ' , 'cl-input-resi' ) . '<strong> <a target="_blank" href="'. esc_attr( $cepatlakoo_link ) .'">'. esc_attr( $cepatlakoo_resi ) .'</a></strong></p></div>';
  }
}
add_action('woocommerce_view_order', 'action_woocommerce_order_details_after_customer_details', 10, 1);

// Inject Code Before Send Email
add_action( 'woocommerce_email_before_order_table', 'add_order_instruction_email', 10, 2 );
function add_order_instruction_email( $order, $sent_to_admin ) {
  $cepatlakoo_resi = ( isset($_POST[ '_cepatlakoo_resi' ]) ) ? $_POST[ '_cepatlakoo_resi' ] : get_post_meta( get_the_ID(), '_cepatlakoo_resi', true );
  $cepatlakoo_resi_date = ( isset($_POST[ '_cepatlakoo_resi_date' ]) ) ? $_POST[ '_cepatlakoo_resi_date' ] : get_post_meta( get_the_ID(), '_cepatlakoo_resi_date', true );
  $cepatlakoo_resi_date =  date( get_option('date_format'), strtotime($cepatlakoo_resi_date) );
  $cepatlakoo_ekspedisi = ( isset($_POST[ '_cepatlakoo_ekspedisi' ]) ) ? $_POST[ '_cepatlakoo_ekspedisi' ] : get_post_meta( get_the_ID(), '_cepatlakoo_ekspedisi', true );
  
  $cepatlakoo_link = get_option('cepatlakoo_resi_link');
  $cepatlakoo_link = str_replace( '%lakoo_no_resi%', $cepatlakoo_resi, $cepatlakoo_link);

  if ( ! $sent_to_admin ) {
    if( ($cepatlakoo_ekspedisi || $cepatlakoo_resi) && $cepatlakoo_resi_date ){
        echo '<p><strong>' . esc_html__('Delivery: ', 'cl-input-resi') .'</strong> '. esc_html__('Your order has been shipped via ', 'cl-input-resi') .' <strong>'. esc_attr( $cepatlakoo_ekspedisi ) .'</strong> '. esc_html__('On', 'cl-input-resi') .'<strong> '. esc_attr( $cepatlakoo_resi_date ) .'</strong>'. esc_html__(' with Tracking Code : ', 'cl-input-resi') .'<strong> <a target="_blank" href="'. esc_attr( $cepatlakoo_link ) .'">'. esc_attr( $cepatlakoo_resi ) .'</a></strong></p>';
    }
    else if( $cepatlakoo_ekspedisi || $cepatlakoo_resi ){
        echo '<p><strong>' . esc_html__('Delivery: ', 'cl-input-resi') .'</strong> '. esc_html__('Your order has been shipped via ', 'cl-input-resi') .'<strong> '. esc_attr( $cepatlakoo_ekspedisi ) .'</strong>'. esc_html__(' with Tracking Code : ', 'cl-input-resi') .' <strong> <a target="_blank" href="'. esc_attr( $cepatlakoo_link ) .'">'. esc_attr( $cepatlakoo_resi ) .'</a></strong></p>';
    }
  }
}

//---------------------------- Inject Code -----------------------------------------//