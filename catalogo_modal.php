<?php

/**
 * Busca a lista de filmes da API RESTful, trata a resposta e ordena os filmes.
 * @param string $api_url URL completa do endpoint da API.
 * @return array Um array associativo contendo:
 * - 'filmes': Array de filmes (ou array vazio em caso de erro/sem dados).
 * - 'error': String com a mensagem de erro (ou null se a busca foi bem-sucedida).
 */
function fetchFilmesFromApi(string $api_url): array {
    $filmes = [];
    $error = null;

    try {
        // Inicializa a sessão cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Executa a requisição
        $response = curl_exec($ch);
        
        // Verifica por erros de cURL
        if (curl_errno($ch)) {
            throw new Exception("Erro cURL: " . curl_error($ch));
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Decodifica a resposta JSON (JSON_UNESCAPED_UNICODE para tratar acentuação)
        $data = json_decode($response, true, 512, JSON_UNESCAPED_UNICODE);

        if ($http_code === 200) {
            if (is_array($data) && count($data) > 0 && isset($data[0]['id'])) {
                $filmes = $data;
                
                // Ordenação local dos filmes em ordem crescente por 'id'.
                usort($filmes, function($a, $b) {
                    return $a['id'] <=> $b['id'];
                });

            } elseif (is_array($data) && empty($data)) {
                $error = "Nenhum filme cadastrado na base de dados.";
            } else {
                 $error = "Formato de dados inesperado da API.";
            }
        } else {
            // Trata códigos de erro HTTP diferentes de 200
            $error_message = $data['message'] ?? "Erro HTTP: " . $http_code;
            throw new Exception("Falha ao buscar dados: " . $error_message);
        }

    } catch (Exception $e) {
        // Captura e armazena o erro da exceção
        $error = $e->getMessage();
    }
    
    // Retorna o array com os dados e o status
    return ['filmes' => $filmes, 'error' => $error];
}


// 1. Obtem a URL base e construir a URL completa para a API
$api_url = 'http://localhost/cloudflix/backend/api.php?resource=filmes';

// 2. Busca os dados da API
$result = fetchFilmesFromApi($api_url);
$filmes = $result['filmes'];
$error = $result['error'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CloudFlix</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <?php include 'nav.php'; ?>
    <main>
        <h2>Catálogo de filmes</h2>
        <p>Desfrute desse catálogo imenso de filmes extradionários</p>
        
        <!-- Botão para adicionar novo filme -->
        <button id="btn-adicionar-filme" class="btn-adicionar">+ Adicionar Novo Filme</button>
        
        <table border="1" id="tabela-catalogo">
            <thead>
                <tr>
                    <th>Cartaz</th>
                    <th>Título</th>
                    <th>Gênero</th>
                    <th>Código</th>
                </tr>
            </thead>
            <tbody id="corpo-tabela-filmes">
                <?php if ($error): ?>
                    <!-- Exibe mensagem de erro -->
                    <tr style="color: red; border: 1px solid red; padding: 10px;">
                        <td colspan="3">Erro</td>
                        <td colspan="3"><p><?php echo htmlspecialchars($error); ?></p></td>
                    </tr>
                <?php elseif (!empty($filmes)): ?>
                    <?php foreach ($filmes as $filme): ?>
                        <tr>
                            <td>
                                <?php
                                    $url = htmlspecialchars($filme['cartaz'] ?? '');
                                    if (!empty($url)):
                                ?>
                                    <!-- CORREÇÃO 3: Exibe a URL como uma imagem <img> -->
                                    <img src="<?php echo $url; ?>" 
                                        alt="<?php echo htmlspecialchars($filme['titulo'] ?? 'Cartaz'); ?>"
                                    />
                                    <!-- Fallback para caso a imagem não carregue -->
                                    <span style="display: none; color: gray;">Imagem não carregada.</span>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($filme['titulo'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($filme['genero'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($filme['id'] ?? ''); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Não foi possível carregar o catálogo de filmes. Verifique a URL da API.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <!-- Modal para adicionar novo filme -->
    <div id="modal-filme" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Adicionar Novo Filme</h3>
            <form id="form-novo-filme" method="POST" action="backend/api.php?resource=filmes">
                <div class="form-group">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>
                
                <div class="form-group">
                    <label for="genero">Gênero:</label>
                    <input type="text" id="genero" name="genero" required>
                </div>
                
                <div class="form-group">
                    <label for="cartaz">URL do Cartaz:</label>
                    <input type="url" id="cartaz" name="cartaz" placeholder="https://exemplo.com/imagem.jpg">
                </div>
                
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" rows="4"></textarea>
                </div>
                
                <div class="form-buttons">
                    <button type="submit" class="btn-salvar">Salvar Filme</button>
                    <button type="button" class="btn-cancelar" id="btn-cancelar">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="js/tema.js"></script>
    <script src="js/catalogo.js"></script>
</body>

</html>