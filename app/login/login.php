<?php

if ($_POST) {

    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $error = "";

    $senha = md5(sha1($senha));


    require_once "../database/conn.php";
    $db = conn();
    $sql = "SELECT id FROM usuarios WHERE email = ? AND senha = ?";
    $result = $db->query($sql,[
        $email,
        $senha
    ]);

    if ($result->numRows()) {
        session_start();
        $id = $result->fetchArray()["id"];
        $session = sha1(rand(1,999)) . $id;
        $_SESSION["session"] = $session;
        $_SESSION["id"] = $id;
        require_once "../lib/session.php";
        iniciaSessao($session,$id,$db);
        header("Location: ../locations/index.php?error=$error");
        exit;
    } else {
        $error = "Email ou senha incorretos!";
        header("Location: ../login/index.php?error=$error");
        exit;
    }
}
$error = "Envio inválido";
Header("Location: index.php?error=$error");
