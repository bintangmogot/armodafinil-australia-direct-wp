<?php
/**
 * Review Carousel Grid Module Template (3 Col)
 */

$heading = get_sub_field('heading') ?: 'Reviews Grid';

// Fetch General Reviews (no linked product)
$reviews = get_posts([
    "post_type" => "review",
    "posts_per_page" => 9,
    "orderby" => "date",
    "order" => "DESC",
    "meta_query" => array(
        'relation' => 'OR',
        array(
            'key'     => 'linked_product',
            'compare' => 'NOT EXISTS'
        ),
        array(
            'key'     => 'linked_product',
            'value'   => '',
            'compare' => '='
        )
    )
]);

$review_count = count($reviews);
?>

<section class="py-16 md:py-20 bg-ink-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="font-serif text-3xl font-semibold text-ink-900 mb-4">
                <?php echo esc_html($heading); ?>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <?php
            if ($reviews):
                foreach ($reviews as $r):
                    $post_id = $r->ID;
                    $title = get_the_title($post_id);
                    $body = get_post_field('post_content', $post_id);
                    $reviewer = get_field("name", $post_id) ?: $title;
                    $meta = get_field('reviewer_meta', $post_id) ?: "Verified Buyer";
                    $rating_val = get_field("rating", $post_id) ?: 5;
                    ?>
                    <div class="bg-white border border-ink-200 rounded-2xl p-6 md:p-8 flex flex-col hover:-translate-y-1 transition-transform shadow-sm">
                        <div class="flex items-center gap-1 text-amber-500 mb-4">
                            <?php for ($stars = 0; $stars < 5; $stars++): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 <?php echo ($stars < $rating_val) ? 'text-amber-500' : 'text-ink-200'; ?>" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                </svg>
                            <?php endfor; ?>
                        </div>
                        
                        <?php if ($title && $title !== $reviewer): ?>
                            <h3 class="font-serif text-lg font-semibold text-ink-900 mb-2 truncate"><?php echo esc_html($title); ?></h3>
                        <?php endif; ?>

                        <div class="text-ink-700 leading-relaxed text-sm flex-1 mb-6">
                            <?php echo wp_kses_post(wpautop($body)); ?>
                        </div>
                        
                        <div class="mt-auto flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-brand-50 text-brand-700 flex items-center justify-center font-bold text-sm uppercase shrink-0">
                                <?php echo esc_html(substr($reviewer, 0, 1)); ?>
                            </div>
                            <div>
                                <div class="font-semibold text-ink-900 text-sm truncate max-w-[200px]">
                                    <?php echo esc_html($reviewer); ?>
                                </div>
                                <div class="flex items-center gap-1 text-[11px] font-medium text-emerald-600 mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <?php echo esc_html($meta); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach;
            else:
                ?>
                <div class="col-span-full py-12 text-center text-ink-500">
                    <p class="text-lg font-medium">No reviews found.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if ($reviews): ?>
        <div class="text-center">
            <a href="/reviews" class="inline-flex items-center gap-2 px-6 py-3 border-2 border-brand-600 text-brand-600 font-semibold rounded-lg hover:bg-brand-600 hover:text-white transition-colors">
                Read All Reviews
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
