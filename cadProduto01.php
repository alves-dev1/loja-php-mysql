<?php
require_once "ses_start.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo produto | Loja do Enzo</title>
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
                <h1>Novo produto.</h1>
                <p class="descricao">Adicione um item ao catálogo e defina o estoque inicial.</p>
            </div>

            <form action="cadProduto02.php" method="POST" class="form-card">
                <div class="campo">
                    <label for="nome">Nome</label>
                    <input id="nome" type="text" name="nome" maxlength="100" required>
                </div>

                <div class="campo">
                    <label for="preco">Preço</label>
                    <input id="preco" type="number" name="preco" min="0" step="0.01" required>
                </div>

                <div class="campo">
                    <label for="quantidade">Quantidade</label>
                    <input id="quantidade" type="number" name="quantidade" min="0" step="1" required>
                </div>

                <div class="form-acoes">
                    <button type="submit" class="botao">Cadastrar produto</button>
                    <a href="estoque.php" class="link-discreto">Cancelar</a>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
