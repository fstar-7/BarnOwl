/**
 * library.js — JavaScript khusus halaman Library
 */

document.addEventListener('DOMContentLoaded', function () {

    // Fungsi dipanggil dari onclick di _card.php
    window.showDownloadInfo = function (gameName) {
        alert('Game "' + gameName + '" adalah game digital.\nKamu dapat memainkannya langsung dari browser atau launcher Barn Owl.');
    };

});
