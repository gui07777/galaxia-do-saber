<?php
$con = mysqli_connect("localhost", "root", "", "GalaxiaDoSaber");

if (!isset($_GET['id_turma'])) {
    echo "<div id='class'><p>Turma não encontrada.</p></div>";
    return;
}

$id_turma = $_GET['id_turma'];

$sql = "SELECT * FROM turma WHERE id_turma = '$id_turma'";
$result = mysqli_query($con, $sql);
$turma = mysqli_fetch_assoc($result);

if (!$turma) {
    echo "<div id='class'><p>Turma não existe.</p></div>";
    return;
}
?>

<div id="class">

    <div class="class-header">
        <h1><?= $turma['nome'] ?></h1>
        <p><?= $turma['descricao'] ?></p>
    </div>

    <div class="class-grid">

        <div class="class-box">
            <h2>Professores</h2>

            <?php
            $sqlProf = "
              SELECT u.nome 
              FROM turma_professores tp
              JOIN usuarios u ON tp.professor_id = u.id
              WHERE tp.id_turma = '$id_turma'
            ";
            $resProf = mysqli_query($con, $sqlProf);
            ?>

            <div class="users-list">
                <?php while($p = mysqli_fetch_assoc($resProf)): ?>
                    <div class="user-card professor"><?= $p['nome'] ?></div>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="class-box">
            <h2>Alunos</h2>

            <?php
            $sqlAluno = "
              SELECT u.nome 
              FROM turma_alunos ta
              JOIN usuarios u ON ta.aluno_id = u.id
              WHERE ta.id_turma = '$id_turma'
            ";
            $resAluno = mysqli_query($con, $sqlAluno);
            ?>

            <div class="users-list">
                <?php while($a = mysqli_fetch_assoc($resAluno)): ?>
                    <div class="user-card aluno"><?= $a['nome'] ?></div>
                <?php endwhile; ?>
            </div>
        </div>

    </div>

    <div class="class-actions">
        <button onclick="loadPage('institution-home.php')" class="btn-back">
            ← Voltar
        </button>

        <form method="POST" action="../../../../Controller/TurmaController.php"
              onsubmit="return confirm('Deseja realmente excluir essa turma?');">
            <input type="hidden" name="id_turma" value="<?= $turma['id_turma'] ?>">
            <button type="submit" name="deletar" class="btn-delete">
                Excluir turma
            </button>
        </form>
    </div>

</div>
