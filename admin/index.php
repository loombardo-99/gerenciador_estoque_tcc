<?php
include_once '../includes/header.php';
require_once '../includes/functions.php';

$conn = connect_db();

// Total Products
$total_products = 0;
$stmt = $conn->query("SELECT COUNT(*) FROM products");
$total_products = $stmt->fetchColumn();

// Low Stock Items (quantity < 10)
$low_stock_items = 0;
$stmt = $conn->query("SELECT COUNT(*) FROM products WHERE quantity < 10");
$low_stock_items = $stmt->fetchColumn();

// Total Sales (Monthly)
$total_sales_month = 0;
$current_month_start = date('Y-m-01 00:00:00');
$current_month_end = date('Y-m-t 23:59:59');
$stmt = $conn->prepare("SELECT SUM(sh.quantity * p.price) FROM stock_history sh JOIN products p ON sh.product_id = p.id WHERE sh.action = 'saida' AND sh.created_at BETWEEN :start_date AND :end_date");
$stmt->bindParam(':start_date', $current_month_start);
$stmt->bindParam(':end_date', $current_month_end);
$stmt->execute();
$total_sales_month = $stmt->fetchColumn();
$total_sales_month = $total_sales_month ? number_format($total_sales_month, 2, ',', '.') : '0,00';


// Active Users
$active_users = 0;
$stmt = $conn->query("SELECT COUNT(*) FROM users WHERE user_type = 'admin' OR user_type = 'employee'"); // Assuming all users are active
$active_users = $stmt->fetchColumn();

// Latest Stock Updates
$latest_updates = [];
$stmt = $conn->query("SELECT sh.quantity, sh.action, sh.created_at, p.name as product_name, u.username as user_name FROM stock_history sh JOIN products p ON sh.product_id = p.id JOIN users u ON sh.user_id = u.id ORDER BY sh.created_at DESC LIMIT 5");
$latest_updates = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="row">
    <div class="col-xl-3 col-sm-6 col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between px-md-1">
                    <div>
                        <p class="mb-0">Produtos Cadastrados</p>
                        <div class="h3 mb-0"><?php echo $total_products; ?></div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-box text-primary fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between px-md-1">
                    <div>
                        <p class="mb-0">Estoque Baixo</p>
                        <div class="h3 mb-0"><?php echo $low_stock_items; ?></div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-triangle text-warning fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between px-md-1">
                    <div>
                        <p class="mb-0">Vendas no Mês</p>
                        <div class="h3 mb-0">R$ <?php echo $total_sales_month; ?></div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chart-pie text-success fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between px-md-1">
                    <div>
                        <p class="mb-0">Usuários Ativos</p>
                        <div class="h3 mb-0"><?php echo $active_users; ?></div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users text-info fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Últimas Atualizações de Estoque</h5>
    </div>
    <div class="card-body">
        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th>Produto</th>
                    <th>Usuário</th>
                    <th>Ação</th>
                    <th>Quantidade</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($latest_updates)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhuma atualização de estoque recente.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($latest_updates as $update): ?>
                        <tr>
                            <td>
                                <p class="fw-bold mb-1"><?php echo $update['product_name']; ?></p>
                            </td>
                            <td>
                                <p class="fw-normal mb-1"><?php echo $update['user_name']; ?></p>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo $update['action'] === 'entrada' ? 'success' : 'danger'; ?> rounded-pill d-inline"><?php echo ucfirst($update['action']); ?></span>
                            </td>
                            <td><?php echo $update['quantity']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($update['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>