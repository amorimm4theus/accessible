<?php
function conn() {
	include("db.php");
	$webLogin = Array(
		'user' => "root",
		'pass' => "",
		'host' => "localhost",
		'port' => '3306',
	); 
	return new db($webLogin['host'], $webLogin['user'], $webLogin['pass'], "accessible");
}
?>