<?php

/**
 * Formulario para agregar un nuevo registro
 *
 * Este formulario permite agregar un nuevo registro a la base de datos.
 *
 * @author MRoblesDev
 * @version 1.0
 * https://github.com/mroblesdev
 *
 */

$listaIntereses = ["Libros", "Música", "Deportes", "Otros"];

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
		<h3 class="text-center pt-3">Nuevo registro</h3>

		<form class="row g-3" method="POST" action="guarda.php" enctype="multipart/form-data" autocomplete="off">

			<div class="col-md-6">
				<label for="nombre" class="form-label">Nombre</label>
				<input type="text" class="form-control" id="nombre" name="nombre" required autofocus>
			</div>

			<div class="col-md-6">
				<label for="email" class="form-label">Correo electrónico</label>
				<input type="email" class="form-control" id="email" name="email" required>
			</div>

			<div class="col-md-6">
				<label for="telefono" class="form-label">Teléfono</label>
				<input type="text" class="form-control" id="telefono" name="telefono">
			</div>

			<div class="col-md-6">
				<label for="estado_civil" class="form-label">Estado Civil</label>
				<select class="form-select" id="estado_civil" name="estado_civil">
					<option value="SOLTERO">SOLTERO</option>
					<option value="CASADO">CASADO</option>
					<option value="OTRO">OTRO</option>
				</select>
			</div>

			<div class="col-md-6">
				<label for="nombre" class="form-label">Intereses</label>

				<?php foreach ($listaIntereses as $interes) { ?>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="<?php echo $interes; ?>" id="<?php echo $interes; ?>" name="intereses[]">
						<label class="form-check-label" for="<?php echo $interes; ?>">
							<?php echo $interes; ?>
						</label>
					</div>
				<?php } ?>
			</div>

			<div class="col-md-6">
				<label for="hijos" class="form-label">¿Tiene Hijos?</label>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="hijos" id="hijos_si" value="1" checked>
					<label class="form-check-label" for="hijos_si">
						Si
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="hijos" id="hijos_no" value="0">
					<label class="form-check-label" for="hijos_no">
						No
					</label>
				</div>
			</div>

			<div class="col-md-6">
				<label for="archivo" class="form-label">Seleccionar archivo</label>
				<input type="file" class="form-control" id="archivo" name="archivo">
			</div>

			<div class="col-12">
				<a href="index.php" class="btn btn-secondary">Regresar</a>
				<button type="submit" class="btn btn-success">Guardar</button>
			</div>

		</form>
	</main>

	<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>