<?php
/**
 * The footer for our theme
 *
 * @package Armodafinil_Australia_Direct
 */

$footer_desc = get_field('footer_description', 'option');
if ($footer_desc) {
	$footer_desc = str_replace('Legal Disclaimer:', '<br><br><span class="opacity-50 uppercase tracking-widest text-[10px] font-bold block mb-1">Legal Disclaimer:</span>', $footer_desc);
}

$footer_address = get_field('footer_address', 'option') ?: "50 Holt Street, Surry Hills, 2010";
$footer_maps_url = get_field('footer_maps_url', 'option') ?: get_field('footer_address_url', 'option');
if ( ! $footer_maps_url && $footer_address ) {
	$footer_maps_url = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode(strip_tags($footer_address));
}
$footer_email = get_field('footer_email', 'option') ?: get_field('support_email', 'option') ?: "orders@waklertaustralia.com.au";
$footer_contact_heading = get_field('footer_contact_heading', 'option') ?: "Get in Touch with Us";
$working_days = get_field('working_days', 'option') ?: "Monday to Sunday";
$office_hours = get_field('office_hours', 'option') ?: "24/7";
$payments_heading = get_field('footer_payments_heading', 'option') ?: "Payment Accepted";
$shipping_heading = get_field('footer_shipping_heading', 'option') ?: "Shipping Partner";
$payment_images = get_field('footer_payment_images', 'option');
$shipping_images = get_field('footer_shipping_images', 'option');
$copyright_text = get_field('copyright_text', 'option') ?: '&copy; ' . date('Y') . ' Armodafinil. Information only &mdash; not medical advice.';

// WhatsApp link
$whatsapp_raw = get_field('whatsapp_button_url', 'option') ?: get_field('whatsapp_number', 'option') ?: '+61 4 8999 5839';
if (strpos($whatsapp_raw, 'http') === 0) {
	$whatsapp_url = $whatsapp_raw;
} else {
	$whatsapp_clean = preg_replace('/[^0-9]/', '', $whatsapp_raw);
	$whatsapp_url = 'https://wa.me/' . $whatsapp_clean;
}
?>

