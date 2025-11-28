<?php
session_start();
require_once('../../../../Model/conexaoBanco/Conexao.php');

if (!isset($_SESSION['id_instituicao'])) {
    header("Location: ../../../auth/institution/login/institution-login.html");
    exit;
}

$idInstituicao = $_SESSION['id_instituicao'];

try {

    $query = $conexao->prepare("
        SELECT id_professor, nome 
        FROM professor 
        WHERE id_instituicao = :instituicao
    ");

    $query->bindParam(":instituicao", $idInstituicao);
    $query->execute();

    $professores = $query->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    die("Erro ao buscar professores: " . $e->getMessage());
}
?>

<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
<link rel="stylesheet" href="teacher-list.css">

<div id="student-area">
    <div class="container">
        <h1>Professores cadastrados</h1>

        <table>
            <thead>
                <th>Nome</th>
                <th>Mais informações</th>
            </thead>
            <tbody>
                <?php foreach ($professores as $prof): ?>
                <tr>
                    <td><?= htmlspecialchars($prof['nome']) ?></td>
                    <td>
                        <button class="btn-visualizar"
                                data-id="<?= $prof['id_professor'] ?>">
                                Ver detalhes
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<div id="overlay-hide">
    <div id="information-modal-hide">
        <header>
            <div></div>
            <h3>Informações Gerais</h3>
            <i class="material-symbols-outlined" onclick="closeModal()">close</i>
        </header>

        <div class="content">
            <div>
                <label>CPF:</label>
                <input type="text" id="cpf" readonly>
            </div>
            <div>
                <label>Email:</label>
                <input type="text" id="email" readonly>
            </div>
            <div>
                <label>Cargo:</label>
                <input type="text" id="cargo" readonly>
            </div>
            <div>
                <label>Disciplina:</label>
                <input type="text" id="disciplina" readonly>
            </div>
            <div>
                <label>Turma:</label>
                <input type="text" id="turma" readonly>
            </div>

            <div class="buttons">
                <button onclick="editInformation()">Editar</button>
            </div>
        </div>

    </div>
</div>

<script src="teacher-list.js"></script>
