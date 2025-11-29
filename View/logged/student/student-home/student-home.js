function navigate(path) {
    if (path === 'atividades') {
        window.location.href = '../activities-zone/activities-zone.php';
    }
    else if (path === 'agenda') {
        window.location.href = '../student-agenda/student-agenda.html';
    }
    else if (path === 'jogos') {
        window.location.href = '../game-zone/game-zone.html';
    } else {
        //toastr erro
        console.error('erro')
    }
}