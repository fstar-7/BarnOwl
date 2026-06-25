<!-- Quick Tags & Sort -->
<div class="products-top">
    <h5 class="text-secondary mb-0 products-count">
        Showing <span class="text-white fw-bold"><?= (int) $totalGames ?></span> Games Found
    </h5>
    <select class="form-select w-auto store-sort-select" name="sort" onchange="this.form.submit()">
        <option value="popular"      <?= $selectedSort === 'popular'       ? 'selected' : '' ?>>Most Popular</option>
        <option value="latest"       <?= $selectedSort === 'latest'        ? 'selected' : '' ?>>Latest Releases</option>
        <option value="lowest_price" <?= $selectedSort === 'lowest_price'  ? 'selected' : '' ?>>Lowest Price</option>
    </select>
</div>

<div class="quick-tags-container">
    <?php
    // Cek apakah tidak ada filter aktif sama sekali
    $noFilter = empty($selectedGenres)
             && empty($selectedPlatforms)
             && $selectedPrice >= $maxPriceLimit
             && !$isPromo
             && !$isTopRated;
    ?>
    <a href="<?= BASE_URL ?>/games"
       class="tag-bubble <?= $noFilter ? 'active' : '' ?>">
        All Games
    </a>
    <a href="<?= BASE_URL ?>/games?shortcut=promo"
       class="tag-bubble <?= $isPromo ? 'active' : '' ?>">
        <i class="bi bi-tags-fill me-1 text-success"></i> On Sale
    </a>
    <a href="<?= BASE_URL ?>/games?shortcut=top_rated"
       class="tag-bubble <?= $isTopRated ? 'active' : '' ?>">
        <i class="bi bi-fire me-1 text-warning"></i> Top Rated
    </a>
    <a href="<?= BASE_URL ?>/games?max_price=150000"
       class="tag-bubble <?= ($selectedPrice == 150000 && $noFilter) ? 'active' : '' ?>">
        Under Rp150k
    </a>
    <a href="<?= BASE_URL ?>/games?max_price=300000"
       class="tag-bubble <?= ($selectedPrice == 300000 && $noFilter) ? 'active' : '' ?>">
        Under Rp300k
    </a>
</div>

<!-- Game Cards Grid -->
<div class="games-grid">
    <?php if (!empty($games)) : ?>
        <?php foreach ($games as $game) : ?>
            <div class="game-card">

                <div class="card-image">

                    <!-- Status Badges — data sudah disiapkan Controller -->
                    <div class="status-badge-container">
                        <?php if ($game['discount'] > 0) : ?>
                            <div class="badge-dynamic badge-discount">
                                -<?= (int) $game['discount'] ?>% OFF
                            </div>
                        <?php endif; ?>
                        <?php if ($game['badge_hot']) : ?>
                            <div class="badge-dynamic badge-hot">
                                <i class="bi bi-lightning-fill"></i> HOT
                            </div>
                        <?php endif; ?>
                        <?php if ($game['badge_top']) : ?>
                            <div class="badge-dynamic badge-top">
                                <i class="bi bi-star-fill"></i> TOP
                            </div>
                        <?php endif; ?>
                        <?php if ($game['badge_new']) : ?>
                            <div class="badge-dynamic badge-new">NEW</div>
                        <?php endif; ?>
                    </div>

                    <img src="<?= BASE_URL ?>/assets/img/games/<?= SanitizeHelper::escape($game['thumbnail']) ?>"
                         alt="<?= SanitizeHelper::escape($game['name']) ?>"
                         onerror="this.src='https://picsum.photos/400/600'">

                    <!-- Action Overlay -->
                    <div class="card-action-overlay">
                        <a href="<?= BASE_URL ?>/store/<?= (int) $game['id'] ?>"
                           class="btn-overlay-action btn-details" title="View Details">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        <a href="<?= BASE_URL ?>/cart/add/<?= (int) $game['id'] ?>"
                           class="btn-overlay-action" title="Add to Cart">
                            <i class="bi bi-cart-plus-fill"></i>
                        </a>
                        <?php if (in_array($game['id'], $wishlistedIds)) : ?>
                            <a href="<?= BASE_URL ?>/wishlist/remove/<?= (int) $game['id'] ?>"
                               class="btn-overlay-action btn-wishlisted" title="Remove Wishlist">
                                <i class="bi bi-heart-fill"></i>
                            </a>
                        <?php else : ?>
                            <a href="<?= BASE_URL ?>/wishlist/add/<?= (int) $game['id'] ?>"
                               class="btn-overlay-action btn-wishlist" title="Add to Wishlist">
                                <i class="bi bi-heart"></i>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="card-body">
                    <div class="mb-2">
                        <h6 class="game-card-title text-truncate"
                            title="<?= SanitizeHelper::escape($game['name']) ?>">
                            <?= SanitizeHelper::escape($game['name']) ?>
                        </h6>
                        <div class="game-rating">
                            <i class="bi bi-star-fill text-warning me-1"></i>
                            <?= number_format((float) $game['rating'], 1) ?>
                        </div>
                    </div>

                    <!-- Harga — final_price sudah dihitung di Controller -->
                    <div class="price-wrapper mt-auto">
                        <div class="price-detail">
                            <?php if ($game['price'] === 0) : ?>
                                <div class="new-price text-success">Free to Play</div>
                            <?php elseif ($game['discount'] > 0) : ?>
                                <div class="old-price"><?= FormatHelper::rupiah((int) $game['price']) ?></div>
                                <div class="new-price"><?= FormatHelper::rupiah((int) $game['final_price']) ?></div>
                            <?php else : ?>
                                <div class="new-price"><?= FormatHelper::rupiah((int) $game['price']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>

    <?php else : ?>
        <div class="store-empty col-12">
            <i class="bi bi-search d-block mb-3"></i>
            <h5>No Games Match Your Filters</h5>
            <p class="small">Coba kurangi kombinasi filter di sidebar.</p>
        </div>
    <?php endif; ?>
</div>
