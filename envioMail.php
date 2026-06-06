<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
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
    header("Location: index.html?erros=" . urlencode(implode("|", $erros)));
    exit();
}

$mail = new PHPMailer(true);

try {
    // ── Configuração SMTP Gmail ──
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'razorbytedev@gmail.com';  // seu Gmail
    $mail->Password   = 'sacfvsywtrowitov';   // senha de app (ver abaixo)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';

    // ── Remetente e destinatário ──
    $mail->setFrom('razorbytedev@gmail.com', 'RazorByte Site');
    $mail->addAddress('razorbytedev@gmail.com', 'RazorByte');
    $mail->addReplyTo($email, $nome);

    // ── Conteúdo ──
    $mail->Subject = "[RazorByte] $assunto";
    $mail->Body    =
        "Nova mensagem recebida pelo site RazorByte:\n\n" .
        "Nome: $nome\n" .
        "E-mail: $email\n" .
        "Assunto: $assunto\n\n" .
        "Mensagem:\n$mensagem";

    $mail->send();
    header("Location: index.html?enviado=1");
    exit();

} catch (Exception $e) {
    // Descomente a linha abaixo para ver o erro durante testes:
    // die("Erro: " . $mail->ErrorInfo);
    header("Location: index.html?enviado=0");
    exit();
}
?>