/**
 * store.js — JavaScript khusus halaman Store
 * Tidak ada inline script di view, semua dipindah ke sini
 */

document.addEventListener('DOMContentLoaded', function () {

    // ── 1. Auto-submit saat checkbox filter berubah ──
    document.querySelectorAll('.filter-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            document.getElementById('filterForm').submit();
        });
    });

    // ── 2. Price range slider — tampilkan nilai real-time ──
    const priceSlider = document.getElementById('priceSlider');
    const priceValue  = document.getElementById('priceValue');

    if (priceSlider && priceValue) {
        priceSlider.addEventListener('input', function () {
            const value = parseInt(this.value);
            priceValue.textContent = 'Rp' + value.toLocaleString('id-ID');
        });

        // Submit saat user lepas slider
        priceSlider.addEventListener('change', function () {
            document.getElementById('filterForm').submit();
        });
    }

    // ── 3. Search genre di sidebar ──
    const searchInput = document.getElementById('searchGenre');
    const genreItems  = document.querySelectorAll('.genre-item');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            genreItems.forEach(function (item) {
                const name = item.getAttribute('data-name') || '';
                item.style.display = name.includes(keyword) ? 'block' : 'none';
            });
        });
    }

});
