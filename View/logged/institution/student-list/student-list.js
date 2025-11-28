const modal = document.querySelector('#information-modal-hide');
const overlayHide = document.querySelector('#overlay-hide');
const btnVisualizar = document.querySelectorAll('.btn-visualizar');

const nome = document.querySelector('#nome');
const matricula = document.querySelector('#matricula');
const email = document.querySelector('#email');
const nasc = document.querySelector('#nasc');
const turma = document.querySelector('#turma');

btnVisualizar.forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute("data-id");

        if (!id) {
            console.error("ID do aluno não encontrado no botão.");
            return;
        }

        loadInformation(id);
    });
});

function loadInformation(id) {

    fetch(`../../../../Controller/BuscarAlunoLista.php?id=${id}`)
        .then(res => res.json())
        .then(data => {

            if (data.erro) {
                console.error("Erro retornado pelo PHP:", data.erro);
                alert("Não foi possível carregar as informações do aluno.");
                return;
            }

            nome.value = data.nome ?? "";
            matricula.value = data.numero_matricula ?? "";
            email.value = data.email ?? "";
            nasc.value = data.data_nasc ?? "";
            turma.value = data.turma ?? "Nenhuma";

            viewModal();
        })
        .catch(err => {
            console.error("Erro na requisição:", err);
            alert("Ocorreu um erro ao buscar os dados.");
        });
}

function viewModal() {
    overlayHide.classList.add('overlay');
    overlayHide.style.display = 'flex';
    modal.classList.add('information-modal');
    modal.style.display = 'flex';
}

function closeModal() {
    modal.classList.remove('information-modal');
    modal.style.display = 'none';
    overlayHide.classList.remove('overlay');
    overlayHide.style.display = 'none';
}

function editInformation() {
    window.location.href = "../student-edit/student-edit.php";
}
