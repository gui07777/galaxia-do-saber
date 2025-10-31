<?php

require_once('../Model/conexaoBanco/Conexao.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tituloAtividade = $_POST['titulo'] ?? '';
    $prazoAtividade = $_POST['prazo'] ?? '';
    $dataPost = $_POST['data_post'] ?? date('Y-m-d H:i:s');
    $nomeTurma = $_POST['turma'] ?? '';
    $anexoAtividade = null;

    if (isset($_FILES['anexo']) && $_FILES['anexo']['error'] === UPLOAD_ERR_OK) {
        $anexoAtividade = file_get_contents($_FILES['anexo']['tmp_name']);
    }


    if (!empty($tituloAtividade) && !empty($prazoAtividade) && !empty($dataPost) && !empty($nomeTurma)) {

        try {

            $stmt = $conexao->prepare("SELECT id_turma FROM turma WHERE nome = :nome");
            $stmt -> bindParam(':nome', $nomeTurma);
            $stmt -> execute();

            if ($stmt->rowCount() === 0){
                echo "<script>
                    alert('Turma não encontrada! Verifique o nome digitado.');
                    window.history.back();
                    </script>";
                exit;            
            }

            $idTurma = $stmt->fetch(PDO::FETCH_ASSOC)['id_turma'];

            $conexao->beginTransaction();

            $sql = "INSERT INTO atividades (titulo,  
            anexo, 
            data_post, 
            prazo) 
            VALUES (:titulo, 
            :anexo, 
            :data_post, 
            :prazo)";

            $requisicao = $conexao->prepare($sql);

            $requisicao->bindParam(':titulo', $tituloAtividade);
            $requisicao->bindParam(':anexo', $anexoAtividade, PDO::PARAM_LOB);
            $requisicao->bindParam(':data_post', $dataPost);
            $requisicao->bindParam(':prazo', $prazoAtividade);

            $requisicao->execute();

            $idAtividade = $conexao->lastInsertId();

            $sqlTurmaAtividade = "INSERT INTO turmaAtividade (id_atividade, id_turma) VALUES (:id_atividade, :id_turma)";
            $relacao = $conexao->prepare($sqlTurmaAtividade);
            $relacao -> bindParam(':id_atividade', $idAtividade);
            $relacao -> bindParam(':id_turma', $idTurma);
            $relacao -> execute();

            $conexao->commit();

            echo "<script>
            alert('Atividade Criada e vinculada a uma Turma!');
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