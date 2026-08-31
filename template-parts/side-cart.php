<div id="armodafinil-side-cart" class="fixed inset-0 z-[110] flex justify-end hidden" aria-modal="true" role="dialog">
    <!-- Backdrop -->
    <div id="side-cart-backdrop" class="fixed inset-0 bg-ink-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>

    <!-- Slide-out Panel -->
    <div id="side-cart-panel" class="relative w-full max-w-md bg-white h-full shadow-2xl flex flex-col translate-x-full transition-transform duration-300 ease-in-out">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b border-ink-100 flex items-center justify-between shrink-0">
            <h2 class="text-xl font-serif font-bold text-ink-900">Your Cart</h2>
            <button id="side-cart-close" class="p-2 text-ink-400 hover:text-ink-700 transition-colors bg-ink-50 hover:bg-ink-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <!-- WooCommerce Mini Cart Widget -->
        <div class="flex-1 overflow-y-auto widget_shopping_cart_content bg-ink-50/30">
            <?php woocommerce_mini_cart(); ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sideCart = document.getElementById('armodafinil-side-cart');
    const backdrop = document.getElementById('side-cart-backdrop');
    const panel = document.getElementById('side-cart-panel');
    const closeBtn = document.getElementById('side-cart-close');
    
    // Find header cart triggers
    const cartTriggers = document.querySelectorAll('.header-cart-link, a[href*="/cart"]');

    function openCart(e) {
        if(e) e.preventDefault();
        
        // Remove hidden
        sideCart.classList.remove('hidden');
        
        // Force reflow
        void sideCart.offsetWidth;
        
        // Animate in
        backdrop.classList.remove('opacity-0');
        backdrop.classList.add('opacity-100');
        panel.classList.remove('translate-x-full');
        panel.classList.add('translate-x-0');
        
        document.body.style.overflow = 'hidden';
    }

    function closeCart() {
        // Animate out
        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('translate-x-0');
        panel.classList.add('translate-x-full');
        
        // Wait for animation to finish before hiding
        setTimeout(() => {
            sideCart.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }

    cartTriggers.forEach(trigger => {
        trigger.addEventListener('click', openCart);
    });

    closeBtn.addEventListener('click', closeCart);
    backdrop.addEventListener('click', closeCart);
    
    // Open cart when item is added via AJAX
    jQuery(document.body).on('added_to_cart', function() {
        openCart();
    });
});
</script>
