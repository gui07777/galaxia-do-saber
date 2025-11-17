<?php
session_start();

if (!isset($_SESSION['email_aluno'])) {
    header("Location: ../../../auth/student/login/student-login.html");
    exit;
}

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

            <?php if (!$id_turma): ?>
                <p>Você ainda não está vinculado a uma turma.</p>
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

            <div id="activity-list" class="activity-list">
                <?php
                if (!$id_turma) {
                    echo "<p style='text-align:center;'>Nenhuma turma associada.</p>";
                } else {
                    $sql = "SELECT 
            a.id_atividade,
            a.titulo,
            a.prazo,
            a.anexo,
            CASE WHEN a.anexo IS NOT NULL THEN 1 ELSE 0 END AS tem_anexo,
            
            CASE 
                WHEN a.prazo < NOW() THEN 'Atrasado'
                ELSE 'Pendente'
            END AS status_atividade

            FROM atividades a
            INNER JOIN turmaAtividade ta ON a.id_atividade = ta.id_atividade
            WHERE ta.id_turma = :id_turma
            ORDER BY a.data_post DESC";

                    $stmt = $conexao->prepare($sql);
                    $stmt->bindValue(':id_turma', $id_turma, PDO::PARAM_INT);
                    $stmt->execute();
                    $atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (empty($atividades)) {
                        echo "<p style='text-align:center;'>Não há atividades para esta turma.</p>";
                    } else {
                        foreach ($atividades as $atividade) {
                            ?>

                            <div class="activity-item">

                                <div class="activity-title">
                                    <strong><?= htmlspecialchars($atividade["titulo"]) ?></strong>

                                    <?php if ($atividade["tem_anexo"] == 1): ?>
                                        <a class="anexo-btn" target="_blank"
                                            href="../../../../Controller/verAnexo.php?id_atividade=<?= $atividade["id_atividade"] ?>">
                                            Ver anexo
                                        </a>
                                    <?php else: ?>
                                        <span class="no-anexo">Sem anexo</span>
                                    <?php endif; ?>
                                </div>

                                <div class="activity-info">
                                    <span><?= $atividade["prazo"] ?? "Sem prazo" ?></span>

                                    <?php
                                    $status = $atividade["status_atividade"];
                                    $classeStatus = ($status === "Atrasado") ? "status atrasado" : "status pendente";
                                    ?>

                                    <span class="<?= $classeStatus ?>">
                                        <?= $status ?>
                                    </span>
                                </div>

                            </div>

                            <?php
                        }
                    }
                }
                ?>