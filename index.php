<?php
require_once "ses_start.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja do Enzo</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

    <div class="container">

        <header class="topo">
            <a href="index.php" class="marca">ENZO / STORE</a>

            <span class="usuario">
                Olá, <?php
                echo htmlspecialchars(
                    $_SESSION["usuario_nome"],
                    ENT_QUOTES,
                    "UTF-8"
                );
                ?>
            </span>
        </header>

        <main>
            <div class="introducao">
                <span class="etiqueta">Painel da loja</span>
                <h1>Tudo sob controle.</h1>
                <p class="descricao">
                    Do estoque à venda, sua loja começa aqui.
                </p>
            </div>

            <nav class="menu" aria-label="Menu principal">

                <a href="venda01.php">
                    <div>
                        <strong>Registrar venda</strong>
                        <small>Selecione o cliente e o produto</small>
                    </div>
                    <span class="seta" aria-hidden="true">↗</span>
                </a>

                <a href="estoque.php">
                    <div>
                        <strong>Estoque</strong>
                        <small>Consulte produtos e quantidades</small>
                    </div>
                    <span class="seta" aria-hidden="true">↗</span>
                </a>

                <a href="clientes.php">
                    <div>
                        <strong>Clientes</strong>
                        <small>Busque e atualize os cadastros</small>
                    </div>
                    <span class="seta" aria-hidden="true">↗</span>
                </a>

                <a href="vendas.php">
                    <div>
                        <strong>Histórico de vendas</strong>
                        <small>Acompanhe as vendas e os totais</small>
                    </div>
                    <span class="seta" aria-hidden="true">↗</span>
                </a>

                <a href="cadProduto01.php">
                    <div>
                        <strong>Novo produto</strong>
                        <small>Adicione um produto ao estoque</small>
                    </div>
                    <span class="seta" aria-hidden="true">+</span>
                </a>

                <a href="cadCliente01.php">
                    <div>
                        <strong>Novo cliente</strong>
                        <small>Cadastre nome e e-mail</small>
                    </div>
                    <span class="seta" aria-hidden="true">+</span>
                </a>

            </nav>
        </main>

        <footer class="rodape">
            <span>ENZO / STORE</span>
            <a href="sair.php" class="sair">Sair da conta ↗</a>
        </footer>

    </div>

</body>
</html>