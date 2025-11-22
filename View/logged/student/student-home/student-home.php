<?php

session_start();

if (!isset($_SESSION['email_aluno'])) {
    header("Location: ../../../auth/student/login/student-login.html");
    exit;
}

$nome_aluno = $_SESSION['nome_aluno'] ?? 'Aluno(a)';

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
            <a href="">
                <img src="../../../../assets/icons/sininho.png" alt="">
            </a>
            <a href="../student-profile/student-profile.php">
                <img src="../../../../assets/icons/anonimous.png" alt="">
            </a>
        </div>
    </header>
    <main>
        <div class="titles">
            <h1>Bem-vindo(a), <?= htmlspecialchars($nome_aluno) ?>!</h1>
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
        </div>
    </main>

</body>
<script src="student-home.js"></script>
</html>