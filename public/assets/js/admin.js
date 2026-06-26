/**
 * admin.js — JavaScript khusus Admin Panel BarnOwl
 */

document.addEventListener('DOMContentLoaded', function () {

    // ── 1. Toast notifikasi ──
    const toastEl = document.getElementById('appToast');
    if (toastEl) {
        new bootstrap.Toast(toastEl, { autohide: true, delay: 3500 }).show();
    }

    // ── 2. Preview gambar sebelum upload ──
    window.previewImage = function (input) {
        const preview = document.getElementById('imgPreview')
                     || document.getElementById('imgPreviewPlaceholder');
        if (!preview || !input.files[0]) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            // Kalau elemen placeholder, ganti dengan <img>
            if (preview.tagName !== 'IMG') {
                const img = document.createElement('img');
                img.id        = 'imgPreview';
                img.className = 'img-preview mb-2';
                img.src       = e.target.result;
                preview.replaceWith(img);
            } else {
                preview.src = e.target.result;
            }
        };
        reader.readAsDataURL(input.files[0]);
    };

    // ── 3. Color picker — update text input sebelahnya ──
    document.querySelectorAll('input[type="color"]').forEach(function (picker) {
        const textInput = picker.nextElementSibling;
        if (!textInput) return;

        picker.addEventListener('input', function () {
            textInput.value = this.value;
        });
    });

});
