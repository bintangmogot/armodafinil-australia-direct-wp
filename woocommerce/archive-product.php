<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<div class="section-wash">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="text-center">
            <span class="text-xs uppercase tracking-widest text-brand-700 font-semibold bg-brand-100 rounded-full px-3 py-1.5">Full catalogue</span>
            <h1 class="mt-4 font-serif text-4xl md:text-5xl font-semibold text-ink-900"><?php woocommerce_page_title(); ?></h1>
            <p class="mt-3 text-ink-700 max-w-2xl mx-auto">Compare prescription and OTC medicines by category, check ratings and prices in AUD, and add to cart in a few taps — shipped discreetly across Australia.</p>
        </div>

        <div class="mt-10 flex flex-col md:flex-row md:items-center gap-4 justify-between">
            <div class="hidden md:flex flex-wrap gap-2">
                <!-- Categories filter -->
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="text-sm font-medium px-4 h-9 rounded-full border transition-colors <?php echo !is_product_category() ? 'bg-brand-600 text-white border-brand-600' : 'bg-white text-ink-700 border-ink-200 hover:border-brand-600'; ?>">All categories</a>
                <?php
                $product_categories = get_terms( 'product_cat', array('hide_empty' => true) );
                if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
                    foreach ( $product_categories as $cat ) {
                        $is_current = is_product_category($cat->term_id);
                        $class = $is_current ? 'bg-brand-600 text-white border-brand-600' : 'bg-white text-ink-700 border-ink-200 hover:border-brand-600';
                        echo '<a href="' . esc_url( get_term_link( $cat ) ) . '" class="text-sm font-medium px-4 h-9 flex items-center rounded-full border transition-colors ' . $class . '">' . esc_html( $cat->name ) . '</a>';
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

            <div class="mt-12 flex justify-center custom-pagination">
                <?php
                echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
                    'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
                    'format'       => '',
                    'add_args'     => false,
                    'current'      => max( 1, get_query_var( 'paged' ) ),
                    'total'        => $wp_query->max_num_pages,
                    'prev_text'    => '&larr;',
                    'next_text'    => '&rarr;',
                    'type'         => 'list',
                    'end_size'     => 3,
                    'mid_size'     => 3,
                ) ) );
                ?>
            </div>

        <?php else : ?>
            <p class="text-center text-ink-500 mt-16">No products found.</p>
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

<?php get_footer( 'shop' ); ?>
