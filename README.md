# Gerenciador de Estoque

Um sistema de gerenciamento de estoque simples e funcional, desenvolvido com PHP, MySQL e Bootstrap. Projetado para ser uma solução web para controle de produtos, usuários e histórico de movimentações.

## Funcionalidades

- **Autenticação de Usuário:** Sistema de login seguro com sessões PHP.
- **Controle de Acesso por Função:** Dois níveis de usuário:
    - **Administrador:** Acesso total ao sistema, incluindo gerenciamento de usuários e produtos.
    - **Funcionário:** Acesso limitado para visualizar e gerenciar o estoque.
- **Gerenciamento de Produtos:** Funcionalidades completas de CRUD (Criar, Ler, Atualizar, Deletar) para os produtos.
- **Controle de Estoque:** Registro de entradas e saídas de produtos.
- **Histórico de Movimentações:** Todas as alterações no estoque são registradas, informando o produto, a quantidade, a ação e o usuário responsável.

## Tecnologias Utilizadas

- **Backend:** PHP 7.4+ (utilizando PDO para conexão com o banco)
- **Banco de Dados:** MySQL
- **Frontend:** HTML, CSS, Bootstrap 5

## Pré-requisitos

Para executar este projeto localmente, você precisará de:

- Um servidor web com suporte a PHP (XAMPP, WAMP, Laragon, etc.).
- Servidor de banco de dados MySQL.
- A extensão `PDO_MYSQL` do PHP habilitada.

## Instalação e Configuração

Siga os passos abaixo para configurar o ambiente de desenvolvimento.

**1. Clone o Repositório**
```bash
git clone https://github.com/loombardo-99/gerenciador_estoque_tcc.git
cd gerenciador_estoque_tcc
```

**2. Crie o Banco de Dados**
- Acesse seu painel de controle do MySQL (phpMyAdmin, por exemplo).
- Crie um novo banco de dados. Por exemplo, `gerenciador_estoque`.

**3. Configure a Conexão com o Banco**
- No diretório `includes/`, crie um arquivo chamado `db_config.php`.
- Adicione o seguinte conteúdo a ele, substituindo os valores pelas suas credenciais do MySQL:

```php
<?php
// Configurações do Banco de Dados
define('DB_HOST', 'localhost');
define('DB_USER', 'seu_usuario_mysql');
define('DB_PASS', 'sua_senha_mysql');
define('DB_NAME', 'gerenciador_estoque'); // Ou o nome que você escolheu
?>
```

**4. Execute o Script de Setup do Banco**
- Inicie seu servidor web.
- Abra o navegador e acesse a URL para o arquivo `setup_database.php`.
- Exemplo: `http://localhost/gerenciador_de_estoque/setup_database.php`

Isso criará todas as tabelas necessárias (`users`, `products`, `stock_history`).

**⚠️ Importante:** Após a execução bem-sucedida, **delete ou renomeie o arquivo `setup_database.php`** por razões de segurança.

## Como Usar

1.  **Acesse o Sistema:** Navegue para a raiz do projeto no seu navegador.
    - Exemplo: `http://localhost/gerenciador_de_estoque/`

2.  **Login:** A página de login será exibida. Para o primeiro acesso, você pode inserir um usuário administrador diretamente no banco de dados na tabela `users`. Use a função `password_hash()` do PHP para gerar uma senha segura.

A partir daí, você pode criar outros usuários e gerenciar o estoque através da interface web.
