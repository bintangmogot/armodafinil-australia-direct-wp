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

$bg_image_url   = '';
$bg_image_title = '';

if ( $bg_image_id ) {
    if ( is_array( $bg_image_id ) ) {
        $bg_image_url   = $bg_image_id['url'] ?? '';
        $bg_image_title = $bg_image_id['title'] ?? '';
        $att_id         = $bg_image_id['ID'] ?? ($bg_image_id['id'] ?? 0);
    } else {
        $att_id         = (int) $bg_image_id;
        $bg_image_url   = wp_get_attachment_image_url( $att_id, 'full' );
        $bg_image_title = get_the_title( $att_id );
    }
    if ( ! $bg_image_title && ! empty( $att_id ) ) {
        $bg_image_title = get_the_title( $att_id );
    }
}
if ( ! $bg_image_url ) {
    $bg_image_url = get_theme_file_uri('/assets/images/homepage-armodafinil-direct.png');
}
if ( ! $bg_image_title ) {
    $bg_image_title = get_bloginfo('name');
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
    pointer-events: auto;
    cursor: default;
    background-position: right top;
    background-size: cover;
    background-repeat: no-repeat;
}
.hero-text-col {
    position: relative;
    z-index: 10;
    text-align: left;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 20px;
    margin: 0;
}
.hero-text-col > * {
    margin: 0;
}

/* Mobile: Compact Landscape Layout */
@media (max-width: 639px) {
    .hero-landscape-section {
        min-height: 230px;
        padding: 16px 0;
    }
    .hero-text-col {
        width: 72%;
        max-width: 295px;
        gap: 12px;
    }
    .hero-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 3.5px;
        font-size: 8px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        white-space: nowrap;
        padding: 2.5px 7.5px;
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.94);
        border: 1px solid rgba(13, 148, 136, 0.35);
        color: #0f766e;
        margin: 0;
        max-width: fit-content;
    }
    .hero-badge-pill svg {
        width: 8px;
        height: 8px;
    }
    .hero-title {
        font-family: var(--font-serif, Georgia, serif);
        font-size: clamp(17px, 5.2vw, 22px);
        line-height: 1.14;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    .hero-subtitle {
        font-size: clamp(15.75px, 4.05vw, 18px);
        line-height: 1.36;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .hero-desc {
        display: block;
        font-size: clamp(12.5px, 3.2vw, 14px);
        line-height: 1.45;
        color: #475569;
        margin: 0;
    }
    .hero-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        height: 34px;
        padding: 0 15px;
        border-radius: 9999px;
        background-color: #0d9488;
        color: #ffffff;
        font-size: 11px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(13, 148, 136, 0.28);
        margin: 0;
        max-width: fit-content;
    }
    .hero-cta-btn svg {
        width: 10px;
        height: 10px;
    }
}

/* Tablet & Desktop */
@media (min-width: 640px) {
    .hero-landscape-section {
        min-height: 420px;
        padding: 48px 0;
    }
    .hero-text-col {
        width: 55%;
        max-width: 660px;
        gap: 20px;
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
        margin: 0;
        max-width: fit-content;
    }
    .hero-badge-pill svg {
        width: 14px;
        height: 14px;
    }
    .hero-title {
        font-family: var(--font-serif, Georgia, serif);
        font-size: clamp(28px, 3.3vw, 48px);
        line-height: 1.1;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    .hero-subtitle {
        font-size: clamp(22.5px, 2.18vw, 28.5px);
        line-height: 1.48;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    .hero-desc {
        font-size: clamp(18px, 1.65vw, 22.5px);
        line-height: 1.55;
        color: #475569;
        margin: 0;
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
        margin: 0;
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
        min-height: 520px;
        padding: 64px 0;
    }
    .hero-text-col {
        width: 56%;
        max-width: 720px;
        gap: 24px;
    }
}

@media (min-width: 1280px) {
    .hero-landscape-section {
        min-height: 560px;
    }
    .hero-text-col {
        width: 58%;
        max-width: 780px;
        gap: 24px;
    }
}
</style>

<section class="hero-landscape-section" title="<?php echo esc_attr( $bg_image_title ); ?>">
    <!-- Background Hero Landscape Image (Title appears on hover via mouse pointer) -->
    <div class="hero-bg-layer"
        style="background-image: url('<?php echo esc_url($bg_image_url); ?>');"
        title="<?php echo esc_attr( $bg_image_title ); ?>"
        aria-label="<?php echo esc_attr( $bg_image_title ); ?>"
        role="img">
    </div>

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
            <h2 class="hero-subtitle">
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