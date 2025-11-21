const btnAdd = document.getElementById("btn-add");
const lista = document.getElementById("lista-comunicados");
const asideEmpty = document.getElementById("aside-empty");

btnAdd.addEventListener("click", () => {
    const texto = prompt("Digite o comunicado:");

    if (texto && texto.trim() !== "") {
        const li = document.createElement("li");
        li.textContent = texto;
        lista.appendChild(li);

        asideEmpty.style.display = "none";
    }
});