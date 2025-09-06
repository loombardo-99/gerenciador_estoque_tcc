<?php

require_once __DIR__ . '/../includes/functions.php';

// Verifica se o ID do usuário foi fornecido
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Conecta-se ao banco de dados
    $conn = connect_db();

    if ($conn) {
        try {
            // Prepara a consulta para buscar o usuário
            $stmt = $conn->prepare("SELECT id, username, email, user_type FROM users WHERE id = :id");
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();

            // Verifica se o usuário existe
            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Retorna os dados do usuário como JSON
                header('Content-Type: application/json');
                echo json_encode($user);
                exit();
            }
        } catch (PDOException $e) {
            // Retorna um erro como JSON
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Erro ao buscar usuário: ' . $e->getMessage()]);
            exit();
        }
    }
}

?>