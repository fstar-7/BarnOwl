<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-white p-4" style="background-color: #0f1117; border: 1px solid #222; border-radius: 18px;">

      <div class="text-end">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="loginForm" method="POST" action="<?= BASE_URL ?>/login">
        <div class="text-center mb-3">
          <img src="<?= BASE_URL ?>/assets/img/logo.png" width="60" alt="Logo">
        </div>
        <h4 class="text-center fw-bold mb-4" style="letter-spacing: 0.5px;">Sign In to Barn Owl</h4>

        <div class="form-floating mb-3">
          <input type="text" name="username" class="form-control custom-modal-input text-white" placeholder="Username" required autocomplete="off">
          <label class="text-secondary">Username</label>
        </div>

        <div class="form-floating mb-3">
          <input type="password" name="password" class="form-control custom-modal-input text-white" placeholder="Password" required>
          <label class="text-secondary">Password</label>
        </div>

        <button class="btn w-100 fw-bold text-white mt-2 py-2.5 btn-purple-modal" type="submit">Sign In</button>

        <p class="text-center small text-secondary mt-4 mb-0">
          Belum punya akun? <a href="#" class="fw-bold text-hover-purple text-decoration-none ms-1" onclick="showRegister(); return false;">Sign Up</a>
        </p>
      </form>

      <form id="registerForm" method="POST" action="<?= BASE_URL ?>/register" style="display:none;">
        <div class="text-center mb-3">
          <img src="<?= BASE_URL ?>/assets/img/logo.png" width="60" alt="Logo">
        </div>
        <h4 class="text-center fw-bold mb-4" style="letter-spacing: 0.5px;">Create Your Account</h4>

        <div class="form-floating mb-3">
          <input type="text" name="username" class="form-control custom-modal-input text-white" placeholder="Username" required autocomplete="off">
          <label class="text-secondary">Username</label>
        </div>

        <div class="form-floating mb-3">
          <input type="email" name="email" class="form-control custom-modal-input text-white" placeholder="Email Address" required autocomplete="off">
          <label class="text-secondary">Email Address</label>
        </div>

        <div class="form-floating mb-3">
          <input type="password" name="password" class="form-control custom-modal-input text-white" placeholder="Password" required>
          <label class="text-secondary">Password</label>
        </div>

        <button class="btn w-100 fw-bold text-white mt-2 py-2.5 btn-purple-modal" type="submit">Register Account</button>

        <p class="text-center small text-secondary mt-4 mb-0">
          Sudah punya akun? <a href="#" class="fw-bold text-hover-purple text-decoration-none ms-1" onclick="showLogin(); return false;">Sign In</a>
        </p>
      </form>

    </div>
  </div>
</div>

<script>
  function showRegister() {
      document.getElementById('loginForm').style.display = 'none';
      document.getElementById('registerForm').style.display = 'block';
  }
  function showLogin() {
      document.getElementById('registerForm').style.display = 'none';
      document.getElementById('loginForm').style.display = 'block';
  }
</script>