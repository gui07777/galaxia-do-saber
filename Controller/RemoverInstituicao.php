<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];

if (!empty($email)) {

    $sql = "DELETE FROM instituicao_escolar WHERE email = :email";

    $requisicao = $conexao->prepare($sql);

    $requisicao->bindParam(':email', $email);

    try {

        $requisicao->execute();

        if ($requisicao->rowCount() > 0) {

            echo 'Instituição deletada do sistema.';

        } else {

            echo 'Instituição não existente no sistema.';

        }

    } catch (PDOException $e) {

        echo 'Erro: ' . $e->getMessage();

    }

} else {

    echo 'Insira um email para validar a exclusão do sistema';

}

?>