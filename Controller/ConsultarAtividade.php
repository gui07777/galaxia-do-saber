<?php

session_start();

require_once('../Model/conexaoBanco/Conexao.php');

if (!isset($_SESSION['id_aluno'])) {
    echo json_encode(['erro' => 'Usuário não autenticado.']);
    exit;
}

if (empty($_SESSION['id_turma'])) {
    echo json_encode([]);
    exit;
}

$id_turma = $_SESSION['id_turma'];

try {
    $sql = "SELECT 
                a.id_atividade,
                a.titulo,
                a.prazo,
                DATE_FORMAT(a.data_post, '%d/%m/%Y %H:%i') AS data_post
            FROM atividades a
            INNER JOIN turmaAtividade ta ON ta.id_atividade = a.id_atividade
            WHERE ta.id_turma = :id_turma
            ORDER BY a.data_post DESC";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
    $stmt->execute();

    $atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($atividades);

} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
?>
