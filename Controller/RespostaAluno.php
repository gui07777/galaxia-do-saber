<?php

session_start();

require_once('../Model/conexaoBanco/Conexao.php');


if(!isset($_SESSION['email_aluno'])){

    echo "<script>
        alert('Sessão expirada. Faça login novamente.');
        window.location.href = '../../auth/student/login/student-login.html';
    </script>";
    exit;
}

$email = $_SESSION['email_aluno'];
$id_atividade = $_POST['id_atividade'] ?? $_GET['id_atividade'] ?? null;

$comentario = $_POST['comentario'] ?? null;

if(!$id_atividade){

    echo "<script>
    alert('Nenhuma atividade foi informada!');
    window.history.back();
    </script>";
    exit;
}

try {
    $sqlAluno = "SELECT id_aluno FROM aluno WHERE email = :email LIMIT 1";
    $stmtAluno = $conexao->prepare($sqlAluno);
    $stmtAluno->bindParam(":email", $email);
    $stmtAluno->execute();
    $aluno = $stmtAluno->fetch();

    if (!$aluno) {
        echo "<script>
            alert('Aluno não encontrado.');
            window.history.back();
        </script>";
        exit;
    }

    $id_aluno = $aluno['id_aluno'];

} catch (Exception $e) {
    echo "<script>
        alert('Erro ao recuperar aluno no banco.');
        window.history.back();
    </script>";
    exit;
}

$arquivoBinario = null;
$nomeArquivo = null;

if (isset($_FILES['anexo']) && $_FILES['anexo']['error'] === UPLOAD_ERR_OK) {
    $arquivoBinario = file_get_contents($_FILES['anexo']['tmp_name']);
    $nomeArquivo = $_FILES['anexo']['name'];
}

try {
    $sqlCheck = "SELECT id_resposta FROM resposta WHERE id_atividade = :id_atividade AND id_aluno = :id_aluno LIMIT 1";
    $stmtCheck = $conexao->prepare($sqlCheck);
    $stmtCheck->bindParam(":id_atividade", $id_atividade);
    $stmtCheck->bindParam(":id_aluno", $id_aluno);
    $stmtCheck->execute();
    $respostaExistente = $stmtCheck->fetch();

if ($respostaExistente) {

        $sqlUpdate = "UPDATE resposta 
                      SET comentario = :comentario, data_envio = NOW()";

        if ($arquivoBinario !== null) {
            $sqlUpdate .= ", anexo = :anexo, nome_arquivo = :nome_arquivo";
        }

        $sqlUpdate .= " WHERE id_resposta = :id_resposta";

        $stmtUpdate = $conexao->prepare($sqlUpdate);
        $stmtUpdate->bindParam(":comentario", $comentario);
        $stmtUpdate->bindParam(":id_resposta", $respostaExistente['id_resposta']);

        if ($arquivoBinario !== null) {
            $stmtUpdate->bindParam(":anexo", $arquivoBinario);
            $stmtUpdate->bindParam(":nome_arquivo", $nomeArquivo);
        }

        $stmtUpdate->execute();

}else{
     $sqlInsert = "INSERT INTO resposta (data_envio, 
     anexo, 
     nome_arquivo, 
     comentario, 
     id_atividade, 
     id_aluno) VALUES 
     (NOW(), 
     :anexo, 
     :nome_arquivo, 
     :comentario, 
     :id_atividade, 
     :id_aluno)";

        $stmtInsert = $conexao->prepare($sqlInsert);
        $stmtInsert->bindParam(":comentario", $comentario);
        $stmtInsert->bindParam(":id_atividade", $id_atividade);
        $stmtInsert->bindParam(":id_aluno", $id_aluno);
        $stmtInsert->bindParam(":anexo", $arquivoBinario);
        $stmtInsert->bindParam(":nome_arquivo", $nomeArquivo);
        $stmtInsert->execute();
}

} catch (Exception $e) { 
    echo "<script> 
    alert('Erro ao registrar sua resposta.'); 
    window.history.back(); 
    </script>"; 
    exit; 
}

echo "<script>
    alert('Resposta enviada com sucesso!');
    window.location.href = '../View/logged/student/activities-zone/activities-zone.php';
</script>";
exit;
?>