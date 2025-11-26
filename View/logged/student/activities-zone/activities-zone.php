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
    <link rel="stylesheet" href="activities-zone.css?v=5">
</head>

<body>

<header>
    <img src="../../../../assets/icons/logosemfundo.png" class="logo" alt="Logo">
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
            <div><label>Entrega</label></div>
            <div><label>Nota</label></div>
            <div><label>Ação</label></div>
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
                        r.nota,
                        r.data_envio
                    FROM atividades a
                    INNER JOIN turmaAtividade ta ON a.id_atividade = ta.id_atividade
                    LEFT JOIN resposta r ON 
                        r.id_atividade = a.id_atividade 
                        AND r.id_aluno = :id_aluno
                    WHERE ta.id_turma = :id_turma
                    ORDER BY a.data_post DESC";

                $stmt = $conexao->prepare($sql);
                $stmt->bindValue(':id_turma', $id_turma, PDO::PARAM_INT);
                $stmt->bindValue(':id_aluno', $_SESSION['id_aluno'], PDO::PARAM_INT);
                $stmt->execute();
                $atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($atividades)) {
                    echo "<p style='text-align:center;'>Não há atividades para esta turma.</p>";
                } else {
                    foreach ($atividades as $atividade) {

                        $data_brasil = $atividade["prazo"]
                            ? date("d/m/Y", strtotime($atividade["prazo"]))
                            : "Sem prazo";
            ?>

            <div class="activity-item">

                <div class="activity-title">
                    <strong><?= htmlspecialchars($atividade["titulo"]) ?></strong>

                    <?php if ($atividade["tem_anexo"]): ?>
                        <a class="anexo-btn" target="_blank"
                           href="../../../../Controller/verAnexo.php?id_atividade=<?= $atividade["id_atividade"] ?>">
                            Ver anexo
                        </a>
                    <?php else: ?>
                        <span class="no-anexo">Sem anexo</span>
                    <?php endif; ?>
                </div>

                <div class="activity-date">
                    <?= $data_brasil ?>
                </div>

                <div class="activity-status">
                    <?php if ($atividade['nota'] !== null): ?>
                        <span class="nota"><?= $atividade['nota'] ?></span>
                    <?php else: ?>
                        <span class="sem-nota">Não enviada</span>
                    <?php endif; ?>
                </div>

                <div class="activity-send">
                    <a class="send-btn"
                       href="activitie-description/activities-description.php?id_atividade=<?= $atividade['id_atividade'] ?>">
                        Enviar
                    </a>
                </div>

            </div>

            <?php
                    }
                }
            }
            ?>

        </div>
    </div>

</main>

</body>
</html>
