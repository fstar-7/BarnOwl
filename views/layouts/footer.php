<!-- footer.php yang bersih -->
<footer class="site-footer">
    <div class="container">
        <div class="row gy-4">

            <div class="col-lg-4">
                <div class="footer-brand">
                    <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Logo" width="38" height="38">
                    <h4>Barn Owl</h4>
                </div>
                <p class="footer-text">
                    Your trusted game marketplace. Explore worlds, build collections.
                </p>
                <div class="footer-contact">
                    <div><i class="bi bi-geo-alt"></i> Jl. Edukasi No. 28, Indonesia</div>
                    <div><i class="bi bi-envelope"></i> support@barnowl.com</div>
                    <div><i class="bi bi-telephone"></i> +62 821-0271-4000</div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4 ps-lg-4">
                <!-- Inline style dihapus, diganti class 'footer-heading' -->
                <h5 class="text-white fw-bold mb-3 footer-heading">Navigation</h5>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <!-- URL diperbarui menggunakan routing BASE_URL -->
                    <li><a href="<?= BASE_URL ?>/" class="text-decoration-none text-secondary text-hover-purple">Home</a></li>
                    <li><a href="<?= BASE_URL ?>/games" class="text-decoration-none text-secondary text-hover-purple">Store</a></li>
                    <li><a href="<?= BASE_URL ?>/library" class="text-decoration-none text-secondary text-hover-purple">My Library</a></li>
                    <li><a href="<?= BASE_URL ?>/wishlist" class="text-decoration-none text-secondary text-hover-purple">Wishlist</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-4">
                <!-- Inline style dihapus, diganti class 'footer-heading' -->
                <h5 class="text-white fw-bold mb-3 footer-heading">Categories</h5>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <!-- URL diperbarui menggunakan routing BASE_URL -->
                    <li><a href="<?= BASE_URL ?>/games?genre=Action" class="text-decoration-none text-secondary text-hover-purple">Action Games</a></li>
                    <li><a href="<?= BASE_URL ?>/games?genre=RPG" class="text-decoration-none text-secondary text-hover-purple">RPG Games</a></li>
                    <li><a href="<?= BASE_URL ?>/games?genre=Adventure" class="text-decoration-none text-secondary text-hover-purple">Adventure</a></li>
                    <li><a href="<?= BASE_URL ?>/support" class="text-decoration-none text-secondary text-hover-purple">Support</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-4">
                <!-- Inline style dihapus, diganti class 'footer-heading' -->
                <h5 class="text-white fw-bold mb-3 footer-heading">Stay Updated</h5>
                <p class="small text-secondary mb-3">Subscribe to get special offers and gaming news.</p>

                <form action="#" method="POST" class="d-flex mb-3">
                    <input type="email" class="newsletter-input form-control form-control-sm text-white" placeholder="Your email address">
                    <button class="btn newsletter-btn btn-sm fw-bold text-white px-3" type="button">Join</button>
                </form>

                <div class="social-box d-flex gap-3 fs-5 mt-4">
                    <a href="#" class="text-secondary text-hover-white"><i class="bi bi-discord"></i></a>
                    <a href="#" class="text-secondary text-hover-white"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-secondary text-hover-white"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="text-secondary text-hover-white"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>

        </div>
        <hr class="footer-divider">
        <div class="footer-bottom">
            <!-- Tahun dibuat dinamis menggunakan PHP -->
            <p>&copy; <?= date('Y'); ?> <span>Barn Owl Store</span>. All rights reserved.</p>
            <p>Made with ❤️ by <span class="footer-author">Egi Dwi Kurniawan</span></p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>