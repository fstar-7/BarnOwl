        </div><!-- end admin-content -->
    </div><!-- end admin-main -->
</div><!-- end admin-wrapper -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/admin.js"></script>
<?php if (!empty($extraJs)) : ?>
    <?php foreach ($extraJs as $js) : ?>
        <script src="<?= BASE_URL ?>/assets/js/<?= SanitizeHelper::escape($js) ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
