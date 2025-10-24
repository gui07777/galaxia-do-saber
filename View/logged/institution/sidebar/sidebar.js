var sidebar = document.querySelector('#sidebar');
var openBtn = document.querySelector('#open_btn');
var registerItems = document.querySelector('#register-items');
var logoutModal = document.querySelector('#logout-modal');
var logoutSidebarButton = document.querySelector('#logout');
var link = document.querySelectorAll('a[data-page]')


//muda o estado da sidebar para aberto ou fechado
function toggleSidebar() {
    if (!sidebar) return;
    sidebar.classList.toggle('show-sidebar');
}

//se clica fora da sidebar, fecha
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

//problema de conflito entre eventos de click
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

//como sao mais de um link eu uso laço pra passar por cada um deles e colocar um ouvinte de clique
link.forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault(); //impeço navegação padrão

        const pageUrl = a.getAttribute('href');
        const pageName = a.dataset.page;

        //fetch para fazer uma requisiçaõ http ao pageUrl e pegar o href da pagina

        fetch(pageUrl)
        //tem esse then q nao sei oq faz mas ele tem como parametro uma response
        //se nao for ok que tambem nao sei oq significa, da erro e exibe o texto da resposta na tela com o return
            .then(response => {
                if (!response.ok) throw new Error('Erro ao carregar pagina')
                return response.text();
            })

            //nao entendi, nao sei oq o then faz
            .then(html => {
                document.querySelector('#main-content').innerHTML = html;
            })

            .catch(error => {
                document.querySelector('#main-content').innerHTML = `<p style="color: red;">Erro ${error.message}</p>`
            })
    })
})