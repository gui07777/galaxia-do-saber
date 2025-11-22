var sidebar = document.querySelector('#sidebar');
var openBtn = document.querySelector('#open_btn');
var registerItems = document.querySelector('#register-items');
var logoutModal = document.querySelector('#logout-modal');
var logoutSidebarButton = document.querySelector('#logout');
var links = document.querySelectorAll('a[data-page]');

function toggleSidebar() {
    const isOpen = document.body.classList.contains('sidebar-open');
    if (isOpen) {
        document.body.classList.remove('sidebar-open');
        sidebar.classList.remove('show-sidebar');
        openBtn.setAttribute('aria-expanded', 'false');
    } else {
        document.body.classList.add('sidebar-open');
        sidebar.classList.add('show-sidebar');
        openBtn.setAttribute('aria-expanded', 'true');
    }
}

function toggleRegisterItems() {
    if (!registerItems) return;
    registerItems.classList.toggle('show-register-items');
}

function openLogoutModal() {
    logoutModal.classList.add('show-logout-modal');
    document.body.classList.add('modal-open');
}

function closeLogoutModal() {
    logoutModal.classList.remove('show-logout-modal');
    document.body.classList.remove('modal-open');
}

function logoutAccount() {
    window.location.href = '../../../landing-page/landing-page.html';
}

function loadPage(pageUrl) {
    if (!pageUrl) {
        console.error('loadPage: pageUrl inválido:', pageUrl);
        return;
    }

    let cssUrl = '';

    if (pageUrl.includes('html')) {
        cssUrl = pageUrl.substring(0, pageUrl.lastIndexOf('/')) + '/' +
            pageUrl.split('/').pop().replace('.html', '.css');
    } else {
        cssUrl = pageUrl.substring(0, pageUrl.lastIndexOf('/')) + '/' +
            pageUrl.split('/').pop().replace('.php', '.css');
    }

    fetch(pageUrl)
        .then(response => {
            if (!response.ok) throw new Error('Erro ao carregar página: ' + response.statusText);
            return response.text();
        })
        .then(html => {
            document.querySelector('#app-content').innerHTML = html;

            const oldScript = document.querySelector('#dynamic-script');
            if (oldScript) oldScript.remove();

            const scriptUrl = pageUrl.substring(0, pageUrl.lastIndexOf('/')) + '/' +
                pageUrl.split('/').pop().replace('.html', '.js');

            const script = document.createElement('script');
            script.src = scriptUrl;
            script.id = 'dynamic-script';
            script.async = false;
            document.body.appendChild(script);

            script.onload = () => {
                if (typeof initAddProfile === 'function') {
                    initAddProfile()
                }
            };

            const oldLink = document.querySelector('#dynamic-style');
            if (oldLink) oldLink.remove();

            const stylesheetLink = document.createElement('link');
            stylesheetLink.rel = 'stylesheet';
            stylesheetLink.href = cssUrl;
            stylesheetLink.id = 'dynamic-style';
            document.head.appendChild(stylesheetLink);
        })
        .catch(error => {
            console.error(error);
            document.querySelector('#app-content').innerHTML = `<p style="color: red;">Erro: ${error.message}</p>`;
        });
}

links.forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault();

        document.querySelectorAll('.side-item').forEach(item => item.classList.remove('active'));
        const sideItem = a.closest('.side-item');
        if (sideItem) sideItem.classList.add('active');

        const pageUrl = a.dataset.page;
        loadPage(pageUrl);
    });
});

window.addEventListener('DOMContentLoaded', () => {
    const defaultPage = "../teacher-home/teacher-home.php";

    const homeItem = document.querySelector('a[data-page="' + defaultPage + '"]');
    if (homeItem && homeItem.closest('.side-item')) {
        homeItem.closest('.side-item').classList.add('active');
    } else {
        const firstSideItem = document.querySelector('.side-item');
        if (firstSideItem) firstSideItem.classList.add('active');
    }

    loadPage(defaultPage);
});
