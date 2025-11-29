<?php

session_start();

if (!isset($_SESSION['email_aluno'])) {
    header("Location: ../../../auth/student/login/student-login.html");
    exit;
}

require_once '../../../../Model/conexaoBanco/Conexao.php';

if (!isset($_SESSION['email_aluno'])) {
    header("Location: ../../../auth/student/login/student-login.html");
    exit;
}
$emailAluno = $_SESSION['email_aluno'];

$sqlAluno = $conexao->prepare("
    SELECT id_aluno 
    FROM aluno 
    WHERE email = ?
");
$sqlAluno->execute([$emailAluno]);
$aluno = $sqlAluno->fetch(PDO::FETCH_ASSOC);

if (!$aluno) {
    die("Erro ao identificar aluno logado.");
}

$id_aluno = $aluno['id_aluno'];

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo estudante!</title>
    <link rel="stylesheet" href="student-notification.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body> 
    <header>
        <div>
            <img src="../../../../assets/icons/logosemfundo.png" class="logo">
        </div>
        <div class="header-buttons">
            <a href="#/student-profile" data-page="../student-profile/student-profile.php">
                <img src="../../../../assets/icons/anonimous.png" alt="">
            </a>
        </div>
    </header>

    <img src="../../../../assets/icons/volte.png" alt="" class="back" onclick="navigationBack()">

    <div id="general-comunication">
        <div class="header">

            <h1 class="titulo">Comunicados</h1>

            <div class="layout">
                <aside class="publicados">
                    <h2>Publicados</h2>
                    <ul id="lista-comunicados"></ul>
                    <p id="sem-comunicados"></p>
                </aside>

                <main class="painel">
                    <div id="mensagem-inicial" class="mensagem">
                        <p>Selecione um comunicado para ver os detalhes.</p>
                    </div>

                    <div id="detalhes-comunicado" class="detalhes hidden">
                        <p><strong>Ass:</strong> <span id="detalhe-assunto"></span></p>
                        <p><strong>Descrição:</strong> <span id="detalhe-descricao"></span></p>
                    </div>
                </main>

            </div>
        </div>
    </div>

    <script src="student-notifications.js"></script>
</body>
</html>
