document.addEventListener('DOMContentLoaded', () => {
    slidesTour();
    loadAnimation();
})

function slidesTour() {
    let count = 1;
    const firstRadio = document.querySelector('#radio1');
    if (firstRadio) firstRadio.checked = true;

    setInterval(() => {
        count++;
        if (count > 3) {
            count = 1;
        }

        const radio = document.querySelector('#radio' + count);
        if (radio) {
            radio.checked = true;
        } else {
            console.warn('radio não encontrado:', '#radio' + count);
        }
    }, 3000);
}

let loader = null;

function loadAnimation() {
    loader = document.querySelector('#loader');

    if (!loader) {
        console.warn('#loader nao encotrado no DOM');
        return;
    }

    window.addEventListener('pageshow', () => {
        loader.style.display = 'none';
        loader.classList.remove('show', 'hide');
    });
}

function navigateRegister() {
    if (!loader) loader = document.querySelector('#loader');

    if (loader) {
        loader.style.display = 'flex';
        loader.classList.add('show');
        loader.classList.remove('hide');
    } else {
        console.warn('navigateRoutes: #loader nao disponivel');
    }

    setTimeout(() => {
        if (loader) {
            loader.classList.remove('show');
            loader.classList.add('hide');
        }

        setTimeout(() => {
            window.location.href = '../auth/institution/register/register.html';
        }, 1500);
    }, 1500);
}

var modal = document.querySelector('#modal');

function openModal() {
    modal.classList.add('show-modal');
}

function navigateLogin(path) {
    if (!loader) loader = document.querySelector('#loader');

    if (loader) {
        loader.style.display = 'flex';
        loader.classList.add('show');
        loader.classList.remove('hide');
    } else {
        console.warn('navigateRoutes: #loader nao disponivel');
    }

    setTimeout(() => {
        if (loader) {
            loader.classList.remove('show');
            loader.classList.add('hide');
        }

        setTimeout(() => {
            if (path === 'institution') {
                window.location.href = '../auth/institution/login/institution-login.html';
            } else if (path === 'teacher') {
                window.location.href = '../auth/teacher/login/teacher-login.html';
            } else if (path === 'student') {
                window.location.href = '../auth/student/login/student-login.html';
            }
        }, 1500);
    }, 1500);
}