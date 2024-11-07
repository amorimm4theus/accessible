<?php

if ($_POST) {
    $nome = $_POST["nome"];
    $cep = $_POST["cep"];
    $endereco = $_POST["endereco"];
    $cidade_id = $_POST["cidade"];
    $acessibilidades = json_decode($_POST["input-custom-dropdown"],true);
    $error = "";
    require_once "../database/conn.php";
    $db = conn();

    session_start();
    $id_usuario = $_SESSION["id"] ?? null;
    if (!$id_usuario) {
        header("Location: ../login/index.php?error=$error");
    }
    $sql = "INSERT INTO `locais`
            (`id`, `nome`, `cep`, `endereco`, `cidade_id`,id_usuario_cadastrou,data_cadastro) 
            VALUES 
                (0,?,?,?,?,?,NOW())";
    $result = $db->query($sql,[
        iconv("UTF-8","ISO-8859-1",$nome),
        $cep,
        iconv("UTF-8","ISO-8859-1",$endereco),
        $cidade_id,
        $id_usuario
    ]);
    if ($db->Error_db()) {
        $error = "Ocorreu um erro ao cadastrar, tente novamente";
        echo json_encode(["erro" => true]);
        exit;
    } else {
        $id = $result->lastInsertID();
        foreach($acessibilidades as $acessibilidade) {
            $sql = "INSERT INTO acessibilidades_locais VALUES(0,?,?)";
            $db->query($sql,[$acessibilidade["code"],$id]);
        }
        $error = "Local cadastrado com sucesso!";
        echo json_encode(["erro" => false]);
        exit;
    }
}
$error = "Envio inválido";
Header("Location: index.php?error=$error");