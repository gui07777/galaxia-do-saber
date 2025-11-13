<?php

require_once('../Model/conexaoBanco/Conexao.php');

session_start();

$email = $_SESSION['email_aluno'] ?? null;

if (!$email) {

    echo json_encode(['erro' => 'Sessão expirada. Faça login novamente.']);
    exit;

}

try {

    $sql = "SELECT aluno.nome, aluno.email, aluno.data_nasc, turma.nome AS turma_nome
        FROM aluno
        LEFT JOIN turma ON aluno.id_turma = turma.id_turma
        WHERE aluno.email = :email";

    $stmt = $conexao->prepare($sql);
    $stmt->execute([':email' => $email]);
    $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($aluno) {
        echo json_encode($aluno);
    } else {
        echo json_encode(['erro' => 'Aluno não encontrado.']);
    }

} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro no banco: ' . $e->getMessage()]);
}
