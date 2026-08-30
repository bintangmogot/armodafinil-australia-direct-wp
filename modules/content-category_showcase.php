<?php
$title = get_sub_field('title');
$subtitle = get_sub_field('subtitle');
$icon_url = get_sub_field('icon');
$link_text = get_sub_field('link_text') ?: 'Browse category';
$category = get_sub_field('category');

if ( ! $category ) {
    return;
}

$product_count = $category->count;
$cat_link = get_term_link($category);

// Get products in this category
$cat_products = wc_get_products(array(
    'category' => array( $category->slug ),
    'limit' => -1,
));
?>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header Card -->
    <div class="bg-[#F8FDFB] border border-brand-100 rounded-[2rem] p-6 md:p-8 flex flex-col md:flex-row md:items-center gap-6 justify-between mb-8">
        
        <div class="flex items-start md:items-center gap-5">
            <?php if ( $icon_url ) : ?>
                <div class="shrink-0 w-[72px] h-[72px] rounded-[1.25rem] bg-white shadow-[0_2px_10px_-4px_rgba(0,169,157,0.1)] flex items-center justify-center text-brand-600">
                    <img src="<?php echo esc_url($icon_url); ?>" alt="" class="w-8 h-8 object-contain" />
                </div>
            <?php else : ?>
                <!-- Default Icon -->
                <div class="shrink-0 w-[72px] h-[72px] rounded-[1.25rem] bg-white shadow-[0_2px_10px_-4px_rgba(0,169,157,0.1)] flex items-center justify-center text-brand-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-box"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                </div>
            <?php endif; ?>
            
            <div>
                <div class="flex flex-wrap items-center gap-4">
                    <h2 class="font-serif text-3xl font-bold text-ink-900 tracking-tight"><?php echo esc_html($title); ?></h2>
                    <span class="text-xs font-semibold text-brand-700 bg-brand-100 rounded-full px-3 py-1"><?php echo esc_html($product_count); ?> products</span>
                </div>
                <?php if ( $subtitle ) : ?>
                    <p class="mt-2.5 text-ink-700 text-sm md:text-base max-w-3xl"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="shrink-0">
            <a href="<?php echo esc_url($cat_link); ?>" class="inline-flex items-center gap-2 h-11 px-6 rounded-full bg-white border border-ink-200 hover:border-brand-600 hover:text-brand-700 text-ink-900 text-sm font-semibold transition-colors">
                <?php echo esc_html($link_text); ?> 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <!-- Product Grid -->
    <?php if ( ! empty( $cat_products ) ) : ?>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <?php
            foreach ( $cat_products as $product ) {
                $product_id = $product->get_id();
                $link = get_permalink($product_id);
                $name = $product->get_name();
                $image_id = $product->get_image_id();
                $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium_large' ) : 'https://placehold.co/600x450/e0f2fe/0369a1?text=' . urlencode($name);
                ?>
                <a href="<?php echo esc_url($link); ?>" class="group bg-white border border-ink-200 rounded-3xl overflow-hidden hover-lift flex flex-col transition-shadow hover:shadow-lg">
                    <div class="aspect-[4/3] bg-brand-50 overflow-hidden relative">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($name); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 mix-blend-multiply" />
                    </div>
                    <div class="p-5 md:p-6 flex-1 flex flex-col justify-center bg-white z-10 relative">
                        <h3 class="font-serif text-lg font-bold text-ink-900 group-hover:text-brand-700 transition-colors line-clamp-1"><?php echo esc_html($name); ?></h3>
                        <div class="mt-1 text-sm text-ink-500 flex items-center gap-1 group-hover:text-brand-600 transition-colors">
                            Explore <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                        </div>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
    <?php endif; ?>

</section>
