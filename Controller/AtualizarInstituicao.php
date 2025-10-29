<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];
$nomeFantasia = $_POST['nome_fantasia'];
$novaSenha = $_POST['senha'];
$telefone = $_POST['telefone'];


if (!empty($nome) && !empty($email)) {

    if (!empty($novaSenha)) {

        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $sql = "UPDATE instituicao SET nome = :nome, senha = :senha, telefone = :telefone WHERE email = :email";


    } else {

        $sql = "UPDATE instituicao SET nome = :nome, telefone = :telefone WHERE email = :email";

    }

    $requisicao = $conexao->prepare($sql);

    $requisicao->bindParam(':email', $email);
    $requisicao->bindParam(':nome', $nome);
    $requisicao->bindParam(':telefone', $telefone);

    if (!empty($novaSenha)) {

        $requisicao->bindParam(':senha', $senhaHash);

    }

    try {

        $requisicao->execute();
        
        echo "<script>
            alert('Informações da Instituição atualizadas!');
            window.history.back()
          </script>";

    } catch (PDOException $e) {

        $conexao->rollBack();
        echo "<script>
            alert('Informações não atualizadas!. Erro: " . addslashes($e->getMessage()) . "');
            window.history.back()
        </script>";
    }

} else {

    echo "<script>
            alert('Preencha o Nome e o Email para formalizar a atualização!');
            window.history.back()
          </script>";

}

?>