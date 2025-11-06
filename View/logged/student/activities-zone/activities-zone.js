async function carregarAtividades(idTurma) {
    const lista = document.getElementById("activity-list");

    try {
        const resposta = await fetch(`consultarAtividade.php?id_turma=${idTurma}`);
        const dados = await resposta.json();

        lista.innerHTML = "";

        if (dados.erro) {
            lista.innerHTML = `<p>Erro: ${dados.erro}</p>`;
            return;
        }

        if (dados.length === 0) {
            lista.innerHTML = "<p>Não há atividades atribuídas a esta turma.</p>";
            return;
        }

        dados.forEach((atividade) => {
            const item = document.createElement("div");
            item.classList.add("activity-item");

            const anexoBtn = atividade.link_anexo
                ? `<a href="${atividade.link_anexo}" target="_blank" class="anexo-btn">Ver anexo</a>`
                : `<span class="no-anexo">Sem anexo</span>`;

            item.innerHTML = `
                <div class="activity-title">
                    ${atividade.titulo}
                    ${anexoBtn}
                </div>
                <div class="activity-info">
                    <span>${atividade.prazo || "Sem prazo definido"}</span>
                    <span class="status">Pendente</span>
                </div>
            `;

            lista.appendChild(item);
        });
    } catch (erro) {
        lista.innerHTML = `<p>Erro ao carregar atividades: ${erro.message}</p>`;
    }
}
