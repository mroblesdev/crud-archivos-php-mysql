<?php

/**
 * Formulario para editar un registro existente
 *
 * Este formulario permite editar los datos de un registro existente en la base de datos.
 *
 * @author MRoblesDev
 * @version 1.0
 * https://github.com/mroblesdev
 *
 */

require 'conexion.php';

// Obtener el ID del registro a editar desde la URL
$id = $conn->real_escape_string($_GET['id']);

$sql = "SELECT * FROM personas WHERE id = '$id'";
$resultado = $conn->query($sql);
$row = $resultado->fetch_assoc();

$interesesArray = explode(' ', $row['intereses']);
$listaIntereses = ["Libros", "Música", "Deportes", "Otros"];

function esImagen($ruta)
{
	$extensionesImagen = ["jpg", "jpeg", "png", "gif"];
	$extension = strtolower(pathinfo($ruta, PATHINFO_EXTENSION));
	return in_array($extension, $extensionesImagen);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CRUD con archivos en PHP y MySQL</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/all.min.css" rel="stylesheet">

</head>

<body>
	<main class="container">
		<h3 class="text-center pt-3">Modificar registro</h3>

		<form class="row g-3" method="POST" action="actualiza.php" enctype="multipart/form-data" autocomplete="off">

			<input type="hidden" id="id" name="id" value="<?php echo $row['id']; ?>" />

			<div class="col-md-6">
				<label for="nombre" class="form-label">Nombre</label>
				<input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" required autofocus>
			</div>

			<div class="col-md-6">
				<label for="email" class="form-label">Correo electrónico</label>
				<input type="email" class="form-control" id="email" name="email" value="<?php echo $row['correo']; ?>" required>
			</div>

			<div class="col-md-6">
				<label for="telefono" class="form-label">Teléfono</label>
				<input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $row['telefono']; ?>">
			</div>

			<div class="col-md-6">
				<label for="estado_civil" class="form-label">Estado Civil</label>
				<select class="form-select" id="estado_civil" name="estado_civil">
					<option value="SOLTERO" <?php if ($row['estado_civil'] == 'SOLTERO') echo 'selected'; ?>>SOLTERO</option>
					<option value="CASADO" <?php if ($row['estado_civil'] == 'CASADO') echo 'selected'; ?>>CASADO</option>
					<option value="OTRO" <?php if ($row['estado_civil'] == 'OTRO') echo 'selected'; ?>>OTRO</option>
				</select>
			</div>

			<div class="col-md-6">
				<label for="nombre" class="form-label">Intereses</label>

				<?php
				foreach ($listaIntereses as $interes) {
					$checked = in_array($interes, $interesesArray) ? 'checked' : '';
				?>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="<?php echo $interes; ?>" id="<?php echo $interes; ?>" name="intereses[]" <?php echo $checked; ?>>
						<label class="form-check-label" for="<?php echo $interes; ?>">
							<?php echo $interes; ?>
						</label>
					</div>

				<?php } ?>

			</div>

			<div class="col-md-6">
				<label for="hijos" class="form-label">¿Tiene Hijos?</label>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="hijos" id="hijos_si" value="1" <?php if ($row['hijos'] == '1') echo 'checked'; ?>>
					<label class="form-check-label" for="hijos_si">
						Si
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="hijos" id="hijos_no" value="0" <?php if ($row['hijos'] == '0') echo 'checked'; ?>>
					<label class="form-check-label" for="hijos_no">
						No
					</label>
				</div>
			</div>

			<div class="col-md-6">
				<label for="archivo" class="form-label">Seleccionar archivo</label>
				<input type="file" class="form-control" id="archivo" name="archivo">
			</div>

			<div class="row mt-4">
				<?php
				$path = 'files/' . $id;
				if (file_exists($path)) {
					$directorio = opendir($path);
					while ($archivo = readdir($directorio)) {
						if (!is_dir($archivo)) {
							echo '<div class="col-md-3">';
							echo '<div>';

							$archivoPath = $path . "/" . $archivo;
							echo "<a href='$archivoPath' target='_blank' title='Ver Archivo'><i class='fa-solid fa-eye'></i> Ver Archivo </a>";
							echo "<a href='#' data='$archivoPath' class='delete ms-2' title='Elimiar Archivo'><i class='fa-solid fa-trash'></i> Eliminar Archivo</a>";

							if (esImagen($archivoPath)) {
								echo "<img src='$archivoPath' class='img-thumbnail'>";
							}

							echo '</div>';
							echo '</div>';
						}
					}
				}
				?>
			</div>

			<div class="col-12">
				<a href="index.php" class="btn btn-secondary">Regresar</a>
				<button type="submit" class="btn btn-success">Guardar</button>
			</div>
		</form>
	</main>

	<script src="assets/js/bootstrap.bundle.min.js"></script>

	<script type="text/javascript">
		let deleteButtons = document.querySelectorAll('.delete');

		for (let i = 0; i < deleteButtons.length; i++) {
			deleteButtons[i].addEventListener('click', function() {
				var file = this.getAttribute('data');
				var dataString = 'file=' + file;

				fetch('del_file.php', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						body: dataString
					})
					.then(function(response) {
						if (response.ok) {
							location.reload();
						}
					})
					.catch(function(error) {
						console.error('Error:', error);
					});
			});
		}
	</script>
</body>

</html>