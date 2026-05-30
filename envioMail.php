<?php
$erros = [];
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Sanitiza os dados recebidos
    $nome     = trim(strip_tags($_POST["nome"] ?? ""));
    $email    = trim(strip_tags($_POST["email"] ?? ""));
    $mensagem = trim(strip_tags($_POST["mensagem"] ?? ""));
    $assunto  = trim(strip_tags($_POST["assunto"] ?? ""));
 
    // Validação
    if (empty($nome)) {
        $erros[] = "O campo nome é obrigatório.";
    }
    if (empty($email)) {
        $erros[] = "O campo e-mail é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "O e-mail fornecido é inválido.";
    }
    if (empty($assunto)) {
        $erros[] = "O campo assunto é obrigatório.";
    }
    if (empty($mensagem)) {
        $erros[] = "O campo mensagem é obrigatório.";
    }
 
    if (empty($erros)) {
        $destinatario = "razorbytedev@gmail.com";
 
        // Assunto com prefixo para identificar no Gmail
        $assunto_email = "[RazorByte] $assunto";
 
        // Corpo do e-mail formatado
        $corpo = "Nova mensagem recebida pelo site RazorByte:\n\n";
        $corpo .= "Nome: $nome\n";
        $corpo .= "E-mail: $email\n";
        $corpo .= "Assunto: $assunto\n\n";
        $corpo .= "Mensagem:\n$mensagem\n";
 
        // Cabeçalhos corretos
        $headers  = "From: RazorByte Site <no-reply@razorbyte.dev>\r\n";
        $headers .= "Reply-To: $nome <$email>\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
 
        if (mail($destinatario, $assunto_email, $corpo, $headers)) {
            // Redireciona de volta com sucesso
            header("Location: index.html?enviado=1");
            exit();
        } else {
            // Redireciona com erro
            header("Location: index.html?enviado=0");
            exit();
        }
 
    } else {
        // Redireciona com erros (codificados na URL)
        $erros_str = urlencode(implode("|", $erros));
        header("Location: index.html?erros=$erros_str");
        exit();
    }
 
} else {
    // Acesso direto ao arquivo — redireciona para home
    header("Location: index.html");
    exit();
}
?>