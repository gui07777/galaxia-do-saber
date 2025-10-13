var sidebar = document.querySelector('#sidebar');
var openBtn = document.querySelector('#open_btn');
var registerItems = document.querySelector('#register-items');
var logoutModal = document.querySelector('#logout-modal');
var logoutSidebarButton = document.querySelector('#logout');


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