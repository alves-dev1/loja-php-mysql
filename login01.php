<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar | Loja do Enzo</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="login-shell">
        <main class="login-card">
            <a href="login01.php" class="marca">ENZO / STORE</a>

            <div class="introducao">
                <span class="etiqueta">Acesso</span>
                <h1>Entrar.</h1>
                <p class="descricao">Use suas credenciais para acessar o painel da loja.</p>
            </div>

            <form action="login02.php" method="POST" class="form-card">
                <div class="campo">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" name="email" maxlength="100" autocomplete="email" required>
                </div>

                <div class="campo">
                    <label for="senha">Senha</label>
                    <input id="senha" type="password" name="senha" autocomplete="current-password" required>
                </div>

                <div class="form-acoes">
                    <button type="submit" class="botao">Entrar</button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
