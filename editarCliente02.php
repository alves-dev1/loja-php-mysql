<?php
require_once "conexao.php";
require_once "ses_start.php";

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$nome = trim($_POST["nome"] ?? "");
$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

if ($id === false || $id === null || $id <= 0) {
    exit("Cliente inválido.");
}

if ($nome == "" || $email === false || $email === null) {
    exit("Preencha o nome e um e-mail válido.");
}

$sql = "UPDATE clientes SET nome = ?, email = ? WHERE id = ?";
$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($comando, "ssi", $nome, $email, $id);
mysqli_stmt_execute($comando);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente atualizado | Loja do Enzo</title>
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
            <h1>Cliente atualizado.</h1>
            <p class="descricao">As alterações foram salvas com sucesso.</p>
            <div class="links-resultado">
                <a href="clientes.php" class="botao">Ver clientes</a>
            </div>
        </main>
    </div>
</body>
</html>
