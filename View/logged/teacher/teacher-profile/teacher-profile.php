<?php

session_start();

if (!isset($_SESSION['email_professor'])) {
header("Location: ../../../auth/teacher/login/teacher-login.html");
exit;
}
?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
<link rel="stylesheet" href="teacher-profile.css">

<div id="teacher-profile">
    <form class="container" action="../../../../Controller/ProfessorController.php" method="post">
        <h2>Informações do perfil</h2>
        <div class="fields">
            <div class="left-side">
                <div>
                    <label for="">Nome:</label>
                    <input type="text" id="nome" name="nome" readonly>
                </div>
                <div>
                    <label for="">Cargo:</label>
                    <input type="text" id="cargo" name="cargo" readonly>
                </div>
                <div>
                    <label for="">Senha:</label>
                    <input type="password" id="senha" name="novaSenha">
                </div>
            </div>
            <div class="right-side">
                <div>
                    <label for="">Email:</label>
                    <input type="text" id="email" name="email" readonly>
                </div>
                <div>
                    <label for="">Disciplina:</label>
                    <input type="text" id="disciplina" name="disciplina" readonly>
                </div>
            </div>
        </div>
        <div class="buttons">
            <!-- <img src="../../../../assets/icons/volte.png" alt="" onclick="navigationBack()"> -->
            <input type="submit" name="requisicao" value="Editar">
        </div>
    </form>
</div>

<script src="teacher-profile.js"></script>
