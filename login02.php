<?php
session_start();

require_once "conexao.php";
require_once "cryp2graph2.php";

$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";

$erro = "";

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $senha == "") {
    $erro = "Preencha um e-mail válido e a senha.";
} else {
    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, "s", $email);
    mysqli_stmt_execute($comando);

    $resultado = mysqli_stmt_get_result($comando);
    $usuario = mysqli_fetch_assoc($resultado);

    if ($usuario && ChecaSenha($senha, $usuario["senha"])) {
        session_regenerate_id(true);
        $_SESSION["usuario_id"] = $usuario["id"];
        $_SESSION["usuario_nome"] = $usuario["nome"];

        header("Location: index.php");
        exit;
    }

    $erro = "E-mail ou senha incorretos.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Não foi possível entrar | Loja do Enzo</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="login-shell">
        <main class="login-card">
            <a href="login01.php" class="marca">ENZO / STORE</a>
            <div class="introducao">
                <span class="etiqueta">Acesso</span>
                <h1>Tente novamente.</h1>
            </div>
            <p class="mensagem mensagem-erro"><?php echo htmlspecialchars($erro, ENT_QUOTES, "UTF-8"); ?></p>
            <a href="login01.php" class="botao">Voltar ao login</a>
        </main>
    </div>
</body>
</html>
