
<?php

require_once __DIR__ . '/includes/functions.php';

// Inicia a sessão
session_start();

// Verifica se o formulário de login foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitiza os dados de entrada
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);

    // Conecta-se ao banco de dados
    $conn = connect_db();

    if ($conn) {
        try {
            // Prepara a consulta para buscar o usuário
            $stmt = $conn->prepare("SELECT id, username, password, user_type FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            // Verifica se o usuário existe
            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verifica a senha
                if (password_verify($password, $user['password'])) {
                    // Armazena os dados do usuário na sessão
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['user_type'] = $user['user_type'];

                    // Redireciona para a página correspondente ao tipo de usuário
                    if ($user['user_type'] === 'admin') {
                        header('Location: /gerenciador_de_estoque/admin/index.php');
                    } else {
                        header('Location: /gerenciador_de_estoque/employee/index.php');
                    }
                    exit();
                } else {
                    $error_message = "Senha incorreta.";
                }
            } else {
                $error_message = "Usuário não encontrado.";
            }
        } catch (PDOException $e) {
            $error_message = "Erro no servidor. Tente novamente mais tarde.";
            error_log("Erro de login: " . $e->getMessage());
        }
    }

    // Se houver um erro, exibe a mensagem na página de login
    if (isset($error_message)) {
        header('Location: index.php?error=' . urlencode($error_message));
        exit();
    }
}

?>
