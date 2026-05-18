<?php
require_once 'connexio.php';
include_once 'mongo.php';
include_once "encabezado.php";
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar</title>
</head>

<body>

<?php
$sql1 = "SELECT idTipologia, nomTipologia FROM TIPOLOGIA";
$sentencia1 = $conn->query($sql1);

$sql2 = "SELECT idTecnic, nom AS nomTecnic FROM TECNIC";
$sentencia2 = $conn->query($sql2);



    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        modificar_incidencia($conn);
    } else {
echo '<div class="container mt-5">';
echo '<div class="row justify-content-center">';
echo '<div class="col-md-6">';
echo '<div class="card-body">';
echo '<h2 class="card-title text-center mb-4">Modificar Incidencia</h2>';
echo '<form method="POST" action="actualizar.php">';

echo '<input type="hidden" name="id" value="' . $_GET["id"] . '">';

echo '<div class="mb-3">';
echo '<label class="form-label fw-bold">Tipologia:</label>';
echo '<select name="tipus" id="tipus" class="form-select" required>';
echo '<option value="" selected>-- Selecciona tipologia --</option>';
while($fila1 = $sentencia1->fetch_assoc()) {
    echo '<option value="' . $fila1["idTipologia"] . '">' . $fila1["nomTipologia"] . '</option>';
}
echo '</select>';
echo '</div>';



echo '<div class="mb-3">';
echo '<label class="form-label fw-bold">Tecnic:</label>';
echo '<select name="tecnic" id="tecnic" class="form-select" required>';
echo '<option value="" selected>-- Selecciona tecnic --</option>';
while($fila2 = $sentencia2->fetch_assoc()) {
    echo '<option value="' . $fila2["idTecnic"] . '">' . $fila2["nomTecnic"] . '</option>';
}
echo '</select>';
echo '</div>';



echo '<div class="mb-3">';
echo '<label class="form-label fw-bold">Prioritat:</label>';
echo '<select name="prioritat" id="prioritat" class="form-select" required>';
echo '<option value="" selected>-- Asignar prioritat --</option>';
echo '<option value="alta">Alta</option>';
echo '<option value="media">Media</option>';
echo '<option value="baja">Baja</option>';
echo '</select>';
echo '</div>';


echo '<div class="d-grid">';
echo '<button type="submit" class="btn btn-primary">Modificar</button>';
echo '</div>';

echo '</form>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
   }
?>