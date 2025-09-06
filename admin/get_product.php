<?php

require_once __DIR__ . '/../includes/functions.php';

// Verifica se o ID do produto foi fornecido
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Conecta-se ao banco de dados
    $conn = connect_db();

    if ($conn) {
        try {
            // Prepara a consulta para buscar o produto
            $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
            $stmt->bindParam(':id', $product_id);
            $stmt->execute();

            // Verifica se o produto existe
            if ($stmt->rowCount() === 1) {
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                // Retorna os dados do produto como JSON
                header('Content-Type: application/json');
                echo json_encode($product);
                exit();
            }
        } catch (PDOException $e) {
            // Retorna um erro como JSON
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Erro ao buscar produto: ' . $e->getMessage()]);
            exit();
        }
    }
}

?>