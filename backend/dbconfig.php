<?php
// dbconfig.php
// Arquivo de configuração da Conexão com o MySQL

// ** ATENÇÃO: SUBSTITUA COM SUAS CREDENCIAIS E NOME DE BD **
define('DB_DRIVER', 'mysql'); 
// O HOST é o IP da máquina onde o container está rodando (seu localhost).
define('DB_HOST', '127.0.0.1'); // Use 'localhost' ou '127.0.0.1'
define('DB_PORT', 3306); 
define('DB_NAME', 'cloudflix'); // Seu novo banco de dados
define('DB_USER', 'root');
define('DB_PASS', 'n7p89f1s'); // A senha definida no docker run

/**
 * Função para estabelecer a conexão com o banco de dados MySQL via PDO.
 *
 * @return PDO Objeto de conexão PDO.
 */
function getDbConnection() {
    // Monta o DSN (Data Source Name) para MySQL.
    $dsn = DB_DRIVER . ":host=" . DB_HOST . 
           ";port=" . DB_PORT . 
           ";dbname=" . DB_NAME . 
           ";charset=utf8mb4"; // Adiciona charset para suporte a emojis e caracteres especiais

    // Opções de conexão PDO (ex: desabilitar comandos preparadas nativos)
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lança exceções em caso de erro
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retorna resultados como array associativo
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Melhor segurança e performance
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        
        return $pdo;
    } catch (\PDOException $e) {
        // Encerra a execução e retorna um erro 500 (ou simplesmente exibe o erro em ambiente de desenvolvimento)
        http_response_code(500);
        // Em um ambiente de produção, você deve logar o erro e não exibi-lo ao usuário!
        die(json_encode(array("message" => "Erro de conexão com o banco de dados MySQL: " . $e->getMessage())));
    }
}

// Exemplo de uso (opcional - para testar a conexão)
/*
try {
    $conn = getDbConnection();
    echo "Conexão MySQL estabelecida com sucesso!";
} catch (Exception $e) {
    echo "Falha na conexão: " . $e->getMessage();
}
*/
?>
