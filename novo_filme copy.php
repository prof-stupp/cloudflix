<?php
// Página para adicionar filme (sem modal) — encaminha os dados para a API REST no backend.

// Se o formulário for enviado, encaminha os dados para a API via cURL (POST).
$message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $cartaz = trim($_POST['cartaz'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    $api_url = 'http://localhost/cloudflix/backend/api.php?resource=filmes';

    // Monta payload para envio como application/x-www-form-urlencoded
    $payload = http_build_query([
        'titulo' => $titulo,
        'genero' => $genero,
        'cartaz' => $cartaz,
        'descricao' => $descricao,
    ]);

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        $message = 'Erro na requisição cURL: ' . curl_error($ch);
    } else {
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // Tenta decodificar JSON de resposta
        $data = json_decode($response, true);
        if ($http_code === 200 || $http_code === 201) {
            // Caso a API retorne um sinal de sucesso, redireciona para o catálogo
            // Ajuste conforme o formato da sua API (ex: $data['success']).
            header('Location: catalogo.php');
            curl_close($ch);
            exit;
        } else {
            // Exibe mensagem de erro retornada pela API, se houver
            $api_msg = $data['message'] ?? $data['error'] ?? $response;
            $message = "Erro ao salvar filme: " . $api_msg;
        }
    }
    curl_close($ch);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Adicionar Filme - CloudFlix</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Pequenos estilos locais para o formulário */
        .container { max-width: 700px; margin: 30px auto; padding: 20px; background:#fff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,.1); }
        .form-group { margin-bottom: 12px; }
        label { display:block; font-weight:600; margin-bottom:6px; }
        input[type="text"], input[type="url"], textarea { width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box; }
        .actions { display:flex; gap:8px; justify-content:flex-end; margin-top:12px; }
        .btn { padding:8px 14px; border:none; border-radius:4px; cursor:pointer; }
        .btn-primary { background:#4CAF50; color:#fff; }
        .btn-secondary { background:#ccc; color:#000; }
        .error { color:#b00020; margin-bottom:12px; }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'nav.php'; ?>

    <main>
        <div class="container">
            <h2>Adicionar Novo Filme</h2>
            <p>Preencha os campos abaixo e salve para incluir um novo filme no catálogo.</p>

            <?php if ($message): ?>
                <div class="error"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form method="POST" action="backend/api.php?resource=filmes" novalidate>
                <div class="form-group">
                    <label for="titulo">Título *</label>
                    <input type="text" id="titulo" name="titulo" required value="<?php echo isset($titulo) ? htmlspecialchars($titulo) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="genero">Gênero *</label>
                    <input type="text" id="genero" name="genero" required value="<?php echo isset($genero) ? htmlspecialchars($genero) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="cartaz">URL do Cartaz</label>
                    <input type="url" id="cartaz" name="cartaz" placeholder="https://exemplo.com/imagem.jpg" value="<?php echo isset($cartaz) ? htmlspecialchars($cartaz) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="5"><?php echo isset($descricao) ? htmlspecialchars($descricao) : ''; ?></textarea>
                </div>

                <div class="actions">
                    <a class="btn btn-secondary" href="catalogo.php">Voltar</a>
                    <button type="submit" class="btn btn-primary">Salvar Filme</button>
                </div>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
```//