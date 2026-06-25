<div class="store-page">
    <div class="store-container">

        <?php include __DIR__ . '/_hero.php'; ?>

        <form method="GET" action="<?= BASE_URL ?>/games" id="filterForm">

            <div class="store-layout">

                <aside class="sidebar">
                    <?php include __DIR__ . '/_sidebar.php'; ?>
                </aside>

                <main>
                    <?php include __DIR__ . '/_game_list.php'; ?>
                    <?php include __DIR__ . '/_pagination.php'; ?>
                    <?php include __DIR__ . '/_sale_banner.php'; ?>
                    <?php include __DIR__ . '/_top_selling.php'; ?>
                </main>

            </div>

        </form>
    </div>
</div>