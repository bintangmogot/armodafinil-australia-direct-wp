<?php
/**
 * FAQ Module Template
 * 
 * Data provided by ACF Sub Fields: title, subtitle, faqs
 */

$title = get_sub_field('title') ?: 'FAQ';
$subtitle = get_sub_field('subtitle') ?: 'Common questions from Australian customers.';
$faqs = get_sub_field('faqs');

if ( empty( $faqs ) ) {
    $faqs = array(
        array('question' => 'How do I place an order?', 'answer' => 'Pick your product and pack size, add it to your cart, then complete checkout with your delivery details. A confirmation email with payment instructions will land in your inbox shortly after.'),
        array('question' => 'What payment methods do you accept?', 'answer' => 'We accept Australian bank transfer, major cards through our encrypted gateway, and a handful of supported cryptocurrencies. Every transaction is processed on a secure, PCI-aligned checkout.'),
        array('question' => 'When is shipping free?', 'answer' => 'Orders above A$299 qualify for complimentary Australia-wide dispatch, plus 10% off with code ARMD10 applied at checkout.'),
        array('question' => 'Do you offer discounts?', 'answer' => 'Yes — new-customer welcome codes, bundle savings for larger pack sizes, and the ongoing ARMD10 code work in combination with our free-shipping threshold.'),
        array('question' => 'How long does delivery take?', 'answer' => 'Most Australian metropolitan addresses receive their parcel within 6–12 business days. Regional and remote postcodes may take a few days longer during peak periods.'),
    );
}
?>

<section class="py-16 md:py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-serif font-semibold text-ink-900 text-center"><?php echo esc_html($title); ?></h2>
        <p class="mt-2 text-center text-ink-500"><?php echo esc_html($subtitle); ?></p>
        <div class="mt-10 space-y-3">
            <?php foreach ( $faqs as $f ) : ?>
            <details class="group border border-ink-200 rounded-xl bg-white overflow-hidden [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex items-center justify-between gap-4 px-5 py-4 cursor-pointer marker:hidden">
                    <span class="font-medium text-ink-900"><?php echo esc_html($f['question']); ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 text-ink-500 transition-transform group-open:rotate-180 group-open:text-brand-600"><path d="m6 9 6 6 6-6"/></svg>
                </summary>
                <div class="px-5 pb-5 text-sm text-ink-700 leading-relaxed">
                    <?php echo wp_kses_post( wpautop( $f['answer'] ) ); ?>
                </div>
            </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
