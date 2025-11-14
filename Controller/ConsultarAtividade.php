<?php

session_start();
ob_start();

require_once(__DIR__ . '/../Model/conexaoBanco/Conexao.php');

$id_turma = $_GET['id_turma'] ?? null;

try {
    
    $sql = "SELECT 
                a.id_atividade,
                a.titulo,
                a.data_post,
                a.prazo,
                a.anexo,
                CASE WHEN a.anexo IS NOT NULL THEN 1 ELSE 0 END AS tem_anexo
            FROM atividades a
            INNER JOIN turmaAtividade ta ON a.id_atividade = ta.id_atividade
            WHERE ta.id_turma = :id_turma
            ORDER BY a.data_post DESC";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
    $stmt->execute();

    $atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ob_clean();

} catch (PDOException $e) {

    ob_clean();
    
}
