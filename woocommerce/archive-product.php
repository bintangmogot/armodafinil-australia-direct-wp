<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
global $wp_query;

$shop_page_id = wc_get_page_id('shop');
$current_term = is_product_category() || is_product_tag() ? get_queried_object() : null;

$has_shop_modules = is_shop() && ! is_search() && have_rows('page_modules', $shop_page_id);
$has_cat_modules = $current_term && have_rows('page_modules', $current_term);

if ( $has_shop_modules || $has_cat_modules ) :
    $acf_id = $has_cat_modules ? $current_term : $shop_page_id;
    while( have_rows('page_modules', $acf_id) ) : the_row();
        $layout = get_row_layout();
        get_template_part('modules/content', $layout);
    endwhile;
else :
    // Fallback to standard WooCommerce layout if no modules defined
?>

<div class="bg-gradient-to-b from-brand-50/60 to-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-10 md:pt-12 md:pb-16">
        
        <?php
        // Fetch custom ACF fields
        $top_image = '';
        $bottom_content = '';
        if ( is_product_category() || is_product_tag() ) {
            $top_image = get_field('top_image', $current_term);
            $bottom_content = get_field('bottom_content', $current_term);
            $thumbnail_id = get_term_meta( $current_term->term_id, 'thumbnail_id', true );
            $image_url = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'medium_large' ) : '';
        } elseif ( is_shop() && ! is_search() ) {
            $bottom_content = get_field('bottom_content', $shop_page_id);
        }
        ?>

        <?php if ( is_product_category() || is_product_tag() ) : ?>
            
            <!-- Category Header -->
            <div class="mb-6 md:mb-10">
                <a href="<?php echo esc_url( home_url( '/categories' ) ); ?>" class="inline-flex items-center gap-2 text-sm font-medium text-ink-500 hover:text-brand-600 transition-colors mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                    All categories
                </a>
                
                <style>
                    .cat-header-icon { width: 80px; height: 80px; flex-shrink: 0; }
                    @media (min-width: 768px) { .cat-header-icon { width: 128px; height: 128px; } }
                </style>
                <div class="flex flex-col md:flex-row gap-6 md:gap-8 items-start">
                    <?php if ( ! empty($image_url) ) : ?>
                        <div class="cat-header-icon rounded-2xl md:rounded-3xl overflow-hidden border border-brand-100 shadow-sm bg-white p-2 md:p-4">
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $current_term->name ); ?>" class="w-full h-full object-contain" />
                        </div>
                    <?php endif; ?>
                    
                    <div>
                        <span class="text-xs uppercase tracking-widest text-brand-700 font-bold">Category</span>
                        <h1 class="mt-1 font-serif text-3xl md:text-5xl font-semibold text-ink-900"><?php echo esc_html( $current_term->name ); ?></h1>
                        <?php 
                        $term_desc = term_description();
                        if ( ! empty( $term_desc ) ) : ?>
                            <div class="mt-3 text-ink-700 max-w-2xl text-sm md:text-base prose prose-sm prose-ink leading-relaxed"><?php echo wp_kses_post( $term_desc ); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ( $top_image ) : ?>
                    <div class="mt-8 md:mt-10 max-w-5xl rounded-2xl md:rounded-3xl overflow-hidden shadow-sm border border-brand-100 bg-white">
                        <img src="<?php echo esc_url( is_array($top_image) ? $top_image['url'] : $top_image ); ?>" alt="Banner Image" class="w-full h-auto object-cover" />
                    </div>
                <?php endif; ?>

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

    </div>
</div>

<?php 
// Load the archive products module manually for the standard layout
get_template_part('modules/content', 'archive_products'); 
?>

<?php if ( ! empty( $bottom_content ) ) : ?>
    <section class="bg-white pb-16 md:pb-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prose prose-ink prose-brand prose-a:text-brand-600 hover:prose-a:text-brand-700 mx-auto">
                <?php echo wp_kses_post( $bottom_content ); ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php endif; // End modules fallback check ?>

<style>
/* Clean up WC sorting dropdown */
.custom-sort-wrapper select {
    height: 2.5rem;
    border-radius: 9999px;
    border-color: #e2e8f0;
    padding-left: 1rem;
    padding-right: 2.5rem;
    font-size: 0.875rem;
    color: #334155;
    background-color: #fff;
    cursor: pointer;
    box-shadow: none;
    outline: none;
}
.custom-sort-wrapper select:focus {
    border-color: #0d9488;
    box-shadow: 0 0 0 1px #0d9488;
}
</style>

<?php
get_footer( 'shop' );

