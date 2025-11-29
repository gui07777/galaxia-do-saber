var modal = document.querySelector('#activities-delivered-modal-hide');
var overlayHide = document.querySelector('#overlay-hide');
var btnVisualizar = document.querySelectorAll('.btn-visualizar');
var closeModalBtn = document.querySelector('#closeModal');

btnVisualizar.forEach(btn => {
    btn.addEventListener('click', () => {

        var id = btn.dataset.id;
        var aluno = btn.dataset.aluno;
        var atividade = btn.dataset.atividade;
        var arquivo = btn.dataset.arquivo;
        var nota = btn.dataset.nota;

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
