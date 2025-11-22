const institutionHome = document.querySelector('#institution-home');
const classCreation = document.querySelector('#class-creation');

function changeToClassCreation() {
    institutionHome.style.display = 'none';
    classCreation.style.display = 'flex';
}

function backToInstitutionHome() {
    classCreation.style.display = 'none';
    institutionHome.style.display = 'flex';
}