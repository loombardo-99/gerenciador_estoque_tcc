<?php

require_once __DIR__ . '/../includes/functions.php';

// Verifica se o ID do usuário foi fornecido
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Conecta-se ao banco de dados
    $conn = connect_db();

    if ($conn) {
        try {
            // Prepara a consulta para excluir o usuário
            $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();

            // Redireciona para a página de usuários com uma mensagem de sucesso
            header('Location: usuarios.php?success=Usuário excluído com sucesso!');
            exit();

        } catch (PDOException $e) {
            // Redireciona para a página de usuários com uma mensagem de erro
            header('Location: usuarios.php?error=Erro ao excluir usuário: ' . $e->getMessage());
            exit();
        }
    }
}

?>