function deleteFilme(id) {
    if (!confirm("Tem certeza que deseja excluir este filme?")) {
        return;
    }

    fetch(`http://localhost/cloudflix/backend/api.php?resource=filmes&id=${id}`, {
        method: "DELETE"
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message || "Filme excluído.");

        // Recarrega a página após deletar
        window.location.reload();
    })
    .catch(err => {
        alert("Erro ao excluir o filme.");
        console.error(err);
    });
}