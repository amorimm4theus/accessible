<?php
require_once "../database/conn.php";
$db = conn();

$sql = "SELECT
            id,nome,uf
        FROM
            estado
        WHERE
            1
        ORDER BY nome
";
$response = $db->query($sql)->fetchAll();
foreach ($response as &$cidade) {
    $cidade["nome"] = iconv("ISO-8859-1","UTF-8",$cidade["nome"]);
}
echo json_encode($response);