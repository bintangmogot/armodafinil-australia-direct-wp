<?php
/**
 * Content seed for Theme Settings > Checkout & Emails.
 *
 * Puts the text of the order thank-you page into WP admin as real field values, so what visitors
 * read is what the client can edit. Runs once per environment. Bump AAD_CHECKOUT_SEED_VERSION when
 * new defaults are added. Only empty fields are filled and each field is seeded at most once, so
 * anything written in the admin is never overwritten (even if it is cleared later).
 *
 * The bank account values and the bank transfer instructions are not typed here: they are copied
 * once from the existing WooCommerce bank transfer settings, so no account data lives in git.
 *
 * @package Armodafinil_Australia_Direct
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const AAD_CHECKOUT_SEED_VERSION = '20261107_checkout_seed_v1';

/**
 * Default text of the Checkout & Emails fields: option name => [ACF field key, value].
 * This is the only place these strings are written in the theme.
 */
function aad_option_defaults() {
	static $defaults = null;
	if ( $defaults !== null ) {
		return $defaults;
	}
	$p = 'field_aad_co_';
	$defaults = array(
		'ty_confirmed_icon'          => array( $p . 'ty_confirmed_icon', 'check-circle' ),
		'ty_confirmed_heading'       => array( $p . 'ty_confirmed_heading', 'Order confirmed' ),
		'ty_confirmed_intro'         => array( $p . 'ty_confirmed_intro', 'Thanks {name} - your order has been received.' ),
		'ty_confirmed_email_note'    => array( $p . 'ty_confirmed_email_note', 'A confirmation email is on its way to {email}.' ),
		'ty_confirmed_name_fallback' => array( $p . 'ty_confirmed_name_fallback', 'friend' ),
		'ty_order_id_label'          => array( $p . 'ty_order_id_label', 'Order ID:' ),

		'ty_next_heading'            => array( $p . 'ty_next_heading', 'What happens next?' ),
		'ty_step1_label'             => array( $p . 'ty_step1_label', 'Payment.' ),
		'ty_step1_text_bacs'         => array( $p . 'ty_step1_text_bacs', 'You will receive our bank details below (and by email). Please transfer the funds within 24 hours.' ),
		'ty_step1_text_crypto'       => array( $p . 'ty_step1_text_crypto', 'A wallet address for your chosen currency is provided. Please complete the transfer.' ),
		'ty_step1_text_other'        => array( $p . 'ty_step1_text_other', 'Your payment is being processed now - no further action needed.' ),
		'ty_step2_label'             => array( $p . 'ty_step2_label', 'Dispatch.' ),
		'ty_step2_text'              => array( $p . 'ty_step2_text', 'Your parcel leaves our facility within 24-48 business hours after funds clear.' ),
		'ty_step3_label'             => array( $p . 'ty_step3_label', 'Tracking.' ),
		'ty_step3_text'              => array( $p . 'ty_step3_text', 'Same-day tracking is emailed to you as soon as your parcel is scanned by the courier.' ),
		'ty_step4_label'             => array( $p . 'ty_step4_label', 'Delivery.' ),
		'ty_step4_text'              => array( $p . 'ty_step4_text', 'Most Australian addresses receive the parcel within 7-10 business days, dispatched in neutral outer packaging.' ),

		'bank_card_heading'          => array( $p . 'bank_card_heading', 'Our bank details' ),
		'bank_label_bank'            => array( $p . 'bank_label_bank', 'Bank' ),
		'bank_label_account_number'  => array( $p . 'bank_label_account_number', 'Account number' ),
		'bank_label_bsb'             => array( $p . 'bank_label_bsb', 'BSB' ),
		'bank_label_payid'           => array( $p . 'bank_label_payid', 'PayID' ),

		'ty_continue_label'          => array( $p . 'ty_continue_label', 'Continue shopping' ),
		'ty_continue_icon'           => array( $p . 'ty_continue_icon', 'arrow-right' ),
		'ty_home_label'              => array( $p . 'ty_home_label', 'Back to home' ),
		'ty_home_icon'               => array( $p . 'ty_home_icon', 'home' ),
		'ty_failed_message'          => array( $p . 'ty_failed_message', 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.' ),
		'ty_failed_pay_label'        => array( $p . 'ty_failed_pay_label', 'Pay' ),
		'ty_failed_account_label'    => array( $p . 'ty_failed_account_label', 'My account' ),
		'ty_notfound_heading'        => array( $p . 'ty_notfound_heading', 'Order received' ),
		'ty_notfound_message'        => array( $p . 'ty_notfound_message', 'Thank you. Your order has been received.' ),
	);
	return $defaults;
}

/** Option names that are filled once from the existing WooCommerce bank transfer settings. */
function aad_bank_option_keys() {
	$p = 'field_aad_co_';
	return array(
		'bank_transfer_bank_name'      => $p . 'bank_transfer_bank_name',
		'bank_transfer_account_name'   => $p . 'bank_transfer_account_name',
		'bank_transfer_bsb'            => $p . 'bank_transfer_bsb',
		'bank_transfer_account_number' => $p . 'bank_transfer_account_number',
		'bank_transfer_instructions'   => $p . 'bank_transfer_instructions',
	);
}

/**
 * Theme Settings text. A saved value (even an empty one) always wins; the default is only a
 * safety net for the time before the seed has run.
 */
function aad_option_text( $name ) {
	$saved = get_option( 'options_' . $name, null );
	if ( $saved !== null ) {
		return is_scalar( $saved ) ? trim( (string) $saved ) : '';
	}
	$defaults = aad_option_defaults();
	return isset( $defaults[ $name ] ) ? (string) $defaults[ $name ][1] : '';
}

/**
 * Bank transfer details. Theme Settings > Checkout & Emails is the single source; the values
 * saved in WooCommerce are only used for a field that is still empty there.
 */
function aad_bank_details() {
	$raw = aad_bacs_raw_account();
	$pick = function ( $name, $raw_key ) use ( $raw ) {
		$value = aad_option_text( $name );
		return $value !== '' ? $value : trim( (string) ( $raw[ $raw_key ] ?? '' ) );
	};
	return array(
		'bank'   => $pick( 'bank_transfer_bank_name', 'bank_name' ),
		'name'   => $pick( 'bank_transfer_account_name', 'account_name' ),
		'bsb'    => $pick( 'bank_transfer_bsb', 'sort_code' ),
		'number' => $pick( 'bank_transfer_account_number', 'account_number' ),
		'payid'  => aad_option_text( 'bank_transfer_payid' ),
	);
}

/** Payment instruction paragraph: Theme Settings, or the WooCommerce text until it is saved there. */
function aad_bank_instructions() {
	$saved = get_option( 'options_bank_transfer_instructions', null );
	if ( $saved !== null ) {
		return is_scalar( $saved ) ? trim( (string) $saved ) : '';
	}
	$settings = aad_bacs_raw_settings();
	return trim( (string) ( $settings['instructions'] ?? '' ) );
}

/** The first WooCommerce bank transfer account exactly as stored, before the Theme Settings overlay. */
function aad_bacs_raw_account() {
	remove_filter( 'option_woocommerce_bacs_accounts', 'aad_filter_bacs_accounts' );
	remove_filter( 'default_option_woocommerce_bacs_accounts', 'aad_filter_bacs_accounts' );
	$accounts = get_option( 'woocommerce_bacs_accounts' );
	add_filter( 'option_woocommerce_bacs_accounts', 'aad_filter_bacs_accounts' );
	add_filter( 'default_option_woocommerce_bacs_accounts', 'aad_filter_bacs_accounts' );
	return ( is_array( $accounts ) && ! empty( $accounts[0] ) && is_array( $accounts[0] ) ) ? $accounts[0] : array();
}

/** The WooCommerce bank transfer gateway settings exactly as stored. */
function aad_bacs_raw_settings() {
	remove_filter( 'option_woocommerce_bacs_settings', 'aad_filter_bacs_settings' );
	$settings = get_option( 'woocommerce_bacs_settings' );
	add_filter( 'option_woocommerce_bacs_settings', 'aad_filter_bacs_settings' );
	return is_array( $settings ) ? $settings : array();
}

/** One-time copy of the existing WooCommerce values into the Theme Settings bank fields. */
function aad_bank_seed_values() {
	$account  = aad_bacs_raw_account();
	$settings = aad_bacs_raw_settings();
	return array(
		'bank_transfer_bank_name'      => trim( (string) ( $account['bank_name'] ?? '' ) ),
		'bank_transfer_account_name'   => trim( (string) ( $account['account_name'] ?? '' ) ),
		'bank_transfer_bsb'            => trim( (string) ( $account['sort_code'] ?? '' ) ),
		'bank_transfer_account_number' => trim( (string) ( $account['account_number'] ?? '' ) ),
		'bank_transfer_instructions'   => trim( (string) ( $settings['instructions'] ?? '' ) ),
	);
}

/**
 * Seeder. Writes what ACF itself would store for an options page field:
 * options_{name} = value and _options_{name} = field key.
 */
add_action( 'acf/init', function () {
	if ( get_option( 'aad_checkout_seed_version' ) === AAD_CHECKOUT_SEED_VERSION ) {
		return;
	}
	$done = get_option( 'aad_checkout_seeded_fields', array() );
	$done = is_array( $done ) ? $done : array();

	$rows = aad_option_defaults();
	$keys = aad_bank_option_keys();
	foreach ( aad_bank_seed_values() as $name => $value ) {
		$rows[ $name ] = array( $keys[ $name ], $value );
	}

	foreach ( $rows as $name => $row ) {
		if ( isset( $done[ $name ] ) ) {
			continue;
		}
		list( $field_key, $value ) = $row;
		$current = get_option( 'options_' . $name, null );
		if ( $current === null || $current === '' ) {
			if ( $value === '' ) {
				continue;
			}
			update_option( 'options_' . $name, $value );
			update_option( '_options_' . $name, $field_key );
		}
		$done[ $name ] = true;
	}

	update_option( 'aad_checkout_seeded_fields', $done, false );
	update_option( 'aad_checkout_seed_version', AAD_CHECKOUT_SEED_VERSION, false );
}, 20 );
