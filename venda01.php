<?php
require_once "ses_start.php";
require_once "conexao.php";

$sql = "SELECT id, nome FROM clientes ORDER BY nome";
$clientes = mysqli_query($conexao, $sql);

$sqlProdutos = "SELECT id, nome, quantidade FROM produtos WHERE quantidade > 0 ORDER BY nome";
$produtos = mysqli_query($conexao, $sqlProdutos);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar venda | Loja do Enzo</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container pagina-formulario">
        <header class="topo">
            <a href="index.php" class="marca">ENZO / STORE</a>
            <a href="index.php" class="voltar">← Voltar ao início</a>
        </header>

        <main>
            <div class="introducao">
                <span class="etiqueta">Vendas</span>
                <h1>Registrar venda.</h1>
                <p class="descricao">Selecione cliente, produto e quantidade para concluir a operação.</p>
            </div>

            <?php if (isset($_GET["sucesso"]) && $_GET["sucesso"] === "1") { ?>
                <p class="mensagem">Venda registrada e estoque atualizado com sucesso.</p>
            <?php } ?>

            <form action="venda02.php" method="POST" class="form-card">
                <div class="campo">
                    <label for="cliente_id">Cliente</label>
                    <select id="cliente_id" name="cliente_id" required>
                        <option value="">Selecione um cliente</option>
                        <?php while ($cliente = mysqli_fetch_assoc($clientes)) { ?>
                            <option value="<?php echo (int) $cliente["id"]; ?>">
                                <?php echo htmlspecialchars($cliente["nome"], ENT_QUOTES, "UTF-8"); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="campo">
                    <label for="produto_id">Produto</label>
                    <select id="produto_id" name="produto_id" required>
                        <option value="">Selecione um produto</option>
                        <?php while ($produto = mysqli_fetch_assoc($produtos)) { ?>
                            <option value="<?php echo (int) $produto["id"]; ?>">
                                <?php
                                echo htmlspecialchars($produto["nome"], ENT_QUOTES, "UTF-8")
                                    . " — Estoque: " . (int) $produto["quantidade"];
                                ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="campo">
                    <label for="quantidade">Quantidade</label>
                    <input id="quantidade" type="number" name="quantidade" min="1" step="1" required>
                </div>

                <div class="form-acoes">
                    <button type="submit" class="botao">Registrar venda</button>
                    <a href="index.php" class="link-discreto">Cancelar</a>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
