<div class="container mt-5" style="min-height: 70vh;">
    
    <h1 class="text-center mb-4" style="color: #8a4dff;"><?= SanitizeHelper::escape($mainMessage); ?></h1>
    
    <div class="row justify-content-center gap-3">
        <?php foreach ($games as $game) : ?>
            <div class="card p-0" style="width: 14rem; background: #1a1d24; border: 1px solid #333;">
                
                <img src="<?= BASE_URL ?>/assets/img/games/<?= SanitizeHelper::escape($game['image']); ?>" class="card-img-top" alt="<?= SanitizeHelper::escape($game['name']); ?>" style="height: 250px; object-fit: cover;">
                
                <div class="card-body text-white">
                    <h5 class="card-title" style="font-size: 1.1rem;"><?= SanitizeHelper::escape($game['name']); ?></h5>
                    
                    <p class="card-text fw-bold" style="color: #10b981;">
                        <?= FormatHelper::rupiah($game['price']); ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
</div>