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

    <style>

    /* Estilos para o contêiner principal da tabela */
.activities {
    width: 80%; /* Ajuste conforme necessário */
    margin: 20px auto; /* Centraliza a tabela */
}

/* Estilo da Tabela Principal */
.activities-table {
    width: 100%;
    border-collapse: collapse; /* Remove espaços entre as bordas das células */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave para destacar a tabela */
    border-radius: 8px;
    overflow: hidden; /* Garante que o border-radius funcione nos cantos */
    background-color: #ffffff; /* Fundo branco para a tabela */
}

/* Estilo do Cabeçalho (thead e th) */
.activities-table thead {
    background-color: #007bff; /* Cor de fundo azul principal */
    color: white;
}

.activities-table th {
    padding: 12px 15px;
    text-align: left;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 0.9em;
}

/* Estilos para as Células do Corpo (tbody e td) */
.activities-table tbody tr {
    border-bottom: 1px solid #eeeeee; /* Linha divisória entre as atividades */
    transition: background-color 0.2s ease;
}

.activities-table tbody tr:hover {
    background-color: #f5f5f5; /* Efeito hover nas linhas */
}

.activities-table td {
    padding: 15px 15px;
    vertical-align: middle; /* Alinhamento vertical centralizado */
    font-size: 0.95em;
    color: #333;
}

/* Ajuste de Largura das Colunas (opcional, dependendo do conteúdo) */
.activities-table th:nth-child(1),
.activities-table td.activity-title-cell {
    width: 45%; /* Coluna de Tarefas é mais larga */
}

.activities-table th:nth-child(2),
.activities-table td.activity-date-cell {
    width: 15%; /* Coluna de Entrega (Prazo) */
    text-align: center;
}

.activities-table th:nth-child(3),
.activities-table td.activity-status-cell {
    width: 15%; /* Coluna de Nota */
    text-align: center;
}

.activities-table th:nth-child(4),
.activities-table td.activity-send-cell {
    width: 25%; /* Coluna de Ação (Botão) */
    text-align: center;
}

/* Estilo do Título e Anexo na célula de Tarefas */
.activity-title-cell strong {
    display: block;
    margin-bottom: 5px;
    color: #1a1a1a;
}

/* Estilo dos Status (Nota e Sem Nota/Não Enviada) */
.nota {
    font-weight: bold;
    color: #28a745; /* Cor verde para nota */
    background-color: #e6f7ea;
    padding: 5px 10px;
    border-radius: 4px;
}

.sem-nota {
    color: #dc3545; /* Cor vermelha para não enviada */
    font-style: italic;
}

/* Estilo do Botão Enviar */
.send-btn {
    display: inline-block;
    padding: 8px 15px;
    background-color: #ffc107; /* Cor amarela/laranja para o botão */
    color: #333;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s;
}

.send-btn:hover {
    background-color: #e0a800;
}

/* Estilo do link Ver Anexo */
.anexo-btn {
    display: inline-block;
    margin-top: 5px;
    font-size: 0.8em;
    color: #007bff;
    text-decoration: none;
    border-bottom: 1px dashed #007bff;
}

.anexo-btn:hover {
    color: #0056b3;
    border-bottom: 1px solid #0056b3;
}

.no-anexo {
    display: block;
    margin-top: 5px;
    font-size: 0.8em;
    color: #6c757d;
}

    </style>
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
        
        <table class="activities-table">
            <thead>
                <tr>
                    <th>Tarefas</th>
                    <th>Entrega</th>
                    <th>Nota</th>
                    <th>Ação</th>
                </tr>
            </thead>
            
            <tbody id="activity-list">

                <?php
                if (!$id_turma) {
                    echo "<tr><td colspan='4' style='text-align:center;'>Nenhuma turma associada.</td></tr>";
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
                        echo "<tr><td colspan='4' style='text-align:center;'>Não há atividades para esta turma.</td></tr>";
                    } else {
                        foreach ($atividades as $atividade) {

                            $data_brasil = $atividade["prazo"]
                                ? date("d/m/Y", strtotime($atividade["prazo"]))
                                : "Sem prazo";
                ?>

                <tr> 
                    <td class="activity-title-cell">
                        <strong><?= htmlspecialchars($atividade["titulo"]) ?></strong>

                        <?php if ($atividade["tem_anexo"]): ?>
                            <a class="anexo-btn" target="_blank"
                                href="../../../../Controller/verAnexo.php?id_atividade=<?= $atividade["id_atividade"] ?>">
                                Ver anexo
                            </a>
                        <?php else: ?>
                            <span class="no-anexo">Sem anexo</span>
                        <?php endif; ?>
                    </td>

                    <td class="activity-date-cell">
                        <?= $data_brasil ?>
                    </td>

                    <td class="activity-status-cell">
                        <?php if ($atividade['nota'] !== null): ?>
                            <span class="nota"><?= $atividade['nota'] ?></span>
                        <?php else: ?>
                            <span class="sem-nota">Não enviada</span>
                        <?php endif; ?>
                    </td>

                    <td class="activity-send-cell">
                        <a class="send-btn"
                            href="activitie-description/activities-description.php?id_atividade=<?= $atividade['id_atividade'] ?>">
                            Enviar
                        </a>
                    </td>

                </tr>
                <?php
                        }
                    }
                }
                ?>

            </tbody>
        </table>
        </div>
</main>

</body>
</html>