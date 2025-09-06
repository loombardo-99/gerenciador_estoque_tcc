<?php

require_once __DIR__ . '/../includes/functions.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitiza os dados de entrada
    $username = sanitize_input($_POST['username']);
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);
    $user_type = sanitize_input($_POST['user_type']);

    // Gera o hash da senha
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Conecta-se ao banco de dados
    $conn = connect_db();

    if ($conn) {
        try {
            // Prepara a consulta para inserir o usuário
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, user_type) VALUES (:username, :email, :password, :user_type)");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashed_password,
                ':user_type' => $user_type
            ]);

            // Redireciona para a página de usuários com uma mensagem de sucesso
            header('Location: usuarios.php?success=Usuário adicionado com sucesso!');
            exit();

        } catch (PDOException $e) {
            // Redireciona para a página de usuários com uma mensagem de erro
            header('Location: usuarios.php?error=Erro ao adicionar usuário: ' . $e->getMessage());
            exit();
        }
    }
}

?>