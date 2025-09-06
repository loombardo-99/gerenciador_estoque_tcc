<?php include_once 'includes/header.php'; ?>

<div class="container-fluid ps-md-0">
  <div class="row g-0">
    <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
    <div class="col-md-8 col-lg-6">
      <div class="login d-flex align-items-center py-5">
        <div class="container">
          <div class="row">
            <div class="col-md-9 col-lg-8 mx-auto">
              <h3 class="login-heading mb-4">Bem-vindo de volta!</h3>

              <?php if (isset($_GET['error'])): ?>
                  <div class="alert alert-danger" role="alert">
                      <?php echo htmlspecialchars($_GET['error']); ?>
                  </div>
              <?php endif; ?>

              <!-- Sign In Form -->
              <form action="login.php" method="POST">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="username" name="username" placeholder="Usuário">
                  <label for="username">Usuário</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
                  <label for="password">Senha</label>
                </div>

                <div class="d-grid">
                  <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Entrar</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once 'includes/footer.php'; ?>