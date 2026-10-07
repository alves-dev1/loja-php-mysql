<?php
require_once "ses_start.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if ($id === false || $id === null || $id <= 0) {
    exit("Produto inválido.");
}

require_once "conexao.php";

$sql = "SELECT * FROM produtos WHERE id = ?";
$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($comando, "i", $id);
mysqli_stmt_execute($comando);

$resultado = mysqli_stmt_get_result($comando);
$produto = mysqli_fetch_assoc($resultado);

if (!$produto) {
    exit("Produto não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar produto | Loja do Enzo</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container pagina-formulario">
        <header class="topo">
            <a href="index.php" class="marca">ENZO / STORE</a>
            <a href="estoque.php" class="voltar">← Voltar ao estoque</a>
        </header>

        <main>
            <div class="introducao">
                <span class="etiqueta">Produtos</span>
                <h1>Editar produto.</h1>
                <p class="descricao">Atualize nome, preço ou quantidade disponível.</p>
            </div>

            <form action="editarProduto02.php" method="POST" class="form-card">
                <input type="hidden" name="id" value="<?php echo (int) $produto['id']; ?>">

                <div class="campo">
                    <label for="nome">Nome</label>
                    <input id="nome" type="text" name="nome" maxlength="100" required
                        value="<?php echo htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="campo">
                    <label for="preco">Preço</label>
                    <input id="preco" type="number" name="preco" min="0" step="0.01" required
                        value="<?php echo htmlspecialchars($produto['preco'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="campo">
                    <label for="quantidade">Quantidade</label>
                    <input id="quantidade" type="number" name="quantidade" min="0" step="1" required
                        value="<?php echo (int) $produto['quantidade']; ?>">
                </div>

                <div class="form-acoes">
                    <button type="submit" class="botao">Salvar alterações</button>
                    <a href="estoque.php" class="link-discreto">Cancelar</a>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
