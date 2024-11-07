<?php
require_once "../database/conn.php";
$db = conn();


$sql = "SELECT
            id,acessibilidade
        FROM
            acessibilidades
        WHERE
            1
        ORDER BY acessibilidade
";
$response = $db->query($sql)->fetchAll();
$whitelist = [];
foreach ($response as &$acessibilidade) {
    $acessibilidade["acessibilidade"] = iconv("ISO-8859-1","UTF-8",$acessibilidade["acessibilidade"]);
    $whitelist[] = ["value"=>$acessibilidade["acessibilidade"],"code"=>$acessibilidade["id"]];
}
echo json_encode(["response"=>$response,"whitelist"=>$whitelist]);