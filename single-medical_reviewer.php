<?php
/**
 * Single Medical Reviewer Template
 */
get_header(); 
?>

<main id="primary" class="site-main bg-white">
    <?php while ( have_posts() ) : the_post(); 
        $image = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: 'https://placehold.co/800x1000/e0f2fe/0369a1?text=Doctor';
    ?>
    <article>
        
        <!-- Beautiful wash header -->
        <div class="section-wash pt-16 pb-32">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold bg-brand-100 rounded-full px-3 py-1.5 inline-block mb-4">Medical Team</div>
                <h1 class="font-serif text-4xl md:text-6xl font-semibold text-ink-900 leading-tight">
                    <?php the_title(); ?>
                </h1>
                <p class="mt-4 text-lg text-ink-600 font-medium">Chief Medical Reviewer</p>
            </div>
        </div>

        <!-- Overlapping Profile Section -->
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 pb-24">
            <div class="bg-white rounded-3xl shadow-xl border border-ink-200 overflow-hidden flex flex-col md:flex-row">
                
                <!-- Image Side -->
                <div class="w-full md:w-2/5 bg-brand-50 relative">
                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-cover min-h-[400px] md:absolute md:inset-0" />
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-900/30 to-transparent"></div>
                </div>

                <!-- Content Side -->
                <div class="w-full md:w-3/5 p-8 md:p-12 lg:p-16 flex flex-col justify-center">
                    
                    <div class="flex items-center gap-2 mb-6 text-brand-700 font-semibold text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        Verified Medical Professional
                    </div>

                    <div class="prose prose-ink prose-lg max-w-none text-ink-700 leading-relaxed">
                        <?php the_content(); ?>
                    </div>

                    <div class="mt-10 pt-8 border-t border-ink-100">
                        <div class="text-xs font-bold uppercase tracking-widest text-ink-400 mb-2">Disclaimer</div>
                        <p class="text-sm text-ink-500 italic leading-relaxed">
                            <?php echo esc_html(get_the_title()); ?> serves strictly as an independent medical reviewer for educational purposes, ensuring clinical accuracy across Armodafinil Direct. This content does not constitute professional medical advice.
                        </p>
                    </div>
                    
                </div>
            </div>
        </div>

    </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
