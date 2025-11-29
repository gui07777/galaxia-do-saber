<?php
session_start();
require_once('../Model/conexaoBanco/Conexao.php');

if (!isset($_GET['id'])) {
    echo json_encode(['erro' => 'ID do professor não enviado.']);
    exit;
}

$idProfessor = $_GET['id'];

try {

    $sql = "
        SELECT 
            p.nome,
            p.email,
            p.cpf,
            p.cargo,
            p.disciplina,
            t.nome AS turma

        FROM professor p
        
        LEFT JOIN ensina e ON e.id_professor = p.id_professor
        LEFT JOIN turma t ON t.id_turma = e.id_turma
        
        WHERE p.id_professor = :id
        LIMIT 1
    ";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $idProfessor);
    $stmt->execute();

    $professor = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($professor) {
        echo json_encode($professor, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['erro' => 'Professor não encontrado.']);
    }

} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro no banco: ' . $e->getMessage()]);
}
