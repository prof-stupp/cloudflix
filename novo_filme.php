<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Filme</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <h1>CloudFlix</h1>
</header>

<nav>
    <a href="catalogo.php">Catálogo</a>
    <a href="novo_filme.php"><b>Novo Filme</b></a>
</nav>

<main>
    <h2>Cadastrar novo filme</h2>

    <form id="formFilme">
        <label for="titulo">Título</label>
        <input type="text" id="titulo" required>

        <label for="genero">Gênero</label>
        <input type="text" id="genero" required>

        <label for="cartaz">Cartaz (nome da imagem)</label>
        <input type="text" id="cartaz">

        <button type="submit">Cadastrar Filme</button>
    </form>
</main>

<footer>
    CloudFlix &copy; 2025
</footer>

<!-- MODAL -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <h3 id="modalMessage">Mensagem aqui</h3>
        <button id="btnModalOK">OK</button>
    </div>
</div>

<script>

</script>

</body>
</html>
