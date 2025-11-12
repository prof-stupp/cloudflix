<?php

/**
 * Constrói e retorna a URL base (protocolo + host + caminho do diretório).
 * Exemplo: http://localhost/cloudflix
 *
 * @return string A URL base absoluta.
 */
function getBaseUrl(): string {
    // 1. Determina o protocolo (http ou https)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    // 2. Obtém o host (ex: localhost, ou www.seusite.com)
    $host = $_SERVER['HTTP_HOST'];

    // 3. Obtém o caminho do diretório onde o script está
    // rtrim(..., '/') remove barras extras no final
    $base_dir = rtrim(dirname($_SERVER['PHP_SELF']), '/');

    // Retorna a URL base completa
    return $protocol . $host . $base_dir;
}

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

?>