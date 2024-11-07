<?php

function verificaJaExisteEmail($email,$db) {
    $sql = "SELECT COUNT(*) as existe FROM usuarios WHERE email = ?";
    return !!$db->query($sql, [$email])->fetchArray()["existe"] ? "Email já cadastrado!" : "";
}