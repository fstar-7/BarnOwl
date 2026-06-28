<?php
// Data sudah dibersihkan & dihitung di Controller — View hanya menampilkan.
$gameId   = (int) $game['id'];
$gameName = SanitizeHelper::escape($game['name']);
$genres   = SanitizeHelper::escape($game['genres'] ?: 'Uncategorized');
$thumb    = SanitizeHelper::escape($game['thumbnail']);
$banner   = SanitizeHelper::escape($game['banner'] ?: $game['thumbnail']);
$desc     = SanitizeHelper::escape($game['description'] ?: 'Belum ada deskripsi untuk game ini.');

$price      = (int) $game['price'];
$discount   = (int) ($game['discount'] ?? 0);
$finalPrice = (int) $game['final_price'];
?>

<div class="detail-page">

    <!-- ── Breadcrumb ── -->
    <div class="detail-breadcrumb-wrap">
        <div class="detail-breadcrumb">
            <a href="<?= BASE_URL ?>/store">Store</a>
            <i class="bi bi-chevron-right"></i>
            <span class="text-truncate"><?= $gameName ?></span>
        </div>
    </div>

    <!-- ── Hero Banner ── -->
    <section class="detail-hero" style="background-image:url('<?= BASE_URL ?>/assets/img/games/<?= $banner ?>')">
        <div class="detail-hero-overlay"></div>
        <div class="detail-hero-content">
            <div class="status-badge-container detail-badges">
                <?php if ($discount > 0) : ?>
                    <div class="badge-dynamic badge-discount">-<?= $discount ?>% OFF</div>
                <?php endif; ?>
                <?php if ($game['badge_hot']) : ?>
                    <div class="badge-dynamic badge-hot"><i class="bi bi-lightning-fill"></i> HOT</div>
                <?php endif; ?>
                <?php if ($game['badge_top']) : ?>
                    <div class="badge-dynamic badge-top"><i class="bi bi-star-fill"></i> TOP</div>
                <?php endif; ?>
                <?php if ($game['badge_new']) : ?>
                    <div class="badge-dynamic badge-new">NEW</div>
                <?php endif; ?>
            </div>

            <h1 class="detail-title"><?= $gameName ?></h1>

            <div class="detail-meta">
                <span><i class="bi bi-star-fill text-warning me-1"></i><?= number_format((float) $game['rating'], 1) ?></span>
                <span><i class="bi bi-eye-fill me-1"></i><?= number_format((int) $game['views']) ?> views</span>
                <span><i class="bi bi-tag-fill me-1"></i><?= $genres ?></span>
            </div>
        </div>
    </section>

    <div class="detail-container">
        <div class="detail-layout">

            <!-- ── LEFT: Info & Description ── -->
            <div class="detail-main">

                <div class="detail-card">
                    <h5 class="detail-card-title"><i class="bi bi-info-circle-fill me-2"></i>About This Game</h5>
                    <p class="detail-description"><?= nl2br($desc) ?></p>
                </div>

                <?php if (!empty($platforms)) : ?>
                    <div class="detail-card">
                        <h5 class="detail-card-title"><i class="bi bi-controller me-2"></i>Available Platforms</h5>
                        <div class="platform-chip-list">
                            <?php foreach ($platforms as $platform) : ?>
                                <span class="platform-chip">
                                    <i class="bi bi-check2 me-1"></i><?= SanitizeHelper::escape($platform['name']) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <!-- ── RIGHT: Purchase Box ── -->
            <aside class="detail-sidebar">
                <div class="purchase-card">

                    <img src="<?= BASE_URL ?>/assets/img/games/<?= $thumb ?>"
                         alt="<?= $gameName ?>"
                         class="purchase-thumb"
                         onerror="this.src='https://picsum.photos/400/260'">

                    <div class="purchase-price-block">
                        <?php if ($price === 0) : ?>
                            <div class="purchase-price-free">Free to Play</div>
                        <?php elseif ($discount > 0) : ?>
                            <div class="purchase-old-price"><?= FormatHelper::rupiah($price) ?></div>
                            <div class="purchase-new-price"><?= FormatHelper::rupiah($finalPrice) ?></div>
                        <?php else : ?>
                            <div class="purchase-new-price"><?= FormatHelper::rupiah($price) ?></div>
                        <?php endif; ?>
                    </div>

                    <?php if ($isOwned) : ?>
                        <div class="purchase-owned-note">
                            <i class="bi bi-check-circle-fill me-1"></i> Game ini sudah ada di Library-mu
                        </div>
                        <a href="<?= BASE_URL ?>/library" class="btn-purchase-action btn-owned">
                            <i class="bi bi-play-fill me-2"></i>Ke Library
                        </a>
                    <?php elseif ($isInCart) : ?>
                        <button type="button" class="btn-purchase-action btn-in-cart"
                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
                            <i class="bi bi-cart-check-fill me-2"></i>Sudah di Keranjang
                        </button>
                    <?php else : ?>
                        <a href="<?= BASE_URL ?>/cart/add/<?= $gameId ?>" class="btn-purchase-action btn-add-cart">
                            <i class="bi bi-cart-plus-fill me-2"></i>
                            <?= $price === 0 ? 'Tambahkan (Gratis)' : 'Tambahkan ke Keranjang' ?>
                        </a>
                    <?php endif; ?>

                    <a href="<?= BASE_URL ?>/wishlist/toggle/<?= $gameId ?>"
                       class="btn-purchase-wishlist <?= $isWishlisted ? 'active' : '' ?>">
                        <i class="bi <?= $isWishlisted ? 'bi-heart-fill' : 'bi-heart' ?> me-2"></i>
                        <?= $isWishlisted ? 'Tersimpan di Wishlist' : 'Tambah ke Wishlist' ?>
                    </a>

                    <ul class="purchase-info-list">
                        <li><i class="bi bi-shield-check"></i> Aktivasi instan setelah pesanan dikonfirmasi</li>
                        <li><i class="bi bi-arrow-repeat"></i> Update game gratis selamanya</li>
                        <li><i class="bi bi-headset"></i> Butuh bantuan? <a href="<?= BASE_URL ?>/support">Hubungi Support</a></li>
                    </ul>

                </div>
            </aside>

        </div>

        <!-- ── Related Games ── -->
        <?php if (!empty($related)) : ?>
            <section class="related-section">
                <h4 class="related-title">You May Also Like</h4>
                <div class="related-grid">
                    <?php foreach ($related as $r) :
                        $rPrice = (int) $r['price'];
                        $rDisc  = (int) ($r['discount'] ?? 0);
                        $rFinal = (int) $r['final_price'];
                    ?>
                        <a href="<?= BASE_URL ?>/store/<?= (int) $r['id'] ?>" class="related-card">
                            <div class="related-card-img">
                                <img src="<?= BASE_URL ?>/assets/img/games/<?= SanitizeHelper::escape($r['thumbnail']) ?>"
                                     alt="<?= SanitizeHelper::escape($r['name']) ?>"
                                     onerror="this.src='https://picsum.photos/400/260'">
                                <?php if ($rDisc > 0) : ?>
                                    <span class="related-discount">-<?= $rDisc ?>%</span>
                                <?php endif; ?>
                            </div>
                            <div class="related-card-body">
                                <h6 class="text-truncate"><?= SanitizeHelper::escape($r['name']) ?></h6>
                                <?php if ($rPrice === 0) : ?>
                                    <span class="related-price free">Free to Play</span>
                                <?php elseif ($rDisc > 0) : ?>
                                    <span class="related-price-old"><?= FormatHelper::rupiah($rPrice) ?></span>
                                    <span class="related-price"><?= FormatHelper::rupiah($rFinal) ?></span>
                                <?php else : ?>
                                    <span class="related-price"><?= FormatHelper::rupiah($rPrice) ?></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

    </div>
</div>
