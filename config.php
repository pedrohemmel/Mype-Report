<!--ME CONECTANDO AO BANCO DE DADOS COM O MÉTODO PDO-->
<?php
$db_name = 'mype_report';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';

$pdo = new PDO('mysql:dbname='.$db_name.';host='.$db_host, $db_user, $db_pass);
?>