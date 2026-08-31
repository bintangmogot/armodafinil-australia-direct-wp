<?php
/**
 * Mini-cart
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<ul class="woocommerce-mini-cart cart_list product_list_widget p-6 space-y-4 <?php echo esc_attr( $args['list_class'] ); ?>">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail', array('class' => 'w-20 h-20 object-cover rounded-xl border border-ink-100 bg-white')), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?> flex gap-4 p-4 bg-white rounded-2xl border border-ink-100 shadow-sm relative group">
					
					<?php
					echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						'woocommerce_cart_item_remove_link',
						sprintf(
							'<a href="%s" class="remove remove_from_cart_button absolute top-2 right-2 w-8 h-8 flex items-center justify-center bg-ink-50 text-ink-400 hover:text-red-500 hover:bg-red-50 rounded-full transition-colors opacity-0 group-hover:opacity-100" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></a>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							esc_attr__( 'Remove this item', 'woocommerce' ),
							esc_attr( $product_id ),
							esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() )
						),
						$cart_item_key
					);
					?>

					<div class="shrink-0">
						<?php if ( empty( $product_permalink ) ) : ?>
							<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php else : ?>
							<a href="<?php echo esc_url( $product_permalink ); ?>">
								<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						<?php endif; ?>
					</div>
					
					<div class="flex-1 min-w-0 py-1">
						<h3 class="text-sm font-semibold text-ink-900 leading-tight mb-1 pr-6">
							<?php if ( empty( $product_permalink ) ) : ?>
								<?php echo wp_kses_post( $product_name ); ?>
							<?php else : ?>
								<a href="<?php echo esc_url( $product_permalink ); ?>" class="hover:text-brand-600 transition-colors">
									<?php echo wp_kses_post( $product_name ); ?>
								</a>
							<?php endif; ?>
						</h3>
						
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						
						<div class="mt-2 flex items-center justify-between">
							<span class="text-xs font-medium text-ink-500 bg-ink-50 px-2 py-1 rounded-md">Qty: <?php echo esc_html( $cart_item['quantity'] ); ?></span>
							<span class="text-sm font-bold text-brand-600"><?php echo $product_price; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						</div>
					</div>
				</li>
				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>

	<div class="woocommerce-mini-cart__footer sticky bottom-0 bg-white border-t border-ink-100 p-6 shadow-[0_-10px_20px_rgba(0,0,0,0.02)] z-10">
		<p class="woocommerce-mini-cart__total total flex items-center justify-between mb-4">
			<?php
			/**
			 * Hook: woocommerce_widget_shopping_cart_total.
			 *
			 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
			 */
			do_action( 'woocommerce_widget_shopping_cart_total' );
			?>
		</p>

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

		<p class="woocommerce-mini-cart__buttons buttons flex flex-col gap-3 m-0">
			<?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>
		</p>

		<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
        
        <div class="mt-4 flex items-center justify-center gap-2 text-xs text-ink-400 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
            Secure 256-bit SSL encryption
        </div>
	</div>

<?php else : ?>

	<div class="woocommerce-mini-cart__empty-message p-12 text-center flex flex-col items-center justify-center h-full">
        <div class="w-20 h-20 bg-ink-50 rounded-full flex items-center justify-center text-ink-300 mb-6 border border-ink-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
        </div>
		<h3 class="text-lg font-bold text-ink-900 mb-2">Your cart is empty</h3>
        <p class="text-ink-500 text-sm mb-8">Looks like you haven't added anything yet.</p>
        <a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" class="bg-brand-600 text-white font-semibold py-3 px-6 rounded-xl hover:bg-brand-700 transition-colors shadow-sm inline-flex items-center gap-2">
            Return to shop
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
	</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
