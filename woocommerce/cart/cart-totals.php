<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

    <?php do_action( 'woocommerce_before_cart_totals' ); ?>

    <h2 class="font-serif text-xl font-semibold text-ink-900"><?php esc_html_e( 'Order summary', 'woocommerce' ); ?></h2>

    <dl class="mt-4 space-y-3 text-sm">
        <div class="flex justify-between items-center">
            <dt class="text-ink-500"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></dt>
            <dd class="font-medium" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></dd>
        </div>

        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
            <div class="flex justify-between items-center text-brand-600 coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <dt><?php wc_cart_totals_coupon_label( $coupon ); ?></dt>
                <dd data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></dd>
            </div>
        <?php endforeach; ?>

        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
            <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
            <?php wc_cart_totals_shipping_html(); ?>
            <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>
        <?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>
            <div class="flex flex-col gap-2 pt-2 pb-2">
                <dt class="text-ink-500"><?php esc_html_e( 'Shipping', 'woocommerce' ); ?></dt>
                <dd data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>"><?php woocommerce_shipping_calculator(); ?></dd>
            </div>
        <?php endif; ?>

        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
            <div class="flex justify-between items-center fee">
                <dt class="text-ink-500"><?php echo esc_html( $fee->name ); ?></dt>
                <dd class="font-medium" data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></dd>
            </div>
        <?php endforeach; ?>

        <?php
        if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
            $taxable_address = WC()->customer->get_taxable_address();
            $estimated_text  = '';
            if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
                $estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
            }
            if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
                foreach ( WC()->cart->get_tax_totals() as $code => $tax ) {
                    ?>
                    <div class="flex justify-between items-center tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                        <dt class="text-ink-500"><?php echo esc_html( $tax->label ) . $estimated_text; ?></dt>
                        <dd class="font-medium" data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></dd>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="flex justify-between items-center tax-total">
                    <dt class="text-ink-500"><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; ?></dt>
                    <dd class="font-medium" data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></dd>
                </div>
                <?php
            }
        }
        ?>

        <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

        <div class="flex justify-between items-center pt-3 border-t border-ink-200 order-total">
            <dt class="font-semibold text-ink-900"><?php esc_html_e( 'Total', 'woocommerce' ); ?></dt>
            <dd class="font-semibold text-ink-900" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_order_total_html(); ?></dd>
        </div>

        <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
    </dl>
    
    <?php
    $subtotal = WC()->cart->get_displayed_subtotal();
    if ($subtotal < 299) {
        $needed = 299 - $subtotal;
        ?>
        <p class="mt-4 text-xs text-brand-700 bg-brand-50 border border-brand-100 rounded-lg p-3 leading-relaxed">
            Add <?php echo wc_price($needed); ?> more to unlock free shipping + 10% off.
        </p>
        <?php
    }
    ?>

    <div class="wc-proceed-to-checkout mt-5">
        <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
    </div>
    
    <p class="mt-3 text-xs text-ink-500 text-center">Secure, encrypted checkout &amp; discreet packaging</p>

    <?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
