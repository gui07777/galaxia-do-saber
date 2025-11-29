<?php
require_once __DIR__ . '/../Model/conexaoBanco/Conexao.php';
session_start();

header('Content-Type: application/json; charset=utf-8');

try {

    if (!isset($_SESSION['id_professor'])) {
        echo json_encode([
            'success' => false,
            'error' => 'Professor não está logado'
        ]);
        exit;
    }

    $idProfessor = $_SESSION['id_professor'];

    $sql = "
        SELECT 
            c.id_comunicado,
            c.titulo,
            c.conteudo,
            c.data_post,
            c.id_instituicao
        FROM comunicados c
        INNER JOIN profComunicado pc 
            ON pc.id_comunicado = c.id_comunicado
        INNER JOIN professor p
            ON p.id_professor = pc.id_professor
        WHERE pc.id_professor = ?
          AND c.id_instituicao = p.id_instituicao
        ORDER BY c.id_comunicado DESC
    ";

    $stmt = $conexao->prepare($sql);
    $stmt->execute([$idProfessor]);

    $comunicados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'total' => count($comunicados),
        'comunicados' => $comunicados
    ]);

} catch (Exception $e) {

    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
