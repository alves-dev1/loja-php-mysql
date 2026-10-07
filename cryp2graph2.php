<?php
function FazSenha($username, $password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function ChecaSenha($password, $dbpassword) {
    return password_verify($password, $dbpassword);
}
?>