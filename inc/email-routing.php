<?php
/**
 * Project-specific mail routing.
 *
 * Keep customer-facing messages addressed to the customer. Only operational
 * admin mail and contact-form notifications are redirected here.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AAD_OPERATIONS_EMAIL', 'Orders@armodafinildirect.com.au' );
define( 'AAD_CONTACT_EMAIL', 'modaaust@gmail.com' );

// WooCommerce operational notifications are always delivered to Operations.
foreach ( array(
	'woocommerce_email_recipient_new_order',
	'woocommerce_email_recipient_cancelled_order',
	'woocommerce_email_recipient_failed_order',
	'woocommerce_email_recipient_admin_payment_gateway_enabled',
) as $aad_email_filter ) {
	add_filter( $aad_email_filter, function() {
		return AAD_OPERATIONS_EMAIL;
	} );
}

// Gravity Forms contact notifications go to the dedicated contact inbox.
add_filter( 'gform_notification', function( $notification, $form ) {
	if ( in_array( (int) rgar( $form, 'id' ), array( 1, 2 ), true ) ) {
		$notification['to'] = AAD_CONTACT_EMAIL;
	}

	return $notification;
}, 10, 2 );
