<?php
require_once "ses_start.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo cliente | Loja do Enzo</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container pagina-formulario">
        <header class="topo">
            <a href="index.php" class="marca">ENZO / STORE</a>
            <a href="clientes.php" class="voltar">← Voltar aos clientes</a>
        </header>

        <main>
            <div class="introducao">
                <span class="etiqueta">Clientes</span>
                <h1>Novo cliente.</h1>
                <p class="descricao">Cadastre os dados básicos para utilizar o cliente nas vendas.</p>
            </div>

            <form action="cadCliente02.php" method="POST" class="form-card">
                <div class="campo">
                    <label for="nome">Nome</label>
                    <input id="nome" type="text" name="nome" maxlength="100" required>
                </div>

                <div class="campo">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" name="email" maxlength="100" required>
                </div>

                <div class="form-acoes">
                    <button type="submit" class="botao">Cadastrar cliente</button>
                    <a href="clientes.php" class="link-discreto">Cancelar</a>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
