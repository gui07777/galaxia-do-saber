const institutionHome = document.querySelector('#institution-home');
const classCreation = document.querySelector('#class-creation');

window.changeToClassCreation = function () {
    institutionHome.style.display = 'none';
    classCreation.style.display = 'flex';
}

window.backToInstitutionHome = function () {
    classCreation.style.display = 'none';
    institutionHome.style.display = 'block';
}