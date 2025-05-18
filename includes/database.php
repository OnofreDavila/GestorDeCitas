<?php

$db = mysqli_connect('mysql-peluqueriacanina.alwaysdata.net', '413715', 'bianca14*', 'peluqueriacanina_mvc');
//$db = mysqli_connect('localhost', 'root', '', 'peluqueriacanina_mvc');

$db->set_charset("utf8");

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "error de depuración: " . mysqli_connect_error();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
