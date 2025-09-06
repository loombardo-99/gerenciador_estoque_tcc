<?php
include_once '../includes/header.php';
require_once '../includes/functions.php';

$conn = connect_db();

// Sales by Category
$sales_by_category = [];
$stmt = $conn->query("SELECT p.category, SUM(sh.quantity * p.price) as total_sales FROM stock_history sh JOIN products p ON sh.product_id = p.id WHERE sh.action = 'saida' GROUP BY p.category");
$sales_by_category = $stmt->fetchAll(PDO::FETCH_ASSOC);

$category_labels = [];
$category_data = [];
foreach ($sales_by_category as $sale) {
    $category_labels[] = $sale['category'];
    $category_data[] = $sale['total_sales'];
}

// Most Sold Products
$most_sold_products = [];
$stmt = $conn->query("SELECT p.name, SUM(sh.quantity) as total_quantity_sold FROM stock_history sh JOIN products p ON sh.product_id = p.id WHERE sh.action = 'saida' GROUP BY p.name ORDER BY total_quantity_sold DESC LIMIT 5");
$most_sold_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Vendas por Categoria</h5>
            </div>
            <div class="card-body">
                <canvas id="salesByCategoryChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Produtos Mais Vendidos</h5>
            </div>
            <div class="card-body">
                <table class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade Vendida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($most_sold_products)): ?>
                            <tr>
                                <td colspan="2" class="text-center">Nenhum produto vendido ainda.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($most_sold_products as $product): ?>
                                <tr>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php echo $product['total_quantity_sold']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const salesByCategoryCtx = document.getElementById('salesByCategoryChart');
    if (salesByCategoryCtx) {
        new Chart(salesByCategoryCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($category_labels); ?>,
                datasets: [{
                    label: 'Vendas por Categoria',
                    data: <?php echo json_encode($category_data); ?>, 
                    backgroundColor: [
                        'rgba(66, 133, 244, 0.8)', // Azul Google
                        'rgba(52, 168, 83, 0.8)', // Verde Google
                        'rgba(251, 188, 5, 0.8)',   // Amarelo Google
                        'rgba(234, 67, 53, 0.8)', // Vermelho Google
                        'rgba(0, 0, 0, 0.8)' // Preto
                    ],
                    borderColor: [
                        'rgba(66, 133, 244, 1)',
                        'rgba(52, 168, 83, 1)',
                        'rgba(251, 188, 5, 1)',
                        'rgba(234, 67, 53, 1)',
                        'rgba(0, 0, 0, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Distribuição de Vendas por Categoria'
                    }
                }
            }
        });
    }
});
</script>