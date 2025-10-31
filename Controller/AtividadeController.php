<?php

$requisicao = $_POST['requisicao'];

switch ($requisicao) {

    case 'Atualizar':

        include 'AtualizarAtividade.php';
        break;

    case 'Criar':

        include 'CriarAtividade.php';
        break;

    case 'Consultar':

        include 'ConsultarAtividade.php';
        break;

    case 'Remover':

        include 'RemoverAtividade.php';
        break;

    default:

        echo "Ação inválida, selecione uma opção válida.";
        break;

}

?>