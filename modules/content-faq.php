<?php
/**
 * FAQ Module Template (Advanced JS Filter)
 * 
 * Data provided by ACF Sub Fields: faq_categories
 */

$title    = get_sub_field('title');
$subtitle = get_sub_field('subtitle');

$raw_categories = get_sub_field('faq_categories');
$categories = array('All topics');
$faqs = array();

// Support Block Fields
$support_title    = get_sub_field('support_title');
$support_subtitle = get_sub_field('support_subtitle');
$support_email    = get_field('support_email', 'option') ?: get_sub_field('support_email') ?: 'orders@armodafinildirect.com.au';
$support_btn_text = get_sub_field('support_btn_text') ?: 'Contact us';
$support_btn_url  = get_sub_field('support_btn_url') ?: '/contact';

// Refresh the original module defaults without overriding custom copy.
if ( empty($support_title) || $support_title === 'Still need help?' ) {
    $support_title = 'Talk to our support team';
}
if ( empty($support_subtitle) || $support_subtitle === 'Our pharmacy support team typically responds within one business day.' ) {
    $support_subtitle = 'Need help with website information, an existing order or delivery details? Send us a message and we will get back to you as soon as possible.';
}

$whatsapp_raw = get_field('whatsapp_button_url', 'option') ?: get_field('whatsapp_number', 'option');
$whatsapp_url = '';
if ( $whatsapp_raw ) {
    $whatsapp_url = strpos($whatsapp_raw, 'http') === 0
        ? $whatsapp_raw
        : 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsapp_raw);
}

$support_image_url = get_template_directory_uri() . '/assets/images/Homepage armodafinil direct.png';

// Default icons mapping for fallback
$icons = array(
    'All topics' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-help-circle w-4 h-4"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>',
    'package' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package w-4 h-4"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>',
    'credit-card' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card w-4 h-4"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>',
    'truck' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck w-4 h-4"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>',
    'user' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user w-4 h-4"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
);
$category_icons = array();

