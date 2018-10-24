<?php
/**
 * Template for proccessing SMS Notification
 *
 * @package WordPress
 * @subpackage CepatLakoo
 * @since CepatLakoo 1.0.2
 */
include( get_template_directory() . '/includes/smsGateway/smsGateway.php' ); // Load Library

/**
* Functions to send SMS if order status change for customer
*
* @package WordPress
* @subpackage CepatLakoo
* @since CepatLakoo 1.0.2
*/
if ( ! function_exists( 'cepatlakoo_customer_order_notification' ) ) {
    function cepatlakoo_customer_order_notification($order) {
        global $woocommerce, $cl_options;

        $cepatlakoo_sms_gateway_token = !empty( $cl_options['cepatlakoo_sms_gateway_token'] ) ? $cl_options['cepatlakoo_sms_gateway_token'] : '';
        $cepatlakoo_sms_gateway_deviceID = !empty( $cl_options['cepatlakoo_sms_gateway_deviceID'] ) ? $cl_options['cepatlakoo_sms_gateway_deviceID'] : '';
        $cepatlakoo_sms_gateway_phone = !empty( $cl_options['cepatlakoo_sms_gateway_phone'] ) ? $cl_options['cepatlakoo_sms_gateway_phone'] : '';

        $cepatlakoo_sms_new_order = !empty( $cl_options['cepatlakoo_sms_new_order'] ) ? $cl_options['cepatlakoo_sms_new_order'] : '';
        $cepatlakoo_sms_order_process = !empty( $cl_options['cepatlakoo_sms_order_process'] ) ? $cl_options['cepatlakoo_sms_order_process'] : '';
        $cepatlakoo_sms_order_complete = !empty( $cl_options['cepatlakoo_sms_order_complete'] ) ? $cl_options['cepatlakoo_sms_order_complete'] : '';
        $cepatlakoo_sms_order_pending = !empty( $cl_options['cepatlakoo_sms_order_pending'] ) ? $cl_options['cepatlakoo_sms_order_pending'] : '';
        $cepatlakoo_sms_order_failed = !empty( $cl_options['cepatlakoo_sms_order_failed'] ) ? $cl_options['cepatlakoo_sms_order_failed'] : '';
        $cepatlakoo_sms_order_refunded = !empty( $cl_options['cepatlakoo_sms_order_refunded'] ) ? $cl_options['cepatlakoo_sms_order_refunded'] : '';
        $cepatlakoo_sms_order_cancel = !empty( $cl_options['cepatlakoo_sms_order_cancel'] ) ? $cl_options['cepatlakoo_sms_order_cancel'] : '';

        // Make Connection to SmsGateway
        $smsGateway = new SmsGateway($cepatlakoo_sms_gateway_token);
        $cl_device_id = $cepatlakoo_sms_gateway_deviceID;

        $cl_order = new WC_Order( $order );
        $cl_custom_fee = $cl_order->get_fees();
        if ( $cl_custom_fee ) {
            foreach($cl_custom_fee as $cl_fee){}
        }else{
            $cl_fee = null;
        }
        $cl_order_id = trim(str_replace('#', '', $cl_order->get_order_number()));
        $cl_base_order_status = $cl_order->status;
        $cl_status_list = array(
                            'pending' => __('Pending', 'cepatlakoo'),
                            'processing' => __('Processing', 'cepatlakoo'),
                            'on-hold' => __('On Hold', 'cepatlakoo'),
                            'completed' => __('Completed', 'cepatlakoo'),
                            'cancelled' => __('Cancelled', 'cepatlakoo'),
                            'refunded' => __('Refunded', 'cepatlakoo'),
                            'failed' => __('Failed', 'cepatlakoo'),
                        );
        foreach ($cl_status_list as $cl_status_lists => $translate){
            if ($cl_base_order_status == $cl_status_lists){
                $cl_order_status = $translate;
            }
        }
        $cl_shop_name = get_bloginfo('name');
        $cl_fullname = get_post_meta( $cl_order_id, '_billing_first_name', true ) . ' ' . get_post_meta( $cl_order_id, '_billing_last_name', true );
        $cl_email = get_post_meta( $cl_order_id, '_billing_email', true );
        $cl_phone_number = get_post_meta( $cl_order_id, '_billing_phone', true );
        $cl_shipping_price = get_post_meta( $cl_order_id, '_order_shipping', true );
        $cl_total_price = get_post_meta( $cl_order_id, '_order_total', true );
        $cl_tracking_code = get_post_meta( $cl_order_id, '_cepatlakoo_resi', true );
        $cl_tracking_date = date( get_option('date_format'), strtotime(get_post_meta( $cl_order_id, '_cepatlakoo_resi_date', true )) );
        $cl_courier = get_post_meta( $cl_order_id, '_cepatlakoo_ekspedisi', true );
        ( $cl_fee ) ? $cl_payment_code = $cl_fee->get_total() : $cl_payment_code = null;

        if ($cl_base_order_status == 'processing'){
            $cepatlakoo_sms_order_process = str_replace( '%lakoo_order_id%', $cl_order_id, $cepatlakoo_sms_order_process);
            $cepatlakoo_sms_order_process = str_replace( '%lakoo_order_status%', $cl_order_status, $cepatlakoo_sms_order_process);
            $cepatlakoo_sms_order_process = str_replace( '%lakoo_shop_name%', $cl_shop_name, $cepatlakoo_sms_order_process);
            $cepatlakoo_sms_order_process = str_replace( '%lakoo_fullname%', $cl_fullname, $cepatlakoo_sms_order_process);
            $cepatlakoo_sms_order_process = str_replace( '%lakoo_email%', $cl_email, $cepatlakoo_sms_order_process);
            $cepatlakoo_sms_order_process = str_replace( '%lakoo_phone_number%', $cl_phone_number, $cepatlakoo_sms_order_process);
            $cepatlakoo_sms_order_process = str_replace( '%lakoo_shipping_price%', $cl_shipping_price, $cepatlakoo_sms_order_process);
            $cepatlakoo_sms_order_process = str_replace( '%lakoo_total_price%', $cl_total_price, $cepatlakoo_sms_order_process);
            $cepatlakoo_sms_order_process = str_replace( '%lakoo_tracking_code%', $cl_tracking_code, $cepatlakoo_sms_order_process);
            $cepatlakoo_sms_order_process = str_replace( '%lakoo_tracking_date%', $cl_tracking_date, $cepatlakoo_sms_order_process);
            $cepatlakoo_sms_order_process = str_replace( '%lakoo_courier%', $cl_courier, $cepatlakoo_sms_order_process);
            $cepatlakoo_sms_order_process = str_replace( '%lakoo_payment_code%', $cl_payment_code, $cepatlakoo_sms_order_process);

            $cepatlakoo_sms_order_process = $smsGateway->sendMessageToNumber($cl_phone_number, $cepatlakoo_sms_order_process, $cl_device_id );
        }else if ($cl_base_order_status == 'pending'){
            $cepatlakoo_sms_order_pending = str_replace( '%lakoo_order_id%', $cl_order_id, $cepatlakoo_sms_order_pending);
            $cepatlakoo_sms_order_pending = str_replace( '%lakoo_order_status%', $cl_order_status, $cepatlakoo_sms_order_pending);
            $cepatlakoo_sms_order_pending = str_replace( '%lakoo_shop_name%', $cl_shop_name, $cepatlakoo_sms_order_pending);
            $cepatlakoo_sms_order_pending = str_replace( '%lakoo_fullname%', $cl_fullname, $cepatlakoo_sms_order_pending);
            $cepatlakoo_sms_order_pending = str_replace( '%lakoo_email%', $cl_email, $cepatlakoo_sms_order_pending);
            $cepatlakoo_sms_order_pending = str_replace( '%lakoo_phone_number%', $cl_phone_number, $cepatlakoo_sms_order_pending);
            $cepatlakoo_sms_order_pending = str_replace( '%lakoo_shipping_price%', $cl_shipping_price, $cepatlakoo_sms_order_pending);
            $cepatlakoo_sms_order_pending = str_replace( '%lakoo_total_price%', $cl_total_price, $cepatlakoo_sms_order_pending);
            $cepatlakoo_sms_order_pending = str_replace( '%lakoo_tracking_code%', $cl_tracking_code, $cepatlakoo_sms_order_pending);
            $cepatlakoo_sms_order_pending = str_replace( '%lakoo_courier%', $cl_courier, $cepatlakoo_sms_order_pending);
            $cepatlakoo_sms_order_pending = str_replace( '%lakoo_payment_code%', $cl_payment_code, $cepatlakoo_sms_order_pending);

            $cepatlakoo_sms_order_pending = $smsGateway->sendMessageToNumber($cl_phone_number, $cepatlakoo_sms_order_pending, $cl_device_id );
        }else if ($cl_base_order_status == 'on-hold'){
            $cepatlakoo_sms_new_order = str_replace( '%lakoo_order_id%', $cl_order_id, $cepatlakoo_sms_new_order);
            $cepatlakoo_sms_new_order = str_replace( '%lakoo_order_status%', $cl_order_status, $cepatlakoo_sms_new_order);
            $cepatlakoo_sms_new_order = str_replace( '%lakoo_shop_name%', $cl_shop_name, $cepatlakoo_sms_new_order);
            $cepatlakoo_sms_new_order = str_replace( '%lakoo_fullname%', $cl_fullname, $cepatlakoo_sms_new_order);
            $cepatlakoo_sms_new_order = str_replace( '%lakoo_email%', $cl_email, $cepatlakoo_sms_new_order);
            $cepatlakoo_sms_new_order = str_replace( '%lakoo_phone_number%', $cl_phone_number, $cepatlakoo_sms_new_order);
            $cepatlakoo_sms_new_order = str_replace( '%lakoo_shipping_price%', $cl_shipping_price, $cepatlakoo_sms_new_order);
            $cepatlakoo_sms_new_order = str_replace( '%lakoo_total_price%', $cl_total_price, $cepatlakoo_sms_new_order);
            $cepatlakoo_sms_new_order = str_replace( '%lakoo_tracking_code%', $cl_tracking_code, $cepatlakoo_sms_new_order);
            $cepatlakoo_sms_new_order = str_replace( '%lakoo_courier%', $cl_courier, $cepatlakoo_sms_new_order);
            $cepatlakoo_sms_new_order = str_replace( '%lakoo_payment_code%', $cl_payment_code, $cepatlakoo_sms_new_order);

            $cepatlakoo_sms_new_order = $smsGateway->sendMessageToNumber($cl_phone_number, $cepatlakoo_sms_new_order, $cl_device_id );
        }else if ($cl_base_order_status == 'completed'){
            $cepatlakoo_sms_order_complete = str_replace( '%lakoo_order_id%', $cl_order_id, $cepatlakoo_sms_order_complete);
            $cepatlakoo_sms_order_complete = str_replace( '%lakoo_order_status%', $cl_order_status, $cepatlakoo_sms_order_complete);
            $cepatlakoo_sms_order_complete = str_replace( '%lakoo_shop_name%', $cl_shop_name, $cepatlakoo_sms_order_complete);
            $cepatlakoo_sms_order_complete = str_replace( '%lakoo_fullname%', $cl_fullname, $cepatlakoo_sms_order_complete);
            $cepatlakoo_sms_order_complete = str_replace( '%lakoo_email%', $cl_email, $cepatlakoo_sms_order_complete);
            $cepatlakoo_sms_order_complete = str_replace( '%lakoo_phone_number%', $cl_phone_number, $cepatlakoo_sms_order_complete);
            $cepatlakoo_sms_order_complete = str_replace( '%lakoo_shipping_price%', $cl_shipping_price, $cepatlakoo_sms_order_complete);
            $cepatlakoo_sms_order_complete = str_replace( '%lakoo_total_price%', $cl_total_price, $cepatlakoo_sms_order_complete);
            $cepatlakoo_sms_order_complete = str_replace( '%lakoo_tracking_code%', $cl_tracking_code, $cepatlakoo_sms_order_complete);
            $cepatlakoo_sms_order_complete = str_replace( '%lakoo_tracking_date%', $cl_tracking_date, $cepatlakoo_sms_order_complete);
            $cepatlakoo_sms_order_complete = str_replace( '%lakoo_courier%', $cl_courier, $cepatlakoo_sms_order_complete);
            $cepatlakoo_sms_order_complete = str_replace( '%lakoo_payment_code%', $cl_payment_code, $cepatlakoo_sms_order_complete);

            $cepatlakoo_sms_order_complete = $smsGateway->sendMessageToNumber($cl_phone_number, $cepatlakoo_sms_order_complete, $cl_device_id );
        }else if ($cl_base_order_status == 'cancelled'){
            $cepatlakoo_sms_order_cancel = str_replace( '%lakoo_order_id%', $cl_order_id, $cepatlakoo_sms_order_cancel);
            $cepatlakoo_sms_order_cancel = str_replace( '%lakoo_order_status%', $cl_order_status, $cepatlakoo_sms_order_cancel);
            $cepatlakoo_sms_order_cancel = str_replace( '%lakoo_shop_name%', $cl_shop_name, $cepatlakoo_sms_order_cancel);
            $cepatlakoo_sms_order_cancel = str_replace( '%lakoo_fullname%', $cl_fullname, $cepatlakoo_sms_order_cancel);
            $cepatlakoo_sms_order_cancel = str_replace( '%lakoo_email%', $cl_email, $cepatlakoo_sms_order_cancel);
            $cepatlakoo_sms_order_cancel = str_replace( '%lakoo_phone_number%', $cl_phone_number, $cepatlakoo_sms_order_cancel);
            $cepatlakoo_sms_order_cancel = str_replace( '%lakoo_shipping_price%', $cl_shipping_price, $cepatlakoo_sms_order_cancel);
            $cepatlakoo_sms_order_cancel = str_replace( '%lakoo_total_price%', $cl_total_price, $cepatlakoo_sms_order_cancel);
            $cepatlakoo_sms_order_cancel = str_replace( '%lakoo_tracking_code%', $cl_tracking_code, $cepatlakoo_sms_order_cancel);
            $cepatlakoo_sms_order_cancel = str_replace( '%lakoo_courier%', $cl_courier, $cepatlakoo_sms_order_cancel);
            $cepatlakoo_sms_order_cancel = str_replace( '%lakoo_payment_code%', $cl_payment_code, $cepatlakoo_sms_order_cancel);

            $cepatlakoo_sms_order_cancel = $smsGateway->sendMessageToNumber($cl_phone_number, $cepatlakoo_sms_order_cancel, $cl_device_id );
        }else if ($cl_base_order_status == 'refunded'){
            $cepatlakoo_sms_order_refunded = str_replace( '%lakoo_order_id%', $cl_order_id, $cepatlakoo_sms_order_refunded);
            $cepatlakoo_sms_order_refunded = str_replace( '%lakoo_order_status%', $cl_order_status, $cepatlakoo_sms_order_refunded);
            $cepatlakoo_sms_order_refunded = str_replace( '%lakoo_shop_name%', $cl_shop_name, $cepatlakoo_sms_order_refunded);
            $cepatlakoo_sms_order_refunded = str_replace( '%lakoo_fullname%', $cl_fullname, $cepatlakoo_sms_order_refunded);
            $cepatlakoo_sms_order_refunded = str_replace( '%lakoo_email%', $cl_email, $cepatlakoo_sms_order_refunded);
            $cepatlakoo_sms_order_refunded = str_replace( '%lakoo_phone_number%', $cl_phone_number, $cepatlakoo_sms_order_refunded);
            $cepatlakoo_sms_order_refunded = str_replace( '%lakoo_shipping_price%', $cl_shipping_price, $cepatlakoo_sms_order_refunded);
            $cepatlakoo_sms_order_refunded = str_replace( '%lakoo_total_price%', $cl_total_price, $cepatlakoo_sms_order_refunded);
            $cepatlakoo_sms_order_refunded = str_replace( '%lakoo_tracking_code%', $cl_tracking_code, $cepatlakoo_sms_order_refunded);
            $cepatlakoo_sms_order_refunded = str_replace( '%lakoo_courier%', $cl_courier, $cepatlakoo_sms_order_refunded);
            $cepatlakoo_sms_order_refunded = str_replace( '%lakoo_payment_code%', $cl_payment_code, $cepatlakoo_sms_order_refunded);

            $cepatlakoo_sms_order_refunded = $smsGateway->sendMessageToNumber($cl_phone_number, $cepatlakoo_sms_order_refunded, $cl_device_id );
        }else if ($cl_base_order_status == 'failed'){
            $cepatlakoo_sms_order_failed = str_replace( '%lakoo_order_id%', $cl_order_id, $cepatlakoo_sms_order_failed);
            $cepatlakoo_sms_order_failed = str_replace( '%lakoo_order_status%', $cl_order_status, $cepatlakoo_sms_order_failed);
            $cepatlakoo_sms_order_failed = str_replace( '%lakoo_shop_name%', $cl_shop_name, $cepatlakoo_sms_order_failed);
            $cepatlakoo_sms_order_failed = str_replace( '%lakoo_fullname%', $cl_fullname, $cepatlakoo_sms_order_failed);
            $cepatlakoo_sms_order_failed = str_replace( '%lakoo_email%', $cl_email, $cepatlakoo_sms_order_failed);
            $cepatlakoo_sms_order_failed = str_replace( '%lakoo_phone_number%', $cl_phone_number, $cepatlakoo_sms_order_failed);
            $cepatlakoo_sms_order_failed = str_replace( '%lakoo_shipping_price%', $cl_shipping_price, $cepatlakoo_sms_order_failed);
            $cepatlakoo_sms_order_failed = str_replace( '%lakoo_total_price%', $cl_total_price, $cepatlakoo_sms_order_failed);
            $cepatlakoo_sms_order_failed = str_replace( '%lakoo_tracking_code%', $cl_tracking_code, $cepatlakoo_sms_order_failed);
            $cepatlakoo_sms_order_failed = str_replace( '%lakoo_courier%', $cl_courier, $cepatlakoo_sms_order_failed);
            $cepatlakoo_sms_order_failed = str_replace( '%lakoo_payment_code%', $cl_payment_code, $cepatlakoo_sms_order_failed);

            $cepatlakoo_sms_order_failed = $smsGateway->sendMessageToNumber($cl_phone_number, $cepatlakoo_sms_order_failed, $cl_device_id );
        }
    }
}
add_action('woocommerce_order_status_pending', 'cepatlakoo_customer_order_notification', 10);
add_action('woocommerce_order_status_failed', 'cepatlakoo_customer_order_notification', 10);
add_action('woocommerce_order_status_on-hold', 'cepatlakoo_customer_order_notification', 10);
add_action('woocommerce_order_status_completed', 'cepatlakoo_customer_order_notification', 10);
add_action('woocommerce_order_status_processing', 'cepatlakoo_customer_order_notification', 10);
add_action('woocommerce_order_status_refunded', 'cepatlakoo_customer_order_notification', 10);
add_action('woocommerce_order_status_cancelled', 'cepatlakoo_customer_order_notification', 10);

