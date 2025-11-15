document.addEventListener("DOMContentLoaded", () => {

    fetch("../../../../Controller/BuscarProfessor.php")
        .then(response => response.json())
        .then(data => {
            if (data.erro) {
                alert(data.erro);
                return;
            }

            document.getElementById("nome").value = data.nome || "";
            document.getElementById("email").value = data.email || "";
            document.getElementById("cargo").value = data.cargo || "";
            document.getElementById("disciplina").value = data.disciplina || "";

        })
        .catch(err => console.error("Erro ao carregar dados do professor:", err));
});

function navigationBack() {
    window.location.href = "../teacher-home/teacher-home.php";
}
