const comunicados = [];
let selecionado = null;

const lista = document.getElementById("lista-comunicados");
const semComunicados = document.getElementById("sem-comunicados");

const mensagemInicial = document.getElementById("mensagem-inicial");
const formComunicado = document.getElementById("form-comunicado");
const detalhesComunicado = document.getElementById("detalhes-comunicado");

const btnAdicionar = document.getElementById("btn-adicionar");
const btnEditar = document.getElementById("btn-editar");

const inputAssunto = document.getElementById("assunto");
const inputDescricao = document.getElementById("descricao");

const detalheAssunto = document.getElementById("detalhe-assunto");
const detalheDescricao = document.getElementById("detalhe-descricao");

function atualizarLista() {
  lista.innerHTML = "";
  if (comunicados.length === 0) {
    semComunicados.style.display = "block";
  } else {
    semComunicados.style.display = "none";
    comunicados.forEach((comunicado, index) => {
      const li = document.createElement("li");
      li.textContent = comunicado.assunto;
      li.onclick = () => mostrarDetalhes(index);
      lista.appendChild(li);
    });
  }
}

function mostrarDetalhes(index) {
  selecionado = index;
  const comunicado = comunicados[index];
  detalheAssunto.textContent = comunicado.assunto;
  detalheDescricao.textContent = comunicado.descricao;

  mensagemInicial.classList.add("hidden");
  formComunicado.classList.add("hidden");
  detalhesComunicado.classList.remove("hidden");
}

btnAdicionar.onclick = () => {
  selecionado = null;
  inputAssunto.value = "";
  inputDescricao.value = "";

  mensagemInicial.classList.add("hidden");
  detalhesComunicado.classList.add("hidden");
  formComunicado.classList.remove("hidden");
};

formComunicado.onsubmit = (e) => {
  e.preventDefault();
  const novo = {
    assunto: inputAssunto.value,
    descricao: inputDescricao.value,
  };

  if (selecionado !== null) {
    comunicados[selecionado] = novo;
  } else {
    comunicados.push(novo);
  }

  inputAssunto.value = "";
  inputDescricao.value = "";
  selecionado = null;

  formComunicado.classList.add("hidden");
  mensagemInicial.classList.remove("hidden");
  atualizarLista();
};

btnEditar.onclick = () => {
  const comunicado = comunicados[selecionado];
  inputAssunto.value = comunicado.assunto;
  inputDescricao.value = comunicado.descricao;

  detalhesComunicado.classList.add("hidden");
  formComunicado.classList.remove("hidden");
};