/**
* Functions to send SMS if order status change for admin
*
* @package WordPress
* @subpackage CepatLakoo
* @since CepatLakoo 1.0.2
*/
if ( ! function_exists( 'cepatlakoo_new_order_admin' ) ) {
    function cepatlakoo_new_order_admin($order) {
        global $woocommerce, $cl_options;

        $cepatlakoo_sms_gateway_token = !empty( $cl_options['cepatlakoo_sms_gateway_token'] ) ? $cl_options['cepatlakoo_sms_gateway_token'] : '';
        $cepatlakoo_sms_gateway_deviceID = !empty( $cl_options['cepatlakoo_sms_gateway_deviceID'] ) ? $cl_options['cepatlakoo_sms_gateway_deviceID'] : '';
        $cepatlakoo_sms_gateway_phone = !empty( $cl_options['cepatlakoo_sms_gateway_phone'] ) ? $cl_options['cepatlakoo_sms_gateway_phone'] : '';

        $cepatlakoo_sms_new_order_admin = !empty( $cl_options['cepatlakoo_sms_new_order_admin'] ) ? $cl_options['cepatlakoo_sms_new_order_admin'] : '';

        $smsGateway = new SmsGateway($cepatlakoo_sms_gateway_token);
        $cl_device_id = $cepatlakoo_sms_gateway_deviceID;
        $cl_admin_number = $cepatlakoo_sms_gateway_phone;

        $cl_order = new WC_Order( $order );
        $cl_order_id = trim(str_replace('#', '', $cl_order->get_order_number()));
        $cl_order_status = $cl_order->status;
        $cl_status_list = array(
                            'pending' => __('Pending', 'cepatlakoo'),
                            'processing' => __('Processing', 'cepatlakoo'),
                            'on-hold' => __('On Hold', 'cepatlakoo'),
                            'completed' => __('Completed', 'cepatlakoo'),
                            'cancelled' => __('Cancelled', 'cepatlakoo'),
                            'refunded' => __('Refunded', 'cepatlakoo'),
                            'failed' => __('Failed', 'cepatlakoo'),
                        );
        foreach ($cl_status_list as $cl_status_lists => $translate){
            if ($cl_order_status == $cl_status_lists){
                $cl_order_status = $translate;
            }
        }
        $cl_shop_name = get_bloginfo('name');

        $cepatlakoo_sms_new_order_admin = str_replace( '%lakoo_order_id%', $cl_order_id, $cepatlakoo_sms_new_order_admin);
        $cepatlakoo_sms_new_order_admin = str_replace( '%lakoo_order_status%', $cl_order_status, $cepatlakoo_sms_new_order_admin);
        $cepatlakoo_sms_new_order_admin = str_replace( '%lakoo_shop_name%', $cl_shop_name, $cepatlakoo_sms_new_order_admin);
        $sent_to_admin = $smsGateway->sendMessageToNumber($cl_admin_number, $cepatlakoo_sms_new_order_admin, $cl_device_id );

    }
}
add_action('woocommerce_order_status_pending_to_processing_notification', 'cepatlakoo_new_order_admin', 10);
add_action('woocommerce_order_status_pending_to_on-hold_notification', 'cepatlakoo_new_order_admin', 10);
add_action('woocommerce_order_status_pending_to_completed_notification', 'cepatlakoo_new_order_admin', 10);

