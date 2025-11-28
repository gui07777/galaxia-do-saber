<?php

session_start();

if (!isset($_SESSION['email_instituicao'])) {
    echo "<script>
        alert('Sessão expirada. Faça login novamente.');
        window.location.href='../../../auth/institution/login/institution-login.html';
    </script>";
    exit;
}

require_once('../../../../Model/conexaoBanco/Conexao.php');
?>


<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
<link rel="stylesheet" href="student-edit.css">
<div id="student-edit">
    <form class="form" method="POST" form action="../../../../Controller/AtualizarAlunoSidebar.php">
        <div class="container">
            <h2>Editar Aluno</h2>
            <div class="fields">
                <div class="left-side">
                    <div>
                        <label for="">Nome:</label>
                        <input type="text" name="nome">
                    </div>
                    <div>
                        <label for="">Número da matrícula:</label>
                        <input type="text" name="numero_matricula"></input>
                    </div>
                    <div>
                        <label for="">Data de Nascimento:</label>
                        <input type="text" name="data_nasc">
                    </div>
                </div>
                <div class="right-side">
                    <div>
                        <label for="">Email:</label>
                        <input type="text" name="email">
                    </div>
                    <div>
                        <label for="">Senha:</label>
                        <input type="password" name="senha"></input>
                    </div>
                    <div>
                        <label for="">Repetir senha:</label>
                        <input type="password" name="repetir_senha"></input>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <a href="../student-edit/student-edit.php">
                    <img src="../../../../assets/icons/volte.png" alt="">
                </a>
                <input type="submit" name="requisicao" value="Atualizar">
            </div>
        </div>
    </form>
</div>