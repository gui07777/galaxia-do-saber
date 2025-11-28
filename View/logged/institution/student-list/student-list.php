<?php
// session_start();
// require_once('../../../../Model/conexaoBanco/Conexao.php');

// if (!isset($_SESSION['id_instituicao'])) {
//     echo "<script>
//             alert('Você precisa estar logado.');
//             window.location.href='../../../auth/institution/login/institution-login.html';
//           </script>";
//     exit;
// }

// $idInstituicao = $_SESSION['id_instituicao'];

try {

    $sql = $conexao->prepare("
        SELECT 
            a.id_aluno,
            a.nome,
            a.numero_matricula,
            t.nome AS turma
        FROM aluno a
        LEFT JOIN turma t ON t.id_turma = a.id_turma
        WHERE t.id_instituicao = :inst 
           OR a.id_turma IS NULL
    ");

    $sql->bindParam(':inst', $idInstituicao);
    $sql->execute();
    $alunos = $sql->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao buscar alunos: " . $e->getMessage());
}
?>

<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0">
<link rel="stylesheet" href="student-list.css">

<div id="student-area">
    <div class="container">
        <h1>Alunos matriculados</h1>

        <table>
            <thead>
                <th>Nome</th>
                <th>Mais informações</th>
            </thead>
            <tbody>

                <?php if (count($alunos) > 0): ?>
                    <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?= htmlspecialchars($aluno['nome']) ?></td>
                            <td>
                                <button class="btn-visualizar"
                                    data-id="<?= $aluno['id_aluno'] ?>">
                                    Ver detalhes
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="2" style="text-align:center; padding: 10px;">
                            Nenhum aluno encontrado.
                        </td>
                    </tr>
                <?php endif; ?>

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
                <label>Nome:</label>
                <input type="text" id="nome" readonly>
            </div>
            <div>
                <label>Número da matrícula:</label>
                <input type="text" id="matricula" readonly>
            </div>
            <div>
                <label>Email:</label>
                <input type="text" id="email" readonly>
            </div>
            <div>
                <label>Data de nascimento:</label>
                <input type="text" id="nasc" readonly>
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

<script src="student-list.js"></script>
