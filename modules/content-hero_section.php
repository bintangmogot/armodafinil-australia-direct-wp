<?php
/**
 * Hero Section Module Template
 * 
 * Data provided by ACF Sub Fields: eyebrow, title, subtitle, cta_label, cta_url, featured_product
 */

$eyebrow   = get_sub_field('eyebrow');
$title     = get_sub_field('title');
$subtitle  = get_sub_field('subtitle');
$cta_label = get_sub_field('cta_label');
$cta_url   = get_sub_field('cta_url');
$product_obj = get_sub_field('featured_product');

// Default product values in case none selected
$p_title = 'Armodafinil 250mg — Artvigil 250mg';
$p_image = 'https://placehold.co/800x450/e0f2fe/0369a1?text=Product+Image';
$p_price_html = '$185.00';
$p_stock = 'In stock';
$p_url   = '#';
$p_note  = 'Limit 1 per customer on first order.';
$p_id    = 0;
$is_variable = false;
$variations_json = '[]';
$attributes = array();
$default_price = 0;

if ( $product_obj ) {
    $product = wc_get_product( $product_obj->ID );
    if ( $product ) {
        $p_id    = $product->get_id();
        $p_title = $product->get_name();
        $p_price_html = $product->get_price_html();
        $p_url   = $product->get_permalink();
        
        $image_id = $product->get_image_id();
        if ( $image_id ) {
            $p_image = wp_get_attachment_image_url( $image_id, 'large' );
        }
        $p_stock = $product->is_in_stock() ? 'In stock' : 'Out of stock';

        if ( $product->is_type( 'variable' ) ) {
            $is_variable = true;
            $available_variations = $product->get_available_variations();
            $variations_json = wp_json_encode( $available_variations );
            $attributes = $product->get_variation_attributes();
            $default_price = $product->get_variation_price( 'min', true );
            $p_price_html = wc_price( $default_price ); // initial price
        }
    }
}
?>

