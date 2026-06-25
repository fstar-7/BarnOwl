<div class="mt-5">
    <h4 class="top-selling-title mb-3">Top Selling This Week</h4>
    <div class="small-grid">
        <?php foreach ($topSelling as $top) : ?>
            <a href="<?= BASE_URL ?>/store/<?= (int) $top['id'] ?>"
               class="text-decoration-none small-card d-block">
                <img src="<?= BASE_URL ?>/assets/img/games/<?= SanitizeHelper::escape($top['thumbnail']) ?>"
                     alt="<?= SanitizeHelper::escape($top['name']) ?>"
                     onerror="this.src='https://picsum.photos/400/300'">
                <p class="fw-medium text-truncate">
                    <?= SanitizeHelper::escape($top['name']) ?>
                </p>
            </a>
        <?php endforeach; ?>
    </div>
</div>
