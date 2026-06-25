<h2 class="section-title mb-4">Featured</h2>

<div class="row">
    <?php foreach ($featuredGames as $game) : ?>
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card game-card clickable-card"
                 onclick="window.location='<?= BASE_URL ?>/store/<?= (int) $game['id'] ?>'">

                <img src="<?= BASE_URL ?>/assets/img/games/<?= SanitizeHelper::escape($game['thumbnail']) ?>"
                     class="card-img-top" alt="<?= SanitizeHelper::escape($game['name']) ?>">

                <?php if (AuthHelper::isLoggedIn()) : ?>
                    <a href="<?= BASE_URL ?>/wishlist/toggle/<?= (int) $game['id'] ?>"
                       class="wishlist-corner" onclick="event.stopPropagation();">
                        <?php if (in_array($game['id'], $wishlistedIds)) : ?>
                            <i class="bi bi-bookmark-fill text-warning"></i>
                        <?php else : ?>
                            <i class="bi bi-bookmark"></i>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>

                <div class="card-body">
                    <h5 class="card-title text-truncate">
                        <?= SanitizeHelper::escape($game['name']) ?>
                    </h5>

                    <div class="card-info mb-3">
                        <span class="genre-tag text-truncate d-inline-block">
                            <?= SanitizeHelper::escape($game['genres'] ?: 'No Genre') ?>
                        </span>
                        <span class="meta-item text-warning">
                            <i class="bi bi-star-fill"></i>
                            <?= SanitizeHelper::escape($game['rating']) ?>
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-eye"></i>
                            <?= number_format((int) $game['views'], 0, ',', '.') ?>
                        </span>
                    </div>

                    <?php
                    // Data sudah disiapkan Controller — View hanya menampilkan
                    $price     = (int) $game['price'];
                    $discount  = (int) ($game['discount'] ?? 0);
                    $finalPrice = (int) $game['final_price'];
                    ?>

                    <div class="price-wrapper">
                        <?php if ($price === 0) : ?>
                            <div class="price-detail">
                                <div class="new-price text-success">Free to Play</div>
                            </div>

                        <?php elseif ($discount > 0) : ?>
                            <div class="discount-box">-<?= $discount ?>%</div>
                            <div class="price-detail">
                                <div class="old-price"><?= FormatHelper::rupiah($price) ?></div>
                                <div class="new-price">
                                    <?= $finalPrice === 0
                                        ? '<span class="text-success">Free</span>'
                                        : FormatHelper::rupiah($finalPrice) ?>
                                </div>
                            </div>

                        <?php else : ?>
                            <div class="price-detail">
                                <div class="new-price"><?= FormatHelper::rupiah($price) ?></div>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
