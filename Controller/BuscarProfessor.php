<?php
session_start();
require_once('../Model/conexaoBanco/Conexao.php');

$email = $_SESSION['email_professor'] ?? null;

if (!$email) {
    echo json_encode(['erro' => 'Sessão expirada. Faça login novamente.']);
    exit;
}

try {
    $sql = "SELECT nome, email, cargo, disciplina 
            FROM professor 
            WHERE email = :email";

    $stmt = $conexao->prepare($sql);
    $stmt->execute([':email' => $email]);
    $professor = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($professor) {
        echo json_encode($professor);
    } else {
        echo json_encode(['erro' => 'Professor não encontrado.']);
    }
} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro no banco: ' . $e->getMessage()]);
}
