// js/filme.js

const action = window.FILME_ACTION;
const filmeId = window.FILME_ID;

/*
// Se estiver editando, carrega os dados do filme
if (action === "editar" && filmeId) {
    fetch(`http://localhost/cloudflix/backend/api.php?resource=filmes&id=${filmeId}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById("titulo").value = data.titulo;
            document.getElementById("genero").value = data.genero;
            document.getElementById("cartaz").value = data.cartaz;
        })
        .catch(err => {
            document.getElementById("modalMessage").innerText = "Erro ao carregar dados do filme.";
            document.getElementById("modalOverlay").style.display = "flex";
        });
}
*/

// SUBMIT DINÂMICO (POST ou PUT)
document.getElementById("form_filme").addEventListener("submit", async function(e) {
    e.preventDefault();

    const payload = {
        titulo: document.getElementById("titulo").value,
        genero: document.getElementById("genero").value,
        cartaz: document.getElementById("cartaz").value
    };

    let url = "http://localhost/cloudflix/backend/api.php?resource=filmes";
    let method = "POST";

    if (action === "editar") {
        method = "PUT";
        url += `&id=${filmeId}`;
    }

    try {
        const response = await fetch(url, {
            method,
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(payload)
        });

        const result = await response.json();

        document.getElementById("modalMessage").innerText = result.message;
        document.getElementById("modalOverlay").style.display = "flex";

    } catch (error) {
        document.getElementById("modalMessage").innerText =
            action === "editar"
                ? "Erro ao atualizar filme."
                : "Erro ao cadastrar filme.";
        document.getElementById("modalOverlay").style.display = "flex";
    }
});

// Botão OK do modal → redireciona para catálogo
document.getElementById("btnModalOK").addEventListener("click", function() {
    window.location.href = "http://localhost/cloudflix/catalogo.php";
});