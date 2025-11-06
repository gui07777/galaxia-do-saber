<?php
require_once('../Model/conexaoBanco/Conexao.php');

$id_turma = $_POST['id_turma'] ?? null;
$id_aluno = $_POST['id_aluno'] ?? null;
$id_professor = $_POST['id_professor'] ?? null;
$tipo = $_POST['tipo'] ?? null;


header('Content-Type: application/json');

if (empty($id_turma) || empty($tipo)) {
  echo json_encode(['status' => 'erro', 'mensagem' => 'Por favor, selecione o tipo e a turma.']);
  exit;
}

try {
  if ($tipo === 'aluno' && !empty($id_aluno)) {

    $check = $conexao->prepare("
      SELECT 1 FROM matricula 
      WHERE id_aluno = :id_aluno AND id_turma = :id_turma
    ");
    $check->execute([
      ':id_aluno' => $id_aluno,
      ':id_turma' => $id_turma
    ]);

    if ($check->rowCount() > 0) {
      echo json_encode(['status' => 'aviso', 'mensagem' => 'O aluno já está matriculado nesta turma.']);
      exit;
    }

    $stmt = $conexao->prepare("
      INSERT INTO matricula (id_aluno, id_turma) 
      VALUES (:id_aluno, :id_turma)
    ");
    $stmt->execute([
      ':id_aluno' => $id_aluno,
      ':id_turma' => $id_turma
    ]);

    $update = $conexao->prepare("
      UPDATE aluno SET id_turma = :id_turma 
      WHERE id_aluno = :id_aluno
    ");
    $update->execute([
      ':id_turma' => $id_turma,
      ':id_aluno' => $id_aluno
    ]);

    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Aluno relacionado com sucesso à turma!']);
    exit;
  }

  if ($tipo === 'professor' && !empty($id_professor)) {

    $check = $conexao->prepare("
      SELECT 1 FROM ensina 
      WHERE id_professor = :id_professor AND id_turma = :id_turma
    ");
    $check->execute([
      ':id_professor' => $id_professor,
      ':id_turma' => $id_turma
    ]);

    if ($check->rowCount() > 0) {
      echo json_encode(['status' => 'aviso', 'mensagem' => 'O professor já está vinculado a esta turma.']);
      exit;
    }


    $stmt = $conexao->prepare("
      INSERT INTO ensina (id_professor, id_turma) 
      VALUES (:id_professor, :id_turma)
    ");
    $stmt->execute([
      ':id_professor' => $id_professor,
      ':id_turma' => $id_turma
    ]);

    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Professor relacionado com sucesso à turma!']);
    exit;
  }

  echo json_encode(['status' => 'erro', 'mensagem' => 'Selecione um professor ou aluno válido.']);
  
} catch (PDOException $e) {
  echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao relacionar: ' . $e->getMessage()]);
}
?>
