<?php
/**
 * Footer Buttons Override
 *
 * @version 2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

extract( Xoo_Wsc_Template_Args::footer_buttons() );

do_action( 'xoo_wsc_before_footer_btns' );

$buttonHTML = '<a href="%1$s" class="%2$s" %4$s>%3$s</a>';

?>
<div class="xoo-wsc-ft-buttons-cont">

	<?php foreach ( $buttons as $key => $button_data ){

		if( !$button_data['label'] ) continue;
		$button_data['class'][] = 'xoo-wsc-ft-btn-'.$key;

		$label = $button_data['label'];
		if ( $key === 'checkout' && function_exists( 'WC' ) && WC()->cart && ! WC()->cart->is_empty() ) {
			$subtotal = WC()->cart->get_cart_subtotal();
			$clean_price = html_entity_decode( strip_tags( $subtotal ), ENT_QUOTES, 'UTF-8' );
			$clean_price = str_replace( 'A', '', $clean_price );
			$clean_price = trim( preg_replace( '/[^0-9\.,\$]/', '', $clean_price ) );
			if ( substr( $clean_price, 0, 1 ) !== '$' ) {
				$clean_price = '$' . $clean_price;
			}
			$label = 'Checkout - ' . $clean_price;
		}

		printf(
			$buttonHTML,
			esc_url( $button_data['url'] ),
			implode( ' ', $button_data['class'] ),
			wp_kses_post( $label ),
			isset( $button_data['data'] ) ? wp_kses_post( $button_data['data'] ) : ''
		);

	} ?>

</div>

<?php do_action( 'xoo_wsc_after_footer_btns' ); ?>
