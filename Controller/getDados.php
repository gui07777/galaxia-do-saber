<?php
require_once('../Model/conexaoBanco/Conexao.php');

header('Content-Type: application/json; charset=utf-8');

try {
    
  $sqlProf = $conexao->query("SELECT id_professor, nome FROM professor ORDER BY nome");
  $professores = $sqlProf->fetchAll(PDO::FETCH_ASSOC);

  $sqlAlu = $conexao->query("SELECT id_aluno, nome FROM aluno ORDER BY nome");
  $alunos = $sqlAlu->fetchAll(PDO::FETCH_ASSOC);

  $sqlTurma = $conexao->query("SELECT id_turma, nome FROM turma ORDER BY nome");
  $turmas = $sqlTurma->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode([
    'professores' => $professores,
    'alunos' => $alunos,
    'turmas' => $turmas
  ]);

} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(['erro' => 'Erro ao buscar dados: ' . $e->getMessage()]);
}
?>
