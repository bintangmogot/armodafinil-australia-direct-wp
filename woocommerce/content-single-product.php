<?php
/**
 * The template for displaying product content in the single-product.php template
 */

defined( 'ABSPATH' ) || exit;

global $product;

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
        $qty = 0;
        foreach($var['attributes'] as $key => $val) {
            $qty = $val;
            break;
        }
        $variations[] = array(
            'id' => $var['variation_id'],
            'qty' => $qty,
            'price' => $var['display_price'],
            'attributes_raw' => $var['attributes']
        );
    }
} else {
    $variations[] = array(
        'id' => 0,
        'qty' => '1 Pack',
        'price' => wc_get_price_to_display( $product ),
        'attributes_raw' => []
    );
}

$currency = html_entity_decode(get_woocommerce_currency_symbol());
$review_count = $product->get_review_count();
$average_rating = $product->get_average_rating();
$full_description = apply_filters( 'the_content', $product->get_description() );

// Specs
$specs = array();
$attributes = $product->get_attributes();
foreach ( $attributes as $attribute ) {
    if ( $attribute->get_name() === 'package-size' && $is_variable ) continue; // Optionally hide the main variation attribute from specs if you want, but we'll leave it or format it.
    if ( $attribute->is_taxonomy() ) {
        $values = wc_get_product_terms( $product_id, $attribute->get_name(), array( 'fields' => 'names' ) );
        $specs[ wc_attribute_label( $attribute->get_name() ) ] = implode( ', ', $values );
    } else {
        $specs[ $attribute->get_name() ] = implode( ', ', $attribute->get_options() );
    }
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
                <div class="lg:sticky lg:top-24">
                    <div class="bg-white rounded-2xl border border-ink-200 overflow-hidden shadow-sm">
                        <div class="aspect-square bg-brand-50">
                            <img src="<?php echo esc_url($product_image_url); ?>" alt="<?php echo esc_attr($product_name); ?>" class="w-full h-full object-cover" />
                        </div>
                    </div>
                    <?php 
                    $text_under_img = get_field('text_under_product_image', $product_id);
                    if($text_under_img): 
                    ?>
                        <div class="mt-4 p-4 bg-white rounded-xl border border-ink-200 text-sm prose prose-ink prose-p:last:mb-0">
                            <?php echo $text_under_img; ?>
                        </div>
                    <?php endif; ?>
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
                        <span class="text-sm text-ink-500" id="dynamic-per-pill">
                            <?php 
                            $ppu = get_field('price_per_unit', $product_id);
                            if ( ! $is_variable && $ppu ) {
                                echo esc_html($ppu);
                            }
                            ?>
                        </span>
                    </div>

                    <!-- Promo strip -->
                    <div class="mt-5 p-4 rounded-xl bg-amber-50 border border-amber-200 flex items-center gap-3 flex-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info w-5 h-5 text-amber-600 shrink-0"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                        <p class="text-sm text-amber-900 flex-1 min-w-[200px]">Free shipping + 10% off on orders above <b>$299</b>. Use code:</p>
                        <button type="button" class="inline-flex items-center gap-2 h-9 px-3 rounded-lg border border-dashed border-amber-500 bg-white text-amber-800 font-mono font-semibold text-sm hover:bg-amber-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-copy w-4 h-4"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg> 
                            <?php echo esc_html(get_field('promo_code', 'option') ?: 'ARMD10'); ?>
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
                                <?php foreach($variations as $i => $v): 
                                    // Serialize attributes for JS parsing
                                    $attrs_json = htmlspecialchars(json_encode($v['attributes_raw']), ENT_QUOTES, 'UTF-8');
                                ?>
                                    <button type="button" data-vid="<?php echo esc_attr($v['id']); ?>" data-price="<?php echo esc_attr($v['price']); ?>" data-qty="<?php echo esc_attr($v['qty']); ?>" data-attrs="<?php echo $attrs_json; ?>" class="variant-btn p-3 rounded-xl border text-left transition-colors <?php echo $i === 0 ? 'bg-brand-600 text-white border-brand-600 active' : 'bg-white text-ink-900 border-ink-200 hover:border-brand-500'; ?>">
                                        <div class="text-lg font-semibold"><?php echo esc_html($v['qty']); ?></div>
                                        <div class="text-xs <?php echo $i === 0 ? 'text-white/80' : 'text-ink-500'; ?> price-label"><?php echo $currency . number_format($v['price'], 2); ?></div>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            
                            <input type="hidden" name="variation_id" class="variation_id" value="<?php echo esc_attr($variations[0]['id']); ?>" />
                            <div id="dynamic-attributes-container">
                                <?php foreach($variations[0]['attributes_raw'] as $key => $val): ?>
                                    <input type="hidden" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($val); ?>" />
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Buy Row -->
                        <div class="mt-6 flex flex-col xl:flex-row items-stretch xl:items-center gap-3">
                            <div class="flex items-center gap-3 w-full xl:w-auto">
                                <div class="inline-flex items-center border border-ink-200 rounded-full overflow-hidden bg-white shrink-0">
                                    <button type="button" class="qty-btn w-10 h-11 grid place-items-center hover:bg-ink-100" data-action="minus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus text-ink-700"><path d="M5 12h14"/></svg>
                                    </button>
                                    <input type="number" name="quantity" value="1" min="1" class="qty-input w-10 text-center text-sm font-semibold border-none p-0 outline-none" style="-moz-appearance: textfield;" />
                                    <button type="button" class="qty-btn w-10 h-11 grid place-items-center hover:bg-ink-100" data-action="plus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus text-ink-700"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                    </button>
                                </div>

                                <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="flex-1 xl:flex-none inline-flex items-center justify-center gap-2 h-11 px-4 sm:px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart w-4 h-4"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg> 
                                    Add to Cart
                                </button>
                            </div>
                            
                            <div class="flex items-center gap-3 w-full xl:w-auto">
                                <button type="button" onclick="document.querySelector('form.cart').submit(); setTimeout(()=>window.location.href='/checkout/', 500);" class="flex-1 xl:flex-none inline-flex items-center justify-center gap-2 h-11 px-4 sm:px-6 rounded-full bg-ink-900 hover:bg-ink-800 text-white font-semibold transition-colors whitespace-nowrap">
                                    Buy now <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </button>

                                <button type="button" aria-label="Wishlist" class="w-11 h-11 shrink-0 grid place-items-center rounded-full border border-ink-200 hover:border-brand-500 hover:text-brand-600 text-ink-500 bg-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                                </button>
                                <button type="button" aria-label="Share" class="w-11 h-11 shrink-0 grid place-items-center rounded-full border border-ink-200 hover:border-brand-500 hover:text-brand-600 text-ink-500 bg-white transition-colors" title="Share this product">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-share-2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg>
                                </button>
                            </div>
                        </div>
                        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
                    </form>
                    <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

                    <!-- Trust row -->
                    <div class="mt-6 grid grid-cols-3 gap-3">
                        <div class="p-3 rounded-lg bg-white border border-ink-200 flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1 sm:gap-2 text-[10px] sm:text-xs font-medium text-ink-700 text-center sm:text-left"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck w-4 h-4 text-brand-600 shrink-0"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg> <span>AU-wide dispatch</span></div>
                        <div class="p-3 rounded-lg bg-white border border-ink-200 flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1 sm:gap-2 text-[10px] sm:text-xs font-medium text-ink-700 text-center sm:text-left"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock w-4 h-4 text-brand-600 shrink-0"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> <span>Encrypted checkout</span></div>
                        <div class="p-3 rounded-lg bg-white border border-ink-200 flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1 sm:gap-2 text-[10px] sm:text-xs font-medium text-ink-700 text-center sm:text-left"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-4 h-4 text-brand-600 shrink-0"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> <span>Quality verified</span></div>
                    </div>

                    <!-- Product Specs Accordion -->
                    <?php
                    $custom_specs = get_field('custom_product_specs', $product_id);
                    $total_specs_count = count($attributes) + (is_array($custom_specs) ? count($custom_specs) : 0);
                    if ($total_specs_count > 0):
                    ?>
                    <div class="mt-8 border border-ink-200 rounded-xl overflow-hidden bg-white">
                        <details class="group">
                            <summary class="flex items-center justify-between p-4 cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle-2 text-brand-600"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                                    <span class="font-medium text-ink-900">Product specs</span>
                                    <span class="text-ink-500 text-sm">(<?php echo $total_specs_count; ?>)</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down text-ink-500 transition-transform group-open:rotate-180"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="px-4 pb-4 border-t border-ink-100 text-sm pt-4">
                                <dl class="divide-y divide-ink-100">
                                    <?php if(is_array($custom_specs)): foreach($custom_specs as $spec): ?>
                                    <div class="py-3 flex justify-between gap-4">
                                        <dt class="text-ink-500 min-w-[120px]"><?php echo esc_html($spec['spec_name']); ?></dt>
                                        <dd class="text-ink-900 font-medium text-right"><?php echo esc_html($spec['spec_value']); ?></dd>
                                    </div>
                                    <?php endforeach; endif; ?>
                                    
                                    <?php foreach ( $attributes as $attribute ) : ?>
                                    <div class="py-3 flex justify-between gap-4">
                                        <dt class="text-ink-500 min-w-[120px]"><?php echo wc_attribute_label( $attribute->get_name() ); ?></dt>
                                        <dd class="text-ink-900 font-medium text-right">
                                            <?php
                                            $values = array();
                                            if ( $attribute->is_taxonomy() ) {
                                                $attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );
                                                foreach ( $attribute_values as $attribute_value ) {
                                                    $value_name = esc_html( $attribute_value->name );
                                                    $values[] = $value_name;
                                                }
                                            } else {
                                                $values = $attribute->get_options();
                                            }
                                            echo wp_kses_post( implode( ', ', $values ) );
                                            ?>
                                        </dd>
                                    </div>
                                    <?php endforeach; ?>
                                </dl>
                            </div>
                        </details>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Tabs and Description -->
    <?php
    $extra_tabs = get_field('extra_tabs', $product_id);
    $has_tabs = !empty($extra_tabs);
    $has_desc = !empty(trim(wp_strip_all_tags($full_description)));
    ?>
    <?php if($has_desc || $has_tabs): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" id="product-tabs-section">
        <div class="mt-8 sm:mt-12">
            <div class="border-b border-ink-200">
                <nav class="-mb-px flex space-x-8 overflow-x-auto tab-navs" aria-label="Tabs">
                    <?php if($has_desc): ?>
                    <button class="tab-btn active whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-brand-600 text-brand-700" data-target="tab-description">
                        Description
                    </button>
                    <?php endif; ?>
                    <?php if($has_tabs): foreach($extra_tabs as $i => $tab): 
                        $is_first_and_no_desc = !$has_desc && $i === 0;
                        $btn_class = $is_first_and_no_desc ? 'tab-btn active whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-brand-600 text-brand-700' : 'tab-btn whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-ink-500 hover:text-ink-700 hover:border-ink-300 transition-colors';
                    ?>
                    <button class="<?php echo $btn_class; ?>" data-target="tab-extra-<?php echo $i; ?>">
                        <?php echo esc_html($tab['tab_title']); ?>
                    </button>
                    <?php endforeach; endif; ?>
                </nav>
            </div>

            <div class="py-8 max-w-3xl prose prose-ink prose-headings:font-serif prose-headings:text-ink-900 prose-a:text-brand-700 max-w-none">
                <?php if($has_desc): ?>
                <div id="tab-description" class="tab-content block">
                    <?php echo $full_description; ?>
                </div>
                <?php endif; ?>
                <?php if($has_tabs): foreach($extra_tabs as $i => $tab): 
                    $is_first_and_no_desc = !$has_desc && $i === 0;
                    $content_class = $is_first_and_no_desc ? 'tab-content block' : 'tab-content hidden';
                ?>
                <div id="tab-extra-<?php echo $i; ?>" class="<?php echo $content_class; ?>">
                    <?php echo $tab['tab_content']; ?>
                </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Important Usage Note and Disclaimer -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <?php
        $default_usage = '{product_name} is a Schedule 4 (prescription-only) medicine in Australia. Effects, dosage, and possible side effects can differ from person to person. Taking this medicine without a doctor\'s advice may be harmful. This website does not encourage self-medication. For official Australian prescription-medicine guidance, see the <a href="https://www.tga.gov.au/" target="_blank" rel="noopener" class="text-brand-700 hover:underline">Therapeutic Goods Administration (TGA)</a>.';
        $usage_note = get_field('important_usage_note', 'option') ?: $default_usage;
        $usage_note = str_replace('{product_name}', esc_html($product->get_name()), $usage_note);
        
        $default_disclaimer = 'This website is for informational purposes only and does not constitute medical advice. Always consult a qualified healthcare professional before starting, stopping, or changing any medication. <a href="/medical-disclaimer" class="font-semibold text-brand-800 hover:underline">Read our full medical disclaimer.</a>';
        $disclaimer = get_field('medical_disclaimer_text', 'option') ?: $default_disclaimer;
        
        $reviewed_by = get_field('medically_reviewed_by', 'option') ?: 'Dr. Ginni Mansberg';
        ?>
        <div class="space-y-4 max-w-4xl mx-auto">
            <!-- Important Usage Note -->
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 sm:p-5 flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-alert text-amber-600 shrink-0 mt-0.5"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                <div>
                    <h4 class="font-bold text-amber-900 text-sm mb-1">Important Usage Note</h4>
                    <div class="text-[13px] text-amber-900/90 leading-relaxed [&_a]:text-brand-700 [&_a]:hover:underline [&_a]:font-semibold">
                        <?php echo wp_kses_post($usage_note); ?>
                    </div>
                </div>
            </div>

            <!-- Informational Disclaimer -->
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 sm:p-5 flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert text-brand-700 shrink-0 mt-0.5"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                <div>
                    <div class="text-[13px] text-slate-700 leading-relaxed [&_a]:text-brand-800 [&_a]:hover:underline [&_a]:font-semibold">
                        <?php echo wp_kses_post($disclaimer); ?>
                    </div>
                </div>
            </div>
            
            <!-- Medically reviewed by -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs text-slate-500 pt-2 px-1">
                <div>Medically reviewed by: <span class="font-semibold text-slate-700"><?php echo esc_html($reviewed_by); ?></span> (Physician)</div>
                <div>Last updated: <?php echo date('F Y'); ?></div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="bg-slate-50 border-t border-slate-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-auto">
                <?php
                $reviews = get_posts([
                    'post_type' => 'review',
                    'posts_per_page' => -1,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'meta_query' => array(
                        array(
                            'key'     => 'linked_product',
                            'value'   => get_the_ID(),
                            'compare' => '='
                        )
                    )
                ]);
                $review_count = count($reviews);
                
                $total_rating = 0;
                $average_rating = 5.0; // default if no reviews
                if ($review_count > 0) {
                    foreach ($reviews as $r) {
                        $rating_val = get_field('rating', $r->ID);
                        $total_rating += $rating_val ? (float)$rating_val : 5.0;
                    }
                    $average_rating = round($total_rating / $review_count, 1);
                }
                $average_rating_formatted = number_format($average_rating, 1);
                $rounded_rating = round($average_rating);
                ?>

                <div class="flex flex-col items-center justify-center text-center mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-4">Customer Reviews</h2>
                    
                    <?php if ($review_count > 0): ?>
                    <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-200">
                        <div class="flex items-center gap-0.5">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="none" class="w-6 h-6 <?php echo ($i < $rounded_rating) ? 'text-amber-400' : 'text-slate-200'; ?>">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-xl font-bold text-slate-900"><?php echo $average_rating_formatted; ?></span>
                            <span class="text-sm font-medium text-slate-500">out of 5 (<?php echo $review_count; ?> reviews)</span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php if ($reviews): ?>
                        <?php foreach ($reviews as $r): 
                            $post_id = $r->ID;
                            $title = get_the_title($post_id);
                            $body = get_post_field('post_content', $post_id);
                            $reviewer = get_field('name', $post_id) ?: $r->post_title;
                            $meta = get_field('reviewer_meta', $post_id) ?: "Verified Buyer";
                            $rating_val = get_field('rating', $post_id) ?: 5;
                        ?>
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm transition-shadow hover:shadow-md">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 shrink-0 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center font-bold text-sm uppercase">
                                        <?php echo substr(esc_html($reviewer), 0, 1); ?>
                                    </div>
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="font-bold text-sm text-slate-900"><?php echo esc_html($reviewer); ?></p>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-50 text-[10px] font-bold text-green-700 uppercase tracking-wide">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                                <?php echo esc_html($meta); ?>
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-0.5 mt-1 text-amber-400">
                                            <?php for ($stars = 0; $stars < 5; $stars++): ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none" class="<?php echo ($stars < $rating_val) ? 'text-amber-400' : 'text-slate-200'; ?>">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                                </svg>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-xs text-slate-400 font-medium whitespace-nowrap">
                                    <?php echo get_the_date('M j, Y', $post_id); ?>
                                </div>
                            </div>
                            <h4 class="font-bold text-base text-slate-900 mb-2"><?php echo esc_html($title); ?></h4>
                            <div class="text-sm text-slate-600 leading-relaxed">
                                <?php echo wp_kses_post($body); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-slate-200 border-dashed">
                            <p class="text-slate-500 font-medium">No reviews yet for this product.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Frequently Bought Together -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-bold text-ink-900 mb-8">Frequently Bought Together</h2>
        <?php 
        woocommerce_output_related_products(array(
            'posts_per_page' => 4,
            'columns'        => 4,
            'orderby'        => 'rand'
        )); 
        ?>
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
    const dynamicAttrsContainer = document.getElementById('dynamic-attributes-container');
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
        const attrs = JSON.parse(btn.dataset.attrs);

        if (inputVid) inputVid.value = vid;
        
        if (dynamicAttrsContainer) {
            dynamicAttrsContainer.innerHTML = '';
            for(const key in attrs) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = attrs[key];
                dynamicAttrsContainer.appendChild(input);
            }
        }

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
    }

    // AJAX Add to Cart
    const cartForm = document.querySelector('form.cart');
    if (cartForm) {
        cartForm.addEventListener('submit', function(e) {
            // If they clicked Buy Now (we can check if event submitter was buy now, but wait, buy now button uses onclick=submit(), so let's check if the submitter is Add To Cart)
            const submitter = e.submitter;
            if (submitter && submitter.textContent.includes('Buy now')) {
                return; // Let it submit normally (or redirect)
            }
            
            e.preventDefault();
            
            const btn = cartForm.querySelector('button[name="add-to-cart"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white/30 border-t-white rounded-full mr-2"></span> Adding...';
            btn.disabled = true;

            const formData = new FormData(cartForm);
            // Append the add-to-cart value which is required
            formData.append('add-to-cart', btn.value);

            fetch('<?php echo esc_url( wc_get_cart_url() ); ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.text();
                }
                throw new Error('Network response was not ok.');
            })
            .then(html => {
                btn.innerHTML = 'Added!';
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 2000);

                // Trigger jQuery event for Side Cart plugin
                if (typeof jQuery !== 'undefined') {
                    jQuery(document.body).trigger('added_to_cart', [null, null, jQuery(btn)]);
                    jQuery(document.body).trigger('wc_fragment_refresh');
                    // Some side carts use this specific trigger to open
                    if (typeof xoo_wsc_cart !== 'undefined') {
                        jQuery(document.body).trigger('xoo_wsc_cart_updated');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        });
    }

    // Tabs Logic
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active classes
            tabBtns.forEach(b => {
                b.classList.remove('border-brand-600', 'text-brand-700', 'active');
                b.classList.add('border-transparent', 'text-ink-500');
            });
            tabContents.forEach(c => {
                c.classList.remove('block');
                c.classList.add('hidden');
            });

            // Add active classes
            btn.classList.add('border-brand-600', 'text-brand-700', 'active');
            btn.classList.remove('border-transparent', 'text-ink-500');
            const target = document.getElementById(btn.dataset.target);
            if (target) {
                target.classList.remove('hidden');
                target.classList.add('block');
            }
        });
    });
    // Share Integration
    const shareBtn = document.querySelector('button[aria-label="Share"]');
    if (shareBtn) {
        shareBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (navigator.share && window.isSecureContext) {
                navigator.share({
                    title: document.title,
                    url: window.location.href
                }).catch(console.error);
            } else {
                // Fallback: Copy to clipboard
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(window.location.href);
                    alert('Link copied to clipboard!');
                } else {
                    // Old school fallback for non-https local dev
                    const textArea = document.createElement('textarea');
                    textArea.value = window.location.href;
                    textArea.style.position = 'fixed';
                    textArea.style.left = '-999999px';
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        alert('Link copied to clipboard!');
                    } catch (err) {
                        console.error('Unable to copy', err);
                    }
                    document.body.removeChild(textArea);
                }
            }
        });
    }

    // Wishlist Integration
    const wishlistBtn = document.querySelector('button[aria-label="Wishlist"]');
    if (wishlistBtn) {
        const syncWishlistState = () => {
            const yithBtn = document.querySelector('.add_to_wishlist');
            const yithExists = document.querySelector('.yith-wcwl-add-button.hide') || document.querySelector('.yith-wcwl-wishlistexistsbrowse') || document.querySelector('.yith-wcwl-wishlistaddedbrowse');
            const tiBtn = document.querySelector('.tinvwl_add_to_wishlist_button');
            
            let isAdded = false;
            
            // Check YITH state
            if (document.querySelector('.yith-wcwl-wishlistaddedbrowse.show, .yith-wcwl-wishlistexistsbrowse.show') || (yithBtn && yithBtn.classList.contains('added'))) {
                isAdded = true;
            }
            
            // Check TI state
            if (tiBtn && (tiBtn.classList.contains('tinvwl-product-in-list') || tiBtn.classList.contains('in-wishlist'))) {
                isAdded = true;
            }
            
            if (isAdded) {
                wishlistBtn.classList.add('text-brand-600', 'border-brand-600');
                wishlistBtn.classList.remove('text-ink-500', 'border-ink-200');
                wishlistBtn.querySelector('svg').classList.add('fill-brand-600');
            } else {
                wishlistBtn.classList.remove('text-brand-600', 'border-brand-600');
                wishlistBtn.classList.add('text-ink-500', 'border-ink-200');
                wishlistBtn.querySelector('svg').classList.remove('fill-brand-600');
            }
        };

        // Run on load and periodically to catch ajax updates
        syncWishlistState();
        setInterval(syncWishlistState, 500);

        wishlistBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const yithBtn = document.querySelector('.add_to_wishlist');
            const tiBtn = document.querySelector('.tinvwl_add_to_wishlist_button');
            
            if (yithBtn) {
                yithBtn.click();
                // State will sync automatically via setInterval
            } else if (tiBtn) {
                tiBtn.click();
            } else {
                alert('Wishlist plugin is not active.');
            }
        });
    }

});
</script>
