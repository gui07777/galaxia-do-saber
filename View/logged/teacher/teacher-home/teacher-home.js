var teacherHome = document.querySelector('#teacher-home');
var activitiesCreation = document.querySelector('#activities-creation');

function changeToActivitiesCreation() {
    teacherHome.style.display = 'none';
    activitiesCreation.style.display = 'flex';
}

function backToTeacherHome() {
    activitiesCreation.style.display = 'none';
    teacherHome.style.display = 'flex';
}