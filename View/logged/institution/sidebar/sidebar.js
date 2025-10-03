var sidebar = document.querySelector('#sidebar');
var openBtn = document.querySelector('#open_btn')

function openSidebar() {
    if (sidebar) sidebar.classList.add('show-sidebar')
}

document.addEventListener('click', (event) => {
    if (!sidebar.contains(event.target) && !openBtn.contains(event.target)) {
        sidebar.classList.remove('show-sidebar')
    }
})