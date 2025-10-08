<?php

require_once('../Model/conexaoBanco/Conexao.php');

$nome = $_POST['nome'];
$descricaoTurma = $_POST['descricao'];


if (!empty($nome)) {

    try {

        $conexao->beginTransaction();

        $sql = "INSERT INTO 
        turma (nome, 
        descricao) 
        VALUES 
        (:nome,
        :descricao)";

        $requisicao = $conexao->prepare("$sql");

        $requisicao->bindParam(':nome', $nome);
        $requisicao->bindParam(':descricao', $descricaoTurma);

        $requisicao->execute();

        $conexao->commit();

        echo "<script>
            alert('Turma Criada com Sucesso!');
            setTimeout(function() {
                window.location.href = '../View/logged/institution/sidebar/sidebar.html';
            }, 50); 
          </script>";


    } catch (PDOException $e) {

        echo"<script>
            alert('Turma não cadastrada, erro: " . addslashes($e -> getMessage()) . "');
        </script>";

    }

} else {

    echo "<script>
    alert('Insira todos os valores nos respectivos campos');
    </script>";

}


?>