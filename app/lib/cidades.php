<?php
require_once "../database/conn.php";
$db = conn();
$param = [];
$filter = "";
if (isset($_POST["uf"])) {
    $filter = "AND uf = ?";
    $param[] = $_POST["uf"];
} 

$sql = "SELECT
            id,nome
        FROM
            cidade
        WHERE
            1
        $filter
        ORDER BY nome
";
$response = $filter ? $db->query($sql,$param)->fetchAll() : $db->query($sql)->fetchAll();
foreach ($response as &$cidade) {
    $cidade["nome"] = iconv("ISO-8859-1","UTF-8",$cidade["nome"]);
}
echo json_encode($response);