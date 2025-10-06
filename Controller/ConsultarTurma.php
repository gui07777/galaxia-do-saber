<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];

if (!empty($email)) {

    $email = $_POST['email'];

    $sql = "SELECT * FROM turma WHERE (email) = (:email)";

    $requisicao = $conexao->prepare($sql);

    $requisicao->bindParam(':email', $email);

    try {

        $requisicao->execute();

        $turma = $requisicao->fetch(PDO::FETCH_ASSOC);

            if($turma){

                echo'Turma no sistema: ' . '<br>';
                echo'Turma: ' . $turma['nome_turma'] . '<br>';
                echo'Email: ' . $turma['email'] . '<br>';

            }else{

                echo 'Turma não existe no sistema';

            }

    }catch(PDOException $e){

        echo'Erro: ' . $e -> getMessage();

    }

}else{

    echo'Insira um email válido.';

}

?>