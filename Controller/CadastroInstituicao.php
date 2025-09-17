<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];
$nomeFantasia = $_POST['nome_fantasia'];
$repetirSenha = $_POST['repetir_senha'];
$senha = $_POST['senha'];
$razaoSocial = $_POST['razao_social'];
$cnpj = $_POST['cnpj'];
$codigoInep = $_POST['codigo_inep'];
$telefone = $_POST['telefone'];
$cep = $_POST['cep'];
$estado = $_POST['estado'];
$municipio = $_POST['municipio'];
$bairro = $_POST['bairro'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$complemento = $_POST['complemento'];


if (!empty($email) && !empty($senha) && !empty($nomeFantasia)) {

    if ($senha !== $repetirSenha) {

        echo 'As senhas não coincidem!';
        exit;

    }


    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    try {

        $conexao->beginTransaction();


        $sqlInstituicao = "INSERT INTO instituicao(email, 
        nome_fantasia, 
        razao_social, 
        senha, 
        cnpj,
        codigo_inep, 
        telefone,
        id_instituicao) 
        VALUES 
        (:email, 
        :nome_fantasia, 
        :razao_social, 
        :senha, 
        :cnpj, 
        :codigo_inep, 
        :telefone,
        :id_instituicao)";

        $requisicao = $conexao->prepare($sqlInstituicao);

        $requisicao->bindParam(':nome_fantasia', $nomeFantasia);
        $requisicao->bindParam(':email', $email);
        $requisicao->bindParam(':senha', $senhaHash);
        $requisicao->bindParam(':razao_social', $razaoSocial);
        $requisicao->bindParam(':cnpj', $cnpj);
        $requisicao->bindParam(':codigo_inep', $codigoInep);
        $requisicao->bindParam(':telefone', $telefone);
        $requisicao->bindParam(':id_instituicao', $id_instituicao);


        $requisicao->execute();

        $id_instituicao = $conexao->lastInsertId();


        $sqlEndereco = "INSERT INTO endereco(cep,
        estado,
        municipio,
        bairro,
        rua,
        numero,
        complemento)
        VALUES
        (:cep,
        :estado,
        :municipio,
        :bairro,
        :rua,
        :numero,
        :complemento)";

        $requisicaoEndereco = $conexao->prepare($sqlEndereco);

        $requisicaoEndereco->bindParam(':cep', $cep);
        $requisicaoEndereco->bindParam(':estado', $estado);
        $requisicaoEndereco->bindParam(':municipio', $municipio);
        $requisicaoEndereco->bindParam(':bairro', $bairro);
        $requisicaoEndereco->bindParam(':rua', $rua);
        $requisicaoEndereco->bindParam(':numero', $numero);
        $requisicaoEndereco->bindParam(':complemento', $complemento);

        $requisicaoEndereco->execute();

        $conexao->commit();

        echo "<script>
            alert('Instituição cadastrada com sucesso!');
            setTimeout(function() {
                window.location.href = '../View/auth/institution/login/institution-login.html';
            }, 50); 
          </script>";


    } catch (PDOException $e) {

        $conexao->rollBack();
        echo 'Instituição não cadastrada, erro: ' . $e->getMessage();

    }

} else {
   echo "<script>
            alert('Insira todos os valores para completar o cadastro.');
        </script>";
}

?>