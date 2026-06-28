<?php
$statusLabel = match ($order['status']) {
    'paid'      => 'Selesai',
    'pending'   => 'Menunggu Konfirmasi Admin',
    'cancelled' => 'Dibatalkan',
    default     => ucfirst($order['status']),
};

$statusClass = match ($order['status']) {
    'paid'      => 'success',
    'pending'   => 'pending',
    default     => 'muted',
};
?>

<div class="checkout-page">
    <div class="checkout-container success-container">

        <div class="success-icon"><i class="bi bi-check-circle-fill"></i></div>
        <h2 class="success-heading">Pesanan Berhasil Dibuat!</h2>
        <p class="success-subtext">
            Order <span class="text-mono">#<?= (int) $order['id'] ?></span> &middot;
            <span class="status-badge status-<?= $statusClass ?>"><?= $statusLabel ?></span>
        </p>

        <div class="success-items">
            <?php foreach ($items as $item) :
                $finalPrice = (int) $item['final_price'];
            ?>
                <div class="checkout-item">
                    <img src="<?= BASE_URL ?>/assets/img/games/<?= SanitizeHelper::escape($item['thumbnail']) ?>"
                         alt="<?= SanitizeHelper::escape($item['name']) ?>"
                         onerror="this.src='https://picsum.photos/200/120'">
                    <div class="checkout-item-info">
                        <h6 class="text-truncate"><?= SanitizeHelper::escape($item['name']) ?></h6>
                    </div>
                    <div class="checkout-item-price">
                        <?= $finalPrice === 0 ? 'Free' : FormatHelper::rupiah($finalPrice) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="summary-row total success-total">
            <span>Total Pesanan</span>
            <span><?= FormatHelper::rupiah((int) $order['total']) ?></span>
        </div>

        <?php if ($order['status'] === 'pending') : ?>
            <p class="checkout-note text-center">
                <i class="bi bi-info-circle me-1"></i>
                Admin akan memverifikasi pesananmu. Game otomatis masuk ke Library setelah disetujui.
            </p>
        <?php endif; ?>

        <div class="success-actions">
            <a href="<?= BASE_URL ?>/store" class="btn-continue-shopping btn-outline-block">
                <i class="bi bi-shop me-1"></i> Lanjut Belanja
            </a>
            <a href="<?= BASE_URL ?>/library" class="btn-place-order btn-fit">
                <i class="bi bi-collection-play me-2"></i>Lihat Library
            </a>
        </div>

    </div>
</div>