/**
* Functions to send SMS if order note add for customer
*
* @package WordPress
* @subpackage CepatLakoo
* @since CepatLakoo 1.0.2
*/
if ( ! function_exists( 'cepatlakoo_send_customer_note' ) ) {
    function cepatlakoo_send_customer_note($data) {
        global $woocommerce, $cl_options;

        $cepatlakoo_sms_gateway_token = !empty( $cl_options['cepatlakoo_sms_gateway_token'] ) ? $cl_options['cepatlakoo_sms_gateway_token'] : '';
        $cepatlakoo_sms_gateway_deviceID = !empty( $cl_options['cepatlakoo_sms_gateway_deviceID'] ) ? $cl_options['cepatlakoo_sms_gateway_deviceID'] : '';
        $cepatlakoo_sms_gateway_phone = !empty( $cl_options['cepatlakoo_sms_gateway_phone'] ) ? $cl_options['cepatlakoo_sms_gateway_phone'] : '';
        $cepatlakoo_sms_order_note = !empty( $cl_options['cepatlakoo_sms_order_note'] ) ? $cl_options['cepatlakoo_sms_order_note'] : '';

        $smsGateway = new SmsGateway($cepatlakoo_sms_gateway_token);
        $cl_device_id = $cepatlakoo_sms_gateway_deviceID;

        $cl_order = new WC_Order( $data['order_id'] );
        $cl_custom_fee = $cl_order->get_fees();
        if ( $cl_custom_fee ) {
            foreach($cl_custom_fee as $cl_fee){}
        }else{
            $cl_fee = null;
        }
        $cl_order_id = trim(str_replace('#', '', $cl_order->get_order_number()));
        $cl_base_order_status = $cl_order->status;
        $cl_status_list = array(
                            'pending' => __('Pending', 'cepatlakoo'),
                            'processing' => __('Processing', 'cepatlakoo'),
                            'on-hold' => __('On Hold', 'cepatlakoo'),
                            'completed' => __('Completed', 'cepatlakoo'),
                            'cancelled' => __('Cancelled', 'cepatlakoo'),
                            'refunded' => __('Refunded', 'cepatlakoo'),
                            'failed' => __('Failed', 'cepatlakoo'),
                        );
        foreach ($cl_status_list as $cl_status_lists => $translate){
            if ($cl_base_order_status == $cl_status_lists){
                $cl_order_status = $translate;
            }
        }
        $cl_shop_name = get_bloginfo('name');
        $cl_fullname = get_post_meta( $cl_order_id, '_billing_first_name', true ) . ' ' . get_post_meta( $cl_order_id, '_billing_last_name', true );
        $cl_email = get_post_meta( $cl_order_id, '_billing_email', true );
        $cl_phone_number = get_post_meta( $cl_order_id, '_billing_phone', true );
        $cl_shipping_price = get_post_meta( $cl_order_id, '_order_shipping', true );
        $cl_total_price = get_post_meta( $cl_order_id, '_order_total', true );
        $cl_tracking_code = get_post_meta( $cl_order_id, '_cepatlakoo_resi', true );
        $cl_tracking_date = date( get_option('date_format'), strtotime(get_post_meta( $cl_order_id, '_cepatlakoo_resi_date', true )) );
        $cl_courier = get_post_meta( $cl_order_id, '_cepatlakoo_ekspedisi', true );
        ( $cl_fee ) ? $cl_payment_code = $cl_fee->get_total() : $cl_payment_code = null;

        $cepatlakoo_sms_order_note = str_replace( '%lakoo_order_id%', $cl_order_id, $cepatlakoo_sms_order_note);
        $cepatlakoo_sms_order_note = str_replace( '%lakoo_order_status%', $cl_order_status, $cepatlakoo_sms_order_note);
        $cepatlakoo_sms_order_note = str_replace( '%lakoo_shop_name%', $cl_shop_name, $cepatlakoo_sms_order_note);
        $cepatlakoo_sms_order_note = str_replace( '%lakoo_fullname%', $cl_fullname, $cepatlakoo_sms_order_note);
        $cepatlakoo_sms_order_note = str_replace( '%lakoo_email%', $cl_email, $cepatlakoo_sms_order_note);
        $cepatlakoo_sms_order_note = str_replace( '%lakoo_phone_number%', $cl_phone_number, $cepatlakoo_sms_order_note);
        $cepatlakoo_sms_order_note = str_replace( '%lakoo_shipping_price%', $cl_shipping_price, $cepatlakoo_sms_order_note);
        $cepatlakoo_sms_order_note = str_replace( '%lakoo_total_price%', $cl_total_price, $cepatlakoo_sms_order_note);
        $cepatlakoo_sms_order_note = str_replace( '%lakoo_tracking_code%', $cl_tracking_code, $cepatlakoo_sms_order_note);
        $cepatlakoo_sms_order_note = str_replace( '%lakoo_tracking_date%', $cl_tracking_date, $cepatlakoo_sms_order_note);
        $cepatlakoo_sms_order_note = str_replace( '%lakoo_courier%', $cl_courier, $cepatlakoo_sms_order_note);
        $cepatlakoo_sms_order_note = str_replace( '%lakoo_payment_code%', $cl_payment_code, $cepatlakoo_sms_order_note);
        $cepatlakoo_sms_order_note = str_replace( '%lakoo_note%', wptexturize($data['customer_note']) , $cepatlakoo_sms_order_note);

        $sent_to_admin = $smsGateway->sendMessageToNumber($cl_phone_number, $cepatlakoo_sms_order_note, $cl_device_id );
    }
}
add_action('woocommerce_new_customer_note', 'cepatlakoo_send_customer_note', 10);
?>
