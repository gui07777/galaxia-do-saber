<?php

require_once('../Model/conexaoBanco/Conexao.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tituloAtividade = $_POST['titulo'] ?? '';
    $prazoAtividade = $_POST['prazo'] ?? '';
    $dataPost = $_POST['data_post'] ?? date('Y-m-d H:i:s');
    $anexoAtividade = null;

    if (isset($_FILES['anexo']) && $_FILES['anexo']['error'] === UPLOAD_ERR_OK) {
        $anexoAtividade = file_get_contents($_FILES['anexo']['tmp_name']);
    }


    if (!empty($tituloAtividade) && !empty($prazoAtividade) && !empty($dataPost)) {

        try {

            $conexao->beginTransaction();

            $sql = "INSERT INTO atividades (titulo,  
            anexo, 
            data_post, 
            prazo) 
            VALUES (:titulo, 
            :anexo, 
            :data_post, 
            :prazo)";

            $requisicao = $conexao->prepare("$sql");

            $requisicao->bindParam(':titulo', $tituloAtividade);
            $requisicao->bindParam(':anexo', $anexoAtividade, PDO::PARAM_LOB);
            $requisicao->bindParam(':data_post', $dataPost);
            $requisicao->bindParam(':prazo', $prazoAtividade);

            $requisicao->execute();
            $conexao->commit();

            echo "<script>
            alert('Atividade Criada!');
            window.history.back();
            </script>";

        } catch (PDOException $e) {

            $conexao->rollBack();
            echo "<script>
            alert('Atividade não criada, erro: " . addslashes($e->getMessage()) . "');
            window.history.back();
            </script>";

        }
    } else {
        echo "<script>
            alert('Preencha todos os campos para criar a atividade!');
        </script>";
    }
}
?>