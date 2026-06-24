<?php
// Icon map diletakkan di View karena ini murni urusan tampilan, bukan logika bisnis
$genreIcons = [
    'Action'     => '⚔',
    'RPG'        => '🛡',
    'Adventure'  => '🧭',
    'Horror'     => '💀',
    'Strategy'   => '👑',
    'Simulation' => '🛠',
    'Casual'     => '🎮',
];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="section-title mb-0">Browse By Category</h2>
    <a href="<?= BASE_URL ?>/games" class="view-all-btn text-decoration-none">View All →</a>
</div>

<div class="row g-3">
    <?php foreach ($genres as $genre) : ?>
        <div class="col-lg-2 col-md-4">
            <div class="category-box"
                 onclick="window.location='<?= BASE_URL ?>/games?genre_id=<?= (int) $genre['id'] ?>'">

                <div class="category-icon">
                    <?= $genreIcons[$genre['name']] ?? '🎮' ?>
                </div>

                <h5><?= SanitizeHelper::escape($genre['name']) ?></h5>
                <p><?= (int) $genre['total_games'] ?> Games</p>

            </div>
        </div>
    <?php endforeach; ?>
</div>
