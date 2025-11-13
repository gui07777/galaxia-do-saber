document.addEventListener("DOMContentLoaded", () => {
    
    fetch("../../../../Controller/BuscarAluno.php")
        .then(response => response.json())
        .then(data => {
            if (data.erro) {
                alert(data.erro);
                return;
            }

            document.getElementById("nome").value = data.nome || "";
            document.getElementById("email").value = data.email || "";
            document.getElementById("data_nasc").value = data.data_nasc || "";
            document.getElementById("turma").value = data.turma_nome || "";
        })
        .catch(err => console.error("Erro ao carregar dados do aluno:", err));
});

function navigationBack() {
    window.location.href = "../institution-home/institution-home.html";
}
