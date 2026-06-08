<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: sac.html");
    exit();
}

$nome     = trim(strip_tags($_POST["nome"]     ?? ""));
$email    = trim(strip_tags($_POST["email"]    ?? ""));
$mensagem = trim(strip_tags($_POST["mensagem"] ?? ""));
$assunto  = trim(strip_tags($_POST["assunto"]  ?? ""));

$erros = [];
if (empty($nome))     $erros[] = "O campo nome é obrigatório.";
if (empty($email))    $erros[] = "O campo e-mail é obrigatório.";
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erros[] = "E-mail inválido.";
if (empty($assunto))  $erros[] = "O campo assunto é obrigatório.";
if (empty($mensagem)) $erros[] = "O campo mensagem é obrigatório.";

if (!empty($erros)) {
    header("Location: sac.html?erros=" . urlencode(implode("|", $erros)));
    exit();
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'razorbytedev@gmail.com';
    $mail->Password   = 'sacfvsywtrowitov';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom('razorbytedev@gmail.com', 'Laço Site');
    $mail->addAddress('razorbytedev@gmail.com', 'Laço');
    $mail->addReplyTo($email, $nome);

    $mail->Subject = "[Laço] $assunto";
    $mail->Body    =
        "Nova mensagem recebida pelo site Laço:\n\n" .
        "Nome: $nome\n" .
        "E-mail: $email\n" .
        "Assunto: $assunto\n\n" .
        "Mensagem:\n$mensagem";

    $mail->send();
    header("Location: sac.html?enviado=1");
    exit();

} catch (Exception $e) {
    header("Location: sac.html?enviado=0&erro=" . urlencode($mail->ErrorInfo));
    exit();
}
?>