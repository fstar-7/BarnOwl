<?php include __DIR__ . '/_header.php'; ?>

<main class="container mb-5 wishlist-main">
    <div class="row">
        <?php if ($total > 0) : ?>
            <?php foreach ($games as $game) : ?>
                <?php include __DIR__ . '/_card.php'; ?>
            <?php endforeach; ?>
        <?php else : ?>
            <?php include __DIR__ . '/_empty.php'; ?>
        <?php endif; ?>
    </div>
</main>
