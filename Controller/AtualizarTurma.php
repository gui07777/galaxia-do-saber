<?php

require_once('../Model/conexaoBanco/Conexao.php');


$nome = $_POST['nome'];
$descricaoTurma = $_POST['descricao'];

if(!empty($nome) && !empty($descricaoTurma)){

    if(!empty($nome)){

        $sql = "UPDATE turma 
        SET nome = :nome,
        descricao = :descricao
        WHERE email = :email";


    }else{

        $sql = "UPDATE turma 
        SET nome = :nome,
        descricao = :descricao
        WHERE email = :email";
        
    }

    $requisicao = $conexao -> prepare($sql);

    $requisicao -> bindParam(':email', $email);
    $requisicao -> bindParam(':nome', $nome);
    $requisicao->bindParam(':descricao', $descricaoTurma);

    try{

        $requisicao -> execute();
        
        echo "<script>
            alert('Informações da Turma atualizadas!');
            window.history.back() 
          </script>";

    }catch(PDOException $e){

    echo"<script>
            alert('Turma não cadastrada, erro: " . addslashes($e -> getMessage()) . "');
            window.history.back()
        </script>";

    }

}else{

    echo "<script>
    alert('Insira todos os valores nos respectivos campos');
    window.history.back()
    </script>";

}

?>