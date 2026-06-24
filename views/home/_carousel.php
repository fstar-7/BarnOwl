<div id="homeCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">

    <div class="carousel-indicators">
        <?php foreach ($carousels as $i => $slide) : ?>
            <button type="button"
                    data-bs-target="#homeCarousel"
                    data-bs-slide-to="<?= $i ?>"
                    <?= $i === 0 ? 'class="active"' : '' ?>></button>
        <?php endforeach; ?>
    </div>

    <div class="carousel-inner">
        <?php foreach ($carousels as $i => $slide) : ?>
            <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">

                <img src="<?= BASE_URL ?>/assets/img/carousel/<?= SanitizeHelper::escape($slide['image']) ?>"
                     class="d-block w-100" alt="<?= SanitizeHelper::escape($slide['title']) ?>">

                <div class="carousel-caption d-none d-md-block">
                    <p class="text-uppercase fw-bold text-warning">
                        <?= SanitizeHelper::escape($slide['subtitle']) ?>
                    </p>
                    <h5><?= SanitizeHelper::escape($slide['title']) ?></h5>
                    <p><?= SanitizeHelper::escape($slide['description']) ?></p>

                    <?php if ($slide['game_id']) : ?>
                        <a href="<?= BASE_URL ?>/games/<?= (int) $slide['game_id'] ?>" class="hero-btn">
                            Lihat Game
                        </a>
                    <?php else : ?>
                        <a href="#store-section" class="hero-btn">Browse Store</a>
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>

</div>
