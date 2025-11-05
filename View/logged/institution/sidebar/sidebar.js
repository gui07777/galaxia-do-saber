var sidebar = document.querySelector('#sidebar');
var openBtn = document.querySelector('#open_btn');
var registerItems = document.querySelector('#register-items');
var logoutModal = document.querySelector('#logout-modal');
var logoutSidebarButton = document.querySelector('#logout');
var link = document.querySelectorAll('a[data-page]')

function toggleSidebar() {
    if (!sidebar) return;
    sidebar.classList.toggle('show-sidebar');
}

document.addEventListener('click', (event) => {
    if (!sidebar) return;
    const clickedOutside = !sidebar.contains(event.target)
        && !(openBtn && openBtn.contains(event.target))
        && !logoutSidebarButton.contains(event.target);
    if (clickedOutside) sidebar.classList.remove('show-sidebar');
})

function toggleRegisterItems() {
    if (!registerItems) return;
    registerItems.classList.toggle('show-register-items');
}

function openLogoutModal() {
    if (!sidebar.classList.contains('show-sidebar')) {
        return;
    } else {
        logoutModal.classList.add('show-logout-modal')
    }
}

function closeLogoutModal() {
    logoutModal.classList.remove('show-logout-modal');
}

link.forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault();

        const pageUrl = a.dataset.page;
        const cssUrl = pageUrl.substring(0, pageUrl.lastIndexOf('/')) + '/' +
            pageUrl.split('/').pop().replace('.html', '.css')

        fetch(pageUrl)
            .then(response => {
                if (!response.ok) throw new Error('Erro ao carregar pagina')
                return response.text();
            })

            .then(html => {
                document.querySelector('#app-content').innerHTML = html;

                const scriptUrl = pageUrl.substring(0, pageUrl.lastIndexOf('/')) + '/' +
                    pageUrl.split('/').pop().replace('.html.', '.js')

                const oldScript = document.querySelector('#dynamic-script');
                if (oldScript) oldScript.remove();

                const script = document.createElement('script');
                script.src = scriptUrl;
                script.id = 'dynamic-script';
                document.body.appendChild(script);

                const oldLink = document.querySelector('#dynamic-style');
                if (oldLink) oldLink.remove();

                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = cssUrl;
                console.log(link.href)
                link.id = 'dynamic-style';
                document.head.appendChild(link);
            })
            .catch(error => {
                document.querySelector('#app-content').innerHTML = `<p style="color: red;">Erro ${error.message}</p>`
            })
    })
})