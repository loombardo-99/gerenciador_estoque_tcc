<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) !== 'login.php' && basename($_SERVER['PHP_SELF']) !== 'index.php') {
    header('Location: /gerenciador_de_estoque/index.php');
    exit();
}

if (isset($_SESSION['user_id'])) {
    // Verifica o tipo de usuário (admin ou funcionário)
    $user_type = $_SESSION['user_type'];
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Estoque</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/gerenciador_de_estoque/assets/css/style.css">
</head>
<body>

<?php if (isset($_SESSION['user_id'])): ?>
<header>
  <!-- Sidebar -->
  <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
    <div class="position-sticky">
      <div class="list-group list-group-flush mx-3 mt-4">
        <?php if ($user_type === 'admin'): ?>
            <a href="/gerenciador_de_estoque/admin/index.php" class="list-group-item list-group-item-action py-2 ripple <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>" aria-current="true">
              <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Dashboard</span>
            </a>
            <a href="/gerenciador_de_estoque/admin/produtos.php" class="list-group-item list-group-item-action py-2 ripple <?php echo basename($_SERVER['PHP_SELF']) === 'produtos.php' ? 'active' : ''; ?>">
              <i class="fas fa-box fa-fw me-3"></i><span>Produtos</span>
            </a>
            <a href="/gerenciador_de_estoque/admin/usuarios.php" class="list-group-item list-group-item-action py-2 ripple <?php echo basename($_SERVER['PHP_SELF']) === 'usuarios.php' ? 'active' : ''; ?>">
              <i class="fas fa-users fa-fw me-3"></i><span>Usuários</span>
            </a>
            <a href="/gerenciador_de_estoque/admin/relatorios.php" class="list-group-item list-group-item-action py-2 ripple <?php echo basename($_SERVER['PHP_SELF']) === 'relatorios.php' ? 'active' : ''; ?>">
              <i class="fas fa-chart-bar fa-fw me-3"></i><span>Relatórios</span>
            </a>
        <?php else: ?>
            <a href="/gerenciador_de_estoque/employee/index.php" class="list-group-item list-group-item-action py-2 ripple <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>" aria-current="true">
              <i class="fas fa-boxes fa-fw me-3"></i><span>Visualizar Produtos</span>
            </a>
            <a href="/gerenciador_de_estoque/employee/atualizar_estoque.php" class="list-group-item list-group-item-action py-2 ripple <?php echo basename($_SERVER['PHP_SELF']) === 'atualizar_estoque.php' ? 'active' : ''; ?>">
              <i class="fas fa-dolly-flatbed fa-fw me-3"></i><span>Atualizar Estoque</span>
            </a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
  <!-- Sidebar -->

  <!-- Navbar -->
  <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <!-- Container wrapper -->
    <div class="container-fluid">
      <!-- Toggle button -->
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu"
        aria-controls="sidebarMenu"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <i class="fas fa-bars"></i>
      </button>

      <!-- Brand -->
      <a class="navbar-brand" href="#">
        <img
          src="https://mdbcdn.b-cdn.net/img/logo/mdb-transaprent-noshadows.webp"
          height="25"
          alt="MDB Logo"
          loading="lazy"
        />
      </a>

      <!-- Right links -->
      <ul class="navbar-nav ms-auto d-flex flex-row">
        <!-- User -->
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle d-flex align-items-center"
            href="#"
            id="navbarDropdownMenuLink"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            <i class="fas fa-user-circle fa-fw me-2"></i>
            <span><?php echo $_SESSION['username']; ?></span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li>
              <a class="dropdown-item" href="/gerenciador_de_estoque/logout.php">Sair</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->
</header>
<main style="margin-top: 58px;">
  <div class="container pt-4">
<?php endif; ?>