<?php
$file = 'woocommerce/archive-product.php';
$content = file_get_contents($file);

// Replace Badge
$old_badge = '<span class="text-xs uppercase tracking-widest text-brand-700 font-semibold bg-brand-100 rounded-full px-3 py-1.5">Full catalogue</span>';
$new_badge = <<<HTML
<?php 
                \$badge_text = 'Full catalogue';
                if ( is_shop() && ! is_search() ) {
                    \$badge_text = get_field('shop_badge_text', \$shop_page_id) ?: 'Full catalogue';
                }
                ?>
                <span class="text-xs uppercase tracking-widest text-brand-700 font-semibold bg-brand-100 rounded-full px-3 py-1.5"><?php echo esc_html(\$badge_text); ?></span>
HTML;
$content = str_replace($old_badge, $new_badge, $content);

// Replace Description Logic
$old_desc = <<<HTML
<?php 
                    if ( is_product_category() || is_product_tag() ) {
                        \$desc = term_description();
                        if ( ! empty( \$desc ) ) {
                            echo wp_kses_post( \$desc );
                        } else {
                            echo 'Compare prescription and OTC medicines by category, check ratings and prices in AUD, and add to cart in a few taps &mdash; shipped discreetly across Australia.';
                        }
                    } else {
                        echo 'Compare prescription and OTC medicines by category, check ratings and prices in AUD, and add to cart in a few taps &mdash; shipped discreetly across Australia.';
                    }
                    ?>
HTML;

$new_desc = <<<HTML
<?php 
                    if ( is_product_category() || is_product_tag() ) {
                        \$desc = term_description();
                        if ( ! empty( \$desc ) ) {
                            echo wp_kses_post( \$desc );
                        } else {
                            echo 'Compare prescription and OTC medicines by category, check ratings and prices in AUD, and add to cart in a few taps &mdash; shipped discreetly across Australia.';
                        }
                    } else if ( is_shop() && ! is_search() ) {
                        \$shop_desc = get_field('shop_description', \$shop_page_id);
                        if (\$shop_desc) {
                            echo wp_kses_post( wpautop(\$shop_desc) );
                        } else {
                            echo 'Compare prescription and OTC medicines by category, check ratings and prices in AUD, and add to cart in a few taps &mdash; shipped discreetly across Australia.';
                        }
                    } else {
                        echo 'Compare prescription and OTC medicines by category, check ratings and prices in AUD, and add to cart in a few taps &mdash; shipped discreetly across Australia.';
                    }
                    ?>
HTML;
$content = str_replace($old_desc, $new_desc, $content);

file_put_contents($file, $content);
echo "Updated archive-product.php\n";
