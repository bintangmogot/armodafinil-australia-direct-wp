<?php
/**
 * Popular Products Module Template
 * 
 * Data provided by ACF Sub Fields: title, subtitle, view_all_text, view_all_url, products
 */

$title = get_sub_field('title') ?: 'Popular right now';
$subtitle = get_sub_field('subtitle') ?: 'Add to cart, or open a product for full details and dosing notes.';
$view_all_text = get_sub_field('view_all_text') ?: 'View all';
$view_all_url = get_sub_field('view_all_url') ?: '/product';
$products = get_sub_field('products');

?>

<section class="py-16 md:py-20 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between gap-4 flex-wrap">
            <div>
                <h2 class="text-3xl md:text-4xl font-serif font-semibold text-ink-900"><?php echo esc_html($title); ?></h2>
                <p class="mt-2 text-ink-500"><?php echo esc_html($subtitle); ?></p>
            </div>
            <a href="<?php echo esc_url($view_all_url); ?>" class="inline-flex items-center gap-1.5 text-brand-700 font-semibold hover:gap-2 transition-all">
                <?php echo esc_html($view_all_text); ?> 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>
        
        <div class="mt-8 grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
            <?php 
            if ( $products ) : 
                foreach ( $products as $post ) : 
                    setup_postdata( $post );
                    $product = wc_get_product( $post->ID );
                    if ( ! $product ) continue;

                    $p_name = $product->get_name();
                    $p_url = $product->get_permalink();
                    $p_price_html = $product->get_price_html();
                    
                    $p_image = 'https://placehold.co/400x300/e0f2fe/0369a1?text=Product';
                    if ( $product->get_image_id() ) {
                        $p_image = wp_get_attachment_image_url( $product->get_image_id(), 'medium' );
                    }
                    
                    // True dynamic rating from WooCommerce
                    $rating = (float) $product->get_average_rating();
                    $review_count = (int) $product->get_review_count();
            ?>
            <div class="group bg-white border border-ink-200 rounded-[20px] overflow-hidden hover:shadow-card hover:border-ink-300 transition-all duration-300 flex flex-col p-2.5">
                <a href="<?php echo esc_url($p_url); ?>" class="block aspect-[4/3] bg-white rounded-xl border border-ink-100 overflow-hidden relative">
                    <img src="<?php echo esc_url($p_image); ?>" alt="<?php echo esc_attr($p_name); ?>" loading="lazy" class="w-full h-full object-contain p-4 transition-transform duration-500 group-hover:scale-105" />
                </a>
                <div class="px-3 pt-4 pb-2 flex flex-col gap-3 flex-1">
                    
                    <!-- Dynamic Star Rating -->
                    <div class="flex items-center gap-2">
                        <div class="flex items-center text-amber-400">
                            <?php for($i=1; $i<=5; $i++): 
                                if ( $rating >= $i ) {
                                    // Full star
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star w-3.5 h-3.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>';
                                } elseif ( $rating >= ( $i - 0.5 ) ) {
                                    // Half star
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star-half w-3.5 h-3.5"><path d="M12 17.8 5.8 21 7 14.1 2 9.3l7-1L12 2"/></svg>';
                                } else {
                                    // Empty star
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star w-3.5 h-3.5 text-ink-200"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>';
                                }
                            endfor; ?>
                        </div>
                        <span class="text-xs text-ink-500 font-medium">
                            <?php if ($review_count > 0): ?>
                                <?php echo number_format($rating, 1); ?> <span class="text-ink-400 font-normal">(<?php echo $review_count; ?>)</span>
                            <?php else: ?>
                                0 reviews
                            <?php endif; ?>
                        </span>
                    </div>

                    <a href="<?php echo esc_url($p_url); ?>" class="font-serif text-lg font-bold text-ink-900 leading-snug hover:text-brand-600 transition-colors line-clamp-2"><?php echo esc_html($p_name); ?></a>
                    
                    <div class="flex items-baseline gap-2 mt-auto">
                        <span class="text-xl font-bold text-ink-900 price-html-wrapper tracking-tight"><?php echo $p_price_html; ?></span>
                    </div>
                    
                    <div class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-widest <?php echo $product->is_in_stock() ? 'text-emerald-700' : 'text-rose-600'; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg> 
                        <?php echo $product->is_in_stock() ? 'In Stock' : 'Out of Stock'; ?>
                    </div>
                    
                    <form action="<?php echo esc_url( $p_url ); ?>" method="get" class="mt-1">
                        <button type="submit" class="w-full inline-flex justify-center items-center gap-2 h-11 rounded-xl bg-ink-900 hover:bg-ink-800 text-white text-sm font-bold transition-all hover:shadow-md hover:shadow-ink-900/10">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart w-4 h-4"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg> 
                            View Details
                        </button>
                    </form>
                </div>
            </div>
            <?php 
                endforeach; 
                wp_reset_postdata();
            else: 
                echo '<p class="text-ink-500">No products selected.</p>';
            endif; 
            ?>
        </div>
    </div>
</section>
