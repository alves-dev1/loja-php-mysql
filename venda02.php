<?php
require_once "ses_start.php";
require_once "conexao.php";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$cliente_id = filter_input(INPUT_POST, "cliente_id", FILTER_VALIDATE_INT);
$produto_id = filter_input(INPUT_POST, "produto_id", FILTER_VALIDATE_INT);
$quantidade = filter_input(INPUT_POST, "quantidade", FILTER_VALIDATE_INT);

if (!$cliente_id || !$produto_id || !$quantidade ||
    $cliente_id < 1 || $produto_id < 1 || $quantidade < 1) {
    exit("Selecione o cliente, o produto e uma quantidade válida.");
}

mysqli_begin_transaction($conexao);

try {
    $sql = "SELECT preco, quantidade FROM produtos WHERE id = ? FOR UPDATE";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, "i", $produto_id);
    mysqli_stmt_execute($comando);

    $resultado = mysqli_stmt_get_result($comando);
    $produto = mysqli_fetch_assoc($resultado);

    if (!$produto) {
        mysqli_rollback($conexao);
        exit("Produto não encontrado.");
    }

    if ($quantidade > $produto["quantidade"]) {
        mysqli_rollback($conexao);
        exit("Estoque insuficiente. Disponível: " . $produto["quantidade"]);
    }

    $preco_unitario = $produto["preco"];

    $sql = "INSERT INTO vendas
            (cliente_id, produto_id, quantidade, preco_unitario)
            VALUES (?, ?, ?, ?)";

    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param(
        $comando,
        "iiis",
        $cliente_id,
        $produto_id,
        $quantidade,
        $preco_unitario
    );
    mysqli_stmt_execute($comando);

    $sql = "UPDATE produtos SET quantidade = quantidade - ? WHERE id = ?";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, "ii", $quantidade, $produto_id);
    mysqli_stmt_execute($comando);

    mysqli_commit($conexao);

    header("Location: venda01.php?sucesso=1");
    exit;
} catch (mysqli_sql_exception $erro) {
    mysqli_rollback($conexao);
    exit("Não foi possível registrar a venda. Confira se o cliente e o produto existem.");
}
?>