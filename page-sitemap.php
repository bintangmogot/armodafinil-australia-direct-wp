<?php
/**
 * Template Name: HTML Sitemap
 */

get_header();
?>

<div class="bg-ink-50 py-16 md:py-24 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="font-serif text-4xl md:text-5xl font-semibold text-ink-900 mb-10 text-center">Site Map</h1>
        
        <div class="bg-white border border-ink-200 rounded-2xl p-8 md:p-12 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                
                <!-- Pages -->
                <div>
                    <h2 class="text-xl font-semibold text-ink-900 mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-600"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Main Pages
                    </h2>
                    <ul class="space-y-3 text-ink-700">
                        <?php
                        wp_list_pages(array(
                            'exclude' => '',
                            'title_li' => '',
                            'depth' => 1,
                        ));
                        ?>
                    </ul>
                </div>

                <!-- Shop Categories -->
                <div>
                    <h2 class="text-xl font-semibold text-ink-900 mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-600"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                        Shop Categories
                    </h2>
                    <ul class="space-y-3 text-ink-700">
                        <?php
                        wp_list_categories(array(
                            'taxonomy' => 'product_cat',
                            'title_li' => '',
                            'hide_empty' => false,
                            'depth' => 1,
                        ));
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
