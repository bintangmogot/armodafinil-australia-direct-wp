<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
global $wp_query;

$shop_page_id = wc_get_page_id('shop');

if ( is_shop() && ! is_search() && have_rows('page_modules', $shop_page_id) ) :
    while( have_rows('page_modules', $shop_page_id) ) : the_row();
        $layout = get_row_layout();
        get_template_part('modules/content', $layout);
    endwhile;
else :
?>

<div class="section-wash">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        
        <?php
        // Fetch custom ACF fields
        $top_image = '';
        $bottom_content = '';
        if ( is_product_category() || is_product_tag() ) {
            $current_term = get_queried_object();
            $top_image = get_field('top_image', $current_term);
            $bottom_content = get_field('bottom_content', $current_term);
            $thumbnail_id = get_term_meta( $current_term->term_id, 'thumbnail_id', true );
            $image_url = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'medium_large' ) : '';
            if ( ! $image_url && $top_image ) {
                $image_url = is_array($top_image) ? $top_image['url'] : $top_image;
            }
        } elseif ( is_shop() && ! is_search() ) {
            $shop_page_id = wc_get_page_id('shop');
            $bottom_content = get_field('bottom_content', $shop_page_id);
        }
        ?>

        <?php if ( is_product_category() || is_product_tag() ) : ?>
            
            <!-- Category Header -->
            <div class="mb-10">
                <a href="<?php echo esc_url( home_url( '/categories' ) ); ?>" class="inline-flex items-center gap-2 text-sm font-medium text-ink-500 hover:text-brand-600 transition-colors mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                    All categories
                </a>
                
                <div class="flex flex-col md:flex-row gap-6 md:gap-8 items-start">
                    <?php if ( ! empty($image_url) ) : ?>
                        <div class="w-24 h-24 md:w-32 md:h-32 rounded-3xl overflow-hidden shrink-0 border border-brand-100 shadow-sm bg-white p-3">
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $current_term->name ); ?>" class="w-full h-full object-contain" />
                        </div>
                    <?php endif; ?>
                    
                    <div>
                        <span class="text-xs uppercase tracking-widest text-brand-700 font-bold">Category</span>
                        <h1 class="mt-1 font-serif text-4xl md:text-5xl font-semibold text-ink-900"><?php echo esc_html( $current_term->name ); ?></h1>
                        <?php 
                        $term_desc = term_description();
                        if ( ! empty( $term_desc ) ) : ?>
                            <div class="mt-3 text-ink-700 max-w-2xl text-sm md:text-base prose prose-sm prose-ink leading-relaxed"><?php echo wp_kses_post( $term_desc ); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php 
                // Fetch subcategories
                $subcats = get_terms( array(
                    'taxonomy'   => 'product_cat',
                    'parent'     => $current_term->term_id,
                    'hide_empty' => false,
                ) );
                
                $show_subcats = $subcats;
                $label = 'Subcategories';
                
                // If no subcats, try siblings if we are a subcat
                if ( empty( $show_subcats ) && $current_term->parent != 0 ) {
                    $show_subcats = get_terms( array(
                        'taxonomy'   => 'product_cat',
                        'parent'     => $current_term->parent,
                        'hide_empty' => false,
                    ) );
                    $label = 'Related Categories';
                }

                if ( ! empty( $show_subcats ) && ! is_wp_error( $show_subcats ) ) : ?>
                    <div class="mt-10">
                        <span class="text-xs uppercase tracking-widest text-ink-500 font-bold"><?php echo esc_html($label); ?></span>
                        <div class="mt-4 flex flex-wrap gap-2.5">
                            <?php foreach ( $show_subcats as $sc ) : 
                                $is_active = ( $sc->term_id === $current_term->term_id );
                                $bg_class = $is_active ? 'bg-brand-50 border-brand-200 text-brand-700' : 'bg-white border-ink-200 text-ink-700 hover:border-brand-600';
                            ?>
                                <a href="<?php echo esc_url( get_term_link( $sc ) ); ?>" class="inline-flex items-center px-4 h-10 rounded-full border text-sm font-medium transition-colors <?php echo $bg_class; ?>">
                                    <?php echo esc_html( $sc->name ); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        <?php else : ?>

            <!-- Shop / Search Header -->
            <div class="text-center mb-10">
                <span class="text-xs uppercase tracking-widest text-brand-700 font-semibold bg-brand-100 rounded-full px-3 py-1.5">Full catalogue</span>
                <h1 class="mt-4 font-serif text-4xl md:text-5xl font-semibold text-ink-900">
                    <?php 
                    if ( is_search() ) {
                        $sq = get_search_query();
                        if ( empty($sq) ) {
                            echo 'Products';
                        } else {
                            echo 'Search results: &ldquo;' . esc_html($sq) . '&rdquo;';
                        }
                    } else {
                        woocommerce_page_title(); 
                    }
                    ?>
                </h1>
                <p class="mt-3 text-ink-700 max-w-2xl mx-auto">Compare prescription and OTC medicines by category, check ratings and prices in AUD, and add to cart in a few taps &mdash; shipped discreetly across Australia.</p>
            </div>

        <?php endif; ?>

        <?php if ( $top_image && ! is_product_category() ) : ?>
            <div class="mt-8 max-w-5xl mx-auto rounded-3xl overflow-hidden shadow-sm border border-brand-100">
                <img src="<?php echo esc_url( is_array($top_image) ? $top_image['url'] : $top_image ); ?>" alt="Banner Image" class="w-full h-auto object-cover" />
            </div>
        <?php endif; ?>

        <div class="mt-12 flex flex-col xl:flex-row xl:items-center gap-4 justify-between">
            <div class="flex overflow-x-auto pb-2 xl:pb-0 xl:flex-wrap gap-2 hide-scrollbar" style="scrollbar-width: none;">
                <!-- Categories filter -->
                <a href="<?php echo esc_url( home_url( '/categories' ) ); ?>" class="shrink-0 text-sm font-medium px-4 h-9 rounded-full border transition-colors flex items-center <?php echo !is_product_category() && !is_search() ? 'bg-brand-600 text-white border-brand-600' : 'bg-white text-ink-700 border-ink-200 hover:border-brand-600'; ?>">All categories</a>
                <?php
                $product_categories = get_terms( 'product_cat', array('hide_empty' => true) );
                if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
                    foreach ( $product_categories as $cat ) {
                        $is_current = is_product_category($cat->term_id);
                        $class = $is_current ? 'bg-brand-600 text-white border-brand-600' : 'bg-white text-ink-700 border-ink-200 hover:border-brand-600';
                        echo '<a href="' . esc_url( get_term_link( $cat ) ) . '" class="shrink-0 text-sm font-medium px-4 h-9 flex items-center rounded-full border transition-colors ' . $class . '">' . esc_html( $cat->name ) . '</a>';
                    }
                }
                ?>
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="flex items-center bg-white border border-ink-200 rounded-full px-3 h-10 flex-1 md:w-72">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search text-ink-500"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <form role="search" method="get" class="flex-1 flex" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="search" class="bg-transparent outline-none border-0 text-sm flex-1 mx-2" placeholder="Search products..." value="<?php echo get_search_query(); ?>" name="s" />
                        <input type="hidden" name="post_type" value="product" />
                    </form>
                </div>
                <!-- WooCommerce Native Sorting -->
                <div class="custom-sort-wrapper">
                    <?php
                    if ( woocommerce_product_loop() ) {
                        woocommerce_catalog_ordering();
                    }
                    ?>
                </div>
            </div>
        </div>

        <?php if ( woocommerce_product_loop() ) : ?>
            
            <p class="mt-6 text-xs text-ink-500">
                <?php
                $paged    = max( 1, $wp_query->get( 'paged' ) );
                $per_page = $wp_query->get( 'posts_per_page' );
                $total    = $wp_query->found_posts;
                $first    = ( $per_page * $paged ) - $per_page + 1;
                $last     = min( $total, $wp_query->get( 'posts_per_page' ) * $paged );
                echo esc_html( sprintf( _n( 'Showing %d of %d product', 'Showing %d–%d of %d products', $total, 'woocommerce' ), $first, $last, $total ) );
                ?>
            </p>

            <div class="mt-4 grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <?php
                while ( have_posts() ) {
                    the_post();
                    /**
                     * Hook: woocommerce_shop_loop.
                     */
                    do_action( 'woocommerce_shop_loop' );
                    wc_get_template_part( 'content', 'product' );
                }
                ?>
            </div>

            <div class="mt-12 flex justify-center">
                <?php
                $current_page = max(1, get_query_var('paged'));
                $total_pages = $wp_query->max_num_pages;
                if ($current_page < $total_pages) {
                    $next_url = get_pagenum_link($current_page + 1);
                    echo '<a href="' . esc_url($next_url) . '" class="inline-flex items-center justify-center h-11 px-8 rounded-full bg-brand-50 text-brand-700 font-semibold hover:bg-brand-600 hover:text-white transition-colors">Load more</a>';
                }
                ?>
            </div>
        <?php else : ?>
            <p class="text-center text-ink-500 py-12">No products found matching your criteria.</p>
        <?php endif; ?>

        <?php if ( ! empty( $bottom_content ) ) : ?>
            <div class="mt-16 md:mt-24 max-w-4xl mx-auto prose prose-ink prose-brand prose-a:text-brand-600 hover:prose-a:text-brand-700">
                <?php echo wp_kses_post( $bottom_content ); ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<style>
/* Clean up WC sorting dropdown */
.custom-sort-wrapper select {
    height: 2.5rem;
    border-radius: 9999px;
    border: 1px solid #e5e7eb;
    background-color: #fff;
    padding-left: 0.75rem;
    padding-right: 2rem;
    font-size: 0.875rem;
    outline: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
}
/* Style pagination */
.custom-pagination ul {
    display: flex;
    gap: 0.5rem;
    list-style: none;
    padding: 0;
    margin: 0;
}
.custom-pagination li a, .custom-pagination li span {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 9999px;
    background: #fff;
    border: 1px solid #e5e7eb;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
}
.custom-pagination li span.current {
    background: #0284c7;
    border-color: #0284c7;
    color: #fff;
}
.custom-pagination li a:hover {
    border-color: #0284c7;
    color: #0284c7;
}
</style>

<?php 
endif; // End page_modules check
get_footer( 'shop' ); 
?>
