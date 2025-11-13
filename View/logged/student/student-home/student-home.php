<?php

session_start();

if (!isset($_SESSION['email_aluno'])) {
    header("Location: ../../../auth/student/login/student-login.html");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo estudante!</title>
    <link rel="stylesheet" href="student-home.css?v=4">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body> 
    <header>
        <img src="../../../../assets/icons/logosemfundo.png" class="logo">
        <div class="width"></div>
        <div class="buttons">
            <img src="../../../../assets/icons/sininho.png" alt="">
            <img src="../../../../assets/icons/nova-mensagem.png" alt="" width="42px">
            <img src="../../../../assets/icons/anonimous.png" alt="">
        </div>
    </header>
    <main>
        <div class="titles">
            <h1>Bem vindo(a) Descobridor(a)!</h1>
            <p>Acesse os planetas</p>
        </div>
        <div class="planets">
            <div onclick="navigate('atividades')">
                <img src="../../../../assets/icons/plan-atividades.png" alt="">
                <label for="">Atividades</label>
            </div>
            <div onclick="navigate('agenda')">
                <img src="../../../../assets/icons/plan-agenda.png" alt="">
                <label for="">Agenda</label>
            </div>
            <div onclick="navigate('jogos')">
                <img src="../../../../assets/icons/plan-jogos.png" alt="">
                <label for="">Jogos</label>
            </div>
            <div onclick="navigate('progresso')">
                <img src="../../../../assets/icons/plan-progresso.png" alt="">
                <label for="">Progresso</label>
            </div>
        </div>
    </main>

</body>
<script src="student-home.js"></script>
</html>