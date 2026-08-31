<?php
$title = get_sub_field('title');
$features = get_sub_field('features');

$icons = array(
    'truck' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>',
    'percent' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><line x1="19" x2="5" y1="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/></svg>',
    'info' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>',
);
$default_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>';
?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 pb-4">
    <?php if ($title) : ?>
        <h2 class="font-serif text-2xl md:text-3xl font-semibold text-ink-900"><?php echo esc_html($title); ?></h2>
    <?php endif; ?>
    
    <?php if (!empty($features)) : ?>
        <div class="mt-6 grid md:grid-cols-3 gap-5">
            <?php foreach ($features as $f) : 
                $icon_svg = isset($icons[$f['icon']]) ? $icons[$f['icon']] : $default_icon;
            ?>
                <div class="bg-white border border-ink-200 rounded-2xl p-6 hover-lift">
                    <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-700 grid place-items-center">
                        <?php echo $icon_svg; ?>
                    </div>
                    <h3 class="mt-4 font-serif text-lg font-semibold text-ink-900"><?php echo esc_html($f['title']); ?></h3>
                    <p class="mt-2 text-sm text-ink-700"><?php echo wp_kses_post($f['desc']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
