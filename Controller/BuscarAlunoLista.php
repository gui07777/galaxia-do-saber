<?php
session_start();
require_once('../Model/conexaoBanco/Conexao.php');

header("Content-Type: application/json; charset=UTF-8");

if (!isset($_GET['id'])) {
    echo json_encode(['erro' => 'ID do aluno não enviado.']);
    exit;
}

$idAluno = $_GET['id'];

try {

    $sql = "
        SELECT 
            a.nome,
            a.numero_matricula,
            a.email,
            a.data_nasc,
            t.nome AS turma
        FROM aluno a
        LEFT JOIN turma t ON t.id_turma = a.id_turma
        WHERE a.id_aluno = :id
        LIMIT 1
    ";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $idAluno, PDO::PARAM_INT);
    $stmt->execute();

    $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$aluno) {
        echo json_encode(['erro' => 'Aluno não encontrado.']);
        exit;
    }

    $response = [
        'nome'              => $aluno['nome'] ?? "",
        'numero_matricula'  => $aluno['numero_matricula'] ?? "",
        'email'             => $aluno['email'] ?? "",
        'data_nasc'         => $aluno['data_nasc'] ?? "",
        'turma'             => $aluno['turma'] ?? null
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro no banco: ' . $e->getMessage()]);
}
