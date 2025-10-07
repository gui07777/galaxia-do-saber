<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];
$nome = $_POST['nome'];
$novaSenha = $_POST['senha'];
$cpf = $_POST['cpf'];
$cargo = $_POST['cargo'];
$disciplina = $_POST['disciplina'];

if(!empty($nome) && !empty($email)){

    if(!empty($novaSenha)){

        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $sql = "UPDATE professor 
        SET 
        nome = :nome, 
        senha = :senha,
        cpf = :cpf,
        cargo = :cargo
        disciplina = :disciplina 
        WHERE 
        email = :email";


    }else{

        $sql = "UPDATE professor 
        SET 
        nome = :nome
        cpf = :cpf,
        cargo = :cargo
        disciplina = :disciplina 
        WHERE 
        email = :email";
        
    }

    $requisicao = $conexao -> prepare($sql);

    $requisicao -> bindParam(':email', $email);
    $requisicao -> bindParam(':nome', $nome);
    $requisicao -> bindParam('cpf', $cpf);
    $requisicao -> bindParam('cargo', $cargo);
    $requisicao -> bindParam('disciplina', $disciplina);

    if(!empty($novaSenha)){

        $requisicao -> bindParam(':senha', $senhaHash);

    }

    try{

        $requisicao -> execute();
        echo'Informações do Professor atualizadas.';

    }catch(PDOException $e){

    echo'Erro: ' . $e -> getMessage();

    }

}else{

    echo'Preencha o nome e o email para formalizar a atualização.';

}

?>