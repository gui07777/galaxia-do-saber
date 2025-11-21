<?php

require_once('../Model/conexaoBanco/Conexao.php');
session_start();


header("Content-Type: text/html; charset=UTF-8");


$id_professor = $_POST['id_professor'] ?? null;
$id_aluno     = $_POST['id_aluno'] ?? null;
$id_turma     = $_POST['id_turma'] ?? null;
$tipos_raw    = $_POST['tipo'] ?? null;

if (is_null($tipos_raw)) {
    $tipos = [];
} elseif (is_array($tipos_raw)) {
    $tipos = $tipos_raw;
} else {
    $tipos = [$tipos_raw];
}

if (empty($tipos)) {
    echo "<script>
        alert('Selecione se é Professor ou Aluno.');
        history.back();
    </script>";
    exit;
}

if (empty($id_turma)) {
    echo "<script>
        alert('Selecione uma turma.');
        history.back();
    </script>";
    exit;
}

if (in_array('professor', $tipos) && empty($id_professor)) {
    echo "<script>
        alert('Você selecionou Professor, mas não escolheu qual professor.');
        history.back();
    </script>";
    exit;
}

if (in_array('aluno', $tipos) && empty($id_aluno)) {
    echo "<script>
        alert('Você selecionou Aluno, mas não escolheu qual aluno.');
        history.back();
    </script>";
    exit;
}

try {

    if (in_array('professor', $tipos) && !empty($id_professor)) {

        $checkProf = $conexao->prepare("
            SELECT 1 FROM ensina
            WHERE id_professor = :prof AND id_turma = :turma
            LIMIT 1
        ");
        $checkProf->execute([
            ':prof'  => $id_professor,
            ':turma' => $id_turma
        ]);

        if ($checkProf->rowCount() > 0) {
            echo "<script>
                alert('Este professor já está vinculado à turma.');
                history.back();
            </script>";
            exit;
        }

        $insertProf = $conexao->prepare("
            INSERT INTO ensina (id_professor, id_turma)
            VALUES (:prof, :turma)
        ");
        $insertProf->execute([
            ':prof'  => $id_professor,
            ':turma' => $id_turma
        ]);
    }

    if (in_array('aluno', $tipos) && !empty($id_aluno)) {

        $checkAluno = $conexao->prepare("
            SELECT 1 FROM matricula
            WHERE id_aluno = :aluno AND id_turma = :turma
            LIMIT 1
        ");
        $checkAluno->execute([
            ':aluno' => $id_aluno,
            ':turma' => $id_turma
        ]);

        if ($checkAluno->rowCount() > 0) {
            echo "<script>
                alert('Este aluno já está matriculado nesta turma.');
                history.back();
            </script>";
            exit;
        }

        $insertAluno = $conexao->prepare("
            INSERT INTO matricula (id_aluno, id_turma)
            VALUES (:aluno, :turma)
        ");
        $insertAluno->execute([
            ':aluno' => $id_aluno,
            ':turma' => $id_turma
        ]);

        $updateAluno = $conexao->prepare("
            UPDATE aluno SET id_turma = :turma WHERE id_aluno = :aluno
        ");
        $updateAluno->execute([
            ':turma' => $id_turma,
            ':aluno' => $id_aluno
        ]);
    }

    echo "<script>
        alert('Relacionamento(s) realizado(s) com sucesso!');
        window.location.href = '../View/logged/institution/sidebar/sidebar.html';
    </script>";
    exit;

} catch (PDOException $e) {
 
    $msg = addslashes($e->getMessage());
    echo "<script>
        alert('Erro ao relacionar: {$msg}');
        history.back();
    </script>";
    exit;
}
?>
