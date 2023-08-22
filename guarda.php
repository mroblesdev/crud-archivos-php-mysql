<?php

/**
 * Script para insertar nuevos datos de registro
 *
 * Este script recibe los nuevos datos del registro a través del método POST
 * y realiza la inserción en la base de datos. También permite la carga de archivos adjuntos.
 *
 * @author MRoblesDev
 * @version 1.0
 * https://github.com/mroblesdev
 *
 */

require 'conexion.php';

$nombre = $conn->real_escape_string($_POST['nombre']);
$email = $conn->real_escape_string($_POST['email']);
$telefono = $conn->real_escape_string($_POST['telefono']);
$estado_civil = $conn->real_escape_string($_POST['estado_civil']);
$hijos = isset($_POST['hijo']) ? $_POST['hijos'] : 0;
$intereses = isset($_POST['intereses']) ? $_POST['intereses'] : '';

if (is_array($intereses)) {
	$intereses = implode(' ', $intereses);
}

$sql = "INSERT INTO personas (nombre, correo, telefono, estado_civil, hijos, intereses) VALUES ('$nombre', '$email', '$telefono', '$estado_civil', '$hijos', '$intereses')";
$resultado = $conn->query($sql);
$id_insert = $conn->insert_id;

if ($_FILES["archivo"]["error"] === 0) {

	$permitidos = array("image/png", "image/jpg", "image/jpeg", "application/pdf");
	$limite_kb = 1024; //1 MB

	if (in_array($_FILES["archivo"]["type"], $permitidos) && $_FILES["archivo"]["size"] <= $limite_kb * 1024) {

		$ruta = 'files/' . $id_insert . '/';
		$archivoNombre = $_FILES["archivo"]["name"];
		$extension = pathinfo($archivoNombre, PATHINFO_EXTENSION);
		$archivo = $ruta . uniqid() . '.' . $extension;

		if (!file_exists($ruta)) {
			mkdir($ruta, 0777, true);
		}

		if (!file_exists($archivo)) {

			$resultado = move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo);

			if ($resultado) {
				echo "Archivo Guardado";
			} else {
				echo "Error al guardar archivo";
			}
		} else {
			echo "Archivo ya existe";
		}
	} else {
		echo "Archivo no permitido o excede el tamaño";
	}
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
			<h3 class="text-center">REGISTRO GUARDADO</h3>
		<?php } else { ?>
			<h3 class="text-center">ERROR AL GUARDAR</h3>
		<?php } ?>


		<div class="col-12 text-center">
			<a href="index.php" class="btn btn-primary">Regresar</a>
		</div>
	</main>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>