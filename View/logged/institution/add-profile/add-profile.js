function navigationBack() {
  window.location.href = '../institution-home/institution-home.html';
}

document.addEventListener("DOMContentLoaded", () => {
  const radioProfessor = document.getElementById("professor");
  const radioAluno = document.getElementById("aluno");
  const selectProfessorDiv = document.getElementById("professorSelect");
  const selectAlunoDiv = document.getElementById("alunoSelect");

  const selectProfessor = document.getElementById("selectProfessor");
  const selectAluno = document.getElementById("selectAluno");
  const selectTurma = document.getElementById("selectTurma");

  const form = document.querySelector(".form");

  function atualizarExibicao() {

  if (radioProfessor.checked) {
    selectProfessorDiv.style.display = "block";
  } else {
    selectProfessorDiv.style.display = "none";
  }

  if (radioAluno.checked) {
    selectAlunoDiv.style.display = "block";
  } else {
    selectAlunoDiv.style.display = "none";
  }
}


  radioProfessor.addEventListener("change", atualizarExibicao);
  radioAluno.addEventListener("change", atualizarExibicao);

  atualizarExibicao();

  fetch("../../../../Controller/getDados.php")
    .then(res => res.json())
    .then(dados => {
      dados.professores.forEach(prof => {
        const option = document.createElement("option");
        option.value = prof.id_professor;
        option.textContent = prof.nome;
        selectProfessor.appendChild(option);
      });

      dados.alunos.forEach(al => {
        const option = document.createElement("option");
        option.value = al.id_aluno;
        option.textContent = al.nome;
        selectAluno.appendChild(option);
      });

      dados.turmas.forEach(turma => {
        const option = document.createElement("option");
        option.value = turma.id_turma;
        option.textContent = turma.nome;
        selectTurma.appendChild(option);
      });
    })
    .catch(err => {
      console.error("Erro ao carregar dados:", err);
      alert("Erro ao carregar dados das turmas e perfis.");
    });

  form.addEventListener("submit", (e) => {
    const tiposSelecionados = document.querySelectorAll('input[name="tipo[]"]:checked');
    const turmaSelecionada = selectTurma.value;
    const idProfessor = selectProfessor.value;
    const idAluno = selectAluno.value;

   if (tiposSelecionados.length === 0) {
  e.preventDefault();
  alert("Selecione Professor e/ou Aluno.");
  return;
  }


   if (document.getElementById("professor").checked && selectProfessor.value === "") {
  e.preventDefault();
  alert("Selecione um professor.");
  return;
}

if (document.getElementById("aluno").checked && selectAluno.value === "") {
  e.preventDefault();
  alert("Selecione um aluno.");
  return;
}


    if (turmaSelecionada === "") {
      e.preventDefault();
      alert("Selecione uma turma.");
      return;
    }
  });
});
