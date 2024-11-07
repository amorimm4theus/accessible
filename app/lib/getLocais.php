<?php
require_once "../database/conn.php";
$db = conn();

if ($_POST) {

    $cidade = $_POST["cidade"];
    $search = $_POST["search"] ?? null;
    $param = [];
    $filter = "";
    if (is_string($search) && trim($search)) {
        $filter = "AND nome LIKE ?";
        $param[] = $search."%";
    }

    $sql = "SELECT
                id,nome,endereco
            FROM
                locais
            WHERE
            1
                $filter
            AND
                cidade_id = ?
            ORDER BY nome
    ";
    $param[] = $cidade;
    $response = $db->query($sql,$param)->fetchAll();
    foreach ($response as &$locais) {
        $locais["nome"] = iconv("ISO-8859-1","UTF-8",$locais["nome"]);
        $locais["endereco"] = iconv("ISO-8859-1","UTF-8",$locais["endereco"]);
        $locais["acessibilidades"] = getAcessibilidadePorLocal($locais["id"],$db);
    }
    echo json_encode($response);
}
function getAcessibilidadePorLocal($id,$db) {
    $sql = "SELECT
                a.acessibilidade
            FROM
                acessibilidades_locais al
            INNER JOIN
                acessibilidades a
            ON
                al.acessibilidade_id = a.id
            WHERE
                al.local_id = ? ";
    $response = $db->query($sql,[$id])->fetchAll();
    foreach ($response as &$acessibilidade) {
        $acessibilidade["acessibilidade"] = iconv("ISO-8859-1","UTF-8",$acessibilidade["acessibilidade"]);
    }
    return $response;
}