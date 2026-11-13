<?php
/**
 * Order thank-you page and bank transfer details, driven by Theme Settings > Checkout & Emails.
 *
 * - aad_option_text() / aad_checkout_icon() / aad_ty_format() are used by woocommerce/checkout/thankyou.php.
 * - The bank transfer block on the thank-you page is printed here from Theme Settings.
 * - WooCommerce itself (bank transfer order email, payment settings) is fed the same Theme Settings
 *   values through the filters below, so there is a single source for the bank details.
 *
 * @package Armodafinil_Australia_Direct
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bundled icons for the thank-you page. The admin chooses one by name; an empty choice falls back
 * to the default icon, 'none' prints no icon.
 */
function aad_checkout_icon( $option, $size = 16, $stroke = '2' ) {
	$icons = array(
		'check-circle' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/>',
		'shield-check' => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/>',
		'package'      => '<path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/>',
		'truck'        => '<path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/>',
		'clock'        => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
		'arrow-right'  => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
		'home'         => '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
	);
	$defaults = aad_option_defaults();
	$fallback = isset( $defaults[ $option ] ) ? $defaults[ $option ][1] : 'check-circle';
	$key      = aad_option_text( $option );
	if ( $key === 'none' ) {
		return '';
	}
	if ( ! isset( $icons[ $key ] ) ) {
		$key = $fallback;
	}
	$inner = preg_replace( '/<(path|circle|polyline) /', '<$1 style="fill:none !important;" ', $icons[ $key ] );
	return '<svg xmlns="http://www.w3.org/2000/svg" width="' . (int) $size . '" height="' . (int) $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="' . esc_attr( $stroke ) . '" stroke-linecap="round" stroke-linejoin="round" class="!fill-none">' . $inner . '</svg>';
}

/**
 * Escape a Theme Settings text and replace its {placeholders} with bold, escaped values.
 * A blank value leaves no empty tag behind. Returns safe HTML, trimmed; the caller checks
 * whether anything visible is left (a text that is blank after replacement must be hidden).
 */
function aad_ty_format( $text, $values = array() ) {
	$html = esc_html( (string) $text );
	foreach ( $values as $key => $value ) {
		$value = trim( (string) $value );
		$html  = str_replace( '{' . $key . '}', $value === '' ? '' : '<b>' . esc_html( $value ) . '</b>', $html );
	}
	return trim( $html );
}

/**
 * WooCommerce bank transfer account follows Theme Settings. A field left empty there keeps the
 * value stored in WooCommerce, so nothing breaks before the Theme Settings are filled in.
 */
function aad_filter_bacs_accounts( $value ) {
	$base    = ( is_array( $value ) && isset( $value[0] ) && is_array( $value[0] ) ) ? $value[0] : array();
	$account = $base;
	$map     = array(
		'bank_transfer_bank_name'      => 'bank_name',
		'bank_transfer_account_name'   => 'account_name',
		'bank_transfer_bsb'            => 'sort_code',
		'bank_transfer_account_number' => 'account_number',
	);
	foreach ( $map as $option => $account_key ) {
		$saved = get_option( 'options_' . $option, null );
		if ( is_scalar( $saved ) && trim( (string) $saved ) !== '' ) {
			$account[ $account_key ] = trim( (string) $saved );
		}
	}
	if ( $account === $base ) {
		return $value;
	}
	$account = array_merge(
		array(
			'account_name'   => '',
			'account_number' => '',
			'sort_code'      => '',
			'bank_name'      => '',
			'iban'           => '',
			'bic'            => '',
		),
		$account
	);
	$accounts = is_array( $value ) ? array_values( $value ) : array();
	$accounts[0] = $account;
	return $accounts;
}
add_filter( 'option_woocommerce_bacs_accounts', 'aad_filter_bacs_accounts' );
add_filter( 'default_option_woocommerce_bacs_accounts', 'aad_filter_bacs_accounts' );

/** The payment instruction paragraph (shown in the bank transfer email) follows Theme Settings once saved there. */
function aad_filter_bacs_settings( $value ) {
	if ( is_array( $value ) ) {
		$saved = get_option( 'options_bank_transfer_instructions', null );
		if ( $saved !== null ) {
			$value['instructions'] = is_scalar( $saved ) ? (string) $saved : '';
		}
	}
	return $value;
}
add_filter( 'option_woocommerce_bacs_settings', 'aad_filter_bacs_settings' );

