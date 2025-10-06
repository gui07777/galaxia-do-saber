<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];
$nome = $_POST['nome'];


if(!empty($nome) && !empty($email)){

    if(!empty($email)){

        $sql = "UPDATE turma 
        SET nome = :nome,
        WHERE email = :email";


    }else{

        $sql = "UPDATE turma 
        SET nome = :nome
        WHERE email = :email";
        
    }

    $requisicao = $conexao -> prepare($sql);

    $requisicao -> bindParam(':email', $email);
    $requisicao -> bindParam(':nome', $nome);

    try{

        $requisicao -> execute();
        echo'Informações do Aluno atualizadas.';

    }catch(PDOException $e){

    echo'Erro: ' . $e -> getMessage();

    }

}else{

    echo'Preencha o nome e o email para formalizar a atualização.';

}

?>