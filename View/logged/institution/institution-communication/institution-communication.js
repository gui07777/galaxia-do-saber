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

/* ===================================================
   Atualiza a lista local (lado esquerdo)
=================================================== */
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

/* ===================================================
   Exibe detalhes do comunicado
=================================================== */
function mostrarDetalhes(index) {
  selecionado = index;
  const comunicado = comunicados[index];

  detalheAssunto.textContent = comunicado.assunto;
  detalheDescricao.textContent = comunicado.descricao;

  mensagemInicial.classList.add("hidden");
  formComunicado.classList.add("hidden");
  detalhesComunicado.classList.remove("hidden");
}

/* ===================================================
   Botão "Adicionar"
=================================================== */
btnAdicionar.onclick = () => {
  selecionado = null;
  inputAssunto.value = "";
  inputDescricao.value = "";

  mensagemInicial.classList.add("hidden");
  detalhesComunicado.classList.add("hidden");
  formComunicado.classList.remove("hidden");
};

/* ===================================================
   Submit do formulário (AGORA COM BACKEND)
=================================================== */
formComunicado.onsubmit = (e) => {
  e.preventDefault();

  const novo = {
    assunto: inputAssunto.value,
    descricao: inputDescricao.value
  };

  // Atualiza UI local
  if (selecionado !== null) {
    comunicados[selecionado] = novo;
  } else {
    comunicados.push(novo);
  }

  // === ENVIO PARA O BACKEND ===
  const formData = new FormData();
  formData.append("assunto", novo.assunto);
  formData.append("descricao", novo.descricao);

  // ... dentro do seu formComunicado.onsubmit após formData criado ...

  fetch("../../../../Controller/SalvarComunicado.php", {
    method: "POST",
    body: formData
  })
    .then(async res => {
      const text = await res.text();

      // Tenta parsear JSON. Se falhar, mostra o texto bruto para debugging.
      try {
        const data = JSON.parse(text);

        if (data.success) {
          console.log("Comunicado salvo e notificação enviada!", data);
          // opcional: atualizar lista a partir do backend ou mostrar mensagem
        } else {
          console.error("Erro do backend:", data.error);
          alert("Erro ao salvar comunicado: " + (data.error || 'Erro desconhecido'));
        }
      } catch (parseErr) {
        // Quando o parse falha, mostramos o conteúdo retornado (provavelmente HTML)
        console.error("Resposta inesperada do servidor (não JSON):", text);
        alert("Resposta inesperada do servidor. Veja console para detalhes.");
      }
    })
    .catch(err => {
      console.error("Erro de rede:", err);
      alert("Erro de conexão com o servidor");
    });


  // Reset UI
  inputAssunto.value = "";
  inputDescricao.value = "";
  selecionado = null;

  formComunicado.classList.add("hidden");
  mensagemInicial.classList.remove("hidden");

  atualizarLista();
};

/* ===================================================
   Editar comunicado (somente visual)
=================================================== */
btnEditar.onclick = () => {
  if (selecionado === null) return;

  const comunicado = comunicados[selecionado];

  inputAssunto.value = comunicado.assunto;
  inputDescricao.value = comunicado.descricao;

  detalhesComunicado.classList.add("hidden");
  formComunicado.classList.remove("hidden");
};

/* ===================================================
   Inicializar lista vazia
=================================================== */
atualizarLista();
