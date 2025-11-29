<?php

session_start();

if (!isset($_SESSION['email_aluno'])) {
    header("Location: ../../../../auth/student/login/student-login.html");
    exit;
}

$id_atividade = $_GET['id'] ?? null;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividade</title>
    <link rel="stylesheet" href="activities-description.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <img src="../../../../../assets/icons/logosemfundo.png" class="logo">
        <div class="width"></div>
        <div class="buttons">
            <a href="../../student-notification/student-notification.php">
                <img src="../../../../../assets/icons/sininho.png" alt="">
            </a>
            <a href="../../student-profile/student-profile.php">
                <img src="../../../../../assets/icons/anonimous.png" alt="">
            </a>
        </div>
    </header>
    <main>
        <div class="back">
            <img src="../../../../../assets/icons/white-back.png" alt="" onclick="navigateBack()">
        </div>
        <div class="titles">
            <h1>Atividade</h1>
        </div>

        <div class="activities">
            <div class="background-activity">
                <div class="activity">

                    <h2>Atividade</h2>

                    <form action="../../../../../Controller/RespostaAluno.php" method="POST" enctype="multipart/form-data">

                       <input type="hidden" name="id_atividade" value="<?= $_GET['id_atividade'] ?>">


                        <label class="label-black">Anexo:</label>

                        <label class="file-upload-box" for="anexo">
                            <span id="file-name">Clique para escolher um arquivo...</span>
                            <input type="file" name="anexo" id="anexo" 
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip,.rar">
                        </label>

                        <label for="comentario">Suba aqui sua Atividade:</label>
                        <div class="upload-box">
                            <textarea id="comentario" name="comentario" placeholder="Comentário (100)"></textarea>
                        </div>

                        <button type="submit" class="enviar">Enviar</button>

                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="activities-description.js"></script>
    <script>
    document.getElementById("anexo").addEventListener("change", function(){
        let text = this.files.length ? this.files[0].name : "Clique para escolher um arquivo...";
        document.getElementById("file-name").textContent = text;
    });
    </script>

</body>

</html>
