<?php

require_once('../Model/conexaoBanco/Conexao.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'phpmailerteste9@gmail.com';
    $mail->Password = 'peqjdrdqezxqeqaz';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('pt_br', __DIR__ . '/PHPMailer/language/phpmailer.lang-pt_br.php');
    $mail->setFrom('phpmailerteste9@gmail.com', 'Galáxia do Saber');

    $sql = "SELECT nome_fantasia, email FROM instituicao WHERE notificado = 0";
    $stmt = $conexao->query($sql);
    $contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($contatos) === 0) {
        die('Nenhum novo e-mail encontrado para envio.');
    }

    foreach ($contatos as $contato) {
        $codigo = rand(100000, 999999); 
        $data_aut = date('Y-m-d H:i:s', time() + 3600); 

        $insert = $conexao->prepare("
            INSERT INTO autenticacao (email, codigo, data_aut)
            VALUES (:email, :codigo, :data_aut)
            ON DUPLICATE KEY UPDATE codigo = :codigo2, data_aut = :data_aut2
        ");

        $insert->execute([
            ':email' => $contato['email'],
            ':codigo' => $codigo,
            ':data_aut' => $data_aut,
            ':codigo2' => $codigo,
            ':data_aut2' => $data_aut
        ]);

        $link = "http://localhost/levi-modular/GALAXIADOSABER/View/auth/institution/register/authentication/authenticator.html";

        $mail->clearAllRecipients();
        $mail->addAddress($contato['email'], $contato['nome_fantasia']);
        $mail->isHTML(true);
        $mail->Subject = 'Seu código de autenticação';
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; background-color: #f3f0ff; padding: 20px;'>
            <table align='center' width='100%' style='max-width: 600px; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 8px rgba(0,0,0,0.1);'>
                <tr style='background-color: #7E3FF2;'>
                    <td style='padding: 20px; text-align: center;'>
                        <img src='https://i.imgur.com/8xEj1jt.png' alt='Galáxia do Saber' width='100' style='display:block;margin:0 auto 10px auto;'>
                        <h1 style='color: #ffffff; font-size: 24px; margin: 0;'>Galáxia do Saber</h1>
                    </td>
                </tr>
                <tr>
                    <td style='padding: 30px; color: #333333;'>
                        <h2 style='color: #7E3FF2;'>Olá, {$contato['nome_fantasia']}!</h2>
                        <p>Recebemos uma solicitação para validar o acesso à sua conta.</p>
                        <p>Use o código abaixo para autenticação:</p>
                        <div style='background-color: #f3f0ff; border: 1px dashed #9C27F0; border-radius: 8px; text-align: center; padding: 15px; margin: 20px 0;'>
                            <span style='font-size: 28px; color: #7E3FF2; letter-spacing: 2px; font-weight: bold;'>$codigo</span>
                        </div>
                        <p>Ou, se preferir, valide diretamente clicando no botão abaixo:</p>
                        <p style='text-align: center;'>
                            <a href='$link'
                               style='background-color: #7E3FF2; color: #ffffff; padding: 12px 25px; text-decoration: none; 
                               border-radius: 6px; font-weight: bold; display: inline-block;'>
                               Validar Minha Conta
                            </a>
                        </p>
                        <p style='margin-top: 20px; font-size: 14px; color: #555;'>⚠️ Este código expira em <b>1 hora</b>.</p>
                    </td>
                </tr>
                <tr style='background-color: #f3f0ff; text-align: center;'>
                    <td style='padding: 15px; font-size: 12px; color: #777;'>
                        <p>© 2025 Galáxia do Saber — Todos os direitos reservados.</p>
                    </td>
                </tr>
            </table>
        </div>";

        set_time_limit(60);
        $mail->send();

        $update = $conexao->prepare("UPDATE instituicao 
        SET notificado = 1 
        WHERE email = :email");

        $update->execute([':email' => $contato['email']]);

    }

    echo "<script>
    alert('Códigos enviados com sucesso!');
    </script>";

} catch (Exception $e) {
    echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
}