document.addEventListener("DOMContentLoaded", () => {
  const telefoneInput = document.getElementById("telefone");

  telefoneInput.addEventListener("input", () => {
    let v = telefoneInput.value.replace(/\D/g, "");

    if (v.length > 11) v = v.slice(0, 11);

    if (v.length > 10) {
      v = v.replace(/(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
    } else if (v.length > 6) {
      v = v.replace(/(\d{2})(\d{4})(\d{0,4})/, "($1) $2-$3");
    } else if (v.length > 2) {
      v = v.replace(/(\d{2})(\d{0,5})/, "($1) $2");
    } else {
      v = v.replace(/(\d{0,2})/, "($1");
    }

    telefoneInput.value = v;
  });
});
