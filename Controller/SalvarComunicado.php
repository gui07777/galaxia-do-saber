<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../Model/conexaoBanco/Conexao.php';
session_start();

try {
    if (!isset($_SESSION['id_instituicao'])) {
        echo json_encode(['success' => false, 'error' => 'Instituição não logada']);
        exit;
    }
    $idInstituicao = $_SESSION['id_instituicao'];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'error' => 'Método inválido']);
        exit;
    }

    $assunto = trim($_POST['assunto'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $enviarProfessor = isset($_POST['professor']) ? intval($_POST['professor']) : 0;
    $enviarAluno = isset($_POST['aluno']) ? intval($_POST['aluno']) : 0;

    if ($assunto === '' || $descricao === '') {
        echo json_encode(['success' => false, 'error' => 'Campos obrigatórios']);
        exit;
    }

    $conexao->beginTransaction();

    $stmt = $conexao->prepare("
        INSERT INTO comunicados (id_instituicao, titulo, conteudo, data_post, enviar_professor, enviar_aluno)
        VALUES (?, ?, ?, DATE_FORMAT(NOW(), '%d/%m/%Y'), ?, ?)
    ");
    $stmt->execute([$idInstituicao, $assunto, $descricao, $enviarProfessor, $enviarAluno]);
    $idComunicado = $conexao->lastInsertId();

    $qtdProf = 0;
    $qtdTurma = 0;

    $conexao->prepare("DELETE FROM profComunicado WHERE id_comunicado = ?")->execute([$idComunicado]);
    $conexao->prepare("DELETE FROM turmaComunicado WHERE id_comunicado = ?")->execute([$idComunicado]);

    if ($enviarProfessor === 1) {
        $stmtProf = $conexao->prepare("SELECT id_professor FROM professor WHERE id_instituicao = ?");
        $stmtProf->execute([$idInstituicao]);
        $professores = $stmtProf->fetchAll(PDO::FETCH_ASSOC);

        $stmtInsertProf = $conexao->prepare("INSERT INTO profComunicado (id_comunicado, id_professor) VALUES (?, ?)");
        foreach ($professores as $p) {
            $stmtInsertProf->execute([$idComunicado, $p['id_professor']]);
            $qtdProf++;
        }
    }

    if ($enviarAluno === 1) {
        $stmtTurma = $conexao->prepare("SELECT id_turma FROM turma WHERE id_instituicao = ?");
        $stmtTurma->execute([$idInstituicao]);
        $turmas = $stmtTurma->fetchAll(PDO::FETCH_ASSOC);

        $stmtInsertTurma = $conexao->prepare("INSERT INTO turmaComunicado (id_comunicado, id_turma) VALUES (?, ?)");
        foreach ($turmas as $t) {
            $stmtInsertTurma->execute([$idComunicado, $t['id_turma']]);
            $qtdTurma++;
        }
    }

    $conexao->commit();

    echo json_encode([
        'success' => true,
        'id_comunicado' => $idComunicado,
        'para_professores' => $enviarProfessor,
        'qtd_professores' => $qtdProf,
        'para_turmas' => $enviarAluno,
        'qtd_turmas' => $qtdTurma
    ]);

} catch (Exception $e) {
    if ($conexao->inTransaction()) $conexao->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
