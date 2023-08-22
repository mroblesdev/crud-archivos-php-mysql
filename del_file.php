<?php

/**
 * Script para eliminar un archivo
 *
 * Este script recibe el nombre de un archivo a través de una petición POST,
 * verifica si el archivo existe, cambia los permisos para poder eliminarlo
 * y luego elimina el archivo.
 *
 * @author MRoblesDev
 * @version 1.0
 * https://github.com/mroblesdev
 *
 */

if (isset($_POST['file'])) {
	$file = $_POST['file'];

	if (is_file($file)) {
		chmod($file, 0777);
		if (unlink($file)) {
			echo true;
		}
	}
}
