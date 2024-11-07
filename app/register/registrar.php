<?php

if ($_POST) {
    $nome = $_POST["nome"];
    $sobrenome = $_POST["sobrenome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $senha2 = $_POST["senha2"];
    $cidade_id = $_POST["cidade"];
    $error = "";
    require_once "../database/conn.php";
    $db = conn();

    if ($senha != $senha2) {
        $error = "As senhas devem ser iguais";
    }
    $senha = md5(sha1($senha));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email inválido.";
    } else {
        require_once "../lib/verificaEmail.php";
        $error = verificaJaExisteEmail($email,$db);
    }

    if ($error) {
        header("Location: index.php?error=$error");
        exit;   
    }
    
    $sql = "INSERT INTO `usuarios`
            (`id`, `nome`, `sobrenome`, `email`, `cidade_id`, `senha`) 
            VALUES 
                (0,?,?,?,?,?)";
    $db->query($sql,[
        $nome,
        $sobrenome,
        $email,
        $cidade_id,
        $senha
    ]);
    if ($db->Error_db()) {
        $error = "Ocorreu um erro ao cadastrar, tente novamente";
        header("Location: index.php?error=$error");
        exit;
    } else {
        $error = "Cadastro realizado com sucesso!";
        header("Location: ../login/index.php?error=$error");
        exit;
    }
}
$error = "Envio inválido";
Header("Location: index.php?error=$error");