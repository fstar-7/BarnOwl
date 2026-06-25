<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content auth-modal-content text-white p-4">

      <div class="text-end">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form Login -->
      <form id="loginForm" method="POST" action="<?= BASE_URL ?>/login">
        <div class="text-center mb-3">
          <img src="<?= BASE_URL ?>/assets/img/logo.png" width="60" alt="Logo">
        </div>
        <h4 class="text-center fw-bold mb-4 auth-modal-title">Sign In to Barn Owl</h4>

        <div class="form-floating mb-3">
          <input type="text" name="username" class="form-control custom-modal-input text-white"
                 placeholder="Username" required autocomplete="off">
          <label class="text-secondary">Username</label>
        </div>

        <div class="form-floating mb-3">
          <input type="password" name="password" class="form-control custom-modal-input text-white"
                 placeholder="Password" required>
          <label class="text-secondary">Password</label>
        </div>

        <button class="btn w-100 fw-bold text-white mt-2 btn-purple-modal" type="submit">Sign In</button>

        <p class="text-center small text-secondary mt-4 mb-0">
          Belum punya akun?
          <a href="#" class="fw-bold text-hover-purple text-decoration-none ms-1"
             onclick="showRegister(); return false;">Sign Up</a>
        </p>
      </form>

      <!-- Form Register -->
      <form id="registerForm" method="POST" action="<?= BASE_URL ?>/register" style="display:none;">
        <div class="text-center mb-3">
          <img src="<?= BASE_URL ?>/assets/img/logo.png" width="60" alt="Logo">
        </div>
        <h4 class="text-center fw-bold mb-4 auth-modal-title">Create Your Account</h4>

        <div class="form-floating mb-3">
          <input type="text" name="username" class="form-control custom-modal-input text-white"
                 placeholder="Username" required autocomplete="off">
          <label class="text-secondary">Username</label>
        </div>

        <div class="form-floating mb-3">
          <input type="email" name="email" class="form-control custom-modal-input text-white"
                 placeholder="Email Address" required autocomplete="off">
          <label class="text-secondary">Email Address</label>
        </div>

        <div class="form-floating mb-3">
          <input type="password" name="password" class="form-control custom-modal-input text-white"
                 placeholder="Password" required>
          <label class="text-secondary">Password</label>
        </div>

        <button class="btn w-100 fw-bold text-white mt-2 btn-purple-modal" type="submit">Register Account</button>

        <p class="text-center small text-secondary mt-4 mb-0">
          Sudah punya akun?
          <a href="#" class="fw-bold text-hover-purple text-decoration-none ms-1"
             onclick="showLogin(); return false;">Sign In</a>
        </p>
      </form>

    </div>
  </div>
</div>
