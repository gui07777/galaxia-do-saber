const loader = document.querySelector('#loader');

window.addEventListener('pageshow', () => {
    loader.style.display = 'none';
    loader.classList.remove('show', 'hide');
});

function navigate(path) {
    loader.style.display = 'flex';
    loader.classList.add('show');
    loader.classList.remove('hide');

    setTimeout(() => {
        loader.classList.remove('show');
        loader.classList.add('hide');

        setTimeout(() => {
            if (path === "login") {
                window.location.href = '../auth/login/login.html';
            } else if (path === "register") {
                window.location.href = '../auth/register/register.html';
            }
        }, 1500);
    }, 1500);
}
