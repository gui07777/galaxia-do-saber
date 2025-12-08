<?php

// Esse PHP tem a função de retornar todos os professores de uma instituição:


session_start();
require_once('../Model/conexaoBanco/Conexao.php');

if (!isset($_GET['id'])) {
    echo json_encode(['erro' => 'ID do professor não enviado.']);
    exit;
}

$idProfessor = $_GET['id'];

// Se existir o id do professor, roda o sql para que puxe todas as informações do professor;


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

    //Se existir ou não, vai retornar em JSON:

    if ($professor) {
        echo json_encode($professor, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['erro' => 'Professor não encontrado.']);
    }

} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro no banco: ' . $e->getMessage()]);
}
