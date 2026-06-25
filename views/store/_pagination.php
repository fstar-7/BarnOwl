<?php if ($totalPages > 1) : ?>
<nav class="mt-5">
    <ul class="pagination justify-content-center">
        <?php for ($p = 1; $p <= $totalPages; $p++) : ?>
            <?php
            // Pertahankan semua parameter filter yang ada, hanya ganti page
            $params         = $_GET;
            $params['page'] = $p;
            $pageUrl        = BASE_URL . '/games?' . http_build_query($params);
            ?>
            <li class="page-item <?= $p === $currentPage ? 'active' : '' ?>">
                <a class="page-link rounded-3 mx-1"
                   href="<?= SanitizeHelper::escape($pageUrl) ?>">
                    <?= $p ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>
