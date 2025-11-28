<?php

require_once('../Model/conexaoBanco/Conexao.php');

$nome = $_POST['nome'] ?? null;
$descricaoTurma = $_POST['descricao'] ?? null;
$idInstituicao = $_POST['id_instituicao'] ?? null;

if (!empty($nome) && !empty($descricaoTurma) && !empty($idInstituicao)) {

    try {

        $conexao->beginTransaction();

        $sql = "INSERT INTO turma 
        (nome, descricao, id_instituicao) 
        VALUES 
        (:nome, :descricao, :id_instituicao)";

        $requisicao = $conexao->prepare($sql);

        $requisicao->bindParam(':nome', $nome);
        $requisicao->bindParam(':descricao', $descricaoTurma);
        $requisicao->bindParam(':id_instituicao', $idInstituicao, PDO::PARAM_INT);

        $requisicao->execute();

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
