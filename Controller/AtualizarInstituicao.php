<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'] ?? null;
$nomeFantasia = $_POST['nome_fantasia'] ?? null;
$novaSenha = $_POST['senha'] ?? null;
$telefone = $_POST['telefone'] ?? null;

function formatarTelefoneBR($telefone) {

    $telefone = preg_replace('/\D/', '', $telefone);

    if (strlen($telefone) == 11) {
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
    }


    if (strlen($telefone) == 10) {
        return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
    }

    return $telefone; 
}

$telefone = formatarTelefoneBR($telefone);

if (empty($nomeFantasia) || empty($email)) {
    echo "<script>
            alert('Preencha o Nome Fantasia e o Email para atualizar!');
            window.history.back();
          </script>";
    exit;
}

try {

    if (!empty($novaSenha)) {

        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $sql = "UPDATE instituicao 
                SET nome_fantasia = :nome_fantasia, senha = :senha, telefone = :telefone 
                WHERE email = :email";

        $requisicao = $conexao->prepare($sql);
        $requisicao->bindParam(':senha', $senhaHash);

    } else {

        $sql = "UPDATE instituicao 
                SET nome_fantasia = :nome_fantasia, telefone = :telefone 
                WHERE email = :email";

        $requisicao = $conexao->prepare($sql);
    }

    $requisicao->bindParam(':email', $email);
    $requisicao->bindParam(':nome_fantasia', $nomeFantasia);
    $requisicao->bindParam(':telefone', $telefone);

    $requisicao->execute();

    echo "<script>
            alert('Informações da Instituição atualizadas com sucesso!');
            window.history.back();
          </script>";

} catch (PDOException $e) {

    echo "<script>
            alert('Erro ao atualizar informações: " . addslashes($e->getMessage()) . "');
            window.history.back();
          </script>";
}
?>
