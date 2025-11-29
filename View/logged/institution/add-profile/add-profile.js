function navigationBack() {
  window.location.href = '../institution-home/institution-home.php';
}
function initAddProfile() {

  const radioProfessor = document.getElementById("professor");
  const radioAluno = document.getElementById("aluno");
  const selectProfessorDiv = document.getElementById("professorSelect");
  const selectAlunoDiv = document.getElementById("alunoSelect");

  const selectProfessor = document.getElementById("selectProfessor");
  const selectAluno = document.getElementById("selectAluno");
  const selectTurma = document.getElementById("selectTurma");

  const form = document.querySelector(".form");

  function atualizarExibicao() {
    selectProfessorDiv.style.display = radioProfessor.checked ? "block" : "none";
    selectAlunoDiv.style.display = radioAluno.checked ? "block" : "none";
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
    const idProfessor = selectProfessor.value;
    const idAluno = selectAluno.value;
    const turmaSelecionada = selectTurma.value;

    if (!radioProfessor.checked && !radioAluno.checked) {
      e.preventDefault();
      alert("Selecione Professor e/ou Aluno.");
      return;
    }

    if (radioProfessor.checked && idProfessor === "") {
      e.preventDefault();
      alert("Selecione um professor.");
      return;
    }

    if (radioAluno.checked && idAluno === "") {
      e.preventDefault();
      alert("Selecione um aluno.");
      return;
    }

    if (turmaSelecionada === "") {
      e.preventDefault();
      alert("Selecione uma turma.");
    }
  });
}
