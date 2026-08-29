<?php
/**
 * The template for displaying product content in the single-product.php template
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$product_id = $product->get_id();
$product_name = $product->get_name();
$product_image = wp_get_attachment_image_src( $product->get_image_id(), 'full' );
$product_image_url = $product_image ? $product_image[0] : 'https://placehold.co/600x600/e0f2fe/0369a1?text=Product';

$is_variable = $product->is_type( 'variable' );
$variations = [];
if ( $is_variable ) {
    $available_variations = $product->get_available_variations();
    foreach ( $available_variations as $var ) {
        // Find the "Pack Size" or "Tablets" attribute
        $qty = 0;
        foreach($var['attributes'] as $key => $val) {
            $qty = $val; // fallback assuming only one attribute
            break;
        }
        $variations[] = array(
            'id' => $var['variation_id'],
            'qty' => $qty,
            'price' => $var['display_price']
        );
    }
} else {
    // Fake a single variant for the UI
    $variations[] = array(
        'id' => 0,
        'qty' => '1 Pack',
        'price' => wc_get_price_to_display( $product )
    );
}

$currency = get_woocommerce_currency_symbol();
$review_count = $product->get_review_count();
$average_rating = $product->get_average_rating();
$short_description = apply_filters( 'woocommerce_short_description', $product->get_short_description() );
$full_description = apply_filters( 'the_content', $product->get_description() );

// Try to get specs from ACF or WooCommerce attributes
$specs = array();
$attributes = $product->get_attributes();
foreach ( $attributes as $attribute ) {
    $specs[$attribute->get_name()] = $attribute->get_options()[0];
}

?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
    
    <!-- Breadcrumb -->
    <div class="border-b border-ink-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-12 flex items-center text-xs text-ink-500 gap-2">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-brand-700">Home</a>
            <span>/</span>
            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="hover:text-brand-700">Products</a>
            <span>/</span>
            <span class="text-ink-900 truncate"><?php echo esc_html($product_name); ?></span>
        </div>
    </div>

    <div class="section-wash">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="inline-flex items-center gap-1.5 text-sm text-ink-700 hover:text-brand-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left w-4 h-4"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg> 
                All products
            </a>

            <div class="mt-6 grid lg:grid-cols-2 gap-8 lg:gap-12 items-start">
                
                <!-- Gallery -->
                <div class="bg-white rounded-2xl border border-ink-200 overflow-hidden shadow-sm lg:sticky lg:top-24">
                    <div class="aspect-square bg-brand-50">
                        <img src="<?php echo esc_url($product_image_url); ?>" alt="<?php echo esc_attr($product_name); ?>" class="w-full h-full object-cover" />
                    </div>
                </div>

                <!-- Info -->
                <div class="product-info-panel">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-brand-700 bg-brand-100 rounded-full px-2.5 py-1">Best Seller</span>
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-brand-700 bg-brand-50 rounded-full px-2.5 py-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check w-3.5 h-3.5"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg> 
                            In stock
                        </span>
                    </div>
                    
                    <h1 class="mt-3 font-serif text-3xl md:text-4xl font-semibold text-ink-900 leading-tight"><?php echo esc_html($product_name); ?></h1>
                    
                    <div class="mt-3 flex items-center gap-2">
                        <?php for($i=0; $i<5; $i++): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="<?php echo $i < round($average_rating) ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star w-4 h-4 <?php echo $i < round($average_rating) ? 'text-amber-500' : 'text-ink-200'; ?>"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <?php endfor; ?>
                        <span class="text-sm text-ink-500"><?php echo esc_html(number_format($average_rating, 1)); ?> &middot; <a href="#reviews" class="hover:text-brand-700 underline decoration-dotted">(<?php echo esc_html($review_count); ?> reviews)</a></span>
                    </div>

                    <div class="mt-5 flex items-baseline gap-3 flex-wrap">
                        <span class="text-4xl font-semibold text-ink-900" id="dynamic-price"><?php echo $currency . number_format($variations[0]['price'], 2); ?></span>
                        <span class="text-sm text-ink-500" id="dynamic-per-pill"></span>
                    </div>

                    <!-- Promo strip -->
                    <div class="mt-5 p-4 rounded-xl bg-amber-50 border border-amber-200 flex items-center gap-3 flex-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info w-5 h-5 text-amber-600 shrink-0"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                        <p class="text-sm text-amber-900 flex-1 min-w-[200px]">Free shipping + 10% off on orders above <b>$299</b>. Use code:</p>
                        <button type="button" class="inline-flex items-center gap-2 h-9 px-3 rounded-lg border border-dashed border-amber-500 bg-white text-amber-800 font-mono font-semibold text-sm hover:bg-amber-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-copy w-4 h-4"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg> 
                            ARMD10
                        </button>
                    </div>

                    <!-- Add to Cart Form -->
                    <form class="cart mt-6" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                        
                        <?php if ( $is_variable ) : ?>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-semibold text-ink-900">Tablets</span>
                                <span class="text-ink-500">Prices vary</span>
                            </div>
                            
                            <div class="mt-3 grid grid-cols-2 sm:grid-cols-4 gap-2" id="variant-buttons">
                                <?php foreach($variations as $i => $v): ?>
                                    <button type="button" data-vid="<?php echo esc_attr($v['id']); ?>" data-price="<?php echo esc_attr($v['price']); ?>" data-qty="<?php echo esc_attr($v['qty']); ?>" class="variant-btn p-3 rounded-xl border text-left transition-colors <?php echo $i === 0 ? 'bg-brand-600 text-white border-brand-600 active' : 'bg-white text-ink-900 border-ink-200 hover:border-brand-500'; ?>">
                                        <div class="text-lg font-semibold"><?php echo esc_html($v['qty']); ?></div>
                                        <div class="text-xs <?php echo $i === 0 ? 'text-white/80' : 'text-ink-500'; ?> price-label"><?php echo $currency . number_format($v['price'], 2); ?></div>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            
                            <input type="hidden" name="variation_id" class="variation_id" value="<?php echo esc_attr($variations[0]['id']); ?>" />
                            <!-- Hardcode attribute assuming it's pa_package-size, update logic if dynamic -->
                            <?php 
                            $attr_name = 'attribute_pa_package-size'; 
                            $attr_val = strtolower($variations[0]['qty']); // might need to be sanitized slug
                            ?>
                            <input type="hidden" name="attribute_pa_package-size" class="variant_attr" value="<?php echo esc_attr($attr_val); ?>" />
                        <?php endif; ?>

                        <!-- Buy Row -->
                        <div class="mt-6 flex flex-wrap items-center gap-3">
                            <div class="inline-flex items-center border border-ink-200 rounded-full overflow-hidden bg-white">
                                <button type="button" class="qty-btn w-10 h-11 grid place-items-center hover:bg-ink-100" data-action="minus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus w-4 h-4"><path d="M5 12h14"/></svg>
                                </button>
                                <input type="number" name="quantity" value="1" min="1" class="qty-input w-10 text-center text-sm font-semibold border-none p-0 outline-none" style="-moz-appearance: textfield;" />
                                <button type="button" class="qty-btn w-10 h-11 grid place-items-center hover:bg-ink-100" data-action="plus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </button>
                            </div>

                            <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 h-11 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart w-4 h-4"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg> 
                                Add to Cart
                            </button>
                        </div>
                    </form>

                    <!-- Trust row -->
                    <div class="mt-6 grid grid-cols-3 gap-3">
                        <div class="p-3 rounded-lg bg-white border border-ink-200 flex items-center gap-2 text-xs font-medium text-ink-700"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck w-4 h-4 text-brand-600"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg> AU-wide dispatch</div>
                        <div class="p-3 rounded-lg bg-white border border-ink-200 flex items-center gap-2 text-xs font-medium text-ink-700"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock w-4 h-4 text-brand-600"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Encrypted checkout</div>
                        <div class="p-3 rounded-lg bg-white border border-ink-200 flex items-center gap-2 text-xs font-medium text-ink-700"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-4 h-4 text-brand-600"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> Quality verified</div>
                    </div>

                    <!-- Specs Accordion (Details tag) -->
                    <div class="mt-6 border border-ink-200 rounded-2xl bg-white overflow-hidden">
                        <details class="group [&_summary::-webkit-details-marker]:hidden" open>
                            <summary class="w-full flex items-center justify-between px-5 py-3 cursor-pointer">
                                <span class="font-semibold text-ink-900 inline-flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check w-4 h-4 text-brand-600"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg> 
                                    Product specs <span class="text-ink-500 font-normal">(<?php echo count($specs); ?>)</span>
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 text-ink-500 transition-transform group-open:rotate-180"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="px-5 pb-5 border-t border-ink-200 pt-4">
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                                    <?php foreach($specs as $k => $v): ?>
                                    <div class="flex justify-between gap-4">
                                        <dt class="text-ink-500 capitalize"><?php echo esc_html(str_replace('pa_', '', $k)); ?></dt>
                                        <dd class="text-ink-900 font-medium text-right"><?php echo esc_html($v); ?></dd>
                                    </div>
                                    <?php endforeach; ?>
                                </dl>
                            </div>
                        </details>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Tabs and Description -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="py-8 max-w-3xl prose prose-ink prose-headings:font-serif prose-headings:text-ink-900 prose-a:text-brand-700 max-w-none">
            <?php echo $full_description; ?>
        </div>
    </div>

    <?php get_template_part('template-parts/order-cta'); ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Quantity logic
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const input = e.currentTarget.parentElement.querySelector('input.qty-input');
            let v = parseInt(input.value) || 1;
            if (e.currentTarget.dataset.action === 'plus') v++;
            else if (v > 1) v--;
            input.value = v;
        });
    });

    // Variant Selection logic
    const buttons = document.querySelectorAll('.variant-btn');
    const inputVid = document.querySelector('.variation_id');
    const inputAttr = document.querySelector('.variant_attr');
    const dynamicPrice = document.getElementById('dynamic-price');
    const dynamicPerPill = document.getElementById('dynamic-per-pill');
    const currency = '<?php echo $currency; ?>';

    const updateUI = (btn) => {
        buttons.forEach(b => {
            b.classList.remove('bg-brand-600', 'text-white', 'border-brand-600', 'active');
            b.classList.add('bg-white', 'text-ink-900', 'border-ink-200');
            b.querySelector('.price-label').classList.remove('text-white/80');
            b.querySelector('.price-label').classList.add('text-ink-500');
        });
        
        btn.classList.remove('bg-white', 'text-ink-900', 'border-ink-200');
        btn.classList.add('bg-brand-600', 'text-white', 'border-brand-600', 'active');
        btn.querySelector('.price-label').classList.remove('text-ink-500');
        btn.querySelector('.price-label').classList.add('text-white/80');

        const vid = btn.dataset.vid;
        const price = parseFloat(btn.dataset.price);
        const qty = parseInt(btn.dataset.qty.replace(/\D/g, '')) || 1;

        if (inputVid) inputVid.value = vid;
        if (inputAttr) inputAttr.value = btn.dataset.qty.toLowerCase();

        dynamicPrice.innerText = currency + price.toFixed(2);
        if (qty > 1) {
            dynamicPerPill.innerText = currency + (price / qty).toFixed(2) + ' / tablet';
        } else {
            dynamicPerPill.innerText = '';
        }
    };

    if (buttons.length > 0) {
        buttons.forEach(btn => {
            btn.addEventListener('click', () => updateUI(btn));
        });
        updateUI(buttons[0]); // init
    }
});
</script>
