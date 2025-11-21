<?php
require_once('../Model/conexaoBanco/Conexao.php');
session_start();

$email = $_POST['email'] ?? null;
$tipo = $_POST['tipo'] ?? null;
$id_turma = $_POST['id_turma'] ?? null;

if (!$email || !$tipo || !$id_turma) {
    echo "<script>
    alert('Dados incompletos.'); 
    history.back();
    </script>";
    exit;
}

if ($tipo === 'professor') {
    $tabela = "professor";
    $tabela_rel = "turma_professor";
    $campo_id = "id_professor";

} else if ($tipo === 'aluno') {
    $tabela = "aluno";
    $tabela_rel = "turma_aluno";
    $campo_id = "id_aluno";

} else {
    echo "<script>
    alert('Tipo inválido.'); 
    history.back();
    </script>";
    exit;
}

try {

    $sqlCheck = "SELECT id FROM $tabela WHERE email = :email LIMIT 1";
    $stmt = $conexao->prepare($sqlCheck);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$registro) {
        echo "<script>
        alert('Este email não está cadastrado como $tipo.'); 
        history.back();
        </script>";
        exit;
    }

    $id_perfil = $registro['id'];

    $sqlDup = "SELECT id FROM $tabela_rel WHERE id_turma = :id_turma AND $campo_id = :id_perfil";
    $stmtDup = $conexao->prepare($sqlDup);
    $stmtDup->bindParam(':id_turma', $id_turma);
    $stmtDup->bindParam(':id_perfil', $id_perfil);
    $stmtDup->execute();

    if ($stmtDup->rowCount() > 0) {
        echo "<script>
        alert('Este perfil já está relacionado à turma.'); 
        history.back();
        </script>";
        exit;
    }

    $sqlInsert = "INSERT INTO $tabela_rel (id_turma, $campo_id) VALUES (:id_turma, :id_perfil)";
    $stmtInsert = $conexao->prepare($sqlInsert);
    $stmtInsert->bindParam(':id_turma', $id_turma);
    $stmtInsert->bindParam(':id_perfil', $id_perfil);
    $stmtInsert->execute();

    echo "<script>
            alert('Perfil relacionado com sucesso!');
            window.location.href = '../View/logged/institution/sidebar/sidebar.html';
         </script>";
    exit;

} catch (PDOException $e) {
    echo "<script>
    alert('Erro: " . $e->getMessage() . "'); 
    history.back();
    </script>";
    exit;
}
?>
