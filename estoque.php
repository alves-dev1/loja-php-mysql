<?php
require_once "ses_start.php";
require_once "conexao.php";

$busca = trim($_GET["busca"] ?? "");
$termo = "%" . $busca . "%";

$filtro = $_GET["estoque"] ?? "";

if (!in_array($filtro, ["", "baixo", "esgotado"], true)) {
    $filtro = "";
}

$sql = "SELECT * FROM produtos WHERE nome LIKE ?";

if ($filtro === "baixo") {
    $sql .= " AND quantidade BETWEEN 1 AND 5";
} elseif ($filtro === "esgotado") {
    $sql .= " AND quantidade = 0";
}

$sql .= " ORDER BY nome";

$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($comando, "s", $termo);
mysqli_stmt_execute($comando);

$resultado = mysqli_stmt_get_result($comando);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque | Loja do Enzo</title>
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
                <span class="etiqueta">Produtos</span>
                <h1>Estoque.</h1>
                <p class="descricao">
                    Consulte preços, confira quantidades e edite seus produtos.
                </p>
            </div>

            <div class="acoes-estoque">

                <form action="estoque.php" method="GET" class="busca">
                    <label for="busca">Buscar pelo nome</label>

                    <input
                        type="text"
                        id="busca"
                        name="busca"
                        placeholder="Ex.: Camiseta Denim"
                        value="<?php echo htmlspecialchars($busca, ENT_QUOTES, 'UTF-8'); ?>"
                    >

                    <label for="filtro-estoque">Filtrar estoque</label>

<select name="estoque" id="filtro-estoque">
    <option value="" <?php if ($filtro === "") echo "selected"; ?>>
        Todos
    </option>

    <option value="baixo" <?php if ($filtro === "baixo") echo "selected"; ?>>
        Estoque baixo — 1 a 5
    </option>

    <option value="esgotado" <?php if ($filtro === "esgotado") echo "selected"; ?>>
        Esgotados
    </option>
</select>

                    <button type="submit" class="botao">Buscar</button>

                    <a href="estoque.php" class="link-discreto">
                        Limpar busca
                    </a>
                </form>

                <a href="cadProduto01.php" class="botao">
                    + Novo produto
                </a>
            </div>

            <?php if (mysqli_num_rows($resultado) == 0) { ?>

                <p class="vazio">Nenhum produto encontrado.</p>

            <?php } else { ?>

                <div class="tabela-container">
                    <table class="tabela tabela-estoque">
                        <thead>
                            <tr>
                                <th scope="col">Produto</th>
                                <th scope="col" class="numero">Preço</th>
                                <th scope="col" class="numero">Quantidade</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($produto = mysqli_fetch_assoc($resultado)) { ?>

                                <tr>
                                    <td>
                                        <?php
                                        echo htmlspecialchars(
                                            $produto["nome"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        );
                                        ?>
                                    </td>

                                    <td class="numero">
                                        R$ <?php echo number_format($produto["preco"], 2, ",", "."); ?>
                                    </td>

                                    <td class="numero">
                                        <?php echo (int) $produto["quantidade"]; ?>
                                    </td>

                                    <td>
                                        <?php if ($produto["quantidade"] > 5) { ?>

                                            <span class="status disponivel">
                                                Em estoque
                                            </span>

                                        <?php } elseif ($produto["quantidade"] >= 1) { ?>

                                            <span class="status baixo">
                                                Pouco em estoque
                                            </span>

                                        <?php } else { ?>

                                            <span class="status esgotado">
                                                Esgotado
                                            </span>

                                        <?php } ?>
                                    </td>

                                    <td>
                                        <a
                                            href="editarProduto01.php?id=<?php echo (int) $produto["id"]; ?>"
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