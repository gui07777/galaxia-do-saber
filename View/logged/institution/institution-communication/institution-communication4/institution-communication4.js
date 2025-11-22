const editarBtn = document.getElementById('editar');
const salvarBtn = document.getElementById('salvar');
const assunto = document.getElementById('assunto');
const descricao = document.getElementById('descricao');


editarBtn.addEventListener('click', () => {
assunto.setAttribute('contenteditable','true');
descricao.setAttribute('contenteditable','true');
assunto.focus();
});


salvarBtn.addEventListener('click', () => {
assunto.setAttribute('contenteditable','false');
descricao.setAttribute('contenteditable','false');
});