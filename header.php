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
            
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center shrink-0 min-w-0">
                <img src="<?php $custom_logo_id = get_theme_mod("custom_logo"); echo $custom_logo_id ? esc_url(wp_get_attachment_image_url($custom_logo_id, "full")) : esc_url(get_template_directory_uri() . "/assets/logo.png"); ?>" alt="Armodafinil Direct" style="height: 32px !important; width: auto !important; max-width: 200px; object-fit: contain;">
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
            <p class="opacity-90 font-medium tracking-wide truncate"><?php echo ($t = get_field("topbar_left", "option")) ? esc_html(trim(str_ireplace("dispatch", "", $t))) : ""; ?></p>

            <div class="flex items-center gap-4 shrink-0">
                <?php if ( $topbar_center = get_field('topbar_center', 'option') ) : ?>
                <p class="opacity-90 hidden md:block whitespace-nowrap text-right"><?php echo esc_html($topbar_center); ?></p>
                <?php endif; ?>
                <?php 
                $support_phone = get_field('whatsapp_number', 'option') ?: '0488 841 833';
                $clean_phone = preg_replace('/[^0-9]/', '', $support_phone);
                // Convert Australian 04... format to 614... for WhatsApp
                $wa_phone = (strpos($clean_phone, '0') === 0) ? '61' . substr($clean_phone, 1) : $clean_phone;
                ?>
                <a href="tel:+<?php echo esc_attr($wa_phone); ?>" class="inline-flex md:hidden items-center gap-1.5 text-brand-300 hover:text-brand-200 whitespace-nowrap shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-call"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/><path d="M14.05 2a9 9 0 0 1 8 7.94"/><path d="M14.05 6A5 5 0 0 1 18 10"/></svg> <?php echo esc_html($support_phone); ?>
                </a>
            </div>
        </div>
    </div>

	<!-- Navbar -->
	<header class="sticky top-0 z-40 bg-white/85 backdrop-blur border-b border-ink-200">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center gap-2 sm:gap-4">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center shrink-0 min-w-0">
                <img src="<?php $custom_logo_id = get_theme_mod("custom_logo"); echo $custom_logo_id ? esc_url(wp_get_attachment_image_url($custom_logo_id, "full")) : esc_url(get_template_directory_uri() . "/assets/logo.png"); ?>" alt="Armodafinil Direct" style="height: 44px !important; width: auto !important; max-width: 250px; object-fit: contain;">
			</a>

			<!-- Spacer to push menu and right actions to the right -->
			<div class="flex-1"></div>

			<nav class="hidden lg:flex items-center gap-1 mr-2 xl:mr-3">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'items_wrap'     => '<ul id="%1$s" class="flex items-center gap-1.5 font-medium">%3$s</ul>',
					'fallback_cb'    => false,
					'walker'         => class_exists('Armodafinil_Desktop_Nav_Walker') ? new Armodafinil_Desktop_Nav_Walker() : false,
				) );
				?>
			</nav>

			<!-- Right Actions: Cart, WhatsApp, Mobile Menu Button -->
			<div class="flex items-center gap-2 sm:gap-3 shrink-0">
				<!-- Cart -->
				<a href="<?php echo wc_get_cart_url(); ?>" class="xoo-wsc-cart-trigger relative w-10 h-10 grid place-items-center rounded-full hover:bg-ink-100" aria-label="Cart">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart text-ink-700"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
					<?php if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
						<span class="absolute -top-0.5 -right-0.5 w-4 h-4 grid place-items-center text-[10px] font-semibold text-white bg-brand-600 rounded-full"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
					<?php endif; ?>
				</a>

				<!-- WhatsApp Button -->
				<?php
				$support_phone = get_field('whatsapp_number', 'option') ?: '+61 4 8999 5839';
				$wa_btn_text   = get_field('whatsapp_button_text', 'option');
				$wa_url        = get_field('whatsapp_button_url', 'option');

				if ( empty( $wa_url ) ) {
					$clean_phone = preg_replace('/[^0-9]/', '', $support_phone);
					if (strpos($clean_phone, '0') === 0) {
						$clean_phone = '61' . substr($clean_phone, 1);
					}
					$wa_url = 'https://wa.me/' . $clean_phone;
				}
				?>
				<a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener noreferrer" class="hidden sm:inline-flex items-center gap-2 h-10 px-3.5 sm:px-4 rounded-full bg-[#075E54] hover:bg-[#054d45] border border-[#054d45] text-white font-bold text-xs sm:text-[13px] shadow-sm transition-all hover:scale-[1.02]">
					<span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#25D366] text-white shrink-0 shadow-2xs">
						<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
							<path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.67-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
						</svg>
					</span>
					<?php if (!empty($wa_btn_text)) : ?>
						<span class="text-xs text-white/90 font-medium hidden md:inline"><?php echo esc_html($wa_btn_text); ?></span>
					<?php endif; ?>
					<span class="text-xs sm:text-[13px] font-bold text-white tracking-tight"><?php echo esc_html($support_phone); ?></span>
				</a>

				<!-- Mobile Menu Button -->
				<button class="lg:hidden w-10 h-10 grid place-items-center rounded-full hover:bg-ink-100" id="mobile-menu-btn" aria-label="Menu">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
				</button>
			</div>
		</div>
		</header>
    <?php endif; ?>