<footer class="mt-24 bg-ink-900 text-ink-100">
	<style>
		@media (min-width: 1024px) {
			.lg-grid-cols-6-fix {
				grid-template-columns: repeat(6, minmax(0, 1fr)) !important;
			}
		}
		.footer-social-btn {
			width: 36px;
			height: 36px;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			border-radius: 9999px;
			background-color: #162136 !important;
			color: #5eead4 !important;
			transition: all 0.2s ease;
			text-decoration: none;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
		}
		.footer-social-btn:hover {
			background-color: #1e2d4a !important;
			color: #ffffff !important;
			transform: scale(1.08);
		}
		.footer-social-btn svg {
			width: 17px;
			height: 17px;
			stroke: currentColor !important;
			stroke-width: 2.2 !important;
		}
	</style>
	<div
		class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 lg-grid-cols-6-fix gap-8">
		<!-- Column 1: Brand, Contact, Payment & Shipping -->
		<div class="col-span-1 sm:col-span-2 lg:col-span-2 pr-0 lg:pr-4">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block bg-white px-3 py-2 rounded-xl mb-1">
				<img src="<?php $custom_logo_id = get_theme_mod("custom_logo");
				echo $custom_logo_id ? esc_url(wp_get_attachment_image_url($custom_logo_id, "full")) : esc_url(get_template_directory_uri() . "/assets/logo.png"); ?>"
					alt="Armodafinil Direct"
					style="height: 36px !important; width: auto !important; max-width: 220px; object-fit: contain;">
			</a>
			<?php if ($footer_desc): ?>
				<p class="mt-3 text-sm text-ink-100/70 max-w-sm"><?php echo wp_kses_post($footer_desc); ?></p>
			<?php endif; ?>

			<!-- Get in Touch with Us -->
			<h3 class="text-[15px] font-bold text-white mb-4 mt-8" style="color: #fff !important;">
				<?php echo esc_html($footer_contact_heading); ?>
			</h3>
			<div class="mt-4 space-y-4">
				<?php if ($footer_address): ?>
					<a href="<?php echo esc_url($footer_maps_url); ?>" target="_blank" rel="noopener noreferrer"
						class="group flex items-start gap-5 text-[13px] text-ink-100/80 hover:text-white transition-colors cursor-pointer w-fit">
						<svg xmlns="http://www.w3.org/2000/svg"
							class="w-4 h-4 mt-0.5 text-[#FFD700] shrink-0 group-hover:scale-110 transition-transform"
							fill="currentColor" viewBox="0 0 24 24">
							<path
								d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
						</svg>
						<span
							class="group-hover:text-white transition-colors"><?php echo esc_html($footer_address); ?></span>
					</a>
				<?php endif; ?>

				<?php if ($whatsapp_raw): ?>
					<a href="<?php echo esc_url($whatsapp_url); ?>" target="_blank" rel="noopener noreferrer"
						class="group flex items-center gap-5 text-[13px] text-ink-100/80 hover:text-white transition-all w-fit">
						<svg xmlns="http://www.w3.org/2000/svg"
							class="w-4 h-4 text-[#25D366] shrink-0 group-hover:scale-110 transition-transform"
							fill="currentColor" viewBox="0 0 24 24">
							<path
								d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.67-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
						</svg>
						<span class="group-hover:text-emerald-400 group-hover:translate-x-0.5 transition-all">WhatsApp
						</span>
					</a>
				<?php endif; ?>

				<?php if ($footer_email): ?>
					<a href="mailto:<?php echo esc_attr($footer_email); ?>"
						class="group flex items-center gap-5 text-[13px] text-ink-100/80 hover:text-white transition-all w-fit">
						<svg xmlns="http://www.w3.org/2000/svg"
							class="w-4 h-4 text-[#FFD700] shrink-0 group-hover:scale-110 transition-transform"
							fill="currentColor" viewBox="0 0 24 24">
							<path
								d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
						</svg>
						<span class="group-hover:text-white transition-colors"><?php echo esc_html($footer_email); ?></span>
					</a>
				<?php endif; ?>

				<?php if ($working_days): ?>
					<div class="flex items-center gap-3 text-[13px] text-ink-100/80">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#FFD700] shrink-0" fill="none"
							viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
						</svg>
						<span><strong class="text-white font-medium">Working Days:</strong>
							<?php echo esc_html($working_days); ?></span>
					</div>
				<?php endif; ?>

				<?php if ($office_hours): ?>
					<div class="flex items-center gap-3 text-[13px] text-ink-100/80">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#FFD700] shrink-0" fill="none"
							viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
						<span><strong class="text-white font-medium">Office Hours:</strong>
							<?php echo esc_html($office_hours); ?></span>
					</div>
				<?php endif; ?>
			</div>

			<!-- Payment Accepted -->
			<h3 class="text-[15px] font-bold text-white mb-3 mt-8" style="color: #fff !important;">
				<?php echo esc_html($payments_heading); ?>
			</h3>
			<div class="flex items-center gap-5 flex-wrap">
				<?php if (!empty($payment_images) && is_array($payment_images)): ?>
					<?php foreach ($payment_images as $pay):
						$img_src = '';
						if (!empty($pay['image'])) {
							if (is_array($pay['image'])) {
								$img_src = $pay['image']['url'] ?? '';
							} elseif (is_numeric($pay['image'])) {
								$img_src = wp_get_attachment_image_url($pay['image'], 'full');
							} elseif (is_string($pay['image'])) {
								$img_src = $pay['image'];
							}
						}
						if (!$img_src)
							continue;
						$alt_val = !empty($pay['alt_text']) ? $pay['alt_text'] : 'Payment Method';
						?>
						<img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr($alt_val); ?>"
							class="footer-payment-logo object-contain h-8 sm:h-9 w-auto hover:scale-105 transition-transform"
							style="height: 34px; max-height: 36px; width: auto; max-width: 160px; object-fit: contain;">
					<?php endforeach; ?>
				<?php else: ?>
					<img src="<?php echo esc_url(get_theme_file_uri('/assets/images/commonwealth-white.png')); ?>"
						alt="Commonwealth Bank"
						class="footer-payment-logo object-contain h-8 sm:h-9 w-auto hover:scale-105 transition-transform"
						style="height: 34px; max-height: 36px; width: auto; max-width: 160px; object-fit: contain;">
					<img src="<?php echo esc_url(get_theme_file_uri('/assets/images/osko-white.png')); ?>"
						alt="Osko by BPAY"
						class="footer-payment-logo object-contain h-7 sm:h-8 w-auto hover:scale-105 transition-transform"
						style="height: 28px; max-height: 32px; width: auto; max-width: 125px; object-fit: contain;">
					<img src="<?php echo esc_url(get_theme_file_uri('/assets/images/payid-white.png')); ?>" alt="PayID"
						class="footer-payment-logo object-contain h-7 sm:h-8 w-auto hover:scale-105 transition-transform"
						style="height: 28px; max-height: 32px; width: auto; max-width: 90px; object-fit: contain;">
				<?php endif; ?>
			</div>

			<!-- Shipping Partner -->
			<h3 class="text-[15px] font-bold text-white mb-3 mt-8" style="color: #fff !important;">
				<?php echo esc_html($shipping_heading); ?>
			</h3>
			<div class="flex items-center gap-5 flex-wrap">
				<?php if (!empty($shipping_images) && is_array($shipping_images)): ?>
					<?php foreach ($shipping_images as $ship):
						$img_src = '';
						if (!empty($ship['image'])) {
							if (is_array($ship['image'])) {
								$img_src = $ship['image']['url'] ?? '';
							} elseif (is_numeric($ship['image'])) {
								$img_src = wp_get_attachment_image_url($ship['image'], 'full');
							} elseif (is_string($ship['image'])) {
								$img_src = $ship['image'];
							}
						}
						if (!$img_src)
							continue;
						$alt_val = !empty($ship['alt_text']) ? $ship['alt_text'] : 'Shipping Partner';
						?>
						<img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr($alt_val); ?>"
							class="footer-shipping-logo object-contain h-10 sm:h-11 w-auto hover:scale-105 transition-transform"
							style="height: 40px; max-height: 44px; width: auto; max-width: 150px; object-fit: contain;">
					<?php endforeach; ?>
				<?php else: ?>
					<img src="<?php echo esc_url(get_theme_file_uri('/assets/images/australia-post.png')); ?>"
						alt="Australia Post"
						class="footer-shipping-logo object-contain h-10 sm:h-11 w-auto hover:scale-105 transition-transform"
						style="height: 40px; max-height: 44px; width: auto; max-width: 150px; object-fit: contain;">
				<?php endif; ?>
			</div>
		</div>

		<!-- Column 2: Shop & Trending Products -->
		<div>
			<div class="text-white font-semibold mb-3 text-sm uppercase tracking-widest">Shop</div>
			<?php wp_nav_menu(array('theme_location' => 'footer_1', 'menu_class' => 'space-y-2 text-sm text-ink-100/80', 'fallback_cb' => false)); ?>

			<div class="text-white font-semibold mt-8 mb-3 text-sm uppercase tracking-widest">Trending Products</div>
			<?php wp_nav_menu(array('theme_location' => 'footer_trending', 'menu_class' => 'space-y-2 text-sm text-ink-100/80', 'fallback_cb' => false)); ?>
		</div>

		<!-- Column 3: Help -->
		<div>
			<div class="text-white font-semibold mb-3 text-sm uppercase tracking-widest">Help</div>
			<?php wp_nav_menu(array('theme_location' => 'footer_2', 'menu_class' => 'space-y-2 text-sm text-ink-100/80', 'fallback_cb' => false)); ?>
		</div>

		<!-- Column 4: Company -->
		<div>
			<div class="text-white font-semibold mb-3 text-sm uppercase tracking-widest">Company</div>
			<?php wp_nav_menu(array('theme_location' => 'footer_3', 'menu_class' => 'space-y-2 text-sm text-ink-100/80', 'fallback_cb' => false)); ?>
		</div>

		<!-- Column 5: Areas Delivered in Australia -->
		<div class="col-span-1 sm:col-span-2 md:col-span-1">
			<div class="text-white font-semibold mb-3 text-sm uppercase tracking-widest">Areas Delivered in Australia
			</div>
			<?php wp_nav_menu(array('theme_location' => 'footer_4', 'menu_class' => 'space-y-2 text-sm text-ink-100/80', 'fallback_cb' => false)); ?>
		</div>
	</div>

	<?php
	$fb_link = get_field('facebook_link', 'option');
	$ig_link = get_field('instagram_link', 'option');
	if ($fb_link || $ig_link):
		?>

	<?php endif; ?>

	<!-- Bottom Bar -->
	<div class="border-t border-white/10">
		<div
			class="flex items-center justify-center sm:justify-between max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-xs text-ink-100/60">
			<p class="text-left m-0">
				<?php echo wp_kses_post($copyright_text); ?>
			</p>
			<div class="flex justify-end items-center gap-3">
				<?php if ($fb_link): ?>
					<a href="<?php echo esc_url($fb_link); ?>" aria-label="Facebook" target="_blank"
						rel="noopener noreferrer"
						class="footer-social-btn"
						style="background-color: #162136; color: #5eead4;">
						<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
							stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
							class="lucide lucide-facebook">
							<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
						</svg>
					</a>
				<?php endif; ?>

				<?php if ($ig_link): ?>
					<a href="<?php echo esc_url($ig_link); ?>" aria-label="Instagram" target="_blank"
						rel="noopener noreferrer"
						class="footer-social-btn"
						style="background-color: #162136; color: #5eead4;">
						<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
							stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
							class="lucide lucide-instagram">
							<rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
							<path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
							<line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
						</svg>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</footer>

