<?php
/**
 * Template Name: Categories
 */

get_header();
?>

<div class="section-wash pt-16 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-xs uppercase tracking-widest text-brand-700 font-semibold bg-brand-100 rounded-full px-3 py-1.5">Shop by condition</span>
        <h1 class="mt-4 font-serif text-4xl md:text-5xl font-semibold text-ink-900">Medical Categories</h1>
        <p class="mt-3 text-ink-700 max-w-2xl mx-auto">Browse our complete range of medications organized by condition. Find the right treatment for your needs, from cognitive enhancement to weight management.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 space-y-16">
    <?php
    // Get top-level product categories
    $parent_categories = get_terms( array(
        'taxonomy'   => 'product_cat',
        'parent'     => 0,
        'hide_empty' => false,
    ) );

    if ( ! empty( $parent_categories ) && ! is_wp_error( $parent_categories ) ) :
        foreach ( $parent_categories as $parent_cat ) :
            
            // Exclude Uncategorized
            if ( $parent_cat->slug === 'uncategorized' ) {
                continue;
            }

            // Get child categories for this parent
            $child_categories = get_terms( array(
                'taxonomy'   => 'product_cat',
                'parent'     => $parent_cat->term_id,
                'hide_empty' => false, 
            ) );
            
            $product_count = $parent_cat->count;
            ?>
            
            <section class="scroll-mt-24" id="<?php echo esc_attr( $parent_cat->slug ); ?>">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <h2 class="font-serif text-2xl md:text-3xl font-semibold text-ink-900"><?php echo esc_html( $parent_cat->name ); ?></h2>
                            <span class="text-xs font-semibold text-brand-700 bg-brand-100 rounded-full px-2.5 py-1"><?php echo esc_html( $product_count ); ?> products</span>
                        </div>
                        <?php if ( ! empty( $parent_cat->description ) ) : ?>
                            <p class="mt-2 text-ink-700 max-w-3xl"><?php echo esc_html( wp_strip_all_tags( $parent_cat->description ) ); ?></p>
                        <?php endif; ?>
                    </div>
                    <a href="<?php echo esc_url( get_term_link( $parent_cat ) ); ?>" class="inline-flex shrink-0 items-center gap-1.5 h-10 px-4 rounded-full bg-white border border-ink-200 hover:border-brand-500 text-ink-900 text-sm font-semibold transition-colors">
                        Browse category 
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>

                <?php if ( ! empty( $child_categories ) && ! is_wp_error( $child_categories ) ) : ?>
                    <div class="mt-5 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                        <?php foreach ( $child_categories as $child_cat ) : 
                            $thumbnail_id = get_term_meta( $child_cat->term_id, 'thumbnail_id', true );
                            $image_url    = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'medium_large' ) : 'https://placehold.co/600x450/e0f2fe/0369a1?text=' . urlencode($child_cat->name);
                        ?>
                            <a href="<?php echo esc_url( get_term_link( $child_cat ) ); ?>" class="group bg-white border border-ink-200 rounded-2xl overflow-hidden hover-lift flex flex-col">
                                <div class="aspect-[4/3] bg-brand-50 overflow-hidden relative">
                                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $child_cat->name ); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 mix-blend-multiply" />
                                </div>
                                <div class="p-4 flex-1 flex flex-col justify-center">
                                    <h3 class="font-serif text-base font-semibold text-ink-900 line-clamp-1"><?php echo esc_html( $child_cat->name ); ?></h3>
                                    <div class="mt-1 text-xs text-ink-500 group-hover:text-brand-600 transition-colors">Explore &rarr;</div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <?php
                    $cat_products = wc_get_products(array(
                        'category' => array( $parent_cat->slug ),
                        'limit' => 4,
                    ));
                    if ( ! empty( $cat_products ) ) :
                    ?>
                    <div class="mt-5 grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        <?php
                        foreach ( $cat_products as $product ) {
                            $post_object = get_post( $product->get_id() );
                            setup_postdata( $GLOBALS['post'] =& $post_object );
                            wc_get_template_part( 'content', 'product' );
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </section>

        <?php endforeach;
    else :
        echo '<p class="text-center text-ink-500">No categories found.</p>';
    endif;
    ?>
</div>

<!-- CTA Section at the bottom -->
<section class="py-14 md:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white border border-ink-200 rounded-2xl p-8 md:p-10 relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-brand-100 blur-3xl" aria-hidden="true"></div>
                <div class="relative">
                    <span class="text-xs uppercase tracking-widest font-semibold text-brand-700">Get started</span>
                    <h2 class="mt-2 font-serif text-3xl md:text-4xl font-semibold text-ink-900">Ready to order with confidence?</h2>
                    <p class="mt-3 text-ink-700 max-w-xl">Pick your pack size, complete a secure checkout in minutes, and track your discreet parcel anywhere in Australia.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a class="inline-flex items-center gap-2 h-11 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors" href="/shop">
                            Order now <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                        <a class="inline-flex items-center gap-2 h-11 px-6 rounded-full border border-ink-200 hover:border-brand-600 text-ink-900 font-semibold transition-colors" href="/faq">
                            How ordering works
                        </a>
                    </div>
                    <div class="mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-ink-500 font-medium">
                        <span class="inline-flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check text-brand-600"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> Verified pharmacy</span>
                        <span class="inline-flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock text-brand-600"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Secure checkout</span>
                        <span class="inline-flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck text-brand-600"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg> AU-wide delivery</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-ink-900 text-white rounded-2xl p-8 md:p-10 relative overflow-hidden">
                <div class="absolute -bottom-10 -left-10 w-48 h-48 rounded-full bg-brand-600 opacity-30 blur-3xl" aria-hidden="true"></div>
                <div class="relative">
                    <span class="text-xs uppercase tracking-widest text-brand-300 font-semibold">Speak with our team</span>
                    <h3 class="mt-2 font-serif text-2xl font-semibold">Australian support</h3>
                    <p class="mt-2 text-ink-100 opacity-80 text-sm leading-relaxed">Product questions and delivery help &mdash; Mon&ndash;Fri, 9am&ndash;5pm AEST.</p>
                    <a href="mailto:support@armodafinildirect.example" class="mt-5 inline-flex items-center gap-2 h-10 px-5 rounded-full bg-white text-ink-900 text-sm font-semibold hover:bg-brand-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-headphones"><path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/></svg> 
                        Contact support
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
