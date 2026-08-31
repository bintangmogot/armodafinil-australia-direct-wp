<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $notices ) {
	return;
}
?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 woocommerce-notices-custom-wrapper">
    <?php foreach ( $notices as $notice ) : ?>
        <div class="p-4 mb-4 rounded-xl bg-green-50 text-green-900 border border-green-200 flex items-center gap-3 shadow-sm" <?php echo wc_get_notice_data_attr( $notice ); ?> role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600 shrink-0"><path class="!fill-none" style="fill: none !important;" d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path class="!fill-none" style="fill: none !important;" d="m9 11 3 3L22 4"/></svg>
            <div class="flex-1 text-sm font-medium leading-relaxed">
                <?php echo wc_kses_notice( $notice['notice'] ); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
