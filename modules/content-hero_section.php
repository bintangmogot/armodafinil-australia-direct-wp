<?php
/**
 * Hero Section Module Template
 * 
 * Sub Fields: badge, title, subtitle, description, cta_label, cta_url, background_image
 */

$badge       = get_sub_field('badge');
$title       = get_sub_field('title');
$subtitle    = get_sub_field('subtitle');
$description = get_sub_field('description');
$cta_label   = get_sub_field('cta_label');
$cta_url     = get_sub_field('cta_url');
$bg_image_id = get_sub_field('background_image');

$bg_image_url = '';
if ( $bg_image_id ) {
    $bg_image_url = is_array($bg_image_id) ? ($bg_image_id['url'] ?? '') : wp_get_attachment_image_url($bg_image_id, 'full');
}
if ( ! $bg_image_url ) {
    $bg_image_url = get_theme_file_uri('/assets/images/homepage-armodafinil-direct.png');
}

$has_text_content = $badge || $title || $subtitle || $description || $cta_label || $cta_url;
?>

<style>
.hero-landscape-section {
    position: relative;
    width: 100%;
    overflow: hidden;
    background-color: #dffff9;
    display: flex;
    align-items: center;
}
.hero-bg-layer {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    background-position: right center;
    background-size: cover;
    background-repeat: no-repeat;
}
.hero-gradient-overlay {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    width: 50%;
    pointer-events: none;
    z-index: 1;
    background: linear-gradient(to right, #dffff9 0%, rgba(223, 255, 249, 0.95) 55%, rgba(223, 255, 249, 0) 100%);
}
.hero-text-col {
    position: relative;
    z-index: 10;
    text-align: left;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* Mobile: Compact Landscape Layout */
@media (max-width: 639px) {
    .hero-landscape-section {
        min-height: 180px;
        padding: 12px 0;
    }
    .hero-text-col {
        width: 44%;
        max-width: 175px;
    }
    .hero-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        font-size: 7.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 2px 7px;
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.92);
        border: 1px solid rgba(13, 148, 136, 0.3);
        color: #0f766e;
        margin-bottom: 4px;
        max-width: fit-content;
    }
    .hero-badge-pill svg {
        width: 8px;
        height: 8px;
    }
    .hero-title {
        font-family: var(--font-serif, Georgia, serif);
        font-size: 13px;
        line-height: 1.15;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }
    .hero-subtitle {
        font-size: 8.5px;
        line-height: 1.25;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .hero-desc {
        display: none;
    }
    .hero-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        height: 24px;
        padding: 0 10px;
        border-radius: 9999px;
        background-color: #0d9488;
        color: #ffffff;
        font-size: 8.5px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 2px 4px rgba(13, 148, 136, 0.25);
        max-width: fit-content;
    }
    .hero-cta-btn svg {
        width: 9px;
        height: 9px;
    }
}

/* Tablet & Desktop */
@media (min-width: 640px) {
    .hero-landscape-section {
        min-height: 380px;
        padding: 40px 0;
    }
    .hero-text-col {
        width: 44%;
        max-width: 520px;
    }
    .hero-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        padding: 4px 12px;
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(13, 148, 136, 0.35);
        color: #0f766e;
        margin-bottom: 12px;
        max-width: fit-content;
    }
    .hero-badge-pill svg {
        width: 14px;
        height: 14px;
    }
    .hero-title {
        font-family: var(--font-serif, Georgia, serif);
        font-size: clamp(26px, 3.2vw, 48px);
        line-height: 1.08;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 12px;
    }
    .hero-subtitle {
        font-size: clamp(14px, 1.4vw, 19px);
        line-height: 1.45;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
    }
    .hero-desc {
        font-size: clamp(12px, 1.1vw, 15px);
        line-height: 1.5;
        color: #475569;
        margin-bottom: 16px;
    }
    .hero-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 44px;
        padding: 0 22px;
        border-radius: 9999px;
        background-color: #0d9488;
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3);
        transition: background-color 0.2s, transform 0.2s;
        max-width: fit-content;
    }
    .hero-cta-btn:hover {
        background-color: #0f766e;
        transform: translateY(-1px);
    }
    .hero-cta-btn svg {
        width: 16px;
        height: 16px;
    }
}

@media (min-width: 1024px) {
    .hero-landscape-section {
        min-height: 480px;
        padding: 60px 0;
    }
}
</style>

<section class="hero-landscape-section">
    <!-- Background Hero Landscape Image -->
    <div class="hero-bg-layer" style="background-image: url('<?php echo esc_url($bg_image_url); ?>');"></div>
    
    <!-- Seamless Left Gradient Blend for Maximum Legibility -->
    <div class="hero-gradient-overlay"></div>

    <!-- Content Container -->
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if ( $has_text_content ) : ?>
        <div class="hero-text-col animate-fadeup">
            
            <?php if ( $badge ) : ?>
            <div>
                <span class="hero-badge-pill">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    <span><?php echo esc_html( $badge ); ?></span>
                </span>
            </div>
            <?php endif; ?>

            <?php if ( $title ) : ?>
            <h1 class="hero-title">
                <?php echo wp_kses_post( $title ); ?>
            </h1>
            <?php endif; ?>

            <?php if ( $subtitle ) : ?>
            <h2 class="hero-subtitle font-bold text-base md:text-md xl:text-lg text-ink-800 leading-snug sm:leading-relaxed line-clamp-3 sm:line-clamp-none">
                <strong><?php echo wp_kses_post( $subtitle ); ?></strong>
            </h2>
            <?php endif; ?>

            <?php if ( $description ) : ?>
            <p class="hero-desc">
                <?php echo wp_kses_post( $description ); ?>
            </p>
            <?php endif; ?>

            <?php if ( $cta_url && $cta_label ) : ?>
            <div>
                <a href="<?php echo esc_url( $cta_url ); ?>" class="hero-cta-btn">
                    <span><?php echo esc_html( $cta_label ); ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
            <?php endif; ?>

        </div>
        <?php endif; ?>
    </div>
</section>
