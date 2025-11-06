<?php

session_start();

require_once('../Model/conexaoBanco/Conexao.php');

$id_turma = $_SESSION['id_turma'] ?? $_GET['id_turma'] ?? null;

if (!$id_turma) {
    echo "<p style='text-align:center; margin-top:20px;'>ID da turma não fornecido.</p>";
    exit;
}

try {
    $sql = "SELECT a.id_atividade, a.titulo, a.data_post, a.prazo,
                   CASE WHEN a.anexo IS NOT NULL THEN 1 ELSE 0 END AS tem_anexo
            FROM atividades a
            INNER JOIN turmaAtividade ta ON a.id_atividade = ta.id_atividade
            WHERE ta.id_turma = :id_turma
            ORDER BY a.data_post DESC";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
    $stmt->execute();

    $atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($atividades)) {
        echo "<p style='text-align:center; margin-top:20px;'>Nenhuma atividade disponível para esta turma.</p>";
    } else {
        foreach ($atividades as $atividade) {
            $titulo = htmlspecialchars($atividade['titulo']);
            $data_post = date('d/m/Y H:i', strtotime($atividade['data_post']));
            $prazo = htmlspecialchars($atividade['prazo']);
            $tem_anexo = $atividade['tem_anexo'];

            echo "<div class='activity-item'>";
            echo "<div class='activity-title'><strong>{$titulo}</strong></div>";
            echo "<div class='activity-info'>";
            echo "<span>Postada em: {$data_post}</span>";
            echo "<span>Prazo: {$prazo}</span>";
            echo "</div>";

            if ($tem_anexo) {
                echo "<div class='activity-file'>
                        <a href='verAnexo.php?id_atividade={$atividade['id_atividade']}' target='_blank'>📎 Ver anexo</a>
                      </div>";
            } else {
                echo "<div class='activity-file'>
                        <em>Sem anexo</em>
                      </div>";
            }

            echo "</div><hr>";
        }
    }

} catch (PDOException $e) {
    echo "<p style='color:red; text-align:center;'>Erro ao buscar atividades: " . htmlspecialchars($e->getMessage()) . "</p>";
}
