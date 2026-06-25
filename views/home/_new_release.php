<div class="container mt-5 px-0">
    <h2 class="section-title">New Release</h2>

    <div class="row">

        <?php if ($bigRelease) : ?>
            <div class="col-lg-8 mb-4">
                <div class="release-big"
                     onclick="window.location='<?= BASE_URL ?>/store/<?= (int) $bigRelease['id'] ?>'">

                    <img src="<?= BASE_URL ?>/assets/img/games/<?= SanitizeHelper::escape($bigRelease['banner'] ?: $bigRelease['thumbnail']) ?>"
                         alt="<?= SanitizeHelper::escape($bigRelease['name']) ?>">

                    <div class="release-overlay">
                        <p><?= SanitizeHelper::escape($bigRelease['genres'] ?: 'New Game') ?></p>
                        <h2><?= SanitizeHelper::escape($bigRelease['name']) ?></h2>
                        <a href="<?= BASE_URL ?>/store/<?= (int) $bigRelease['id'] ?>" class="hero-btn">
                            View Game
                        </a>
                    </div>

                </div>
            </div>
        <?php endif; ?>

        <div class="col-lg-4">
            <?php if (!empty($smallReleases)) : ?>
                <?php foreach ($smallReleases as $release) : ?>
                    <div class="release-small mb-4"
                         onclick="window.location='<?= BASE_URL ?>/store/<?= (int) $release['id'] ?>'">

                        <img src="<?= BASE_URL ?>/assets/img/games/<?= SanitizeHelper::escape($release['banner'] ?: $release['thumbnail']) ?>"
                             alt="<?= SanitizeHelper::escape($release['name']) ?>">

                        <div class="small-overlay">
                            <?= SanitizeHelper::escape($release['name']) ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="p-4 text-muted border border-secondary rounded text-center">
                    Belum ada game New Release tambahan.
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
