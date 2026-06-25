<?php
// Data sudah dibersihkan & dihitung di Controller — View hanya menampilkan.
$gameId   = (int) $game['id'];
$gameName = SanitizeHelper::escape($game['name']);
$genres   = SanitizeHelper::escape($game['genres'] ?: 'No Genre');
$thumb    = SanitizeHelper::escape($game['thumbnail']);

$price      = (int) $game['price'];
$discount   = (int) ($game['discount'] ?? 0);
$finalPrice = (int) $game['final_price'];
?>

<div class="col-xl-3 col-lg-4 col-md-6 mb-4">
    <div class="card wishlist-card rounded-3 overflow-hidden h-100">

        <div class="position-relative">
            <img src="<?= BASE_URL ?>/assets/img/games/<?= $thumb ?>"
                 class="card-img-top wishlist-card-img"
                 alt="<?= $gameName ?>"
                 onerror="this.src='https://picsum.photos/400/600'">

            <?php if ($discount > 0) : ?>
                <div class="wishlist-discount-badge position-absolute top-0 end-0 m-2">
                    -<?= $discount ?>%
                </div>
            <?php endif; ?>
        </div>

        <div class="card-body p-3 d-flex flex-column justify-content-between">
            <div>
                <h5 class="card-title fw-bold mb-1 text-truncate fs-6" title="<?= $gameName ?>">
                    <?= $gameName ?>
                </h5>
                <p class="text-muted mb-2 wishlist-genre"><?= $genres ?></p>

                <div class="wishlist-price mb-1">
                    <?php if ($price === 0) : ?>
                        <span class="fw-bold text-success">Free to Play</span>
                    <?php elseif ($discount > 0) : ?>
                        <span class="wishlist-old-price me-2"><?= FormatHelper::rupiah($price) ?></span>
                        <span class="fw-bold text-purple-light"><?= FormatHelper::rupiah($finalPrice) ?></span>
                    <?php else : ?>
                        <span class="fw-bold text-purple-light"><?= FormatHelper::rupiah($price) ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="d-flex gap-2 mt-2">
                <a href="<?= BASE_URL ?>/cart/add/<?= $gameId ?>" class="btn btn-play w-100 btn-sm">
                    <i class="bi bi-cart-plus me-1"></i> Beli
                </a>
                <a href="<?= BASE_URL ?>/wishlist/remove/<?= $gameId ?>"
                   class="btn btn-outline-danger btn-sm px-2"
                   title="Hapus dari Wishlist"
                   onclick="return confirm('Hapus game ini dari Wishlist?');">
                    <i class="bi bi-bookmark-dash"></i>
                </a>
            </div>
        </div>

    </div>
</div>
