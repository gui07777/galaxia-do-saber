<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../Model/conexaoBanco/Conexao.php';
session_start();

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Método não permitido']);
        exit;
    }

    $assunto   = trim($_POST['assunto'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    if ($assunto === '' || $descricao === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Campos obrigatórios vazios']);
        exit;
    }

    $db = $conexao;

    // pega id da instituição
    $idInstituicao = $_SESSION['id_instituicao'] ?? 1;

    // inicia transaction antes de tudo
    $db->beginTransaction();

    // 1) salva comunicado
    $stmt = $db->prepare("INSERT INTO comunicados (titulo, conteudo, data_post) VALUES (?, ?, NOW())");
    $stmt->execute([$assunto, $descricao]);

    $idComunicado = $db->lastInsertId();

    // 2) pega professores
    $stmtProf = $db->prepare("SELECT id_professor FROM professor WHERE id_instituicao = ?");
    $stmtProf->execute([$idInstituicao]);

    $professores = $stmtProf->fetchAll(PDO::FETCH_ASSOC);

    // 3) salva notificações
    $stmtNotif = $db->prepare("
        INSERT INTO notifications (sender_id, receiver_id, message, created_at)
        VALUES (?, ?, ?, NOW())
    ");

    foreach ($professores as $p) {
        $stmtNotif->execute([
            $idInstituicao,
            $p['id_professor'],
            $assunto
        ]);
    }

    $db->commit();

    echo json_encode([
        'success' => true,
        'notificacoes_criadas' => count($professores)
    ]);

} catch (Exception $e) {
    if (isset($db)) {
        $db->rollBack();
    }

    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
