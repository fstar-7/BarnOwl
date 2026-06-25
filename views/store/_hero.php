<section class="store-hero mb-4">
    <div>
        <h6 class="store-hero-label">
            <?= SanitizeHelper::escape($storeHero['label'] ?? 'Discover') ?>
        </h6>
        <h1>
            <?= SanitizeHelper::escape($storeHero['title'] ?? 'BARN OWL') ?>
            <span><?= SanitizeHelper::escape($storeHero['title_accent'] ?? 'STORE') ?></span>
        </h1>
        <p class="text-secondary mb-0">
            <?= SanitizeHelper::escape($storeHero['description'] ?? 'Temukan game legendaris idamanmu dengan harga terbaik.') ?>
        </p>
    </div>
</section>
