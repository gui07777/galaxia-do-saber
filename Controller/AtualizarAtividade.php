<?php

require_once('../Model/conexaoBanco/Conexao.php');

$tituloAtividade = $_POST['titulo'];
$prazoAtividade = $_POST['prazo'];
$anexoAtividade = $_POST['anexo'];
$dataPost = $_POST['data_post'];


if (!empty($tituloAtividade) && !empty($prazoAtividade)) {

        $sql = "UPDATE atividades 
        SET titulo = :titulo, 
        prazo = :prazo, 
        anexo = :anexo,
        data_post = :data_post WHERE 
        titulo = :titulo";
    
    $requisicao = $conexao->prepare($sql);

    $requisicao->bindParam(':titulo', $tituloAtividade);
    $requisicao->bindParam(':prazo', $prazoAtividade);
    $requisicao->bindParam(':anexo', $anexoAtividade);
    $requisicao->bindParam(':data_post', $dataPost);

    try {

        $requisicao->execute();
        echo 'Informações da Atividade atualizadas.';

    } catch (PDOException $e) {

        echo 'Erro: ' . $e->getMessage();

    }

} else {

    echo 'Preencha os campos para formalizar a atualização.';

}

?>