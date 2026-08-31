<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $notices ) {
	return;
}
?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 woocommerce-notices-custom-wrapper">
    <div class="p-4 mb-4 rounded-xl bg-red-50 text-red-900 border border-red-200 shadow-sm" role="alert">
        <ul class="space-y-2 !m-0 !p-0 list-none">
            <?php foreach ( $notices as $notice ) : ?>
                <li class="flex items-start gap-3 !m-0" <?php echo wc_get_notice_data_attr( $notice ); ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600 shrink-0 mt-0.5 !fill-none"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    <div class="flex-1 text-sm font-medium leading-relaxed">
                        <?php echo wc_kses_notice( $notice['notice'] ); ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
