
<?php

include_once '../includes/header.php';
require_once '../includes/functions.php';

// Conecta-se ao banco de dados
$conn = connect_db();

// Busca todos os usuários
$stmt = $conn->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Gerenciamento de Usuários</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-user-plus me-2"></i> Adicionar Usuário
        </button>
    </div>
    <div class="card-body">
        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <span class="badge bg-<?php echo $user['user_type'] === 'admin' ? 'primary' : 'secondary'; ?> rounded-pill d-inline">
                                <?php echo $user['user_type']; ?>
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm btn-floating" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="<?php echo $user['id']; ?>">
                                <i class="fas fa-user-edit"></i>
                            </button>
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm btn-floating" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                <i class="fas fa-user-times"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Adicionar Usuário -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Adicionar Novo Usuário</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="add_user.php" method="POST">
            <div class="mb-3">
                <label for="userName" class="form-label">Nome do Usuário</label>
                <input type="text" class="form-control" id="userName" name="username" required>
            </div>
            <div class="mb-3">
                <label for="userEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="userEmail" name="email" required>
            </div>
            <div class="mb-3">
                <label for="userPassword" class="form-label">Senha</label>
                <input type="password" class="form-control" id="userPassword" name="password" required>
            </div>
            <div class="mb-3">
                <label for="userType" class="form-label">Tipo de Usuário</label>
                <select class="form-select" id="userType" name="user_type" required>
                    <option value="employee" selected>Funcionário</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Salvar Usuário</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Editar Usuário -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Editar Usuário</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="edit_user.php" method="POST">
            <input type="hidden" id="editUserId" name="id">
            <div class="mb-3">
                <label for="editUserName" class="form-label">Nome do Usuário</label>
                <input type="text" class="form-control" id="editUserName" name="username" required>
            </div>
            <div class="mb-3">
                <label for="editUserEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="editUserEmail" name="email" required>
            </div>
            <div class="mb-3">
                <label for="editUserType" class="form-label">Tipo de Usuário</label>
                <select class="form-select" id="editUserType" name="user_type" required>
                    <option value="employee">Funcionário</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php include_once '../includes/footer.php'; ?>
