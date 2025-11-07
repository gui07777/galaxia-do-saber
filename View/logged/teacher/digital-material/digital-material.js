function adicionarAtividade() {
  const assunto = document.getElementById('assunto').value.trim();
  const descricao = document.getElementById('descricao').value.trim();

  if (!assunto || !descricao) {
    alert("Por favor, preencha todos os campos antes de adicionar.");
    return;
  }

  alert(`Atividade adicionada!\n\nAssunto: ${assunto}\nDescrição: ${descricao}`);
}
