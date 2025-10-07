<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];
$nome = $_POST['nome'];
$senha = $_POST['senha'];
$cpf = $_POST['cpf'];
$cargo = $_POST['cargo'];
$disciplina = $_POST['disciplina'];

if(!empty($email) && !empty($senha) && !empty($nome)){

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO professor 
    (email, 
    nome, 
    senha,
    cpf,
    cargo,
    disciplina) 
    VALUES 
    (:email, 
    :nome, 
    :senha,
    :cpf,
    :cargo,
    :disciplina)";

    $requisicao = $conexao ->prepare("$sql");

    $requisicao -> bindParam(':nome', $nome);
    $requisicao -> bindParam(':email', $email);
    $requisicao -> bindParam(':senha', $senhaHash);
    $requisicao -> bindParam('cpf', $cpf);
    $requisicao -> bindParam('cargo', $cargo);
    $requisicao -> bindParam('disciplina', $disciplina);


    try{

        $requisicao -> execute();
        echo 'Professor Cadastrado';

    }catch(PDOException $e){

        echo 'Professor não cadastrado, erro: '. $e -> getMessage();

    }

}else{

echo'<p style = "color: red;"> Insira todos os valores nos respectivos campos. </p>';

}


?>