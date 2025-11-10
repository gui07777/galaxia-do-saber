const buttons = document.querySelectorAll(".menu-item");
const titulo = document.getElementById("titulo-comunicado");
const texto = document.getElementById("texto-comunicado");

// Guarda o texto de cada comunicado separadamente
const comunicados = {
  1: "",
  2: "",
  3: ""
};

// Clique em cada botão lateral
buttons.forEach((btn) => {
  btn.addEventListener("click", () => {
    // Salva o texto do comunicado atual
    const ativo = document.querySelector(".menu-item.active");
    if (ativo) {
      const idAtivo = ativo.dataset.target;
      comunicados[idAtivo] = texto.value;
      ativo.classList.remove("active");
    }

    // Define o novo ativo
    btn.classList.add("active");
    const id = btn.dataset.target;

    // Atualiza o título e o texto
    titulo.textContent = `Comunicados ${id}`;
    texto.value = comunicados[id];
  });
});

// Atualiza o objeto ao digitar
texto.addEventListener("input", () => {
  const ativo = document.querySelector(".menu-item.active");
  if (ativo) {
    const id = ativo.dataset.target;
    comunicados[id] = texto.value;
  }
});
