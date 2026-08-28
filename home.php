<?php
/**
 * The main template file for blog archives
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="section-wash">
        <div class="max-w-4xl mx-auto px-4 py-14 md:py-20 text-center">
            <span class="text-xs uppercase tracking-widest text-brand-700 font-semibold bg-brand-100 rounded-full px-3 py-1.5">Journal</span>
            <h1 class="mt-4 font-serif text-4xl md:text-5xl font-semibold text-ink-900">From the blog</h1>
            <p class="mt-3 text-ink-700 max-w-2xl mx-auto">Practical productivity notes, dosing explainers, and honest research summaries.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <?php if ( have_posts() ) : 
            
            // First post is featured
            the_post();
            $feat_id = get_the_ID();
            $feat_title = get_the_title();
            $feat_excerpt = get_the_excerpt();
            $feat_url = get_permalink();
            $feat_date = get_the_date('M j');
            $feat_author = get_the_author_meta('display_name');
            $feat_image = get_the_post_thumbnail_url($feat_id, 'large') ?: 'https://placehold.co/1200x800/e0f2fe/0369a1?text=Blog+Hero';
            $categories = get_the_category();
            $feat_cat = !empty($categories) ? $categories[0]->name : 'Article';
        ?>
            <a href="<?php echo esc_url($feat_url); ?>" class="grid lg:grid-cols-2 gap-8 items-center group mb-14">
                <div class="aspect-[16/10] rounded-2xl bg-brand-50 overflow-hidden">
                    <img src="<?php echo esc_url($feat_image); ?>" alt="<?php echo esc_attr($feat_title); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.02]" loading="lazy" />
                </div>
                <div>
                    <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold"><?php echo esc_html($feat_cat); ?></div>
                    <h2 class="mt-2 font-serif text-3xl md:text-4xl font-semibold text-ink-900 leading-tight"><?php echo esc_html($feat_title); ?></h2>
                    <p class="mt-3 text-ink-700 leading-relaxed"><?php echo esc_html($feat_excerpt); ?></p>
                    <div class="mt-4 flex items-center gap-4 text-xs text-ink-500">
                        <span class="inline-flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days w-3.5 h-3.5"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg> 
                            <?php echo esc_html($feat_date); ?>
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-2 w-3.5 h-3.5"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 1 0-16 0"/></svg> 
                            <?php echo esc_html($feat_author); ?>
                        </span>
                    </div>
                    <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">
                        Read article <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </span>
                </div>
            </a>
            
            <?php if ( have_posts() ) : ?>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <?php while ( have_posts() ) : the_post(); 
                        $p_id = get_the_ID();
                        $categories = get_the_category();
                        $p_cat = !empty($categories) ? $categories[0]->name : 'Article';
                        $p_image = get_the_post_thumbnail_url($p_id, 'medium_large') ?: 'https://placehold.co/600x400/e0f2fe/0369a1?text=Blog';
                    ?>
                        <a href="<?php the_permalink(); ?>" class="group bg-white border border-ink-200 rounded-2xl overflow-hidden hover-lift block shadow-sm">
                            <div class="aspect-[16/9] bg-brand-50 overflow-hidden">
                                <img src="<?php echo esc_url($p_image); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]" />
                            </div>
                            <div class="p-5">
                                <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold"><?php echo esc_html($p_cat); ?></div>
                                <h3 class="mt-1 font-serif text-lg font-semibold text-ink-900 line-clamp-2"><?php the_title(); ?></h3>
                                <p class="mt-2 text-sm text-ink-700 leading-relaxed line-clamp-2"><?php echo get_the_excerpt(); ?></p>
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
            <?php endif; ?>

        <?php else : ?>
            <p class="text-center text-ink-500">No articles found.</p>
        <?php endif; ?>
    </div>

    <?php get_template_part('template-parts/order-cta'); ?>
</main>

<?php get_footer(); ?>