<section class="section-wash">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 md:py-20 grid lg:grid-cols-2 gap-10 items-center">
        <div class="animate-fadeup">
            <?php if ( $eyebrow ) : ?>
            <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.18em] text-brand-700 bg-brand-100 px-3 py-1.5 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                <?php echo esc_html( $eyebrow ); ?>
            </span>
            <?php endif; ?>

            <?php if ( $title ) : ?>
            <h1 class="mt-5 font-serif text-4xl md:text-6xl leading-[1.05] font-semibold text-ink-900">
                <?php echo wp_kses_post( $title ); ?>
            </h1>
            <?php endif; ?>

            <?php if ( $subtitle ) : ?>
            <p class="mt-5 text-lg text-ink-700 leading-relaxed max-w-xl">
                <?php echo wp_kses_post( $subtitle ); ?>
            </p>
            <?php endif; ?>

            <div class="mt-8 flex flex-wrap gap-3">
                <?php if ( $cta_url && $cta_label ) : ?>
                <a href="<?php echo esc_url( $cta_url ); ?>" class="inline-flex items-center gap-2 h-12 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors shadow-soft">
                    <?php echo esc_html( $cta_label ); ?> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
                <?php endif; ?>
                <a href="/conditions" class="inline-flex items-center gap-2 h-12 px-6 rounded-full border border-ink-200 hover:border-brand-600 text-ink-900 font-semibold transition-colors">
                    Explore guides
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-ink-200 shadow-card overflow-hidden animate-fadeup" id="hero-product-<?php echo esc_attr($p_id); ?>">
            <a href="<?php echo esc_url($p_url); ?>" class="block aspect-[16/9] bg-brand-50">
                <img src="<?php echo esc_url( $p_image ); ?>" alt="<?php echo esc_attr( $p_title ); ?>" class="w-full h-full object-cover mix-blend-multiply" />
            </a>
            <div class="p-5 md:p-6">
                <div class="flex items-start justify-between gap-3">
                    <h3 class="font-serif text-xl font-semibold text-ink-900"><a href="<?php echo esc_url($p_url); ?>"><?php echo esc_html( $p_title ); ?></a></h3>
                    <span class="shrink-0 text-xs font-semibold text-brand-700 bg-brand-100 px-2.5 py-1 rounded-full"><?php echo esc_html( $p_stock ); ?></span>
                </div>
                
                <?php if ( $is_variable && ! empty( $attributes ) ) : ?>
                    <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                    <div class="mt-4 attribute-selector">
                        <div class="text-[11px] uppercase tracking-widest text-ink-500 mb-2"><?php echo wc_attribute_label( $attribute_name ); ?></div>
                        <div class="flex flex-wrap gap-1.5">
                            <?php foreach ( $options as $index => $option ) : 
                                $is_selected = $index === 0;
                            ?>
                                <button type="button" 
                                        data-attribute="<?php echo esc_attr( 'attribute_' . sanitize_title( $attribute_name ) ); ?>"
                                        data-value="<?php echo esc_attr( $option ); ?>"
                                        class="variation-btn text-xs font-semibold px-2.5 py-1.5 rounded-md border transition-colors <?php echo $is_selected ? 'bg-brand-600 text-white border-brand-600' : 'bg-white text-ink-700 border-ink-200 hover:border-brand-600'; ?>">
                                    <?php echo esc_html( $option ); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div class="mt-4 p-3 rounded-lg bg-amber-50 border border-amber-200 text-xs text-amber-900 flex items-start gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info mt-0.5 shrink-0"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg> 
                    <?php echo esc_html($p_note); ?>
                </div>

                <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <div class="text-2xl font-semibold text-ink-900 price-display">
                            <?php echo $p_price_html; ?>
                        </div>
                        <div class="text-xs text-ink-500">250mg strength</div>
                    </div>
                    
                    <form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post" enctype='multipart/form-data' class="flex items-center gap-2 hero-add-to-cart-form">
                        <div class="inline-flex items-center border border-ink-200 rounded-full overflow-hidden bg-white">
                            <button type="button" onclick="this.nextElementSibling.stepDown()" class="w-9 h-9 grid place-items-center hover:bg-ink-100 text-ink-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                            </button>
                            <input type="number" name="quantity" value="1" min="1" class="w-8 text-center text-sm font-medium border-0 p-0 focus:ring-0 text-ink-900" style="-moz-appearance: textfield;" />
                            <button type="button" onclick="this.previousElementSibling.stepUp()" class="w-9 h-9 grid place-items-center hover:bg-ink-100 text-ink-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            </button>
                        </div>
                        
                        <?php if ( $is_variable ) : ?>
                            <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $p_id ); ?>" />
                            <input type="hidden" name="product_id" value="<?php echo esc_attr( $p_id ); ?>" />
                            <input type="hidden" name="variation_id" class="variation_id" value="" />
                            <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                                <input type="hidden" name="attribute_<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>" class="attribute_hidden_field" value="<?php echo esc_attr( $options[0] ); ?>" />
                            <?php endforeach; ?>
                        <?php else : ?>
                            <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $p_id ); ?>" />
                        <?php endif; ?>

                        <button type="submit" class="inline-flex items-center gap-2 h-10 px-4 rounded-full bg-ink-900 hover:bg-ink-800 text-white text-sm font-semibold transition-colors shadow-soft whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                            Add
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ( $is_variable ) : ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const heroSection = document.getElementById('hero-product-<?php echo esc_attr($p_id); ?>');
    if (!heroSection) return;

    const variations = <?php echo $variations_json; ?>;
    const priceDisplay = heroSection.querySelector('.price-display');
    const variationIdInput = heroSection.querySelector('.variation_id');
    const addToCartForm = heroSection.querySelector('.hero-add-to-cart-form');
    
    // Find matching variation based on currently selected attributes
    function updateVariation() {
        // Collect current selections
        const currentSelections = {};
        heroSection.querySelectorAll('.attribute_hidden_field').forEach(input => {
            currentSelections[input.name] = input.value;
        });

        // Find match
        let matchedVariation = null;
        for (let i = 0; i < variations.length; i++) {
            let match = true;
            for (let attrName in currentSelections) {
                // Woo saves attributes as 'attribute_pa_size' or 'attribute_package-size'
                // the value could be empty (any) or matched
                let val = currentSelections[attrName];
                if (variations[i].attributes[attrName] !== undefined && variations[i].attributes[attrName] !== '' && variations[i].attributes[attrName] !== val) {
                    match = false;
                    break;
                }
            }
            if (match) {
                matchedVariation = variations[i];
                break;
            }
        }

        if (matchedVariation) {
            priceDisplay.innerHTML = matchedVariation.price_html;
            variationIdInput.value = matchedVariation.variation_id;
        } else {
            variationIdInput.value = '';
        }
    }

    // Attach click events to variation buttons
    const buttons = heroSection.querySelectorAll('.variation-btn');
    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            const attrName = this.dataset.attribute;
            const attrValue = this.dataset.value;

            // Update UI styling for this group
            const group = this.closest('.attribute-selector');
            group.querySelectorAll('.variation-btn').forEach(b => {
                b.classList.remove('bg-brand-600', 'text-white', 'border-brand-600');
                b.classList.add('bg-white', 'text-ink-700', 'border-ink-200');
            });
            this.classList.remove('bg-white', 'text-ink-700', 'border-ink-200');
            this.classList.add('bg-brand-600', 'text-white', 'border-brand-600');

            // Update hidden input
            const hiddenInput = heroSection.querySelector(`input[name="${attrName}"]`);
            if (hiddenInput) {
                hiddenInput.value = attrValue;
            }

            // Recalculate match
            updateVariation();
        });
    });

    // Run once on load to set initial state
    updateVariation();
});
</script>
<?php endif; ?>
