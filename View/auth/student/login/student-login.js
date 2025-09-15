function navigateBack() {
    window.location.href = '../../../landing-page/landing-page.html'
}

let modal = document.querySelector('#modal');

function openModal() {
    document.body.style.background = 'white';
    document.body.style.opacity = '0.8';

    modal.classList.add('show');
}

function closeModal() {
    modal.classList.remove('show');
}