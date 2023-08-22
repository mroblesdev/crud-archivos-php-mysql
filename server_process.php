<?php

/**
 * Script para cargar datos del lado del servidor en DataTables
 *
 * Este script recibe solicitudes AJAX de DataTables para cargar y procesar
 * datos del lado del servidor en la tabla. Realiza la consulta a la base de datos,
 * aplica paginación, ordenamiento y búsqueda, y devuelve los resultados
 * en formato JSON para DataTables.
 *
 * @author MRoblesDev
 * @version 1.0
 * https://github.com/mroblesdev
 *
 */

require 'conexion.php';

$sTabla = "personas";
$aColumnas = ['id', 'nombre', 'correo', 'telefono'];
$sIndexColumn = "id";

$sLimit = '';
if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
    $sLimit = "LIMIT {$_GET['iDisplayStart']}, {$_GET['iDisplayLength']}";
}

$sOrder = '';
if (isset($_GET['iSortCol_0'])) {
    $sOrder = 'ORDER BY ';
    for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
        $colIndex = intval($_GET["iSortCol_$i"]);
        if ($_GET["bSortable_$colIndex"] == "true") {
            $sOrder .= "{$aColumnas[$colIndex]} {$_GET["sSortDir_$i"]}, ";
        }
    }
    $sOrder = rtrim($sOrder, ', ');
}

$searchConditions = [];
$searchValue = $_GET['sSearch'];
if ($searchValue != "") {
    foreach ($aColumnas as $column) {
        $searchConditions[] = "$column LIKE '%$searchValue%'";
    }
}

$individualSearchConditions = [];
for ($i = 0; $i < count($aColumnas); $i++) {
    $searchKey = "sSearch_$i";
    if ($_GET["bSearchable_$i"] == "true" && $_GET[$searchKey] != '') {
        $individualSearchConditions[] = "{$aColumnas[$i]} LIKE '%{$_GET[$searchKey]}%'";
    }
}

$whereConditions = [];
if (!empty($searchConditions) || !empty($individualSearchConditions)) {
    $whereConditions[] = implode(' OR ', array_merge($searchConditions, $individualSearchConditions));
}

$sWhere = '';
if (!empty($whereConditions)) {
    $sWhere = "WHERE " . implode(' AND ', $whereConditions);
}

$sQuery = "
    SELECT SQL_CALC_FOUND_ROWS " . implode(', ', $aColumnas) . "
    FROM $sTabla
    $sWhere
    $sOrder
    $sLimit
";
$rResult = $conn->query($sQuery);

$rResultFilterTotal = $conn->query("SELECT FOUND_ROWS()");
$iFilteredTotal = $rResultFilterTotal->fetch_array()[0];

$rResultTotal = $conn->query("SELECT COUNT($sIndexColumn) FROM $sTabla");
$iTotal = $rResultTotal->fetch_array()[0];

$output = [
    "sEcho" => intval($_GET['sEcho']),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData" => []
];

while ($aRow = $rResult->fetch_array()) {
    $row = [];
    foreach ($aColumnas as $column) {
        if ($column == "version") {
            $row[] = ($aRow[$column] == "0") ? '-' : $aRow[$column];
        } elseif ($column != ' ') {
            $row[] = $aRow[$column];
        }
    }

    $row[] = "<td><a class='btn btn-warning btn-sm' href='modifica.php?id={$aRow['id']}'><i class='fa-solid fa-pen-to-square'></i></a></td>";
    $row[] = "<td><a class='btn btn-danger btn-sm' href='#' data-bs-href='elimina.php?id={$aRow['id']}' data-bs-toggle='modal' data-bs-target='#eliminaModal'><i class='fa-solid fa-trash'></i></a></td>";

    $output['aaData'][] = $row;
}

echo json_encode($output);
