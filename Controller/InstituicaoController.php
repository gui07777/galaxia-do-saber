<?php

$requisicao = $_POST['requisicao'];

switch ($requisicao) {

    case 'Atualizar':

        include 'AtualizarInstituicao.php';
        break;

    case 'Cadastrar':

        include 'CadastroInstituicao.php';
        break;

    case 'Consultar':

        include 'ConsultaInstituicao.php';
        break;

    case 'Remover':

        include 'RemoverInstituicao.php';
        break;


    default:

        echo "Ação inválida, selecione uma opção válida.";
        break;

}

?>