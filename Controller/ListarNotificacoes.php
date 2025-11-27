<?php
require_once('../Model/conexaoBanco/Conexao.php');
session_start();

header('Content-Type: application/json; charset=utf-8');

// verifica se tem professor logado
if (!isset($_SESSION['id_professor'])) {
    echo json_encode([
        'success' => false,
        'mensagem' => 'Professor não está logado'
    ]);
    exit;
}

$idProfessor = $_SESSION['id_professor'];

$stmt = $conexao->prepare("
    SELECT message, created_at 
    FROM notifications 
    WHERE receiver_id = ?
    ORDER BY created_at DESC
");
$stmt->execute([$idProfessor]);

$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'success' => true,
    'total' => count($dados),
    'notificacoes' => $dados,
    'id_logado' => $idProfessor
]);
exit;
