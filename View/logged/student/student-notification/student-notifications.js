var lista = document.getElementById("lista-comunicados");
var semComunicados = document.getElementById("sem-comunicados");

var mensagemInicial = document.getElementById("mensagem-inicial");
var detalhesComunicado = document.getElementById("detalhes-comunicado");

var detalheAssunto = document.getElementById("detalhe-assunto");
var detalheDescricao = document.getElementById("detalhe-descricao");

let comunicados = [];
let selecionado = null;

function carregarComunicados() {
  fetch("../../../../Controller/ListarComunicadosAluno.php")
    .then(res => res.json())
    .then(data => {
      if (!data.success) {
        console.error("Erro no backend:", data.error);
        return;
      }

      comunicados = data.comunicados.filter(c => c.enviar_aluno == 1);
      atualizarLista();
    })
    .catch(err => {
      console.error("Erro de requisição:", err);
    });
}

function atualizarLista() {
  lista.innerHTML = "";
  selecionado = null;

  detalhesComunicado.classList.add("hidden");
  mensagemInicial.classList.remove("hidden");

  if (!comunicados || comunicados.length === 0) {
    semComunicados.style.display = "block";
    semComunicados.textContent = "Você não tem comunicados publicados";
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

  const liSelecionado = lista.children[index];
  liSelecionado.style.background = "#d7dcfa";
  liSelecionado.style.fontWeight = "bold";

  detalheAssunto.textContent = c.titulo;
  detalheDescricao.textContent = c.conteudo;

  mensagemInicial.classList.add("hidden");
  detalhesComunicado.classList.remove("hidden");
}

carregarComunicados();

function navigationBack() {
  window.location.href = '../student-home/student-home.php';
}
