const institutionHome = document.querySelector('#institution-home');
const classCreation = document.querySelector('#class-creation');
const turmas = document.querySelector('#turmas');

function changeToClassCreation() {
    institutionHome.style.display = 'none';
    turmas.style.display = 'none';
    classCreation.style.display = 'flex';
}

function backToInstitutionHome() {
    classCreation.style.display = 'none';
    if (turmas) {
        turmas.style.display = 'block';
    } else {
        institutionHome.style.display = 'block';
    }
}