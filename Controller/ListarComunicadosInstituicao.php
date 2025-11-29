<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../Model/conexaoBanco/Conexao.php';
session_start();

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['id_instituicao'])) {
    echo json_encode([
        'success' => false,
        'error' => 'Instituição não está logada'
    ]);
    exit;
}

$idInstituicao = $_SESSION['id_instituicao'];

try {

    $stmt = $conexao->prepare("
        SELECT 
            c.id_comunicado, 
            c.titulo, 
            c.conteudo, 
            c.data_post
        FROM comunicados c
        WHERE c.id_instituicao = ?
        ORDER BY c.id_comunicado DESC
    ");

    $stmt->execute([$idInstituicao]);

    $comunicados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($comunicados as &$c) {

        $idCom = $c["id_comunicado"];

        $stmtProf = $conexao->prepare("
            SELECT COUNT(*) AS total 
            FROM profComunicado
            WHERE id_comunicado = ?
        ");
        $stmtProf->execute([$idCom]);
        $c["enviado_professores"] = $stmtProf->fetch(PDO::FETCH_ASSOC)['total'] > 0;

        $stmtAluno = $conexao->prepare("
            SELECT COUNT(*) AS total
            FROM turmaComunicado
            WHERE id_comunicado = ?
        ");
        $stmtAluno->execute([$idCom]);
        $c["enviado_alunos"] = $stmtAluno->fetch(PDO::FETCH_ASSOC)['total'] > 0;
    }

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
