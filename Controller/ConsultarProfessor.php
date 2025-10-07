<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];

if(!empty($email)){

    $sql = "SELECT * FROM 
    professor 
    WHERE 
    email = :email";

    $requisicao = $conexao->prepare($sql);

    $requisicao->bindParam(':email', $email);

try{

    $requisicao -> execute();
    $professor = $requisicao -> fetch(PDO::FETCH_ASSOC);

if($professor){

echo'Professor no sistema: ' . '<br>';
echo'Nome: ' . $professor['nome'] . '<br>';
echo'Email: ' . $professor['email'] . '<br>';

}else{

echo'Professor não existente no sistema.';

}

}catch(PDOException $e){

echo'Erro: ' . $e->getMessage();

}

}else{

echo'Insira um e-mail válido.';

}

?>