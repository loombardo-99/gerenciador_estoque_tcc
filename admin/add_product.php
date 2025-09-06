<?php

require_once __DIR__ . '/../includes/functions.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitiza os dados de entrada
    $name = sanitize_input($_POST['name']);
    $description = sanitize_input($_POST['description']);
    $price = sanitize_input($_POST['price']);
    $quantity = sanitize_input($_POST['quantity']);

    // Conecta-se ao banco de dados
    $conn = connect_db();

    if ($conn) {
        try {
            // Prepara a consulta para inserir o produto
            $stmt = $conn->prepare("INSERT INTO products (name, description, price, quantity) VALUES (:name, :description, :price, :quantity)");
            $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':quantity' => $quantity
            ]);

            // Redireciona para a página de produtos com uma mensagem de sucesso
            header('Location: produtos.php?success=Produto adicionado com sucesso!');
            exit();

        } catch (PDOException $e) {
            // Redireciona para a página de produtos com uma mensagem de erro
            header('Location: produtos.php?error=Erro ao adicionar produto: ' . $e->getMessage());
            exit();
        }
    }
}

?>