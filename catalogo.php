<?php
// Inclui o arquivo de biblioteca que contém as funções getBaseUrl() e fetchFilmesFromApi()
include_once 'backend/lib.php';

// 1. Obtem a URL base e construir a URL completa para a API
$base_url = getBaseUrl();
$api_url = $base_url . '/backend/api.php?resource=filmes';

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
    <?php include 'footer.php'; ?>
    <script src="js/tema.js"></script>
</body>

</html>