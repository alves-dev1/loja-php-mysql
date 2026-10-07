<?php
require_once "ses_start.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: vendas.php");
    exit;
}

$token = $_POST["token"] ?? "";

if (
    !is_string($token) ||
    empty($_SESSION["token_cancelamento"]) ||
    !hash_equals($_SESSION["token_cancelamento"], $token)
) {
    exit("Solicitação inválida. Volte ao histórico e tente novamente.");
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if ($id === false || $id === null || $id <= 0) {
    exit("Venda inválida.");
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require_once "conexao.php";

mysqli_begin_transaction($conexao);

try {
    $sql = "SELECT produto_id, quantidade, status
            FROM vendas
            WHERE id = ?
            FOR UPDATE";

    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, "i", $id);
    mysqli_stmt_execute($comando);

    $resultado = mysqli_stmt_get_result($comando);
    $venda = mysqli_fetch_assoc($resultado);

    if (!$venda) {
        mysqli_rollback($conexao);
        exit("Venda não encontrada.");
    }

    if ($venda["status"] !== "ativa") {
        mysqli_rollback($conexao);
        header("Location: vendas.php");
        exit;
    }

    $sql = "UPDATE produtos
            SET quantidade = quantidade + ?
            WHERE id = ?";

    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param(
        $comando,
        "ii",
        $venda["quantidade"],
        $venda["produto_id"]
    );
    mysqli_stmt_execute($comando);

    if (mysqli_stmt_affected_rows($comando) !== 1) {
        throw new RuntimeException("Produto não atualizado.");
    }

    $sql = "UPDATE vendas SET status = 'cancelada' WHERE id = ?";

    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, "i", $id);
    mysqli_stmt_execute($comando);

    mysqli_commit($conexao);

    header("Location: vendas.php");
    exit;
} catch (Exception $erro) {
    mysqli_rollback($conexao);
    exit("Não foi possível cancelar a venda. Volte ao histórico e tente novamente.");
}