let comunicados = [];
let selecionado = null;

var lista = document.getElementById("lista-comunicados");
var semComunicados = document.getElementById("sem-comunicados");

var mensagemInicial = document.getElementById("mensagem-inicial");
var formComunicado = document.getElementById("form-comunicado");
var detalhesComunicado = document.getElementById("detalhes-comunicado");

var btnAdicionar = document.getElementById("btn-adicionar");
var btnEditar = document.getElementById("btn-editar");

var inputAssunto = document.getElementById("assunto");
var inputDescricao = document.getElementById("descricao");

var cbProfessor = document.getElementById("cbProfessor");
var cbAluno = document.getElementById("cbAluno");

var detalheAssunto = document.getElementById("detalhe-assunto");
var detalheDescricao = document.getElementById("detalhe-descricao");

function carregarComunicados() {
  fetch("../../../../Controller/ListarComunicadosInstituicao.php")
    .then(res => res.json())
    .then(data => {
      if (!data.success) {
        console.error("Erro ao buscar comunicados:", data.error);
        return;
      }

      comunicados = data.comunicados;
      atualizarLista();
    })
    .catch(err => console.error("Erro de conexão:", err));
}

function atualizarLista() {
  lista.innerHTML = "";
  selecionado = null;

  mensagemInicial.classList.remove("hidden");
  detalhesComunicado.classList.add("hidden");

  if (!comunicados || comunicados.length === 0) {
    semComunicados.style.display = "block";
    return;
  }

  semComunicados.style.display = "none";

  comunicados.forEach((c, index) => {
    const li = document.createElement("li");
    li.textContent = c.titulo;
    li.classList.add("item-comunicado");

    li.onclick = () => mostrarDetalhes(index);

    lista.appendChild(li);
  });
}

function mostrarDetalhes(index) {
  selecionado = index;
  const c = comunicados[index];

  document.querySelectorAll("#lista-comunicados li").forEach(li => {
    li.style.background = "#eef1fb";
    li.style.fontWeight = "normal";
  });

  const liSel = lista.children[index];
  liSel.style.background = "#d7dcfa";
  liSel.style.fontWeight = "bold";

  detalheAssunto.textContent = c.titulo;
  detalheDescricao.textContent = c.conteudo;

  mensagemInicial.classList.add("hidden");
  formComunicado.classList.add("hidden");
  detalhesComunicado.classList.remove("hidden");
}

btnAdicionar.onclick = () => {
  selecionado = null;

  inputAssunto.value = "";
  inputDescricao.value = "";
  cbProfessor.checked = false;
  cbAluno.checked = false;

  mensagemInicial.classList.add("hidden");
  detalhesComunicado.classList.add("hidden");
  formComunicado.classList.remove("hidden");
};

formComunicado.onsubmit = (e) => {
  e.preventDefault();

  const assunto = inputAssunto.value.trim();
  const descricao = inputDescricao.value.trim();

  const formData = new FormData();
  formData.append("assunto", assunto);
  formData.append("descricao", descricao);

  formData.append("professor", cbProfessor.checked ? 1 : 0);
  formData.append("aluno", cbAluno.checked ? 1 : 0);

  fetch("../../../../Controller/SalvarComunicado.php", {
    method: "POST",
    body: formData
  })
    .then(r => r.text())
    .then(text => {
      try {
        const data = JSON.parse(text);

        if (data.success) {
          alert("Comunicado salvo com sucesso!");
          carregarComunicados();
        } else {
          alert("Erro ao salvar comunicado: " + (data.error || "Erro desconhecido"));
        }
      } catch (e) {
        console.error("Resposta inesperada do servidor:", text);
        alert("Erro inesperado do servidor.");
      }
    })
    .catch(err => {
      console.error("Erro de rede:", err);
      alert("Falha ao conectar ao servidor.");
    });

  inputAssunto.value = "";
  inputDescricao.value = "";
  cbProfessor.checked = false;
  cbAluno.checked = false;

  formComunicado.classList.add("hidden");
  mensagemInicial.classList.remove("hidden");
};

btnEditar.onclick = () => {
  if (selecionado === null) return;

  const c = comunicados[selecionado];

  inputAssunto.value = c.titulo;
  inputDescricao.value = c.conteudo;

  detalhesComunicado.classList.add("hidden");
  formComunicado.classList.remove("hidden");
};

carregarComunicados();
