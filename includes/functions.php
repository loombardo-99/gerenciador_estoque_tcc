
<?php

// Inclui o arquivo de configuração do banco de dados
require_once __DIR__ . '/db_config.php';

/**
 * Conecta-se ao banco de dados.
 *
 * @return PDO|null Retorna um objeto PDO em caso de sucesso ou null em caso de falha.
 */
function connect_db()
{
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        // Em um ambiente de produção, você não deve exibir o erro diretamente.
        // Em vez disso, registre o erro em um arquivo de log.
        error_log("Erro de conexão com o banco de dados: " . $e->getMessage());
        return null;
    }
}

/**
 * Limpa os dados de entrada do usuário para evitar ataques XSS.
 *
 * @param string $data O dado a ser limpo.
 * @return string O dado limpo.
 */
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
