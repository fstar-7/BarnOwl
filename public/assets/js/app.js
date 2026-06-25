/**
 * app.js — JavaScript global BarnOwl
 * Load urutan di footer: Bootstrap JS → app.js
 * Jadi Bootstrap sudah pasti tersedia saat app.js dijalankan
 */

document.addEventListener('DOMContentLoaded', function () {

    // ── 1. Toast — Bootstrap sudah load, aman dipanggil ──
    const toastEl = document.getElementById('appToast');
    if (toastEl) {
        new bootstrap.Toast(toastEl, {
            autohide: true,
            delay: 3500,
        }).show();
    }

    // ── 2. Newsletter ──
    const newsletterBtn   = document.getElementById('newsletterBtn');
    const newsletterEmail = document.getElementById('newsletterEmail');

    if (newsletterBtn && newsletterEmail) {
        newsletterBtn.addEventListener('click', function () {
            if (newsletterEmail.value.trim() !== '') {
                alert('Terima kasih! Email kamu berhasil terdaftar di newsletter Barn Owl.');
                newsletterEmail.value = '';
            } else {
                alert('Silakan masukkan email kamu terlebih dahulu.');
            }
        });
    }

});

// ── 3. Auth Modal toggle — dipanggil onclick di auth.php ──
// Tidak perlu DOMContentLoaded karena dipanggil saat user klik
function showRegister() {
    document.getElementById('loginForm').style.display    = 'none';
    document.getElementById('registerForm').style.display = 'block';
}

function showLogin() {
    document.getElementById('registerForm').style.display = 'none';
    document.getElementById('loginForm').style.display    = 'block';
}
