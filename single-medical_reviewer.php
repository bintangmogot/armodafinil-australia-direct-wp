<?php
/**
 * Single Medical Reviewer Template
 */
get_header(); 
?>

<main id="primary" class="site-main bg-white">
    <?php while ( have_posts() ) : the_post(); 
        $image = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: 'https://placehold.co/400x400/e0f2fe/0369a1?text=Doctor';
    ?>
    <article class="max-w-4xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row gap-8 md:gap-12 items-start">
            
            <div class="w-full md:w-1/3 flex-shrink-0">
                <div class="aspect-[4/5] rounded-2xl overflow-hidden shadow-lg border border-ink-100">
                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-cover" />
                </div>
                <div class="mt-6 p-4 bg-brand-50 rounded-xl border border-brand-100">
                    <div class="text-xs font-bold uppercase tracking-widest text-brand-700 mb-1">Role</div>
                    <div class="text-ink-900 font-medium">Chief Medical Reviewer</div>
                    
                    <div class="mt-4 text-xs font-bold uppercase tracking-widest text-brand-700 mb-1">Contact</div>
                    <a href="mailto:support@armodafinildirect.com" class="text-brand-600 hover:underline">Via Support Team</a>
                </div>
            </div>

            <div class="w-full md:w-2/3">
                <h1 class="text-3xl md:text-5xl font-serif font-bold text-ink-900 leading-tight">
                    <?php the_title(); ?>
                </h1>
                
                <div class="mt-8 text-ink-700 leading-relaxed prose prose-ink max-w-none">
                    <?php the_content(); ?>
                </div>
            </div>

        </div>

    </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
