<?php
function iniciaSessao($sessao,$id,$db) {
    $sql = "UPDATE usuarios SET sessao = ? WHERE id = ?";
    $db->query($sql,[$sessao,$id]);
}
function terminaSessao() {
    require_once "../database/conn.php";
    session_start();
    $id = $_SESSION["id"] ?? null;
    $db = conn();
    $sql = "UPDATE usuarios SET sessao = NULL WHERE id = ?";
    $db->query($sql,[$id]);
}
function validaSessao() {
    require_once "../database/conn.php";
    session_start();
    $sessao = $_SESSION["session"] ?? null;
    $id = $_SESSION["id"] ?? null;
    $db = conn();
    $sql = "SELECT COUNT(*) as existe FROM usuarios WHERE sessao = ? AND id = ?";
    return $db->query($sql,[$sessao, $id])->fetchArray()["existe"] == 1;
}