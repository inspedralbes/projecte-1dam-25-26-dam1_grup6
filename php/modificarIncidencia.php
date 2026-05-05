<?php

require_once 'connexio.php';

?>
<!DOCTYPE html>
<html lang="ca">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Modificar</title>
</head>

<body>
   <h1>Modificar Incidencia</h1>
   <?php


   if ($_SERVER["REQUEST_METHOD"] == "POST") {
       modificar_incidencia($conn);
   } else {
$sql1 = "SELECT idTipologia, nomTipologia FROM TIPOLOGIA";
$sentencia1 = $conn->query($sql1);


$sql2 = "SELECT idTecnic, nom FROM TECNIC";
$sentencia2 = $conn->query($sql2);


echo '<form method="POST" action="actualizar.php">';


echo '<input type="hidden" name="id" value="' . $_GET["id"] . '">';


echo '<fieldset>';
echo '<legend>Modificar Incidencia</legend>';


echo '<br><br>';


//TIPUS
echo '<select name="tipus" id="tipus" required>';
echo '<option value="" selected>-- Assignar tipus --</option>';


while ($fila = $sentencia1->fetch_assoc()) {
   echo '<option value="' . $fila["idTipologia"] . '">' . $fila["nomTipologia"] . '</option>';
}
echo '</select>';


echo '<br><br>';


//TÈCNIC
echo '<select name="tecnic" id="tecnic" required>';
echo '<option value="" selected>-- Assignar tècnic --</option>';


while ($fila = $sentencia2->fetch_assoc()) {
   echo '<option value="' . $fila["idTecnic"] . '">' . $fila["nom"] . '</option>';
}
echo '</select>';


echo '<br><br>';


//PRIORITAT
echo '<select name="prioritat" id="prioritat" required>';
echo '<option value="" selected>-- Assignar prioritat --</option>';
echo '<option value="alta">Alta</option>';
echo '<option value="media">Media</option>';
echo '<option value="baja">Baja</option>';
echo '</select>';


echo '<br><br>';


echo '<input type="submit" value="Modificar">';


echo '</fieldset>';
echo '</form>';
   }
?>
