var sidebar = document.querySelector('#sidebar');
var openBtn = document.querySelector('#open_btn');

//muda o estado da sidebar para aberto ou fechado
function toggleSidebar() {
    if (!sidebar) return;
    sidebar.classList.toggle('show-sidebar');
}

//se clica fora da sidebar, fecha
document.addEventListener('click', (event) => {
    if (!sidebar) return;
    const clickedOutside = !sidebar.contains(event.target) && !(openBtn && openBtn.contains(event.target));
    if (clickedOutside) sidebar.classList.remove('show-sidebar');
})