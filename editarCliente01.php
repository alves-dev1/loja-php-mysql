<?php
require_once "ses_start.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if ($id === false || $id === null || $id <= 0) {
    exit("Cliente inválido.");
}

require_once "conexao.php";

$sql = "SELECT * FROM clientes WHERE id = ?";
$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($comando, "i", $id);
mysqli_stmt_execute($comando);

$resultado = mysqli_stmt_get_result($comando);
$cliente = mysqli_fetch_assoc($resultado);

if (!$cliente) {
    exit("Cliente não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar cliente | Loja do Enzo</title>
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
                <h1>Editar cliente.</h1>
                <p class="descricao">Atualize as informações do cadastro selecionado.</p>
            </div>

            <form action="editarCliente02.php" method="POST" class="form-card">
                <input type="hidden" name="id" value="<?php echo (int) $cliente['id']; ?>">

                <div class="campo">
                    <label for="nome">Nome</label>
                    <input id="nome" type="text" name="nome" maxlength="100" required
                        value="<?php echo htmlspecialchars($cliente['nome'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="campo">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" name="email" maxlength="100" required
                        value="<?php echo htmlspecialchars($cliente['email'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="form-acoes">
                    <button type="submit" class="botao">Salvar alterações</button>
                    <a href="clientes.php" class="link-discreto">Cancelar</a>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
