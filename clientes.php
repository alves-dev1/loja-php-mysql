<?php
require_once "ses_start.php";
require_once "conexao.php";

$busca = trim($_GET["busca"] ?? "");
$termo = "%" . $busca . "%";

$sql = "SELECT * FROM clientes WHERE nome LIKE ? ORDER BY nome";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "s", $termo);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes | Loja do Enzo</title>
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
                <span class="etiqueta">Cadastros</span>
                <h1>Clientes.</h1>
                <p class="descricao">
                    Encontre um cliente e atualize seus dados.
                </p>
            </div>

            <div class="acoes-estoque">

                <form action="clientes.php" method="GET" class="busca">
                    <label for="busca">Buscar pelo nome</label>

                    <input
                        type="text"
                        id="busca"
                        name="busca"
                        placeholder="Digite o nome do cliente"
                        value="<?php echo htmlspecialchars($busca, ENT_QUOTES, 'UTF-8'); ?>"
                    >

                    <button type="submit" class="botao">Buscar</button>

                    <a href="clientes.php" class="link-discreto">
                        Limpar busca
                    </a>
                </form>

                <a href="cadCliente01.php" class="botao">
                    + Novo cliente
                </a>

            </div>

            <?php if (mysqli_num_rows($resultado) == 0) { ?>

                <p class="vazio">Nenhum cliente encontrado.</p>

            <?php } else { ?>

                <div class="tabela-container">
                    <table class="tabela tabela-clientes">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($cliente = mysqli_fetch_assoc($resultado)) { ?>

                                <tr>
                                    <td>
                                        <?php
                                        echo htmlspecialchars(
                                            $cliente["nome"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        );
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        echo htmlspecialchars(
                                            $cliente["email"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        );
                                        ?>
                                    </td>

                                    <td>
                                        <a
                                            href="editarCliente01.php?id=<?php echo (int) $cliente["id"]; ?>"
                                            class="editar"
                                        >
                                            Editar
                                        </a>
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