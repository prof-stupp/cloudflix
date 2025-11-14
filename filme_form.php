<?php
// filme_form.php

$action = $_GET['action'] ?? 'novo';
$id = $_GET['id'] ?? null;

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
        <h2><?= $action == 'editar' ? 'Editar Filme' : 'Cadastro de novo filme' ?></h2>
        <form id="form_filme">
            <label for="titulo">Título</label>
            <input type="text" id="titulo" value="<?= htmlspecialchars($_GET['titulo'] ?? '') ?>" required>

            <label for="genero">Gênero</label>
            <input type="text" id="genero" value="<?= htmlspecialchars($_GET['genero'] ?? '') ?>" required>

            <label for="cartaz">Cartaz (nome da imagem)</label>
            <input type="text" id="cartaz" value="<?= htmlspecialchars($_GET['cartaz'] ?? '') ?>" required>

            <button type="submit">
                <?= $action == 'editar' ? 'Salvar Alterações' : 'Cadastrar Filme' ?>
            </button>
        </form>

    </main>

    <?php include 'footer.php'; ?>

    <!-- MODAL -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <h3 id="modalMessage">Mensagem aqui</h3>
            <button id="btnModalOK">OK</button>
        </div>
    </div>

    <script>
        window.FILME_ACTION = "<?= $action ?>";
        window.FILME_ID = "<?= $id ?>";
    </script>

    <script src="js/tema.js"></script>
    <script src="js/filme.js"></script>
</body>
</html>
