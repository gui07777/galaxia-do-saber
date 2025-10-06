<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];
$nome = $_POST['nome'];

if(!empty($email) && !empty($senha) && !empty($nome)){

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO 
    turma (email, 
    nome, 
    senha) 
    VALUES 
    (:email, 
    :nome, 
    :senha)";

    $requisicao = $conexao ->prepare("$sql");

    $requisicao -> bindParam(':nome', $nome);
    $requisicao -> bindParam(':email', $email);
    $requisicao -> bindParam(':senha', $senhaHash);
    

    try{

        $requisicao -> execute();
        echo'Turma Cadastrada';

    }catch(PDOException $e){

        echo 'Turma não cadastrada, erro: '. $e -> getMessage();

    }

}else{

echo'Insira todos os valores nos respectivos campos.';

}


?>