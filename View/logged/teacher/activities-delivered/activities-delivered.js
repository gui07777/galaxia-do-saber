const modal = document.querySelector('#activities-delivered-modal-hide');
const overlayHide = document.querySelector('#overlay-hide');
const btnVisualizar = document.querySelectorAll('.btn-visualizar');
const closeModalBtn = document.querySelector('#closeModal');

btnVisualizar.forEach(btn => {
    btn.addEventListener('click', () => {

        const id = btn.dataset.id;
        const aluno = btn.dataset.aluno;
        const atividade = btn.dataset.atividade;
        const arquivo = btn.dataset.arquivo;
        const nota = btn.dataset.nota;

        if (!id) {
            console.error("ERRO: data-id não encontrado no botão:", btn);
            alert("Erro interno: ID da resposta não encontrado.");
            return;
        }

        document.querySelector('#modal-id-resposta').value = id;
        document.querySelector('#modal-aluno').textContent = aluno ?? "";
        document.querySelector('#modal-atividade').textContent = atividade ?? "";

        const linkArquivo = document.querySelector('#modal-arquivo');

        if (arquivo && arquivo.trim() !== "") {
            linkArquivo.textContent = "Baixar arquivo";
            linkArquivo.href = "../../../../Controller/Download.php?id=" + id;
        } else {
            linkArquivo.textContent = "Nenhum arquivo enviado";
            linkArquivo.removeAttribute("href");
        }

        document.querySelector('#modal-nota').value = nota ?? "";

        openModal();
    });
});

function openModal() {
    overlayHide.style.display = "flex";
    modal.style.display = "flex";
    overlayHide.classList.add('overlay');
    modal.classList.add('activities-delivered-modal');
}

function closeModal() {
    modal.style.display = "none";
    overlayHide.style.display = "none";
}

closeModalBtn.addEventListener('click', closeModal);
overlayHide.addEventListener('click', closeModal);

document.querySelector('#btnSalvarNota').addEventListener('click', () => {
    const id = document.querySelector('#modal-id-resposta').value;
    const nota = document.querySelector('#modal-nota').value;

    if (nota < 0 || nota > 10) {
        alert("A nota deve ser entre 0 e 10.");
        return;
    }

    fetch("../../../../Controller/SalvarNota.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id_resposta=${id}&nota=${nota}`
    })
    .then(res => res.text())
    .then(response => {
        alert("Nota salva!");
        closeModal();
        location.reload();
    });
});
