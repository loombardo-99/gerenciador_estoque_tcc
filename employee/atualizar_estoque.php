
<?php

include_once '../includes/header.php';
require_once '../includes/functions.php';

// Conecta-se ao banco de dados
$conn = connect_db();

// Busca todos os produtos para o dropdown
$stmt = $conn->query("SELECT id, name FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Atualizar Estoque</h5>
    </div>
    <div class="card-body">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="update_stock.php" method="POST">
            <div class="mb-3">
                <label for="product" class="form-label">Produto</label>
                <select class="form-select" id="product" name="product_id" required>
                    <option selected disabled>Selecione o produto</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="mb-3">
                <label for="action" class="form-label">Ação</label>
                <select class="form-select" id="action" name="action" required>
                    <option selected disabled>Selecione a ação</option>
                    <option value="entrada">Entrada</option>
                    <option value="saida">Saída</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar Estoque</button>
        </form>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>
