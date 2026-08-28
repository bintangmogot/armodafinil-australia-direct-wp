<?php
/**
 * Hero Section Module Template
 * 
 * Data provided by ACF Sub Fields: eyebrow, title, subtitle, cta_label, cta_url, featured_product
 */

$eyebrow   = get_sub_field('eyebrow');
$title     = get_sub_field('title');
$subtitle  = get_sub_field('subtitle');
$cta_label = get_sub_field('cta_label');
$cta_url   = get_sub_field('cta_url');
$product_obj = get_sub_field('featured_product');

// Default product values in case none selected
$p_title = 'Armodafinil 250mg — Artvigil 250mg';
$p_image = 'https://placehold.co/800x450/e0f2fe/0369a1?text=Product+Image';
$p_price = '185.00';
$p_stock = 'In stock';
$p_url   = '#';
$p_note  = 'Limit 1 per customer on first order.';
$p_id    = 0;

if ( $product_obj ) {
    $product = wc_get_product( $product_obj->ID );
    if ( $product ) {
        $p_id    = $product->get_id();
        $p_title = $product->get_name();
        $p_price = wc_get_price_to_display( $product );
        $p_url   = $product->get_permalink();
        
        $image_id = $product->get_image_id();
        if ( $image_id ) {
            $p_image = wp_get_attachment_image_url( $image_id, 'large' );
        }
        $p_stock = $product->is_in_stock() ? 'In stock' : 'Out of stock';
    }
}
?>

<section class="section-wash">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 md:py-20 grid lg:grid-cols-2 gap-10 items-center">
        <div class="animate-fadeup">
            <?php if ( $eyebrow ) : ?>
            <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.18em] text-brand-700 bg-brand-100 px-3 py-1.5 rounded-full">
                <!-- Sparkles Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                <?php echo esc_html( $eyebrow ); ?>
            </span>
            <?php endif; ?>

            <?php if ( $title ) : ?>
            <h1 class="mt-5 font-serif text-4xl md:text-6xl leading-[1.05] font-semibold text-ink-900">
                <?php echo wp_kses_post( $title ); ?>
            </h1>
            <?php endif; ?>

            <?php if ( $subtitle ) : ?>
            <p class="mt-5 text-lg text-ink-700 leading-relaxed max-w-xl">
                <?php echo wp_kses_post( $subtitle ); ?>
            </p>
            <?php endif; ?>

            <div class="mt-8 flex flex-wrap gap-3">
                <?php if ( $cta_url && $cta_label ) : ?>
                <a href="<?php echo esc_url( $cta_url ); ?>" class="inline-flex items-center gap-2 h-12 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors shadow-soft">
                    <?php echo esc_html( $cta_label ); ?> 
                    <!-- Arrow Right Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
                <?php endif; ?>
                <a href="/conditions" class="inline-flex items-center gap-2 h-12 px-6 rounded-full border border-ink-200 hover:border-brand-600 text-ink-900 font-semibold transition-colors">
                    Explore guides
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-ink-200 shadow-card overflow-hidden animate-fadeup">
            <a href="<?php echo esc_url($p_url); ?>" class="block aspect-[16/9] bg-brand-50">
                <img src="<?php echo esc_url( $p_image ); ?>" alt="<?php echo esc_attr( $p_title ); ?>" class="w-full h-full object-cover mix-blend-multiply" />
            </a>
            <div class="p-5 md:p-6">
                <div class="flex items-start justify-between gap-3">
                    <h3 class="font-serif text-xl font-semibold text-ink-900"><a href="<?php echo esc_url($p_url); ?>"><?php echo esc_html( $p_title ); ?></a></h3>
                    <span class="shrink-0 text-xs font-semibold text-brand-700 bg-brand-100 px-2.5 py-1 rounded-full"><?php echo esc_html( $p_stock ); ?></span>
                </div>
                
                <div class="mt-4">
                    <div class="text-[11px] uppercase tracking-widest text-ink-500 mb-2">Package Size</div>
                    <div class="flex flex-wrap gap-1.5">
                        <span class="text-xs font-semibold px-2.5 py-1.5 rounded-md border bg-brand-600 text-white border-brand-600">100 pills</span>
                        <span class="text-xs font-semibold px-2.5 py-1.5 rounded-md border bg-white text-ink-700 border-ink-200">200 pills</span>
                        <span class="text-xs font-semibold px-2.5 py-1.5 rounded-md border bg-white text-ink-700 border-ink-200">300 pills</span>
                    </div>
                </div>

                <div class="mt-4 p-3 rounded-lg bg-amber-50 border border-amber-200 text-xs text-amber-900 flex items-start gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info mt-0.5 shrink-0"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg> 
                    <?php echo esc_html($p_note); ?>
                </div>

                <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <div class="text-2xl font-semibold text-ink-900">
                            <?php echo get_woocommerce_currency_symbol(); ?><?php echo esc_html( $p_price ); ?>
                        </div>
                        <div class="text-xs text-ink-500">250mg strength</div>
                    </div>
                    
                    <form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post" enctype='multipart/form-data' class="flex items-center gap-2">
                        <div class="inline-flex items-center border border-ink-200 rounded-full overflow-hidden bg-white">
                            <button type="button" onclick="this.nextElementSibling.stepDown()" class="w-9 h-9 grid place-items-center hover:bg-ink-100 text-ink-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                            </button>
                            <input type="number" name="quantity" value="1" min="1" class="w-8 text-center text-sm font-medium border-0 p-0 focus:ring-0 text-ink-900" style="-moz-appearance: textfield;" />
                            <button type="button" onclick="this.previousElementSibling.stepUp()" class="w-9 h-9 grid place-items-center hover:bg-ink-100 text-ink-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            </button>
                        </div>
                        <button type="submit" name="add-to-cart" value="<?php echo esc_attr($p_id); ?>" class="inline-flex items-center gap-2 h-10 px-4 rounded-full bg-ink-900 hover:bg-ink-800 text-white text-sm font-semibold transition-colors shadow-soft whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                            Add
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
