navigateBack = () => {
        window.location.href = '../student-home/student-home.html';
}

document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector(".activities");

    fetch("consultaratividade.php")
        .then(response => response.json())
        .then(data => {
            if (data.erro) {
                container.innerHTML = `<p class="error">${data.erro}</p>`;
                return;
            }

            if (data.length === 0) {
                container.innerHTML += `<p class="empty">Nenhuma atividade encontrada.</p>`;
                return;
            }

            data.forEach(atividade => {
                const atividadeDiv = document.createElement("div");
                atividadeDiv.classList.add("atividade");

                atividadeDiv.innerHTML = `
                    <div class="atividade-info">
                        <h2>${atividade.titulo}</h2>
                        <p>Postada em: ${atividade.data_post}</p>
                    </div>
                    <div class="atividade-status">
                        <p>Prazo: ${atividade.prazo}</p>
                        <p>Status: Pendente</p>
                    </div>
                `;

                container.appendChild(atividadeDiv);
            });
        })
        .catch(err => {
            console.error(err);
            container.innerHTML = `<p class="error">Erro ao carregar atividades.</p>`;
        });
});