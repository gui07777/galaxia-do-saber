var lista = document.getElementById("lista-comunicados");
var semComunicados = document.getElementById("sem-comunicados");

var mensagemInicial = document.getElementById("mensagem-inicial");
var detalhesComunicado = document.getElementById("detalhes-comunicado");

var detalheAssunto = document.getElementById("detalhe-assunto");
var detalheDescricao = document.getElementById("detalhe-descricao");

let comunicados = [];
let selecionado = null;

function carregarComunicados() {
  fetch("../../../../Controller/ListarComunicadosProfessor.php")
    .then(res => res.json())
    .then(data => {
      if (!data.success) {
        console.error("Erro no backend:", data.error);
        return;
      }

      comunicados = data.comunicados || [];
      atualizarLista();
    })
    .catch(err => {
      console.error("Erro de requisição:", err);
    });
}

function atualizarLista() {
  lista.innerHTML = "";
  selecionado = null;

  mensagemInicial.classList.remove("hidden");
  detalhesComunicado.classList.add("hidden");

  if (comunicados.length === 0) {
    semComunicados.style.display = "block";
    return;
  }

  semComunicados.style.display = "none";

  comunicados.forEach((c, index) => {
    const li = document.createElement("li");
    li.classList.add("item-comunicado");
    li.textContent = c.titulo || "(Sem título)";

    li.onclick = () => mostrarDetalhes(index);

    lista.appendChild(li);
  });
}

function mostrarDetalhes(index) {
  selecionado = index;
  const c = comunicados[index];

  document.querySelectorAll("#lista-comunicados li").forEach(li => {
    li.classList.remove("ativo");
  });

  const liSelecionado = lista.children[index];
  liSelecionado.classList.add("ativo");

  detalheAssunto.textContent = c.titulo || "(Sem título)";
  detalheDescricao.textContent = c.conteudo || "(Sem descrição)";

  mensagemInicial.classList.add("hidden");
  detalhesComunicado.classList.remove("hidden");
}

carregarComunicados();
