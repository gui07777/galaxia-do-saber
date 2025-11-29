<?php
require_once __DIR__ . '/../Model/conexaoBanco/Conexao.php';
session_start();

header('Content-Type: application/json; charset=utf-8');

try {

    if (!isset($_SESSION['id_aluno'])) {
        echo json_encode([
            'success' => false,
            'error' => 'Aluno não está logado'
        ]);
        exit;
    }

    $idAluno = $_SESSION['id_aluno'];

    $stmt = $conexao->prepare("
        SELECT id_turma 
        FROM aluno 
        WHERE id_aluno = ?
    ");
    $stmt->execute([$idAluno]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode([
            'success' => false,
            'error' => 'Aluno não encontrado'
        ]);
        exit;
    }

    $idTurma = $row['id_turma'];

    $sql = "
        SELECT c.id_comunicado, c.titulo, c.conteudo, c.data_post, c.enviar_aluno
        FROM comunicados c
        INNER JOIN turmaComunicado tc 
            ON tc.id_comunicado = c.id_comunicado
        WHERE tc.id_turma = ?
        ORDER BY c.id_comunicado DESC
    ";

    $stmt = $conexao->prepare($sql);
    $stmt->execute([$idTurma]);

    $comunicados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'comunicados' => $comunicados
    ]);

} catch (Exception $e) {

    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
