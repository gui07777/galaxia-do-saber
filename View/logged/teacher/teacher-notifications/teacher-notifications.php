<?php
session_start();

require_once '../../../../Model/conexaoBanco/Conexao.php';

if (!isset($_SESSION['email_professor'])) {
    header("Location: ../../../auth/teacher/login/teacher-login.html");
    exit;
}

$emailProfessor = $_SESSION['email_professor'];

$sqlProfessor = $conexao->prepare("
    SELECT id_professor 
    FROM professor 
    WHERE email = ?
");
$sqlProfessor->execute([$emailProfessor]);
$professor = $sqlProfessor->fetch(PDO::FETCH_ASSOC);

if (!$professor) {
    die("Erro ao identificar professor logado.");
}

$id_professor = $professor['id_professor'];
?>

<link rel="stylesheet" href="teacher-notifications.css">

<div id="general-comunication">
    <div class="container">

        <h1 class="titulo">Comunicados</h1>

        <div class="layout">

            <aside class="publicados">
                <h2>Publicados</h2>

                <ul id="lista-comunicados"></ul>

                <p id="sem-comunicados">Nenhum comunicado foi publicado pela instituição.</p>
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

<script src="teacher-notifications.js"></script>
