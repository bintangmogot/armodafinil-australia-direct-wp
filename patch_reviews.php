<?php
$files = [
    'modules/content-review_page.php',
    'modules/content-reviews_carousel.php',
    'modules/content-reviews_carousel_grid.php'
];

foreach ($files as $file) {
    $content = file_get_contents($file);

    // 1. Fix the top badge stars (if they exist)
    $content = str_replace(
        'class="w-6 h-6 flex items-center justify-center rounded-[3px] bg-[#00B67A] text-white"',
        'class="w-6 h-6 flex items-center justify-center rounded-[3px] text-white" style="background-color: #00B67A;"',
        $content
    );

    // 2. Fix the card stars
    $content = preg_replace(
        '/class="w-7 h-7 flex items-center justify-center rounded-\[3px\] <\?php echo \(\$stars < \$rating_val\) \? \'bg-\[#00B67A\]\' : \'bg-\[#E5E7EB\]\'; \?> text-white"/',
        'class="w-7 h-7 flex items-center justify-center rounded-[3px] text-white" style="background-color: <?php echo ($stars < $rating_val) ? \'#00B67A\' : \'#E5E7EB\'; ?>;"',
        $content
    );

    // 3. Remove the profile picture block entirely, up to the <div> wrapping the name
    $content = preg_replace(
        '/<div class="w-10 h-10 rounded-full bg-\[#00B67A\] text-white flex items-center justify-center font-bold text-\[15px\] uppercase shrink-0">\s*<\?php echo esc_html\(substr\(\$reviewer, 0, 1\)\); \?>\s*<\/div>\s*<div>/s',
        '<div>',
        $content
    );

    // 4. Update the reviewer name, job/location, and date output block
    // We want to insert the job/location if it does not contain 'verified' or 'buyer'
    $new_reviewer_block = <<<HTML
<div>
                                    <div class="font-bold text-ink-900 text-[15px] leading-tight">
                                        <?php echo esc_html(\$reviewer); ?>
                                    </div>
                                    <?php if (\$meta && stripos(\$meta, 'verified') === false && stripos(\$meta, 'buyer') === false): ?>
                                    <div class="text-xs text-ink-600 mt-0.5">
                                        <?php echo esc_html(\$meta); ?>
                                    </div>
                                    <?php endif; ?>
                                    <div class="text-xs text-ink-400 mt-1">
                                        <?php echo get_the_date('j F Y', \$post_id); ?>
                                    </div>
                                </div>
HTML;

    // First replace the old div block containing the reviewer text
    $content = preg_replace(
        '/<div>\s*<div class="font-bold text-ink-900 text-\[15px\] leading-tight[^>]*">\s*<\?php echo esc_html\(\$reviewer\); \?>\s*<\/div>\s*<div class="text-xs text-ink-400 mt-1">\s*<\?php echo get_the_date\(\'j F Y\', \$post_id\); \?>\s*<\/div>\s*<\/div>/s',
        $new_reviewer_block,
        $content
    );

    // Remove the `<div class="flex items-center gap-3">` wrapper since it no longer wraps the avatar + text
    // Wait, the wrapper is `<div class="flex items-center gap-3">` and it contains the `<div>` we just replaced.
    // If we leave it, it's just a flex container with 1 child. That's harmless, but let's see.
    // In content-review_page.php it's `<div class="mt-8 pt-5 border-t border-ink-100 flex flex-wrap items-center justify-between gap-3">`
    // followed by `<div class="flex items-center gap-3">` (which we can safely leave).
    
    file_put_contents($file, $content);
}

echo "Files updated successfully.\n";
