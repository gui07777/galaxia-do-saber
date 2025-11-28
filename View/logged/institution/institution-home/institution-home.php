<?php
session_start();

if (!isset($_SESSION['email_instituicao'])) {
    echo "<script>
        alert('Sessão expirada. Faça login novamente.');
        window.location.href='../../../auth/institution/login/institution-login.html';
    </script>";
    exit;
}

$idInstituicao = $_SESSION['id_instituicao'] ?? null;
?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
<!-- <link rel="stylesheet" href="institution-home.css"> -->

<div id="institution-home">
    <div class="header">
        <h1>Seja bem-vindo, Instituição!</h1>
        <h2>Crie a sua primeira turma</h2>
    </div>
    <button onclick="changeToClassCreation()">Criar</button>
</div>

<div id="class-creation" style="display: none">
    <form class="form" method="POST" action="../../../../Controller/TurmaController.php">
        <div class="container">
            <h1>Cadastro de turmas</h1>

            <input type="hidden" name="id_instituicao" value="<?= $_SESSION['id_instituicao'] ?>">


            <div class="fields">
                <div>
                    <label>Nome da Turma:</label>
                    <input type="text" name="nome" required>
                </div>
                <div>
                    <label>Descrição:</label>
                    <textarea name="descricao" id="descricao" cols="30" rows="5" required></textarea>
                </div>
            </div>

            <div class="buttons">
                <img src="../../../../assets/icons/volte.png" alt="" onclick="backToInstitutionHome()">
                <input type="submit" value="Cadastrar" name="requisicao">
            </div>
        </div>
    </form>
</div>
<!-- <script src="institution-home.js"></script> -->