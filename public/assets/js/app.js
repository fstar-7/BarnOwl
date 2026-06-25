/**
 * app.js — JavaScript global BarnOwl
 * Diload di semua halaman via footer.php
 */

// ── Auth Modal: toggle antara form Login dan Register ──
function showRegister() {
    document.getElementById('loginForm').style.display    = 'none';
    document.getElementById('registerForm').style.display = 'block';
}

function showLogin() {
    document.getElementById('registerForm').style.display = 'none';
    document.getElementById('loginForm').style.display    = 'block';
}

// ── Newsletter: validasi & notifikasi sederhana ──
document.addEventListener('DOMContentLoaded', function () {
    const btn   = document.getElementById('newsletterBtn');
    const input = btn ? btn.closest('form').querySelector('input[type="email"]') : null;

    if (btn && input) {
        btn.addEventListener('click', function () {
            if (input.value.trim() !== '') {
                alert('Terima kasih! Email kamu berhasil terdaftar di newsletter Barn Owl.');
                input.value = '';
            } else {
                alert('Silakan masukkan email kamu terlebih dahulu.');
            }
        });
    }
});
