<?php 
$usuario ="matheus";
$senha = "123";
$charset = 'utf8mb4';
$db_url = 'mysql:host=127.0.0.1;port=3306;dbname=corredores;'.$charset;
$pdo = new PDO($db_url,$usuario,$senha);

define('RAIZ_SISTEMA',dirname(__DIR__,1));
?>