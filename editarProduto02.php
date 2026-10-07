<?php
require_once "ses_start.php";
require_once "conexao.php";

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$nome = trim($_POST["nome"] ?? "");
$preco = filter_input(INPUT_POST, "preco", FILTER_VALIDATE_FLOAT);
$quantidade = filter_input(INPUT_POST, "quantidade", FILTER_VALIDATE_INT);

if ($id === false || $id === null || $id <= 0) {
    exit("Produto inválido.");
}

if ($nome == "" || $preco === false || $preco === null ||
    $quantidade === false || $quantidade === null) {
    exit("Preencha o nome, um preço válido e uma quantidade inteira.");
}

if ($preco < 0 || $quantidade < 0) {
    exit("Preço e quantidade não podem ser negativos.");
}

$sql = "UPDATE produtos SET nome = ?, preco = ?, quantidade = ? WHERE id = ?";
$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($comando, "sdii", $nome, $preco, $quantidade, $id);
mysqli_stmt_execute($comando);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto atualizado | Loja do Enzo</title>
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
            <h1>Produto atualizado.</h1>
            <p class="descricao">As alterações foram salvas com sucesso.</p>
            <div class="links-resultado">
                <a href="estoque.php" class="botao">Ver estoque</a>
            </div>
        </main>
    </div>
</body>
</html>
