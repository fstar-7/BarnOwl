<?php
// Data sudah bersih dari Controller — View hanya menampilkan
$gameId   = (int) $game['id'];
$gameName = SanitizeHelper::escape($game['name']);
$genres   = SanitizeHelper::escape($game['genres'] ?? 'No Genre');
$thumb    = SanitizeHelper::escape($game['thumbnail']);
$date     = isset($game['purchased_at'])
            ? date('d M Y', strtotime($game['purchased_at']))
            : '-';
?>

<div class="col-xl-3 col-lg-4 col-md-6 mb-4">
    <div class="card library-card rounded-3 overflow-hidden h-100">

        <div class="position-relative">
            <img src="<?= BASE_URL ?>/assets/img/games/<?= $thumb ?>"
                 class="card-img-top library-card-img"
                 alt="<?= $gameName ?>">
            <div class="position-absolute top-0 start-0 p-3">
                <span class="library-status-badge">Ready to Play</span>
            </div>
        </div>

        <div class="card-body p-3 d-flex flex-column justify-content-between">
            <div>
                <h5 class="card-title fw-bold mb-1 text-truncate fs-6" title="<?= $gameName ?>">
                    <?= $gameName ?>
                </h5>
                <p class="text-muted mb-1 library-genre"><?= $genres ?></p>
                <p class="text-muted library-date">
                    <i class="bi bi-calendar3 me-1"></i><?= $date ?>
                </p>
            </div>

            <div class="d-grid gap-2 mt-2">
                <a href="<?= BASE_URL ?>/games/play/<?= $gameId ?>"
                   class="btn btn-play py-2 btn-sm rounded-2">
                    <i class="bi bi-play-fill me-1"></i> Play Game
                </a>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm w-100 py-1 opacity-75"
                            title="Download Game Files"
                            onclick="showDownloadInfo('<?= addslashes($gameName) ?>')">
                        <i class="bi bi-download"></i>
                    </button>
                    <a href="<?= BASE_URL ?>/store/<?= $gameId ?>"
                       class="btn btn-outline-secondary btn-sm w-100 py-1 opacity-75"
                       title="Lihat Halaman Toko">
                        <i class="bi bi-shop"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
