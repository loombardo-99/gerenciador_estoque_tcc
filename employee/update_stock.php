<?php

require_once __DIR__ . '/../includes/functions.php';
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitiza os dados de entrada
    $product_id = sanitize_input($_POST['product_id']);
    $quantity = sanitize_input($_POST['quantity']);
    $action = sanitize_input($_POST['action']);
    $user_id = $_SESSION['user_id'];

    // Conecta-se ao banco de dados
    $conn = connect_db();

    if ($conn) {
        try {
            // Inicia a transação
            $conn->beginTransaction();

            // Busca a quantidade atual do produto
            $stmt = $conn->prepare("SELECT quantity FROM products WHERE id = :id");
            $stmt->bindParam(':id', $product_id);
            $stmt->execute();
            $current_quantity = $stmt->fetchColumn();

            // Calcula a nova quantidade
            if ($action === 'entrada') {
                $new_quantity = $current_quantity + $quantity;
            } else {
                $new_quantity = $current_quantity - $quantity;
                // Verifica se há estoque suficiente para a saída
                if ($new_quantity < 0) {
                    throw new Exception("Estoque insuficiente para esta operação.");
                }
            }

            // Atualiza a quantidade do produto
            $stmt = $conn->prepare("UPDATE products SET quantity = :quantity WHERE id = :id");
            $stmt->execute([
                ':quantity' => $new_quantity,
                ':id' => $product_id
            ]);

            // Insere o registro no histórico de estoque
            $stmt = $conn->prepare("INSERT INTO stock_history (product_id, user_id, action, quantity) VALUES (:product_id, :user_id, :action, :quantity)");
            $stmt->execute([
                ':product_id' => $product_id,
                ':user_id' => $user_id,
                ':action' => $action,
                ':quantity' => $quantity
            ]);

            // Confirma a transação
            $conn->commit();

            // Redireciona com mensagem de sucesso
            header('Location: atualizar_estoque.php?success=Estoque atualizado com sucesso!');
            exit();

        } catch (Exception $e) {
            // Desfaz a transação em caso de erro
            $conn->rollBack();
            // Redireciona com mensagem de erro
            header('Location: atualizar_estoque.php?error=' . urlencode($e->getMessage()));
            exit();
        }
    }
}

?>