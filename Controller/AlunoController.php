<?php

$requisicao = $_POST['requisicao'];

switch ($requisicao) {

    case 'Salvar alterações':

        include 'AtualizarAluno.php';
        break;

    case 'Cadastrar':

        include 'CadastroAluno.php';
        break;

    case 'Consultar':

        include 'ConsultarAluno.php';
        break;

    case 'Remover':

        include 'RemoverAluno.php';
        break;

    default:

        echo "Ação inválida, selecione uma opção válida.";
        break;

}

?>