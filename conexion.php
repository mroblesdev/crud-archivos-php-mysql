<?php

/**
 * Script para conectarse a la base de datos
 *
 * Este script crea una conexión a la base de datos MySQL utilizando la extensión mysqli.
 * Si la conexión falla, muestra un mensaje de error.
 *
 * @author MRoblesDev
 * @version 1.0
 * https://github.com/mroblesdev
 *
 */

// Parámetros de conexión a la base de datos
$hostname = "127.0.0.1";
$username = "root";
$password = "";
$database = "personal";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
	die("Error de conexión" . $conn->connect_error);
}
