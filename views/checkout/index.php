<div class="checkout-page">
    <div class="checkout-container">

        <h2 class="checkout-title"><i class="bi bi-credit-card-2-back-fill me-2"></i>Checkout</h2>

        <div class="checkout-layout">

            <!-- ── Daftar Item ── -->
            <div class="checkout-items">
                <h5 class="checkout-section-title">Item Pesanan (<?= count($items) ?>)</h5>

                <?php foreach ($items as $item) :
                    $name       = SanitizeHelper::escape($item['name']);
                    $img        = SanitizeHelper::escape($item['image']);
                    $price      = (int) $item['price'];
                    $discount   = (int) ($item['discount'] ?? 0);
                    $finalPrice = (int) $item['finalPrice'];
                ?>
                    <div class="checkout-item">
                        <img src="<?= BASE_URL ?>/assets/img/games/<?= $img ?>"
                             alt="<?= $name ?>"
                             onerror="this.src='https://picsum.photos/200/120'">

                        <div class="checkout-item-info">
                            <h6 class="text-truncate"><?= $name ?></h6>
                            <?php if ($discount > 0) : ?>
                                <span class="checkout-item-old"><?= FormatHelper::rupiah($price) ?></span>
                                <span class="checkout-item-discount">-<?= $discount ?>%</span>
                            <?php endif; ?>
                        </div>

                        <div class="checkout-item-price">
                            <?= $finalPrice === 0 ? 'Free' : FormatHelper::rupiah($finalPrice) ?>
                        </div>

                        <a href="<?= BASE_URL ?>/cart/remove/<?= (int) $item['cart_id'] ?>"
                           class="checkout-item-remove"
                           title="Hapus dari keranjang"
                           onclick="return confirm('Hapus game ini dari keranjang?')">
                            <i class="bi bi-trash3"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- ── Ringkasan & Aksi ── -->
            <div class="checkout-summary">
                <h5 class="checkout-section-title">Ringkasan Pesanan</h5>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span><?= FormatHelper::rupiah($subtotal) ?></span>
                </div>
                <div class="summary-row">
                    <span>Biaya Admin</span>
                    <span class="text-success">Gratis</span>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-row total">
                    <span>Total</span>
                    <span><?= FormatHelper::rupiah($subtotal) ?></span>
                </div>

                <form method="POST" action="<?= BASE_URL ?>/checkout/place">
                    <?= CsrfHelper::field() ?>
                    <button type="submit" class="btn-place-order">
                        <i class="bi bi-lock-fill me-2"></i>Buat Pesanan
                    </button>
                </form>

                <a href="<?= BASE_URL ?>/store" class="btn-continue-shopping">
                    <i class="bi bi-arrow-left me-1"></i> Lanjut Belanja
                </a>

                <p class="checkout-note">
                    <i class="bi bi-info-circle me-1"></i>
                    <?= $subtotal === 0
                        ? 'Semua game di sini gratis — akan langsung masuk ke Library setelah pesanan dibuat.'
                        : 'Pesanan akan diverifikasi oleh Admin sebelum game masuk ke Library-mu.' ?>
                </p>
            </div>

        </div>
    </div>
</div>
