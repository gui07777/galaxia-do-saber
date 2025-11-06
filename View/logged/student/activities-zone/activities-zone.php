<?php

session_start();
if (!isset($_SESSION['id_aluno'])) {
    header('Location: ../../../auth/student/login/student-login.html');
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suas atividades</title>
    <link rel="stylesheet" href="activities-zone.css?v=4">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <img src="../../../../assets/icons/logosemfundo.png" class="logo">
        <div class="width"></div>
        <div class="buttons">
            <img src="../../../../assets/icons/sininho.png" alt="Notificações">
            <img src="../../../../assets/icons/anonimous.png" alt="Perfil">
        </div>
    </header>

    <main>
        <div class="back">
            <img src="../../../../assets/icons/volte.png" alt="Voltar" onclick="navigateBack()">
        </div>

        <div class="titles">
            <h1>Bem vindo(a), <?= htmlspecialchars($_SESSION['nome_aluno']) ?>!</h1>

            <?php if (empty($_SESSION['id_turma'])): ?>
                <p>Você ainda não está vinculado a uma turma. Aguarde a coordenação atribuir sua turma.</p>
            <?php else: ?>
                <p>Veja as atividades da sua turma.</p>
            <?php endif; ?>
        </div>

        <div class="activities">
            <?php if (empty($_SESSION['id_turma'])): ?>
                <div class="status-bar" style="text-align:center; margin-top:20px;">
                    <p>Sem atividades disponíveis no momento.</p>
                </div>
            <?php else: ?>
                <div class="status-bar">
                    <div><label>Tarefas</label></div>
                    <div>
                        <label>Entrega</label>
                        <label>Status</label>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script src="activities-zone.js?v=3"></script>
</body>
</html>
