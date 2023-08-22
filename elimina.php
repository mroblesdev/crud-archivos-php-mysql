<?php

/**
 * Script para eliminar un registro y sus archivos asociados
 *
 * Este script elimina un registro de la base de datos y, si existe,
 * la carpeta de archivos asociados a ese registro.
 *
 * @author MRoblesDev
 * @version 1.0
 * https://github.com/mroblesdev
 *
 */

require 'conexion.php';

$id = $conn->real_escape_string($_GET['id']);

$sql = "DELETE FROM personas WHERE id = $id";
$resultado = $conn->query($sql);

$carpeta = 'files/' . $id;

if (is_dir($carpeta)) {
	$archivos = glob($carpeta . '/*'); // Obtener lista de archivos
	foreach ($archivos as $archivo) {
		unlink($archivo); // Eliminar cada archivo
	}
	rmdir($carpeta);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CRUD con archivos en PHP y MySQL</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
	<main class="container">
		<?php if ($resultado) { ?>
			<h3 class="text-center">REGISTRO ELIMINADO</h3>
		<?php } else { ?>
			<h3 class="text-center">ERROR AL ELIMINAR</h3>
		<?php } ?>

		<div class="col-12 text-center">
			<a href="index.php" class="btn btn-primary">Regresar</a>
		</div>
	</main>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>