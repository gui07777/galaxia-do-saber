var institutionHome = document.querySelector('#institution-home');
var classCreation = document.querySelector('#class-creation');

window.changeToClassCreation = function () {
    institutionHome.style.display = 'none';
    classCreation.style.display = 'flex';
}

window.backToInstitutionHome = function () {
    classCreation.style.display = 'none';
    institutionHome.style.display = 'flex';
}