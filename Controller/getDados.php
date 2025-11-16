<?php
require_once(__DIR__ . '/../Model/conexaoBanco/Conexao.php');

header("Content-Type: application/json; charset=utf-8");

try {

    $sqlProf = $conexao->prepare("SELECT id_professor, nome FROM professor ORDER BY nome ASC");
    $sqlProf->execute();
    $professores = $sqlProf->fetchAll(PDO::FETCH_ASSOC);

    $sqlAluno = $conexao->prepare("SELECT id_aluno, nome FROM aluno ORDER BY nome ASC");
    $sqlAluno->execute();
    $alunos = $sqlAluno->fetchAll(PDO::FETCH_ASSOC);

    $sqlTurma = $conexao->prepare("SELECT id_turma, nome FROM turma ORDER BY nome ASC");
    $sqlTurma->execute();
    $turmas = $sqlTurma->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => "sucesso",
        "professores" => $professores,
        "alunos" => $alunos,
        "turmas" => $turmas
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "erro",
        "mensagem" => "Erro ao carregar dados: " . $e->getMessage()
    ]);
}
?>
