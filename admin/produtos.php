
<?php

include_once '../includes/header.php';
require_once '../includes/functions.php';

// Conecta-se ao banco de dados
$conn = connect_db();

// Busca todos os produtos
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Gerenciamento de Produtos</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="fas fa-plus me-2"></i> Adicionar Produto
        </button>
    </div>
    <div class="card-body">
        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['description']; ?></td>
                        <td>R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></td>
                        <td><?php echo $product['quantity']; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm btn-floating" data-bs-toggle="modal" data-bs-target="#editProductModal" data-id="<?php echo $product['id']; ?>">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm btn-floating" onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Adicionar Produto -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Adicionar Novo Produto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="add_product.php" method="POST">
            <div class="mb-3">
                <label for="productName" class="form-label">Nome do Produto</label>
                <input type="text" class="form-control" id="productName" name="name" required>
            </div>
            <div class="mb-3">
                <label for="productDescription" class="form-label">Descrição</label>
                <textarea class="form-control" id="productDescription" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="productPrice" class="form-label">Preço</label>
                <input type="text" class="form-control" id="productPrice" name="price" required>
            </div>
            <div class="mb-3">
                <label for="productQuantity" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="productQuantity" name="quantity" required>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Salvar Produto</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Editar Produto -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProductModalLabel">Editar Produto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="edit_product.php" method="POST">
            <input type="hidden" id="editProductId" name="id">
            <div class="mb-3">
                <label for="editProductName" class="form-label">Nome do Produto</label>
                <input type="text" class="form-control" id="editProductName" name="name" required>
            </div>
            <div class="mb-3">
                <label for="editProductDescription" class="form-label">Descrição</label>
                <textarea class="form-control" id="editProductDescription" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="editProductPrice" class="form-label">Preço</label>
                <input type="text" class="form-control" id="editProductPrice" name="price" required>
            </div>
            <div class="mb-3">
                <label for="editProductQuantity" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="editProductQuantity" name="quantity" required>
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
