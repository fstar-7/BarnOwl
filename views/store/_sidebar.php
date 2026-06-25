<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold sidebar-title">
        <i class="bi bi-sliders me-2"></i>Filters
    </h5>
    <?php if (!empty($selectedGenres) || !empty($selectedPlatforms) || $selectedPrice < $maxPriceLimit || $isPromo || $isTopRated) : ?>
        <a href="<?= BASE_URL ?>/games" class="filter-reset-link">Reset</a>
    <?php endif; ?>
</div>

<!-- Genre -->
<div class="filter-group">
    <h6 class="filter-label">Genres</h6>
    <div class="input-group input-group-sm mb-2">
        <span class="input-group-text filter-search-icon">
            <i class="bi bi-search"></i>
        </span>
        <input type="text" id="searchGenre"
               class="form-control form-control-sm filter-search-input"
               placeholder="Search genre...">
    </div>
    <div class="genre-scroll-container" id="genreContainer">
        <?php foreach ($genres as $genre) : ?>
            <div class="form-check genre-item"
                 data-name="<?= strtolower(SanitizeHelper::escape($genre['name'])) ?>">
                <input class="form-check-input filter-checkbox" type="checkbox"
                       name="genres[]"
                       value="<?= (int) $genre['id'] ?>"
                       id="genre_<?= (int) $genre['id'] ?>"
                       <?= in_array($genre['id'], $selectedGenres) ? 'checked' : '' ?>>
                <label class="form-check-label text-truncate d-block"
                       for="genre_<?= (int) $genre['id'] ?>"
                       title="<?= SanitizeHelper::escape($genre['name']) ?>">
                    <?= SanitizeHelper::escape($genre['name']) ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Max Price -->
<div class="filter-group">
    <h6 class="filter-label">Max Price</h6>
    <div class="d-flex justify-content-between text-muted small mb-1">
        <span>Rp0</span>
        <span id="priceValue" class="text-white fw-bold">
            <?= FormatHelper::rupiah($selectedPrice) ?>
        </span>
    </div>
    <input type="range" class="form-range" name="max_price"
           id="priceSlider"
           min="0"
           max="<?= $maxPriceLimit ?>"
           step="10000"
           value="<?= $selectedPrice ?>">
</div>

<!-- Platform -->
<div class="filter-group">
    <h6 class="filter-label">Platform</h6>
    <?php foreach ($platforms as $platform) : ?>
        <div class="form-check">
            <input class="form-check-input filter-checkbox" type="checkbox"
                   name="platforms[]"
                   value="<?= (int) $platform['id'] ?>"
                   id="plat_<?= (int) $platform['id'] ?>"
                   <?= in_array($platform['id'], $selectedPlatforms) ? 'checked' : '' ?>>
            <label class="form-check-label" for="plat_<?= (int) $platform['id'] ?>">
                <?= SanitizeHelper::escape($platform['name']) ?>
            </label>
        </div>
    <?php endforeach; ?>
</div>
