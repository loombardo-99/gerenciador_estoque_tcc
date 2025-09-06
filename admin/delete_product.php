<?php

require_once __DIR__ . '/../includes/functions.php';

// Verifica se o ID do produto foi fornecido
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Conecta-se ao banco de dados
    $conn = connect_db();

    if ($conn) {
        try {
            // Prepara a consulta para excluir o produto
            $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
            $stmt->bindParam(':id', $product_id);
            $stmt->execute();

            // Redireciona para a página de produtos com uma mensagem de sucesso
            header('Location: produtos.php?success=Produto excluído com sucesso!');
            exit();

        } catch (PDOException $e) {
            // Redireciona para a página de produtos com uma mensagem de erro
            header('Location: produtos.php?error=Erro ao excluir produto: ' . $e->getMessage());
            exit();
        }
    }
}

?>