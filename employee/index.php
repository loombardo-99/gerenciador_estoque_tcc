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
    <div class="card-header">
        <h5 class="card-title">Visualização de Produtos</h5>
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>