<?php
define('RAIZ_SISTEMA',dirname(__DIR__,1));
define('FILE_EXTENSIONS','csv');
date_default_timezone_set("America/Sao_Paulo");
define('LOGS_SISTEMA',dirname(__DIR__,1).'\logs');
define('DOCS_SISTEMA',dirname(__DIR__,1).'\docs');
$usuario ="root";
$senha = "admin123";
$charset = 'utf8mb4';
$db_url = 'mysql:host=127.0.0.1;port=3306;dbname=corredores;'.$charset;
$date = new DateTime();
?>