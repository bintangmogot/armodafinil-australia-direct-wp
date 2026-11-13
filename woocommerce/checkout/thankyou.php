<?php
/**
 * Thankyou page
 *
 * All visible text, labels and icons are editable in WP admin:
 * Theme Settings > Checkout & Emails (read with aad_option_text() and aad_checkout_icon()).
 * Bank transfer details and the payment instructions are printed by aad_render_bacs_thankyou()
 * (inc/checkout-page.php) on the woocommerce_thankyou_bacs hook below.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16 woocommerce-order">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<?php
			$aad_failed_msg  = aad_option_text( 'ty_failed_message' );
			$aad_failed_pay  = aad_option_text( 'ty_failed_pay_label' );
			$aad_failed_acct = is_user_logged_in() ? aad_option_text( 'ty_failed_account_label' ) : '';
			?>
			<?php if ( $aad_failed_msg !== '' ) : ?>
			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed p-4 mb-6 rounded-xl bg-red-50 text-red-900 border border-red-200"><?php echo esc_html( $aad_failed_msg ); ?></p>
			<?php endif; ?>

			<?php if ( $aad_failed_pay !== '' || $aad_failed_acct !== '' ) : ?>
			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions flex gap-3">
				<?php if ( $aad_failed_pay !== '' ) : ?>
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="inline-flex items-center gap-2 h-11 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors"><?php echo esc_html( $aad_failed_pay ); ?></a>
				<?php endif; ?>
				<?php if ( $aad_failed_acct !== '' ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="inline-flex items-center gap-2 h-11 px-6 rounded-full border border-ink-200 hover:border-brand-600 text-ink-900 font-semibold transition-colors"><?php echo esc_html( $aad_failed_acct ); ?></a>
				<?php endif; ?>
			</p>
			<?php endif; ?>

		<?php else : ?>

            <?php
            $aad_first_name = $order->get_billing_first_name();
            $aad_customer   = $aad_first_name ? $aad_first_name : aad_option_text( 'ty_confirmed_name_fallback' );
            $aad_intro_html = aad_ty_format( aad_option_text( 'ty_confirmed_intro' ), array( 'name' => $aad_customer ) );
            $aad_note_html  = $order->get_billing_email() ? aad_ty_format( aad_option_text( 'ty_confirmed_email_note' ), array( 'email' => $order->get_billing_email() ) ) : '';
            $aad_has_intro  = trim( wp_strip_all_tags( $aad_intro_html ) ) !== '';
            $aad_has_note   = trim( wp_strip_all_tags( $aad_note_html ) ) !== '';
            $aad_order_lbl  = aad_option_text( 'ty_order_id_label' );
            $aad_heading    = aad_option_text( 'ty_confirmed_heading' );
            $aad_next_head  = aad_option_text( 'ty_next_heading' );

            // Step 1 depends on how the customer pays; steps 2 to 4 are fixed.
            $aad_method = (string) $order->get_payment_method();
            if ( $aad_method === 'bacs' ) {
                $aad_step1_text = 'ty_step1_text_bacs';
            } elseif ( $aad_method === 'crypto' || strpos( $aad_method, 'bitcoin' ) !== false ) {
                $aad_step1_text = 'ty_step1_text_crypto';
            } else {
                $aad_step1_text = 'ty_step1_text_other';
            }
            $aad_step_fields = array(
                array( 'ty_step1_label', $aad_step1_text ),
                array( 'ty_step2_label', 'ty_step2_text' ),
                array( 'ty_step3_label', 'ty_step3_text' ),
                array( 'ty_step4_label', 'ty_step4_text' ),
            );
            // Only steps that have a label or a text are listed, numbered in order.
            $aad_steps = array();
            foreach ( $aad_step_fields as $aad_step_field ) {
                $aad_step_label = aad_option_text( $aad_step_field[0] );
                $aad_step_text  = aad_option_text( $aad_step_field[1] );
                if ( $aad_step_label !== '' || $aad_step_text !== '' ) {
                    $aad_steps[] = array( $aad_step_label, $aad_step_text );
                }
            }
            $aad_continue_label = aad_option_text( 'ty_continue_label' );
            $aad_home_label     = aad_option_text( 'ty_home_label' );
            $aad_continue_icon  = aad_checkout_icon( 'ty_continue_icon', 16, '2.5' );
            $aad_home_icon      = aad_checkout_icon( 'ty_home_icon', 16, '2' );
            $aad_confirm_icon   = aad_checkout_icon( 'ty_confirmed_icon', 32, '2.5' );
            ?>

            <div class="space-y-6 lg:space-y-8">
                <!-- Order Confirmed Card -->
                <section class="bg-white border border-brand-200 shadow-sm ring-1 ring-brand-200/50 rounded-2xl p-8 text-center relative overflow-hidden">
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-brand-50 rounded-full blur-2xl opacity-60"></div>
                    <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-brand-50 rounded-full blur-2xl opacity-60"></div>

                    <?php if ( $aad_confirm_icon !== '' ) : ?>
                    <div class="relative z-10 w-16 h-16 rounded-full bg-brand-100 text-brand-700 grid place-items-center mx-auto mb-5 shadow-sm">
                        <?php echo $aad_confirm_icon; // phpcs:ignore WordPress.Security.EscapeOutput -- bundled SVG markup ?>
                    </div>
                    <?php endif; ?>
                    <?php if ( $aad_heading !== '' ) : ?>
                    <h2 class="relative z-10 font-serif text-3xl font-semibold text-ink-900"><?php echo esc_html( $aad_heading ); ?></h2>
                    <?php endif; ?>
                    <?php if ( $aad_has_intro || $aad_has_note ) : ?>
                    <p class="relative z-10 mt-3 text-ink-700 max-w-lg mx-auto leading-relaxed">
                        <?php if ( $aad_has_intro ) { echo $aad_intro_html; } // phpcs:ignore WordPress.Security.EscapeOutput -- escaped inside aad_ty_format ?>
                        <?php if ( $aad_has_note ) { echo $aad_note_html; } // phpcs:ignore WordPress.Security.EscapeOutput -- escaped inside aad_ty_format ?>
                    </p>
                    <?php endif; ?>
                    <div class="relative z-10 mt-6 inline-flex items-center gap-2 bg-brand-50 border border-brand-200 text-brand-800 rounded-full px-5 py-2 font-mono text-sm font-semibold tracking-wide">
                        <?php echo esc_html( trim( $aad_order_lbl . ' ' . $order->get_order_number() ) ); ?>
                    </div>
                </section>

                <!-- What happens next -->
                <?php if ( $aad_steps ) : ?>
                <section class="bg-white border border-ink-200 rounded-2xl p-6 md:p-8">
                    <?php if ( $aad_next_head !== '' ) : ?>
                    <h3 class="font-serif text-xl font-semibold text-ink-900 mb-6"><?php echo esc_html( $aad_next_head ); ?></h3>
                    <?php endif; ?>
                    <ol class="space-y-5 text-sm text-ink-700">
                        <?php foreach ( $aad_steps as $aad_index => $aad_step ) : ?>
                        <li class="flex gap-4">
                            <span class="w-6 h-6 grid place-items-center rounded-full bg-ink-100 text-ink-600 text-xs font-bold shrink-0"><?php echo (int) ( $aad_index + 1 ); ?></span>
                            <span class="leading-relaxed">
                                <?php if ( $aad_step[0] !== '' ) : ?><b class="text-ink-900"><?php echo esc_html( $aad_step[0] ); ?></b><?php endif; ?>
                                <?php echo esc_html( $aad_step[1] ); ?>
                            </span>
                        </li>
                        <?php endforeach; ?>
                    </ol>
                </section>
                <?php endif; ?>

                <!-- Payment Details (BACS, Crypto, etc) -->
                <div class="woocommerce-thankyou-hooks space-y-6">
                    <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
                    <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
                </div>

                <!-- Action Buttons -->
                <?php if ( $aad_continue_label !== '' || $aad_home_label !== '' ) : ?>
                <div class="flex flex-wrap gap-3 justify-center pt-4">
                    <?php if ( $aad_continue_label !== '' ) : ?>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="inline-flex items-center gap-2 h-11 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors">
                        <?php echo esc_html( $aad_continue_label ); ?>
                        <?php echo $aad_continue_icon; // phpcs:ignore WordPress.Security.EscapeOutput -- bundled SVG markup ?>
                    </a>
                    <?php endif; ?>
                    <?php if ( $aad_home_label !== '' ) : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center gap-2 h-11 px-6 rounded-full border border-ink-200 hover:border-brand-600 text-ink-900 font-semibold transition-colors">
                        <?php echo $aad_home_icon; // phpcs:ignore WordPress.Security.EscapeOutput -- bundled SVG markup ?>
                        <?php echo esc_html( $aad_home_label ); ?>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

		<?php endif; ?>

	<?php else : ?>

        <!-- Fallback if no order found -->
        <?php
        $aad_nf_heading = aad_option_text( 'ty_notfound_heading' );
        $aad_nf_message = aad_option_text( 'ty_notfound_message' );
        $aad_nf_button  = aad_option_text( 'ty_continue_label' );
        ?>
        <?php if ( $aad_nf_heading !== '' || $aad_nf_message !== '' || $aad_nf_button !== '' ) : ?>
        <div class="bg-white border border-ink-200 rounded-2xl p-8 text-center max-w-2xl mx-auto">
            <?php if ( $aad_nf_heading !== '' ) : ?>
            <h2 class="font-serif text-3xl font-semibold text-ink-900 mb-4"><?php echo esc_html( $aad_nf_heading ); ?></h2>
            <?php endif; ?>
            <?php if ( $aad_nf_message !== '' ) : ?>
            <p class="text-ink-700 mb-8"><?php echo esc_html( $aad_nf_message ); ?></p>
            <?php endif; ?>
            <?php if ( $aad_nf_button !== '' ) : ?>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="inline-flex items-center gap-2 h-11 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors"><?php echo esc_html( $aad_nf_button ); ?></a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

	<?php endif; ?>

</div>
<style>
/* Style WooCommerce default hooks content (e.g. BACS Bank details) */
.woocommerce-thankyou-hooks h2 {
    font-family: "Playfair Display", ui-serif, Georgia, serif;
    font-size: 1.25rem;
    font-weight: 600;
    color: #09152b; /* ink-900 */
    margin-bottom: 1rem;
}
.woocommerce-thankyou-hooks h3 {
    font-family: "Playfair Display", ui-serif, Georgia, serif;
    font-size: 1.125rem;
    font-weight: 600;
    color: #09152b;
    margin-bottom: 0.75rem;
}
.woocommerce-thankyou-hooks ul.order_details {
    background: #fff;
    border: 1px solid #e2e8f0; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    list-style: none;
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
}
.woocommerce-thankyou-hooks ul.order_details li {
    font-size: 0.875rem;
    color: #64748b;
}
.woocommerce-thankyou-hooks ul.order_details li strong {
    display: block;
    color: #09152b;
    font-size: 1rem;
    margin-top: 0.25rem;
}
.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details {
    background: #f8fafc;
    border: 1px solid #e2e8f0; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

/* All WooCommerce tables (Order Details, Medical Conditions, etc) */
.woocommerce-thankyou-hooks table.shop_table {
    width: 100%;
    border-collapse: separate; border-spacing: 0;
    background: #fff;
    border: 1px solid #e2e8f0; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
    border-radius: 1rem;
    overflow: hidden;
    margin-bottom: 2rem;
}
.woocommerce-thankyou-hooks table.shop_table thead th {
    background: #f8fafc;
    font-weight: 600;
    color: #09152b;
    border-bottom: 1px solid #e2e8f0;
}
.woocommerce-thankyou-hooks table.shop_table th,
.woocommerce-thankyou-hooks table.shop_table td {
    padding: 1rem 1.5rem;
    font-size: 0.875rem;
    color: #334155;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: top;
}
.woocommerce-thankyou-hooks table.shop_table tr:last-child th,
.woocommerce-thankyou-hooks table.shop_table tr:last-child td {
    border-bottom: none;
}

/* Receipt-style alignment for Order Details Table */
.woocommerce-thankyou-hooks table.shop_table.order_details th:first-child,
.woocommerce-thankyou-hooks table.shop_table.order_details td:first-child {
    text-align: left;
}
.woocommerce-thankyou-hooks table.shop_table.order_details th:last-child,
.woocommerce-thankyou-hooks table.shop_table.order_details td:last-child {
    text-align: right;
}
.woocommerce-thankyou-hooks table.shop_table.order_details tfoot th {
    font-weight: 600;
    color: #09152b;
}
.woocommerce-thankyou-hooks table.shop_table.order_details tfoot td {
    font-weight: 500;
    color: #09152b;
}

/* Medical Conditions Table specific tweaks */
.woocommerce-thankyou-hooks table.woocommerce-table--customer-details th {
    font-weight: 600;
    color: #09152b;
    width: 40%;
    text-align: left;
}
.woocommerce-thankyou-hooks table.woocommerce-table--customer-details td {
    text-align: left;
}

.woocommerce-customer-details {
    background: #fff;
    border: 1px solid #e2e8f0; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
    border-radius: 1rem;
    padding: 1.5rem;
    margin-top: 1.5rem;
}
.woocommerce-customer-details address {
    font-style: normal;
    font-size: 0.875rem;
    color: #334155;
    line-height: 1.6;
}

.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details h3 { padding-left: 1rem;
    font-size: 1.125rem;
    color: #0f172a;
    margin-bottom: 1rem;
}
.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul,
.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul.order_details.bacs_details {
    display: flex !important;
    flex-direction: column !important;
    gap: 1.25rem !important;
    padding: 1rem 1.5rem !important; margin: 1rem 0 0 0 !important;
    list-style: none !important;
}
@media (min-width: 640px) {
    .woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul,
    .woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul.order_details.bacs_details {
        flex-direction: row !important;
        flex-wrap: wrap !important;
        gap: 2.5rem !important;
    }
}
.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul li,
.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul.order_details.bacs_details li {
    float: none !important;
    text-align: left !important;
    border: none !important;
    padding: 0 !important;
    margin: 0 !important;
    width: 100% !important;
}
@media (min-width: 640px) {
    .woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul li,
    .woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul.order_details.bacs_details li {
        width: auto !important;
    }
}
.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul li strong,
.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul.order_details.bacs_details li strong {
    display: block !important;
    font-size: 1.125rem !important;
    color: #0f172a !important;
    font-weight: 700 !important;
    margin-top: 0.25rem !important;
}
</style>




