<?php
require_once('../../../../Model/conexaoBanco/Conexao.php');

$id_turma = $_SESSION['id_turma'] ?? $_GET['id_turma'] ?? null;
$nome_aluno = $_SESSION['nome_aluno'] ?? 'Aluno(a)';
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
        <img src="../../../../assets/icons/logosemfundo.png" class="logo" alt="Logo">
        <div class="width"></div>
        <div class="buttons">
            <img src="../../../../assets/icons/sininho.png" alt="Notificações">
            <img src="../../../../assets/icons/anonimous.png" alt="Perfil">
        </div>
    </header>

    <main>
        <div class="back">
            <img src="../../../../assets/icons/volte.png" alt="Voltar" onclick="history.back()">
        </div>

        <div class="titles">
            <h1>Bem-vindo(a), <?= htmlspecialchars($nome_aluno) ?>!</h1>

            <?php if (empty($id_turma)): ?>
                <p>Você ainda não está vinculado a uma turma. Aguarde a coordenação atribuir sua turma.</p>
            <?php else: ?>
                <p>Veja as atividades da sua turma abaixo.</p>
            <?php endif; ?>
        </div>

        <div class="activities">
            <div class="status-bar">
                <div><label>Tarefas</label></div>
                <div>
                    <label>Entrega</label>
                    <label>Status</label>
                </div>
            </div>

            <div class="activity-list">
                <?php
                if ($id_turma) {
                    include('../../../../Controller/ConsultarAtividade.php');
                } else {
                    echo "<p style='text-align:center; margin-top: 20px;'>Nenhuma turma associada.</p>";
                }
                ?>
            </div>
        </div>
    </main>

    <script src="activities-zone.js?v=4"></script>
</body>

</html>
