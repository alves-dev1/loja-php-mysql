<?php
require_once "ses_start.php";
require_once "conexao.php";

$nome = trim($_POST["nome"] ?? "");
$preco = filter_var($_POST["preco"] ?? "", FILTER_VALIDATE_FLOAT);
$quantidade = filter_var($_POST["quantidade"] ?? "", FILTER_VALIDATE_INT);

if ($nome == "" || $preco === false || $quantidade === false) {
    exit("Preencha o nome, um preço válido e uma quantidade inteira.");
}

if ($preco < 0 || $quantidade < 0) {
    exit("Preço e quantidade não podem ser negativos.");
}

$sql = "INSERT INTO produtos (nome, preco, quantidade) VALUES (?, ?, ?)";
$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($comando, "sdi", $nome, $preco, $quantidade);
mysqli_stmt_execute($comando);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto cadastrado | Loja do Enzo</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container pagina-resultado">
        <header class="topo">
            <a href="index.php" class="marca">ENZO / STORE</a>
            <a href="estoque.php" class="voltar">← Voltar ao estoque</a>
        </header>
        <main class="resultado-card">
            <span class="etiqueta">Concluído</span>
            <h1>Produto cadastrado.</h1>
            <p class="descricao">O novo produto já está disponível no estoque.</p>
            <div class="links-resultado">
                <a href="estoque.php" class="botao">Ver estoque</a>
                <a href="cadProduto01.php" class="link-discreto">Cadastrar outro produto</a>
            </div>
        </main>
    </div>
</body>
</html>
