<?php
/**
 * The template for displaying all single pages
 */

get_header(); ?>

<main id="primary" class="site-main">

    <?php 
    $page_id = get_the_ID();
    
    // If this is the blog posts index, use the ID of the page assigned in Settings -> Reading
    if ( is_home() && get_option('page_for_posts') ) {
        $page_id = get_option('page_for_posts');
    }

    if( have_rows('page_modules', $page_id) ):
        while( have_rows('page_modules', $page_id) ) : the_row();
            $layout = get_row_layout();
            get_template_part('modules/content', $layout);
        endwhile;
    else: ?>
        <div class="max-w-7xl mx-auto px-4 py-20">
            <?php 
            while ( have_posts() ) : the_post();
                the_content();
            endwhile; 
            ?>
        </div>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
