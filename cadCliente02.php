<?php
require_once "ses_start.php";
require_once "conexao.php";

$nome = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");

if ($nome == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Preencha o nome e um e-mail válido.");
}

$sql = "INSERT INTO clientes (nome, email) VALUES (?, ?)";
$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($comando, "ss", $nome, $email);
mysqli_stmt_execute($comando);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente cadastrado | Loja do Enzo</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container pagina-resultado">
        <header class="topo">
            <a href="index.php" class="marca">ENZO / STORE</a>
            <a href="clientes.php" class="voltar">← Voltar aos clientes</a>
        </header>
        <main class="resultado-card">
            <span class="etiqueta">Concluído</span>
            <h1>Cliente cadastrado.</h1>
            <p class="descricao">O cliente já está disponível para novas vendas.</p>
            <div class="links-resultado">
                <a href="clientes.php" class="botao">Ver clientes</a>
                <a href="cadCliente01.php" class="link-discreto">Cadastrar outro cliente</a>
            </div>
        </main>
    </div>
</body>
</html>
