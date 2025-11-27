document.addEventListener('DOMContentLoaded', () => {
    fetch('../../../../Controller/ListarNotificacoes.php')
        .then(res => res.json())
        .then(data => {
            const container = document.querySelector('.fields');
            container.innerHTML = '';

            if (data.length === 0) {
                container.innerHTML = '<p>Sem notificações</p>';
                return;
            }

            data.forEach(notif => {
                container.innerHTML += `
                    <div class="notification">
                        <span class="material-symbols-outlined">
                            notifications
                        </span>
                        <p>${notif.message}</p>
                    </div>
                `;
            });
        });
});
