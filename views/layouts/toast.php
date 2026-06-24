<?php if (isset($_SESSION['toast'])) : ?>
<?php $toast = $_SESSION['toast']; unset($_SESSION['toast']); ?>
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
    <div id="appToast"
         class="toast align-items-center text-white border-0 toast-<?= SanitizeHelper::escape($toast['type']) ?>"
         role="alert" data-bs-autohide="true" data-bs-delay="3500">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <?php
                $icons = [
                    'success' => 'bi-check-circle-fill',
                    'danger'  => 'bi-x-circle-fill',
                    'warning' => 'bi-exclamation-triangle-fill',
                    'info'    => 'bi-info-circle-fill',
                ];
                $icon = $icons[$toast['type']] ?? 'bi-bell-fill';
                ?>
                <i class="bi <?= $icon ?>"></i>
                <span><?= SanitizeHelper::escape($toast['message']) ?></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
<script>
    const toastEl = document.getElementById('appToast');
    if (toastEl) new bootstrap.Toast(toastEl).show();
</script>
<?php endif; ?>
