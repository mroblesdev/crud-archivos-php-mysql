<?php

/**
 * Página principal que muestra la tabla de registros
 *
 * Esta página muestra una tabla que contiene los registros almacenados en la base de datos.
 * Permite visualizar, editar y eliminar registros.
 *
 * @author MRoblesDev
 * @version 1.0
 * https://github.com/mroblesdev
 *
 */

require 'conexion.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CRUD con archivos en PHP y MySQL</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/all.min.css" rel="stylesheet">
	<link href="assets/css/datatables.min.css" rel="stylesheet">
</head>

<body>

	<main class="container">
		<h3 class="text-center pt-3">CRUD con archivos en PHP y MySQL</h3>

		<a href="nuevo.php" class="btn btn-primary my-4">Nuevo Registro</a>

		<div class="table-responsive-sm">
			<table class="display table table-bordered" id="mitabla">
				<thead>
					<tr>
						<th>ID</th>
						<th>Nombre</th>
						<th>Email</th>
						<th>Teléfono</th>
						<th width="5%"></th>
						<th width="5%"></th>
					</tr>
				</thead>

				<tbody>

				</tbody>
			</table>
		</div>
	</main>

	<!-- Modal elimina registro -->
	<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Eliminar Registro</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					¿Desea eliminar el registro?
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<a class="btn btn-danger btn-ok">Eliminar</a>
				</div>

			</div>
		</div>
	</div>

	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/datatables.min.js"></script>

	<script>
		$(document).ready(function() {
			$('#mitabla').DataTable({
				"order": [
					[0, "asc"]
				],
				"language": {
					"lengthMenu": "Mostrar _MENU_ registros por pagina",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtrada de _MAX_ registros)",
					"loadingRecords": "Cargando...",
					"processing": "Procesando...",
					"search": "Buscar:",
					"zeroRecords": "No se encontraron registros coincidentes",
					"paginate": {
						"next": "Siguiente",
						"previous": "Anterior"
					},
				},
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": "server_process.php"
			});
		});

		let eliminaModal = document.getElementById('eliminaModal')
		eliminaModal.addEventListener('shown.bs.modal', event => {
			let button = event.relatedTarget
			let url = button.getAttribute('data-bs-href')
			eliminaModal.querySelector('.modal-footer .btn-ok').href = url
		})
	</script>

</body>

</html>