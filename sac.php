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
        <h2>Serviço de Atendimento ao Consumidor</h2>
        <p>Você pode entrar em contato enviando uma mensagem pelo formulário abaixo:</p>
        <form action="" method="post">
            <label for="id_nome">Nome do cliente:</label><br>
            <input type="text" name="nome" id="id_nome"><br><br>

            <label for="id_email">E-mail do cliente:</label><br> 
            <input type="text" name="email" id="id_email"><br><br>

            <label for="id_mensagem">Mensagem:</label><br>
            <textarea name="mensagem" id="id_mensagem"></textarea><br><br>
            <button type="submit">Enviar</button>
        </form>

    </main>
    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <script src="js/tema.js"></script>
</body>
</html>
