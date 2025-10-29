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


try {

    $Obrigatorios = [
        'E-mail' => $email,
        'Senha' => $senha,
        'Repetir Senha' => $repetirSenha,
        'Nome Fantasia' => $nomeFantasia,
        'Razão Social' => $razaoSocial,
        'CNPJ' => $cnpj,
        'CEP' => $cep,
        'Estado' => $estado,
        'Município' => $municipio,
        'Bairro' => $bairro,
        'Rua' => $rua,
        'Número' => $numero
    ];

    foreach ($Obrigatorios as $nomeCampo => $valorCampo) {
        if (empty($valorCampo)) {
            echo "<script>
            alert('O campo {$nomeCampo} é obrigatório.');
            window.history.back()
            </script>";
            
            exit;
        }
    }


    if ($senha !== $repetirSenha) {
        echo "<script>
        alert('As senhas não coincidem!');
        window.history.back()
        </script>";
        exit;
    }


    $verificarEmail = $conexao->prepare("SELECT COUNT(*) FROM instituicao WHERE email = :email");
    $verificarEmail->bindParam(':email', $email);
    $verificarEmail->execute();

    if ($verificarEmail->fetchColumn() > 0) {

        echo "<script>
        alert('Este e-mail já está cadastrado.');
        window.history.back()
        </script>";
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);


    $conexao->beginTransaction();

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

    $id_end = $conexao->lastInsertId();

    $sqlInstituicao = "INSERT INTO instituicao(email, 
        nome_fantasia, 
        razao_social, 
        senha, 
        cnpj,
        codigo_inep, 
        telefone,
        id_end) 
        VALUES 
        (:email, 
        :nome_fantasia, 
        :razao_social, 
        :senha, 
        :cnpj, 
        :codigo_inep, 
        :telefone,
        :id_end)";

    $requisicao = $conexao->prepare($sqlInstituicao);

    $requisicao->bindParam(':nome_fantasia', $nomeFantasia);
    $requisicao->bindParam(':email', $email);
    $requisicao->bindParam(':senha', $senhaHash);
    $requisicao->bindParam(':razao_social', $razaoSocial);
    $requisicao->bindParam(':cnpj', $cnpj);
    $requisicao->bindParam(':codigo_inep', $codigoInep);
    $requisicao->bindParam(':telefone', $telefone);
    $requisicao->bindParam(':id_end', $id_end);

    $requisicao->execute();

    $conexao->commit();

    echo "<script>
            alert('Instituição cadastrada com sucesso!');
            setTimeout(function() {
                window.location.href = '../View/auth/institution/login/institution-login.html';
            }, 70); 
          </script>";


} catch (PDOException $e) {

    $conexao->rollBack();
    echo "<script>
            alert('Instituição não cadastrada, erro: " . addslashes($e->getMessage()) . "');
            window.history.back()
        </script>";

}

?>