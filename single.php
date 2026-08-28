<?php
/**
 * Single Blog Template
 */

get_header(); ?>

<main id="primary" class="site-main">
    <?php while ( have_posts() ) : the_post(); 
        $title = get_the_title();
        $excerpt = get_the_excerpt();
        $content = apply_filters('the_content', get_the_content());
        $image = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: 'https://placehold.co/1200x800/e0f2fe/0369a1?text=Blog';
        $categories = get_the_category();
        $cat_name = !empty($categories) ? $categories[0]->name : 'Article';
    ?>
    <article>
        <!-- Breadcrumb -->
        <div class="border-b border-ink-200 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-12 flex items-center text-xs text-ink-500 gap-2">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-brand-700">Home</a>
                <span>/</span>
                <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="hover:text-brand-700">Blog</a>
                <span>/</span>
                <span class="text-ink-900 truncate"><?php echo esc_html($title); ?></span>
            </div>
        </div>

        <div class="section-wash">
            <div class="max-w-4xl mx-auto px-4 py-12 md:py-16 text-center">
                <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold bg-brand-100 rounded-full px-3 py-1.5 inline-block"><?php echo esc_html($cat_name); ?></div>
                <h1 class="mt-4 font-serif text-4xl md:text-5xl font-semibold text-ink-900 leading-tight"><?php echo esc_html($title); ?></h1>
                <?php if ($excerpt) : ?>
                    <p class="mt-4 text-lg text-ink-700 leading-relaxed max-w-2xl mx-auto"><?php echo esc_html($excerpt); ?></p>
                <?php endif; ?>
                <div class="mt-6 flex items-center justify-center gap-4 text-xs text-ink-500">
                    <span class="inline-flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days w-3.5 h-3.5"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg> 
                        <?php echo get_the_date('M j, Y'); ?>
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-2 w-3.5 h-3.5"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 1 0-16 0"/></svg> 
                        <?php echo get_the_author_meta('display_name'); ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 py-10">
            <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-brand-50 border border-ink-200">
                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover" />
            </div>

            <div class="mt-10 space-y-8 text-ink-700 leading-relaxed prose prose-ink prose-a:text-brand-700 prose-headings:font-serif prose-headings:text-ink-900 max-w-none">
                <?php echo $content; ?>
            </div>
        </div>

        <?php get_template_part('template-parts/order-cta'); ?>
    </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