if ( !empty( $raw_categories ) ) {
    foreach ( $raw_categories as $cat ) {
        if ( empty($cat['cat_name']) ) continue;
        
        $cat_name = $cat['cat_name'];
        $categories[] = $cat_name;
        
        $icon_name = !empty($cat['cat_icon']) ? $cat['cat_icon'] : 'help-circle';
        $category_icons[$cat_name] = isset($icons[$icon_name]) ? $icons[$icon_name] : $icons['All topics'];
        
        if ( !empty($cat['faqs']) ) {
            foreach ( $cat['faqs'] as $faq ) {
                $faqs[] = array(
                    'category' => $cat_name,
                    'question' => $faq['question'],
                    'answer'   => $faq['answer'],
                );
            }
        }
    }
} else {
    // Fallback data if module is empty
    if ( empty($title) ) {
        $title = 'Frequently Asked Questions';
    }
    if ( empty($subtitle) ) {
        $subtitle = 'Find answers to common questions about our products, ordering, shipping, and payment options.';
    }
    $categories = array('All topics', 'Ordering', 'Payment', 'Shipping', 'Account');
    $category_icons = array(
        'Ordering' => $icons['package'],
        'Payment' => $icons['credit-card'],
        'Shipping' => $icons['truck'],
        'Account' => $icons['user'],
    );
    $faqs = array(
        array('category' => 'Ordering', 'question' => 'How do I place an order?', 'answer' => 'Pick your product and pack size, add it to your cart, then complete checkout with your delivery details. A confirmation email with payment instructions will land in your inbox shortly after.'),
        array('category' => 'Payment', 'question' => 'What payment methods do you accept?', 'answer' => 'We accept Australian bank transfer, major cards through our encrypted gateway, and a handful of supported cryptocurrencies. Every transaction is processed on a secure, PCI-aligned checkout.'),
        array('category' => 'Shipping', 'question' => 'When is shipping free?', 'answer' => 'Orders above $299 qualify for complimentary Australia-wide dispatch, plus 10% off with code ARMD10 applied at checkout.'),
        array('category' => 'Payment', 'question' => 'Do you offer discounts?', 'answer' => 'Yes - new-customer welcome codes, bundle savings for larger pack sizes, and the ongoing ARMD10 code work in combination with our free-shipping threshold.'),
        array('category' => 'Shipping', 'question' => 'How long does delivery take?', 'answer' => 'Most Australian metropolitan addresses receive their parcel within 7-10 business days. Regional and remote postcodes may take a few days longer during peak periods.'),
        array('category' => 'Ordering', 'question' => 'Do I need a prescription?', 'answer' => 'Australian regulations may require a prescription depending on your circumstances. We recommend a chat with your GP or our support team before you order for personal use.'),
        array('category' => 'Shipping', 'question' => 'Is my order discreet?', 'answer' => 'Every parcel ships in neutral outer packaging - no brand names, product references, or clinical branding are printed on the outside.'),
        array('category' => 'Ordering', 'question' => 'What is your return policy?', 'answer' => 'Sealed, unopened items can be returned within 14 days of delivery. Email support with your order number and we will send return instructions the next business day.'),
        array('category' => 'Account', 'question' => 'Do I need an account?', 'answer' => 'No - checkout works fine as a guest. Creating an account simply speeds up future orders and gives you a running history of shipments and tracking links.'),
        array('category' => 'Account', 'question' => 'How do I contact support?', 'answer' => 'WhatsApp is fastest during business hours, or email support@armodafinildirect.example anytime. Our team usually replies within one business day.'),
    );
}
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-10" id="faq-app">
    
    <?php if ( !empty($title) || !empty($subtitle) ) : ?>
        <div class="text-center mb-8">
            <?php if ( !empty($title) ) : ?>
                <h2 class="text-3xl md:text-4xl font-serif font-semibold text-ink-900 leading-tight"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            <?php if ( !empty($subtitle) ) : ?>
                <p class="mt-2 text-ink-500 max-w-2xl mx-auto"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Filter Buttons -->
    <div class="flex flex-wrap gap-2 justify-center">
        <?php foreach ($categories as $cat) : ?>
            <button type="button" 
                data-faq-cat="<?php echo esc_attr($cat); ?>"
                class="faq-cat-btn inline-flex items-center gap-2 text-sm font-medium px-4 h-10 rounded-full border transition-colors <?php echo $cat === 'All topics' ? 'bg-brand-600 text-white border-brand-600' : 'bg-white text-ink-700 border-ink-200 hover:border-brand-600'; ?>">
                <?php echo $cat === 'All topics' ? $icons['All topics'] : (isset($category_icons[$cat]) ? $category_icons[$cat] : $icons['All topics']); ?> <?php echo esc_html($cat); ?>
            </button>
        <?php endforeach; ?>
    </div>

    <!-- Search Bar -->
    <div class="mt-6 flex items-center bg-white border border-ink-200 rounded-full px-4 h-12 max-w-2xl mx-auto shadow-soft focus-within:border-brand-500 focus-within:ring-1 focus-within:ring-brand-500 transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search w-4 h-4 text-ink-500"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="text" id="faq-search" placeholder="Search questions..." class="bg-transparent outline-none border-0 text-sm flex-1 mx-3 text-ink-900 placeholder-ink-400 focus:ring-0 focus:outline-none" />
    </div>

    <!-- FAQ Items -->
    <div class="mt-8 space-y-3" id="faq-list">
        <p id="faq-empty" class="text-center text-ink-500 py-16 hidden">No answers match your search. Try a different keyword.</p>
        
        <?php foreach ( $faqs as $index => $f ) : 
            $item_cat = isset($f['category']) ? $f['category'] : 'Ordering';
        ?>
            <div class="faq-item border border-ink-200 rounded-2xl bg-white overflow-hidden transition-colors" data-cat="<?php echo esc_attr($item_cat); ?>" data-text="<?php echo esc_attr(strtolower($f['question'] . ' ' . $f['answer'])); ?>">
                <button type="button" class="faq-toggle w-full flex items-center gap-4 text-left px-5 py-4 focus:outline-none">
                    <span class="faq-num w-8 h-8 grid place-items-center rounded-lg text-sm font-semibold shrink-0 bg-brand-50 text-brand-700 transition-colors"><?php echo $index + 1; ?></span>
                    <span class="flex-1 font-medium text-ink-900"><?php echo esc_html($f['question']); ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="faq-chevron lucide lucide-chevron-down w-4 h-4 text-ink-500 transition-transform"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div class="faq-content hidden p-5 text-sm text-ink-700 leading-relaxed flex gap-3 items-start border-t border-transparent">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-help-circle w-4 h-4 text-brand-600 mt-1 shrink-0"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                    <span><?php echo wp_kses_post( wpautop( $f['answer'] ) ); ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Support Banner -->
    <div class="faq-support-shell mt-14">
        <section class="faq-support-banner" style="--faq-support-image: url('<?php echo esc_url($support_image_url); ?>');" aria-labelledby="faq-support-heading">
            <div class="faq-support-orbit faq-support-orbit-one" aria-hidden="true"></div>
            <div class="faq-support-orbit faq-support-orbit-two" aria-hidden="true"></div>

            <div class="faq-support-content">
                <h2 id="faq-support-heading"><?php echo esc_html($support_title); ?></h2>
                <p><?php echo esc_html($support_subtitle); ?></p>

                <div class="faq-support-actions">
                    <?php if ( $whatsapp_url ) : ?>
                        <a href="<?php echo esc_url($whatsapp_url); ?>" class="faq-support-button faq-support-button-primary" target="_blank" rel="noopener noreferrer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/><path d="M8.2 8.2c.5 3 2.6 5.1 5.6 5.6"/></svg>
                            WhatsApp Support
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                        </a>
                    <?php endif; ?>

                    <?php if ( $support_email ) : ?>
                        <a href="mailto:<?php echo esc_attr($support_email); ?>" class="faq-support-button faq-support-button-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            Email Support
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                        </a>
                    <?php elseif ( $support_btn_text && $support_btn_url ) : ?>
                        <a href="<?php echo esc_url($support_btn_url); ?>" class="faq-support-button faq-support-button-secondary">
                            <?php echo esc_html($support_btn_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="faq-support-brand" aria-hidden="true">
                <span class="faq-support-brand-mark">A</span>
                <span>Armodafinil Direct</span>
            </div>
        </section>
    </div>
</div>

<style>
.faq-support-shell {
    width: min(1120px, calc(100vw - 32px));
    margin-left: 50%;
    transform: translateX(-50%);
}
.faq-support-banner {
    --faq-navy: #061b33;
    position: relative;
    min-height: 330px;
    overflow: hidden;
    border-radius: 24px;
    isolation: isolate;
    background-color: var(--faq-navy);
    background-image: linear-gradient(90deg, rgba(6, 27, 51, .99) 0%, rgba(6, 27, 51, .98) 40%, rgba(6, 27, 51, .76) 58%, rgba(6, 27, 51, .1) 100%), var(--faq-support-image);
    background-repeat: no-repeat;
    background-size: cover, cover;
    background-position: center, 70% center;
    box-shadow: 0 24px 60px rgba(6, 27, 51, .16);
}
.faq-support-banner::after {
    content: "";
    position: absolute;
    inset: 0;
    z-index: -1;
    border: 1px solid rgba(45, 212, 191, .28);
    border-radius: inherit;
    pointer-events: none;
}
.faq-support-content {
    width: min(620px, 62%);
    padding: 66px 56px;
    color: #fff;
}
.faq-support-content h2 {
    margin: 0;
    color: #fff;
    font-family: inherit;
    font-size: clamp(1.75rem, 3vw, 2.55rem);
    font-weight: 750;
    line-height: 1.08;
    letter-spacing: -.025em;
}
.faq-support-content p {
    max-width: 560px;
    margin: 16px 0 0;
    color: rgba(255, 255, 255, .79);
    font-size: 1rem;
    line-height: 1.65;
}
.faq-support-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 28px;
}
.faq-support-button {
    display: inline-flex;
    min-height: 44px;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 0 18px;
    border: 1px solid transparent;
    border-radius: 999px;
    font-size: .84rem;
    font-weight: 700;
    line-height: 1;
    text-decoration: none;
    transition: transform .2s ease, background-color .2s ease, border-color .2s ease, color .2s ease;
}
.faq-support-button:hover {
    transform: translateY(-2px);
}
.faq-support-button-primary {
    background: #fff;
    color: #075e57;
}
.faq-support-button-primary:hover {
    background: #e6fffb;
    color: #064e49;
}
.faq-support-button-secondary {
    border-color: rgba(94, 234, 212, .65);
    background: rgba(13, 148, 136, .2);
    color: #fff;
}
.faq-support-button-secondary:hover {
    border-color: #5eead4;
    background: rgba(13, 148, 136, .38);
    color: #fff;
}
.faq-support-brand {
    position: absolute;
    top: 28px;
    right: 30px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 11px 7px 8px;
    border: 1px solid rgba(255, 255, 255, .38);
    border-radius: 8px;
    background: rgba(255, 255, 255, .88);
    color: #075e57;
    font-size: .72rem;
    font-weight: 700;
    box-shadow: 0 8px 28px rgba(6, 27, 51, .18);
    backdrop-filter: blur(8px);
}
.faq-support-brand-mark {
    display: grid;
    width: 21px;
    height: 21px;
    place-items: center;
    border-radius: 50%;
    background: #0d9488;
    color: #fff;
    font-family: Georgia, serif;
    font-size: .8rem;
}
.faq-support-orbit {
    position: absolute;
    z-index: -1;
    border: 1px solid rgba(45, 212, 191, .2);
    border-radius: 50%;
    pointer-events: none;
}
.faq-support-orbit-one {
    width: 250px;
    height: 250px;
    left: 31%;
    top: -95px;
}
.faq-support-orbit-two {
    width: 130px;
    height: 130px;
    left: 43%;
    bottom: -72px;
}
@media (max-width: 767px) {
    .faq-support-shell {
        width: calc(100vw - 24px);
    }
    .faq-support-banner {
        min-height: 420px;
        background-image: linear-gradient(180deg, rgba(6, 27, 51, .97) 0%, rgba(6, 27, 51, .91) 57%, rgba(6, 27, 51, .45) 100%), var(--faq-support-image);
        background-position: center, 72% center;
    }
    .faq-support-content {
        width: 100%;
        padding: 52px 26px 180px;
        text-align: left;
    }
    .faq-support-actions {
        align-items: stretch;
        flex-direction: column;
    }
    .faq-support-button {
        width: 100%;
    }
    .faq-support-brand {
        top: auto;
        right: 18px;
        bottom: 18px;
    }
}
@media (prefers-reduced-motion: reduce) {
    .faq-support-button {
        transition: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const app = document.getElementById('faq-app');
    if (!app) return;

    let currentCat = 'All topics';
    let searchQuery = '';
    
    const catBtns = app.querySelectorAll('.faq-cat-btn');
    const searchInput = document.getElementById('faq-search');
    const faqItems = app.querySelectorAll('.faq-item');
    const emptyMsg = document.getElementById('faq-empty');

    function filterFaqs() {
        let visibleCount = 0;
        
        faqItems.forEach((item, index) => {
            const itemCat = item.getAttribute('data-cat');
            const itemText = item.getAttribute('data-text');
            
            const matchCat = currentCat === 'All topics' || currentCat === itemCat;
            const matchSearch = searchQuery === '' || itemText.includes(searchQuery);
            
            if (matchCat && matchSearch) {
                item.style.display = 'block';
                visibleCount++;
                // Reset numbering based on visible order
                item.querySelector('.faq-num').textContent = visibleCount;
                
                // Open by default when filtering
                openItem(item);
            } else {
                item.style.display = 'none';
            }
        });
        
        // Hide/show empty message
        if (visibleCount > 0) {
            emptyMsg.classList.add('hidden');
        } else {
            emptyMsg.classList.remove('hidden');
        }
    }

    function closeItem(item) {
        item.classList.remove('border-brand-500', 'shadow-card');
        item.classList.add('border-ink-200');
        
        const num = item.querySelector('.faq-num');
        num.classList.remove('bg-brand-600', 'text-white');
        num.classList.add('bg-brand-50', 'text-brand-700');
        
        const chevron = item.querySelector('.faq-chevron');
        chevron.classList.remove('rotate-180', 'text-brand-600');
        
        item.querySelector('.faq-content').classList.add('hidden');
    }

    function openItem(item) {
        item.classList.remove('border-ink-200');
        item.classList.add('border-brand-500', 'shadow-card');
        
        const num = item.querySelector('.faq-num');
        num.classList.remove('bg-brand-50', 'text-brand-700');
        num.classList.add('bg-brand-600', 'text-white');
        
        const chevron = item.querySelector('.faq-chevron');
        chevron.classList.add('rotate-180', 'text-brand-600');
        
        item.querySelector('.faq-content').classList.remove('hidden');
    }

    // Initialize toggles
    faqItems.forEach(item => {
        const toggle = item.querySelector('.faq-toggle');
        toggle.addEventListener('click', () => {
            const isOpen = !item.querySelector('.faq-content').classList.contains('hidden');
            
            // Toggle clicked
            if (!isOpen) {
                openItem(item);
            } else {
                closeItem(item);
            }
        });
    });

    // Initialize category buttons
    catBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            currentCat = btn.getAttribute('data-faq-cat');
            
            // Update active state
            catBtns.forEach(b => {
                b.classList.remove('bg-brand-600', 'text-white', 'border-brand-600');
                b.classList.add('bg-white', 'text-ink-700', 'border-ink-200', 'hover:border-brand-600');
            });
            btn.classList.remove('bg-white', 'text-ink-700', 'border-ink-200', 'hover:border-brand-600');
            btn.classList.add('bg-brand-600', 'text-white', 'border-brand-600');
            
            filterFaqs();
        });
    });

    // Initialize search
    searchInput.addEventListener('input', (e) => {
        searchQuery = e.target.value.toLowerCase();
        filterFaqs();
    });

    // Run initial filter to open first item
    filterFaqs();
});
</script>




