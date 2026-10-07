<?php
require_once "ses_start.php";
require_once "conexao.php";

$filtro = $_GET["status"] ?? "";

if (!in_array($filtro, ["", "ativa", "cancelada"], true)) {
    $filtro = "";
}

if (empty($_SESSION["token_cancelamento"])) {
    $_SESSION["token_cancelamento"] = bin2hex(random_bytes(32));
}

$sql = "SELECT vendas.id, clientes.nome AS cliente,
        produtos.nome AS produto, vendas.quantidade,
        vendas.preco_unitario, vendas.data_venda, vendas.status,
        vendas.quantidade * vendas.preco_unitario AS total
        FROM vendas
        INNER JOIN clientes ON vendas.cliente_id = clientes.id
        INNER JOIN produtos ON vendas.produto_id = produtos.id";

if ($filtro !== "") {
    $sql .= " WHERE vendas.status = ?";
}

$sql .= " ORDER BY vendas.id DESC";

$comando = mysqli_prepare($conexao, $sql);

if ($filtro !== "") {
    mysqli_stmt_bind_param($comando, "s", $filtro);
}

mysqli_stmt_execute($comando);
$resultado = mysqli_stmt_get_result($comando);

$vendas = [];
$totalVendas = 0;
$unidadesVendidas = 0;
$quantidadeVendas = 0;

while ($venda = mysqli_fetch_assoc($resultado)) {
    $vendas[] = $venda;

    if ($venda["status"] === "ativa") {
        $totalVendas += $venda["total"];
        $unidadesVendidas += $venda["quantidade"];
        $quantidadeVendas++;
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de vendas | Loja do Enzo</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <header class="topo">
            <a href="index.php" class="marca">ENZO / STORE</a>
            <a href="index.php" class="voltar">← Voltar ao início</a>
        </header>

        <main>
            <div class="introducao">
                <span class="etiqueta">Vendas</span>
                <h1>Histórico.</h1>
                <p class="descricao">Acompanhe as operações registradas e os principais totais.</p>
            </div>

            <form action="vendas.php" method="GET" class="filtro-vendas">
    <label for="status">Mostrar vendas:</label>

    <select name="status" id="status">
        <option value="" <?php if ($filtro === "") echo "selected"; ?>>
            Todas
        </option>

        <option value="ativa" <?php if ($filtro === "ativa") echo "selected"; ?>>
            Ativas
        </option>

        <option value="cancelada" <?php if ($filtro === "cancelada") echo "selected"; ?>>
            Canceladas
        </option>
    </select>

    <button type="submit" class="botao">Filtrar</button>
</form>

            <section class="resumo-vendas" aria-label="Resumo de vendas">
                <div class="resumo-item">
                    <span>Vendas ativas</span>
                    <strong><?php echo $quantidadeVendas; ?></strong>
                </div>
                <div class="resumo-item">
                    <span>Unidades vendidas</span>
                    <strong><?php echo $unidadesVendidas; ?></strong>
                </div>
                <div class="resumo-item">
                    <span>Total vendido</span>
                    <strong>R$ <?php echo number_format($totalVendas, 2, ",", "."); ?></strong>
                </div>
            </section>

            <?php if (count($vendas) === 0) { ?>
                <p class="vazio">Nenhuma venda encontrada para este filtro.</p>
            <?php } else { ?>
                <div class="tabela-container">
                    <table class="tabela tabela-vendas">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Produto</th>
                                <th scope="col" class="numero">Qtd.</th>
                                <th scope="col" class="numero">Preço unit.</th>
                                <th scope="col" class="numero">Total</th>
                                <th scope="col">Data</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($vendas as $venda) { ?>
                                <tr class="<?php echo $venda["status"] === "cancelada" ? "venda-cancelada" : ""; ?>">
                                    <td><?php echo (int) $venda["id"]; ?></td>
                                    <td class="cliente"><?php echo htmlspecialchars($venda["cliente"], ENT_QUOTES, "UTF-8"); ?></td>
                                    <td class="produto"><?php echo htmlspecialchars($venda["produto"], ENT_QUOTES, "UTF-8"); ?></td>
                                    <td class="numero"><?php echo (int) $venda["quantidade"]; ?></td>
                                    <td class="numero">R$ <?php echo number_format($venda["preco_unitario"], 2, ",", "."); ?></td>
                                    <td class="numero">R$ <?php echo number_format($venda["total"], 2, ",", "."); ?></td>
                                    <td><?php echo htmlspecialchars($venda["data_venda"], ENT_QUOTES, "UTF-8"); ?></td>
                                    <td>
                            <?php if ($venda["status"] === "ativa") { ?>
                            <span class="status disponivel">Ativa</span>
                            <?php } else { ?>
                            <span class="status esgotado">Cancelada</span>
                            <?php } ?>
                            </td>

    <td>
    <?php if ($venda["status"] === "ativa") { ?>
        <form
            action="cancelarVenda.php"
            method="POST"
            onsubmit="return confirm('Cancelar esta venda e devolver os produtos ao estoque?');"
        >
            <input
                type="hidden"
                name="id"
                value="<?php echo (int) $venda["id"]; ?>"
            >

            <input
                type="hidden"
                name="token"
                value="<?php echo htmlspecialchars($_SESSION["token_cancelamento"], ENT_QUOTES, 'UTF-8'); ?>"
            >

            <button type="submit" class="cancelar">
                Cancelar
            </button>
        </form>
    <?php } else { ?>
        —
    <?php } ?>
</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </main>
    </div>
</body>
</html>
