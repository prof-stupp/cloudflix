<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Filme</title>
</head>
<body>
    <h2>Cadastrar Novo Filme</h2>

    <form id="formFilme">
        <label>Título:</label><br>
        <input type="text" id="titulo" required><br><br>

        <label>Gênero:</label><br>
        <input type="text" id="genero" required><br><br>

        <label>Cartaz (arquivo ou nome da imagem):</label><br>
        <input type="text" id="cartaz"><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <pre id="resposta"></pre>

    <script>
        document.getElementById("formFilme").addEventListener("submit", async function (e) {
            e.preventDefault();

            const titulo = document.getElementById("titulo").value;
            const genero = document.getElementById("genero").value;
            const cartaz = document.getElementById("cartaz").value;

            const payload = {
                titulo: titulo,
                genero: genero,
                cartaz: cartaz
            };

            try {
                const response = await fetch("http://localhost/cloudflix/backend/api.php?resource=filmes", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();
                document.getElementById("resposta").textContent = JSON.stringify(result, null, 4);

            } catch (error) {
                document.getElementById("resposta").textContent = "Erro: " + error;
            }
        });
    </script>

</body>
</html>
