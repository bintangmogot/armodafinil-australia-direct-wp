<?php
$files = [
    'modules/content-review_page.php',
    'modules/content-reviews_carousel.php',
    'modules/content-reviews_carousel_grid.php'
];

foreach ($files as $file) {
    $content = file_get_contents($file);

    // Remove the if statement wrapping the verified badge
    $content = preg_replace(
        '/<\?php if \(stripos\(\$meta, \'verified\'\) !== false \|\| stripos\(\$meta, \'buyer\'\) !== false\): \?>\s*(<div class="flex items-center gap-1 px-2 py-1 bg-emerald-50 text-emerald-700 text-\[10px\] font-bold rounded uppercase tracking-wide shrink-0">.*?<\/div>)\s*<\?php endif; \?>/s',
        '$1',
        $content
    );

    file_put_contents($file, $content);
}

echo "Verified badge made permanent in all files.\n";
