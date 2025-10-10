<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];
$nome = $_POST['nome'];
$senha = $_POST['senha'];
$repetirSenha = $_POST['repetir_senha'];
$numero_matricula = $_POST['numero_matricula'];
$data_nasc = $_POST['data_nasc'];

if (!empty($email) && !empty($senha) && !empty($nome)) {

    if ($senha !== $repetirSenha) {

        echo "<script>
        alert('As senhas não coincidem!');
        </script>";

        exit;

    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    try {

        $conexao->beginTransaction();

        $sql = "INSERT INTO aluno (email, 
        nome, 
        senha, 
        numero_matricula, 
        data_nasc) 
        VALUES (:email, 
        :nome, 
        :senha, 
        :numero_matricula, 
        :data_nasc)";

        $requisicao = $conexao->prepare("$sql");

        $requisicao->bindParam(':nome', $nome);
        $requisicao->bindParam(':email', $email);
        $requisicao->bindParam(':senha', $senhaHash);
        $requisicao->bindParam(':numero_matricula', $numero_matricula);
        $requisicao->bindParam(':data_nasc', $data_nasc);

        $requisicao->execute();
        $conexao->commit();
        
        echo "<script>
            alert('Aluno(a) Cadastrado!');
            setTimeout(function() {
                window.location.href = '../View/auth/student/login/student-login.html';
            }, 50); 
          </script>";

    } catch (PDOException $e) {

        $conexao->rollBack();
        echo "<script>
            alert('Aluno(a) não cadastrado, erro: " . addslashes($e->getMessage()) . "');
        </script>";

    }

} else {

    echo "<script>
            alert('Insira todos os valores para completar o cadastro.');
        </script>";

}


?>