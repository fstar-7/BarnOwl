<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center fw-bold text-white navbar-brand-text" href="<?= BASE_URL ?>/">
      <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Logo" width="38" height="38" class="me-2">
      Barn Owl
    </a>

    <button class="navbar-toggler btn-transparent-custom" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
      aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
      <div class="navbar-nav d-flex gap-3 align-items-center">
        <a class="nav-link <?= ($currentRoute == '') ? 'active' : '' ?>" href="<?= BASE_URL ?>/">Home</a>
        <a class="nav-link <?= ($currentRoute == 'games') ? 'active' : '' ?>" href="<?= BASE_URL ?>/games">Store</a>
        <a class="nav-link <?= ($currentRoute == 'library') ? 'active' : '' ?>" href="<?= BASE_URL ?>/library">Library</a>
        <a class="nav-link <?= ($currentRoute == 'wishlist') ? 'active' : '' ?>" href="<?= BASE_URL ?>/wishlist">Wishlist</a>
        <a class="nav-link <?= ($currentRoute == 'support') ? 'active' : '' ?>" href="<?= BASE_URL ?>/support">Support</a>
      </div>
    </div>

    <div class="ms-auto d-flex align-items-center gap-3">

      <div class="position-relative d-none d-sm-block">
        <form method="GET" action="<?= BASE_URL ?>/search" class="d-flex align-items-center">
          <input type="text" name="keyword" id="searchInput" class="form-control search-game" placeholder="Search game..." autocomplete="off">
          <button type="submit" class="btn text-white position-absolute end-0 me-1 btn-transparent-custom">
            <i class="bi bi-search"></i>
          </button>
        </form>
        <div id="searchResult" class="search-result"></div>
      </div>

      <div class="position-relative me-1">
        <button class="btn p-0 position-relative d-flex align-items-center btn-transparent-custom" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
          <i class="bi bi-cart3 text-white fs-4 cart-icon"></i>
          <?php if ($cartSummary['totalItems'] > 0) : ?>
            <span class="badge rounded-pill position-absolute cart-badge-count">
              <?= $cartSummary['totalItems']; ?>
            </span>
          <?php endif; ?>
        </button>
      </div>

      <?php if (AuthHelper::isLoggedIn()) : ?>
        <div class="dropdown">
          <button class="btn dropdown-toggle d-flex align-items-center gap-2 px-3 py-1.5 btn-user-dropdown"
            type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?= BASE_URL ?>/assets/img/profile.jpg" width="30" height="30" class="profile-img-sm">
            <span class="small fw-semibold"><?= SanitizeHelper::escape(AuthHelper::username()); ?></span>
          </button>

          <ul class="dropdown-menu dropdown-menu-end custom-nav-dropdown mt-2" aria-labelledby="userDropdown">
            <?php if (AuthHelper::isAdmin()) : ?>
              <li>
                <a class="dropdown-item fw-bold text-danger-custom" href="<?= BASE_URL ?>/admin/dashboard">
                  <i class="bi bi-shield-lock-fill me-2"></i> Admin Panel
                </a>
              </li>
              <li><hr class="dropdown-divider-custom"></li>
            <?php endif; ?>

            <li>
              <a class="dropdown-item text-white-custom" href="<?= BASE_URL ?>/profile">
                <i class="bi bi-person me-2 text-secondary"></i> Profile My Account
              </a>
            </li>
            <li><hr class="dropdown-divider-custom"></li>
            <li>
              <a class="dropdown-item fw-bold text-danger-custom" href="<?= BASE_URL ?>/logout">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
              </a>
            </li>
          </ul>
        </div>
      <?php else : ?>
        <button class="btn px-4 fw-bold text-white shadow-sm btn-login-nav" data-bs-toggle="modal" data-bs-target="#loginModal">
          Login
        </button>
      <?php endif; ?>

    </div>
  </div> 
</nav>

<div class="offcanvas offcanvas-end text-white offcanvas-custom" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
  <div class="offcanvas-header border-bottom border-secondary">
    <h5 class="offcanvas-title fw-bold" id="offcanvasCartLabel">
      <i class="bi bi-cart3 me-2 text-purple-primary"></i>Your Cart
    </h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body d-flex flex-column justify-content-between">
    <div class="cart-items-list overflow-y-auto mb-3 cart-scroll-area">
      <?php if ($cartSummary['totalItems'] > 0) : ?>
        <?php foreach ($cartSummary['items'] as $item) : ?>
          <div class="d-flex align-items-center justify-content-between p-2 mb-2 rounded cart-item-box">
            <div class="d-flex align-items-center col-9">
              <img src="<?= BASE_URL ?>/assets/img/games/<?= SanitizeHelper::escape($item['image']); ?>" alt="" class="rounded me-2 cart-item-img">
              <div class="text-truncate">
                <h6 class="mb-0 small fw-bold text-truncate"><?= SanitizeHelper::escape($item['name']); ?></h6>
                
                <span class="text-purple-light cart-price-sm">
                  <?= FormatHelper::rupiah($item['finalPrice']); ?>
                </span>
                
              </div>
            </div>
            <div class="col-2 text-end">
              <a href="<?= BASE_URL ?>/cart/remove/<?= $item['cart_id']; ?>" class="text-danger border-0 btn-transparent-custom btn-sm" onclick="return confirm('Hapus dari keranjang?')" title="Hapus">
                <i class="bi bi-trash3-fill"></i>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <div class="text-center py-5 text-muted">
          <i class="bi bi-cart-x display-5 d-block mb-2"></i>
          <p class="small">Keranjang belanjamu kosong.</p>
        </div>
      <?php endif; ?>
    </div>

    <?php if ($cartSummary['totalItems'] > 0) : ?>
      <div class="border-top border-secondary pt-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-secondary small">Subtotal Price:</span>
          
          <span class="fs-5 fw-bold text-purple-primary"><?= FormatHelper::rupiah($cartSummary['subtotal']); ?></span>
          
        </div>
        <a href="<?= BASE_URL ?>/checkout" class="btn py-2.5 w-100 fw-bold text-white mb-2 btn-checkout">
          <i class="bi bi-credit-card-2-back me-2"></i>Proceed to Checkout
        </a>
      </div>
    <?php endif; ?>
  </div>
</div>