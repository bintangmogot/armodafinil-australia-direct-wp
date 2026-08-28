<?php
/**
 * The template for displaying Condition archives
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="section-wash">
        <div class="max-w-4xl mx-auto px-4 py-14 md:py-20 text-center">
            <span class="text-xs uppercase tracking-widest text-brand-700 font-semibold bg-brand-100 rounded-full px-3 py-1.5">Guides</span>
            <h1 class="mt-4 font-serif text-4xl md:text-5xl font-semibold text-ink-900">Explore by condition</h1>
            <p class="mt-3 text-ink-700 max-w-2xl mx-auto">In-depth, plain-language notes on daily wellness — what to expect, what actually helps, and how to spot the noise.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <?php if ( have_posts() ) : ?>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <?php while ( have_posts() ) : the_post(); 
                    $p_id = get_the_ID();
                    $p_image = get_the_post_thumbnail_url($p_id, 'medium_large') ?: 'https://placehold.co/600x400/e0f2fe/0369a1?text=Guide';
                ?>
                    <a href="<?php the_permalink(); ?>" class="group bg-white border border-ink-200 rounded-2xl overflow-hidden hover-lift block shadow-sm">
                        <div class="aspect-[16/9] bg-brand-50 overflow-hidden">
                            <img src="<?php echo esc_url($p_image); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]" />
                        </div>
                        <div class="p-5">
                            <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold">Guide</div>
                            <h3 class="mt-1 font-serif text-lg font-semibold text-ink-900 line-clamp-2"><?php the_title(); ?></h3>
                            <p class="mt-2 text-sm text-ink-700 leading-relaxed line-clamp-2"><?php echo get_the_excerpt(); ?></p>
                            <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">
                                Read guide <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </span>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
            
            <div class="mt-12 flex justify-center">
                <?php 
                the_posts_pagination( array(
                    'prev_text' => '&larr; Prev',
                    'next_text' => 'Next &rarr;',
                    'class' => 'pagination-links flex gap-2'
                ) ); 
                ?>
            </div>
        <?php else : ?>
            <p class="text-center text-ink-500">No conditions found.</p>
        <?php endif; ?>
    </div>

    <?php get_template_part('template-parts/order-cta'); ?>
</main>

<?php get_footer(); ?>
