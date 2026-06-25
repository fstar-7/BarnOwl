<?php if ($bannerSale) : ?>
<?php
// Tentukan background style — logika presentasi di View boleh ada di sini
// karena ini murni urusan tampilan (bukan logika bisnis)
if ($bannerSale['bg_mode'] === 'image' && !empty($bannerSale['bg_image'])) {
    $opacity  = (float) ($bannerSale['overlay_opacity'] ?? 0.4);
    $bgStyle  = "background: linear-gradient(rgba(0,0,0,{$opacity}), rgba(0,0,0,{$opacity})),
                 url('" . BASE_URL . "/assets/img/carousel/" . SanitizeHelper::escape($bannerSale['bg_image']) . "')
                 center/cover no-repeat;";
} else {
    $from    = SanitizeHelper::escape($bannerSale['bg_color_from'] ?? '#4c1d95');
    $to      = SanitizeHelper::escape($bannerSale['bg_color_to']   ?? '#9333ea');
    $bgStyle = "background: linear-gradient(135deg, {$from}, {$to});";
}
?>
<div class="sale-banner" style="<?= $bgStyle ?>">
    <h2 class="fw-black"><?= SanitizeHelper::escape($bannerSale['title']) ?></h2>

    <?php if (!empty($bannerSale['discount_text'])) : ?>
        <h4 class="mb-2 text-white-50">
            UP TO <span class="sale-accent"><?= SanitizeHelper::escape($bannerSale['discount_text']) ?></span>
        </h4>
    <?php endif; ?>

    <?php if (!empty($bannerSale['subtitle'])) : ?>
        <p class="mb-1 fw-semibold text-white-50">
            <?= SanitizeHelper::escape($bannerSale['subtitle']) ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($bannerSale['description'])) : ?>
        <p class="mb-3 text-secondary small">
            <?= SanitizeHelper::escape($bannerSale['description']) ?>
        </p>
    <?php endif; ?>

    <a href="<?= SanitizeHelper::escape($bannerSale['link_url'] ?? BASE_URL . '/games?shortcut=promo') ?>"
       class="btn btn-light px-4 py-2 rounded-pill fw-bold text-dark shadow-sm sale-btn">
        <?= SanitizeHelper::escape($bannerSale['button_text'] ?? 'Browse Deals') ?>
    </a>
</div>
<?php endif; ?>
