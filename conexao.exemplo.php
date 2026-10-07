<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conexao = mysqli_connect("localhost", "root", "", "loja_demo");
    mysqli_set_charset($conexao, "utf8mb4");
} catch (mysqli_sql_exception $erro) {
    http_response_code(500);
    exit("Não foi possível conectar ao banco de dados.");
}
