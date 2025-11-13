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

            if (data.data_nasc) {
                const partes = data.data_nasc.split("/");
                if (partes.length === 3) {
                    const dataISO = `${partes[2]}-${partes[1]}-${partes[0]}`; 
                    document.getElementById("data_nasc").value = dataISO;
                }
            }

            document.getElementById("turma").value = data.turma_nome || "";
        })
        .catch(err => console.error("Erro ao carregar dados do aluno:", err));
});

function navigationBack() {
    window.location.href = "../institution-home/institution-home.html";
}
