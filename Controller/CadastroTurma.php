<?php

session_start();
require_once('../Model/conexaoBanco/Conexao.php');

$idInstituicao = $_SESSION['id_instituicao'] ?? null;

$nome = $_POST['nome'] ?? null;
$descricaoTurma = $_POST['descricao'] ?? null;

if (!empty($nome) && !empty($descricaoTurma) && !empty($idInstituicao)) {

    try {

        $conexao->beginTransaction();

        $sql = "INSERT INTO turma 
        (nome, descricao, id_instituicao) 
        VALUES 
        (:nome, :descricao, :id_instituicao)";

        $stmt = $conexao->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricaoTurma);
        $stmt->bindParam(':id_instituicao', $idInstituicao, PDO::PARAM_INT);

        $stmt->execute();

        $conexao->commit();

        echo "<script>
            alert('Turma criada com sucesso!');
            window.history.back();
        </script>";

    } catch (PDOException $e) {

        $conexao->rollBack();

        echo "<script>
            alert('Erro ao cadastrar a turma: " . addslashes($e->getMessage()) . "');
            window.history.back();
        </script>";
    }

} else {

    echo "<script>
        alert('Preencha todos os campos antes de continuar.');
        window.history.back();
    </script>";
}

?>
