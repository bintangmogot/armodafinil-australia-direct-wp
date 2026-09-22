<?php
/**
 * The header for our theme
 *
 * @package Armodafinil_Australia_Direct
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

	<?php if ( function_exists('is_checkout') && is_checkout() && empty( is_wc_endpoint_url('order-received') ) ) : ?>
    <header class="sticky top-0 z-40 bg-white border-b border-ink-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="flex items-center gap-1.5 text-sm font-medium text-ink-500 hover:text-ink-900 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill:none !important;" d="m15 18-6-6 6-6"/></svg> Cart
            </a>
            
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2 shrink-0 min-w-0">
                <span class="w-8 h-8 shrink-0 rounded-lg bg-brand-600 grid place-items-center text-white shadow-soft">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill:none !important;" d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                </span>
                <span class="leading-tight min-w-0 max-w-[120px] sm:max-w-none">
                    <span class="block font-serif text-[15px] sm:text-base font-bold text-brand-700 leading-none truncate">Armodafinil Direct</span>
                </span>
            </a>

            <div class="flex items-center gap-1.5 text-brand-700 text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill:none !important;" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path style="fill:none !important;" d="m9 12 2 2 4-4"/></svg> Secure
            </div>
        </div>
    </header>
<?php else: ?>
	<!-- TopBar -->
	    <div class="w-full bg-ink-900 text-white text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-9 flex items-center justify-between gap-4">
            <?php if ( $topbar_left = get_field('topbar_left', 'option') ) : ?>
            <p class="hidden sm:block opacity-90"><?php echo esc_html($topbar_left); ?></p>
            <?php endif; ?>
            <?php if ( $topbar_center = get_field('topbar_center', 'option') ) : ?>
            <p class="opacity-90 hidden md:block"><?php echo esc_html($topbar_center); ?></p>
            <?php endif; ?>
            <?php 
            $support_phone = get_field('whatsapp_number', 'option') ?: '0488 841 833';
            $clean_phone = preg_replace('/[^0-9+]/', '', $support_phone);
            ?>
            <a href="tel:<?php echo esc_attr($clean_phone); ?>" class="inline-flex items-center gap-1.5 text-brand-300 hover:text-brand-200">
                Call📞 : <?php echo esc_html($support_phone); ?>
            </a>
        </div>
    </div>

	<!-- Navbar -->
	<header class="sticky top-0 z-40 bg-white/85 backdrop-blur border-b border-ink-200">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center gap-2 sm:gap-4">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2 shrink-0 min-w-0">
				<span class="w-9 h-9 shrink-0 rounded-xl bg-brand-600 grid place-items-center text-white shadow-soft">
					<!-- Sparkles Icon -->
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
				</span>
				<span class="leading-tight min-w-0 max-w-[120px] sm:max-w-none">
					<span class="block font-serif text-base sm:text-lg font-semibold text-ink-900 leading-none truncate">Armodafinil Direct</span>
				</span>
			</a>

			<nav class="hidden lg:flex items-center gap-1 ml-4">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'items_wrap'     => '%3$s', // Strip ul wrapper for tailwind flexibility, though WP uses LI. Better to style LI.
					'fallback_cb'    => false,
					// Custom walker can be added here for perfect Tailwind classes on <li> and <a>
				) );
				?>
                </nav>

			<div class="flex-1"></div>

						<!-- Search Trigger Button -->
			<button id="header-search-trigger" aria-label="Open Search" class="hidden md:flex items-center bg-ink-50 hover:bg-ink-100 transition-colors rounded-full px-4 h-[42px] w-80 border border-ink-200 shadow-sm cursor-text text-left group">
				<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-ink-400 group-hover:text-brand-600 transition-colors shrink-0"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
				<span class="flex-1 mx-3 text-[13px] text-ink-500 font-medium truncate">Search products, strengths, brands...</span>
				<span class="text-[10px] font-semibold text-ink-500 bg-white border border-ink-200 rounded px-1.5 py-0.5 shadow-sm shrink-0">Ctrl K</span>
			</button>

			<!-- Cart -->
			<a href="<?php echo wc_get_cart_url(); ?>" class="xoo-wsc-cart-trigger relative w-10 h-10 grid place-items-center rounded-full hover:bg-ink-100" aria-label="Cart">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart text-ink-700"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                <?php if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
				    <span class="absolute -top-0.5 -right-0.5 w-4 h-4 grid place-items-center text-[10px] font-semibold text-white bg-brand-600 rounded-full"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                <?php endif; ?>
			</a>

			<!-- Shop Button -->
			<a href="/shop" class="hidden md:inline-flex items-center h-10 px-4 rounded-full bg-brand-600 text-white text-sm font-semibold hover:bg-brand-700 transition-colors">
				Shop
			</a>

			<!-- Mobile Menu Button -->
			<button class="lg:hidden w-10 h-10 grid place-items-center rounded-full hover:bg-ink-100" id="mobile-menu-btn" aria-label="Menu">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
			</button>
		</div>
		</header>
    <?php endif; ?>


