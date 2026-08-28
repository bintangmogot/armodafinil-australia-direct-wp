<?php
/**
 * Single Condition Template
 */

get_header(); ?>

<main id="primary" class="site-main">
    <?php while ( have_posts() ) : the_post(); 
        $title = get_the_title();
        $excerpt = get_the_excerpt();
        $content = apply_filters('the_content', get_the_content());
        $image = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: 'https://placehold.co/1200x800/e0f2fe/0369a1?text=Guide';
    ?>
    <article>
        <!-- Breadcrumb -->
        <div class="border-b border-ink-200 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-12 flex items-center text-xs text-ink-500 gap-2">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-brand-700">Home</a>
                <span>/</span>
                <a href="<?php echo esc_url(home_url('/conditions/')); ?>" class="hover:text-brand-700">Conditions</a>
                <span>/</span>
                <span class="text-ink-900 truncate"><?php echo esc_html($title); ?></span>
            </div>
        </div>

        <div class="section-wash">
            <div class="max-w-4xl mx-auto px-4 py-12 md:py-16">
                <a href="<?php echo esc_url(home_url('/conditions/')); ?>" class="inline-flex items-center gap-1.5 text-sm text-ink-700 hover:text-brand-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left w-4 h-4"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg> 
                    All guides
                </a>
                <div class="mt-6 text-[11px] uppercase tracking-widest text-brand-700 font-semibold">Guide</div>
                <h1 class="mt-2 font-serif text-4xl md:text-5xl font-semibold text-ink-900 leading-tight"><?php echo esc_html($title); ?></h1>
                <?php if ($excerpt) : ?>
                    <p class="mt-4 text-lg text-ink-700 leading-relaxed"><?php echo esc_html($excerpt); ?></p>
                <?php endif; ?>
                <div class="mt-5 flex items-center gap-3 flex-wrap text-xs text-ink-500">
                    <span class="inline-flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-3.5 h-3.5 text-brand-600"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> 
                        Medically reviewed
                    </span>
                    <span>&middot;</span>
                    <span>Reading time &middot; 4 min</span>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 py-10">
            <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-brand-50 border border-ink-200">
                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover" />
            </div>

            <div class="mt-10 space-y-8 text-ink-700 leading-relaxed prose prose-ink prose-a:text-brand-700 prose-headings:font-serif prose-headings:text-ink-900 max-w-none">
                <?php echo $content; ?>

                <div class="mt-10 p-6 rounded-2xl bg-brand-50 border border-brand-100 not-prose">
                    <div class="text-xs uppercase tracking-widest text-brand-700 font-semibold">Editor’s note</div>
                    <p class="mt-2 text-ink-700">This guide is informational and does not replace personalised medical advice. If any symptoms persist or worsen, please book an appointment with your GP or a qualified specialist.</p>
                </div>
            </div>
        </div>

        <!-- Related guides -->
        <?php
        $related = new WP_Query(array(
            'post_type' => 'condition',
            'posts_per_page' => 3,
            'post__not_in' => array(get_the_ID())
        ));
        if ( $related->have_posts() ) :
        ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 border-t border-ink-200">
            <div class="flex items-end justify-between gap-4 flex-wrap">
                <h2 class="font-serif text-2xl md:text-3xl font-semibold text-ink-900">Related guides</h2>
                <a href="<?php echo esc_url(home_url('/conditions/')); ?>" class="inline-flex items-center gap-1.5 text-brand-700 font-semibold hover:gap-2 transition-all">
                    All guides <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
            <div class="mt-6 grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <?php while ( $related->have_posts() ) : $related->the_post(); 
                    $r_img = get_the_post_thumbnail_url(get_the_ID(), 'medium_large') ?: 'https://placehold.co/600x400/e0f2fe/0369a1?text=Guide';
                ?>
                <a href="<?php the_permalink(); ?>" class="group bg-white border border-ink-200 rounded-2xl overflow-hidden hover-lift block">
                    <div class="aspect-[16/9] bg-brand-50"><img src="<?php echo esc_url($r_img); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]" /></div>
                    <div class="p-5">
                        <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold">Guide</div>
                        <h3 class="mt-1 font-serif text-lg font-semibold text-ink-900"><?php the_title(); ?></h3>
                        <p class="mt-2 text-sm text-ink-700 leading-relaxed line-clamp-2"><?php echo get_the_excerpt(); ?></p>
                        <span class="mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">Read guide <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
                    </div>
                </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
        <?php endif; ?>

        <?php get_template_part('template-parts/order-cta'); ?>
    </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
