<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'] ?? '';
$nome = $_POST['nome'] ?? '';
$novaSenha = $_POST['novaSenha'] ?? '';
$data_nasc = $_POST['data_nasc'] ?? '';
$turma = $_POST['turma'] ?? null;

if (!empty($nome) && !empty($email)) {

    $campos = ["nome = :nome", "data_nasc = :data_nasc"];

    $param = [

        ':email' => $email,
        ':nome' => $nome,
        ':data_nasc' => $data_nasc,

    ];


    if (!empty($novaSenha)) {

        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $campos[] = "senha = :senha";
        $param[':senha'] = $senhaHash;

    }

    if (!empty($turma)) {

        $campos[] = "id_turma = :turma";
        $param[':turma'] = $turma;

    }

    $sql = "UPDATE aluno SET " . implode(', ', $campos) . " WHERE email = :email";

    $requisicao = $conexao->prepare($sql);

    try {

        $consultaEmail = "SELECT COUNT(*) FROM aluno WHERE email = :email";
        $consultaEmail = $conexao->prepare($consultaEmail);
        $consultaEmail->execute([':email' => $email]);
        $existeEmail = $consultaEmail->fetchColumn();

        if ($existeEmail == 0) {

            echo "<script>
                alert('Erro: nenhum aluno encontrado com o e-mail informado.');
                window.history.back();
            </script>";
            exit;

        }

        $requisicao->execute($param);

        echo "<script>
            alert('Informações do Aluno atualizadas!');
            window.history.back();
                </script>";

    } catch (PDOException $e) {

        echo "<script>
            alert('Erro ao atualizar:  " . addslashes($e->getMessage()) . "');
                </script>";

    }

} else {

    echo "<script>
        alert('Preencha pelo menos o nome e o email.');
        window.history.back();
            </script>";

}

?>