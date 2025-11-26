<?php
$con = mysqli_connect("localhost", "root", "", "GalaxiaDoSaber");
$result = mysqli_query($con, 'SELECT nome FROM turma');
$data = $result->fetch_all(MYSQLI_ASSOC);
$temTurmas = count($data) > 0;
?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
<link rel="stylesheet" href="institution-home.css">

<?php if (!$temTurmas): ?>
<div id="institution-home">
    <div class="header">
        <h1>Seja bem-vindo, Instituição!</h1>
        <h2>Crie a sua primeira turma</h2>
    </div>
    <button onclick="changeToClassCreation()">Criar</button>
</div>
<? endif;?>

<div id="class-creation" style="display: none">
    <form class="form" method="POST" action="../../../../Controller/TurmaController.php">
        <div class="container">
            <h1>Cadastro de turmas</h1>
            <div class="fields">
                <div>
                    <label for="">Nome da Turma:</label>
                    <input type="text" name="nome" required>
                </div>
                <div>
                    <label for="">Descrição:</label>
                    <textarea name="descricao" id="descricao" cols="30" rows="5" required></textarea>
                </div>
            </div>
            <div class="buttons">
                <img src="../../../../assets/icons/volte.png" alt="" onclick="backToInstitutionHome()">
                <input type="submit" value="Cadastrar" name="requisicao">
            </div>
        </div>
    </form>
</div>

<?php if ($temTurmas): ?>
<div id="turmas">
    <div class='cards-turma'>
    <?php foreach ($data as $row): ?>
        <div class='card'>
            <h2><?= $row['nome'] ?></h2>
        </div>
        <?php endforeach; ?>
    </div>
</div>a
<?php endif; ?>

<script src="institution-home.js"></script>