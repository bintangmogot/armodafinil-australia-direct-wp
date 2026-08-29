<?php
/**
 * The template for displaying product content within loops
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
$image = wp_get_attachment_image_src( $product->get_image_id(), 'medium_large' );
$img_url = $image ? $image[0] : 'https://placehold.co/400x400/e0f2fe/0369a1?text=Product';

$is_variable = $product->is_type( 'variable' );
$price_html = $product->get_price_html();
if ( $is_variable ) {
    $price_html = 'From ' . wc_price($product->get_variation_price('min'));
}

$rating = $product->get_average_rating();
?>
<div <?php wc_product_class( 'group bg-white border border-ink-200 rounded-2xl overflow-hidden hover-lift flex flex-col relative', $product ); ?>>
    
    <div class="aspect-square bg-brand-50 relative">
        <a href="<?php echo esc_url( $link ); ?>" class="block w-full h-full">
            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105 mix-blend-multiply drop-shadow-sm" />
        </a>
        <span class="absolute top-3 left-3 text-[10px] font-bold uppercase tracking-wider text-brand-800 bg-brand-200/80 backdrop-blur-sm px-2.5 py-1 rounded-full pointer-events-none">
            <?php 
            $cats = wc_get_product_category_list($product->get_id(), ', ', '', ''); 
            echo strip_tags($cats) ?: 'Medicine';
            ?>
        </span>
        
        <button type="button" class="loop-wishlist-btn absolute top-3 right-3 z-10 w-9 h-9 flex items-center justify-center rounded-full bg-white/90 backdrop-blur shadow-sm text-ink-400 hover:text-brand-600 transition-colors" data-product-id="<?php echo $product->get_id(); ?>" aria-label="Add to Wishlist">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart transition-colors"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
        </button>
    </div>
    
    <div class="hidden loop-wishlist-plugin-container" data-product-id="<?php echo $product->get_id(); ?>">
        <?php echo do_shortcode('[ti_wishlists_addtowishlist product_id="'.$product->get_id().'"]'); ?>
        <?php echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="'.$product->get_id().'"]'); ?>
    </div>
    
    <a href="<?php echo esc_url( $link ); ?>" class="p-5 border-t border-ink-100 flex flex-col flex-1 hover:no-underline">
        <h3 class="font-serif text-lg font-semibold text-ink-900 group-hover:text-brand-700 transition-colors"><?php echo esc_html($product->get_name()); ?></h3>
        <p class="mt-1 text-sm text-ink-500 line-clamp-2">
            <?php 
            $shop_text = get_field('shop_page_text', $product->get_id());
            echo $shop_text ? esc_html(wp_strip_all_tags($shop_text)) : esc_html(wp_strip_all_tags($product->get_short_description())); 
            ?>
        </p>
        
        <div class="mt-auto pt-4 flex items-center justify-between">
            <div class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star text-amber-500"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <span class="text-sm font-medium text-ink-700"><?php echo number_format($rating, 1); ?></span>
            </div>
            <div class="text-base font-semibold text-ink-900 [&>span.amount]:!font-semibold [&>del]:text-ink-400 [&>del]:font-normal [&>del]:text-sm [&>ins]:no-underline">
                <?php echo $price_html; ?>
            </div>
        </div>
        
        <div class="mt-4 w-full h-10 inline-flex items-center justify-center rounded-xl bg-brand-600 text-white font-semibold text-sm group-hover:bg-brand-700 transition-colors">
            View product
        </div>
    </a>
</div>

<?php
static $loop_wishlist_script_output = false;
if ( ! $loop_wishlist_script_output ) {
    $loop_wishlist_script_output = true;
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const syncLoopWishlist = () => {
            document.querySelectorAll('.loop-wishlist-btn').forEach(btn => {
                const pid = btn.dataset.productId;
                const container = document.querySelector(`.loop-wishlist-plugin-container[data-product-id="${pid}"]`);
                if(!container) return;
                
                const yithBtn = container.querySelector('.add_to_wishlist');
                const tiBtn = container.querySelector('.tinvwl_add_to_wishlist_button');
                
                let isAdded = false;
                if (container.querySelector('.yith-wcwl-wishlistaddedbrowse.show, .yith-wcwl-wishlistexistsbrowse.show') || (yithBtn && yithBtn.classList.contains('added'))) {
                    isAdded = true;
                }
                if (tiBtn && (tiBtn.classList.contains('tinvwl-product-in-list') || tiBtn.classList.contains('in-wishlist'))) {
                    isAdded = true;
                }
                
                if (isAdded) {
                    btn.classList.add('text-brand-600');
                    btn.classList.remove('text-ink-400');
                    btn.querySelector('svg').classList.add('fill-brand-600');
                } else {
                    btn.classList.remove('text-brand-600');
                    btn.classList.add('text-ink-400');
                    btn.querySelector('svg').classList.remove('fill-brand-600');
                }
            });
        };

        syncLoopWishlist();
        setInterval(syncLoopWishlist, 500);

        document.querySelectorAll('.loop-wishlist-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                const pid = btn.dataset.productId;
                const container = document.querySelector(`.loop-wishlist-plugin-container[data-product-id="${pid}"]`);
                if(!container) return;
                
                const yithBtn = container.querySelector('.add_to_wishlist');
                const tiBtn = container.querySelector('.tinvwl_add_to_wishlist_button');
                
                if (yithBtn) {
                    yithBtn.click();
                } else if (tiBtn) {
                    tiBtn.click();
                } else {
                    alert('Wishlist plugin is not active.');
                }
            });
        });
    });
    </script>
    <?php
}
?>