</div><!-- #page -->

<!-- Mobile Menu Drawer (Bottom Sheet) -->
<style>
	.mobile-drawer-backdrop {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: rgba(9, 21, 37, 0.6);
		z-index: 9998;
		opacity: 0;
		transition: opacity 0.3s ease;
		pointer-events: none;
	}

	.mobile-drawer-backdrop.is-active {
		opacity: 1;
		pointer-events: auto;
	}

	.mobile-drawer {
		position: fixed;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ffffff;
		z-index: 9999;
		border-radius: 24px 24px 0 0;
		box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.1);
		transform: translateY(100%);
		transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
		display: flex;
		flex-direction: column;
		max-height: 85vh;
	}

	.mobile-drawer.is-active {
		transform: translateY(0);
	}
</style>
<div id="mobile-menu-backdrop" class="mobile-drawer-backdrop lg:hidden" aria-hidden="true"></div>

<div id="mobile-menu" class="mobile-drawer lg:hidden">
	<div class="p-5 flex items-center justify-between border-b border-ink-100">
		<span class="font-serif font-semibold text-xl text-ink-900">Menu</span>
		<button id="mobile-menu-close"
			class="w-10 h-10 grid place-items-center rounded-full bg-ink-50 text-ink-500 hover:bg-ink-100 hover:text-ink-900 transition-colors"
			aria-label="Close menu">
			<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
				stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
				<path d="M18 6 6 18" />
				<path d="m6 6 12 12" />
			</svg>
		</button>
	</div>
	<nav class="flex flex-col overflow-y-auto pb-8">
		<?php
		wp_nav_menu(array(
			'theme_location' => 'mobile',
			'menu_id' => 'mobile-menu-items',
			'container' => false,
			'items_wrap' => '%3$s',
			'fallback_cb' => false,
		));
		?>
	</nav>
</div>

<!-- Mobile menu toggle script -->
<script>
	const menuBtn = document.getElementById('mobile-menu-btn');
	const menuClose = document.getElementById('mobile-menu-close');
	const menu = document.getElementById('mobile-menu');
	const backdrop = document.getElementById('mobile-menu-backdrop');

	if (menuBtn && menuClose && menu && backdrop) {
		function openMenu() {
			backdrop.classList.add('is-active');
			menu.classList.add('is-active');
			document.body.style.overflow = 'hidden';
		}

		function closeMenu() {
			backdrop.classList.remove('is-active');
			menu.classList.remove('is-active');
			document.body.style.overflow = '';
		}

		menuBtn.addEventListener('click', openMenu);
		menuClose.addEventListener('click', closeMenu);
		backdrop.addEventListener('click', closeMenu);
	}
</script>
<?php wp_footer(); ?>

<?php get_template_part('template-parts/search-modal'); ?>
</body>

</html>