/** Bank transfer email: labels from Theme Settings and a PayID line. */
add_filter( 'woocommerce_bacs_account_fields', function ( $fields ) {
	$labels = array(
		'bank_name'      => 'bank_label_bank',
		'account_number' => 'bank_label_account_number',
		'sort_code'      => 'bank_label_bsb',
	);
	foreach ( $labels as $field_key => $option ) {
		$label = aad_option_text( $option );
		if ( isset( $fields[ $field_key ] ) && $label !== '' ) {
			$fields[ $field_key ]['label'] = $label;
		}
	}
	$payid = aad_option_text( 'bank_transfer_payid' );
	if ( $payid !== '' ) {
		$fields['payid'] = array(
			'label' => aad_option_text( 'bank_label_payid' ),
			'value' => $payid,
		);
	}
	return $fields;
} );

/** Bank transfer email: heading of the bank details block (a WooCommerce core string). */
add_filter( 'gettext', function ( $translated, $text, $domain ) {
	if ( $domain === 'woocommerce' && $text === 'Our bank details' ) {
		$heading = aad_option_text( 'bank_card_heading' );
		if ( $heading !== '' ) {
			return $heading;
		}
	}
	return $translated;
}, 10, 3 );

/** Thank-you page: replace the WooCommerce bank transfer block with the Theme Settings one. */
add_action( 'woocommerce_before_thankyou', function () {
	if ( ! function_exists( 'WC' ) || ! WC()->payment_gateways() ) {
		return;
	}
	$gateways = WC()->payment_gateways()->payment_gateways();
	if ( isset( $gateways['bacs'] ) ) {
		remove_action( 'woocommerce_thankyou_bacs', array( $gateways['bacs'], 'thankyou_page' ) );
	}
}, 1 );
add_action( 'woocommerce_thankyou_bacs', 'aad_render_bacs_thankyou' );

/** Payment instructions, account holder, bank details and PayID on the order thank-you page. */
function aad_render_bacs_thankyou() {
	$instructions = aad_bank_instructions();
	if ( $instructions !== '' ) {
		echo wp_kses_post( wpautop( wptexturize( $instructions ) ) );
	}

	$bank = aad_bank_details();
	$rows = array(
		array( 'bank_name', 'bank_label_bank', $bank['bank'] ),
		array( 'account_number', 'bank_label_account_number', $bank['number'] ),
		array( 'sort_code', 'bank_label_bsb', $bank['bsb'] ),
		array( 'payid', 'bank_label_payid', $bank['payid'] ),
	);

	// A row with no value is dropped; a blank label is dropped but the value stays.
	$list = '';
	foreach ( $rows as $row ) {
		if ( $row[2] === '' ) {
			continue;
		}
		$label = aad_option_text( $row[1] );
		$list .= '<li class="' . esc_attr( $row[0] ) . '">' . ( $label !== '' ? esc_html( $label ) . ': ' : '' ) . '<strong>' . wp_kses_post( wptexturize( $row[2] ) ) . '</strong></li>' . PHP_EOL;
	}

	$html = '';
	if ( $bank['name'] !== '' ) {
		$html .= '<h3 class="wc-bacs-bank-details-account-name">' . wp_kses_post( $bank['name'] ) . ':</h3>' . PHP_EOL;
	}
	if ( $list !== '' ) {
		$html .= '<ul class="wc-bacs-bank-details order_details bacs_details">' . PHP_EOL . $list . '</ul>';
	}
	// Nothing to show (no account holder and no rows): the whole block, heading included, vanishes.
	if ( $html === '' ) {
		return;
	}

	$heading = aad_option_text( 'bank_card_heading' );
	echo '<section class="woocommerce-bacs-bank-details">';
	if ( $heading !== '' ) {
		echo '<h2 class="wc-bacs-bank-details-heading">' . esc_html( $heading ) . '</h2>';
	}
	echo wp_kses_post( PHP_EOL . $html ) . '</section>';
}
