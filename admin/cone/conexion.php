<?php

$servidor = "localhost";
$usuario = "pruebas";
$clave = "123456";
$db = "proyecto";

$mysqli = new mysqli($servidor, $usuario, $clave, $db);

/*
$query = $mysqli->query("SELECT * from blog");

$res= $query->fetch_object();

echo $res->img;
*/

?>