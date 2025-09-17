<?php

session_start();

require_once('../../../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

if(!empty($email) && !empty($senha)){

$sql = 'SELECT * FROM aluno WHERE email = :email';

$requisicao = $conexao -> prepare($sql);
$requisicao -> bindParam(':email', $email);
$requisicao -> execute();

$aluno = $requisicao -> fetch(PDO::FETCH_ASSOC);

if($aluno){
    if(password_verify($senha, $aluno['senha'])){

    $_SESSION['aluno_id'] = $aluno['id'];
    $_SESSION['aluno_nome'] = $aluno['nome'];

    header('Location: ../../../logged/student/student-home/student-home.html');

    exit;

    }else{

    echo'Senha incorreta';

    }

}else{

    echo'Usuário não encontrado!';

}

}else{

echo'Preencha todos os campos';

}
?>