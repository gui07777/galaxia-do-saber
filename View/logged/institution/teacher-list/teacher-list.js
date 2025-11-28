const modal = document.querySelector('#information-modal-hide');
const overlayHide = document.querySelector('#overlay-hide');
const btnVisualizar = document.querySelectorAll('.btn-visualizar');

const cpf = document.querySelector('#cpf');
const email = document.querySelector('#email');
const cargo = document.querySelector('#cargo');
const disciplina = document.querySelector('#disciplina');
const turma = document.querySelector('#turma');

btnVisualizar.forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute("data-id");
        loadInformation(id);
    });
});

function loadInformation(id) {
    fetch(`../../../../Controller/BuscarProfessorLista.php?id=${id}`)
        .then(res => res.json())
        .then(data => {

            cpf.value = data.cpf ?? "";
            email.value = data.email ?? "";
            cargo.value = data.cargo ?? "";
            disciplina.value = data.disciplina ?? "Nenhuma";
            turma.value = data.turma ?? "Nenhuma";

            viewModal();
        })
        .catch(err => console.error(err));
}

function viewModal() {
    overlayHide.classList.add('overlay');
    overlayHide.style.display = 'flex';
    modal.classList.add('information-modal');
    modal.style.display = 'flex';
}

function closeModal() {
    modal.style.display = 'none';
    overlayHide.style.display = 'none';
}

function editInformation() {
    window.location.href = "../teacher-edit/teacher-edit.php";
}
