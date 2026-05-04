<?php

require_once 'connexio.php';

function modificar_incidencia($conn) {
    $incidencia = $_POST["incidencia"];
    $prioritat = $_POST["prioritat"];
    $tecnic = $_POST["tecnic"];
    $tipus = $_POST["tipus"];

$sentenciaMod = $conn->prepare("UPDATE INCIDENCIA SET prioritat = ?, idTecnic = ?, idTipologia = ? WHERE idIncidencia = ?");

$sentenciaMod->bind_param("sii", $prioritat, $tecnic, $tipus);
$sentenciaMod->execute();
}

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
        ?>
        <form method="POST" action="modificarIncidencia.php">
            <fieldset>
                <legend>Modifica incidencia</legend>
                <br><br>
                <label>Incidencia</label>
                <input type="integer" id="incidencia" name="incidencia">
                <br><br>
                <label>Prioritat</label>
                <input type="text" id="prioritat" name="prioritat" required>
                <br><br>
                <label>Tecnic</label>
                <input type="text" id="tecnic" name="tecnic" required>
                <br><br>
                <label>Tipus</label>
                <input type="text" id="tipus" name="tipus" required>
                <br><br>
                <input type="submit" value="Registrar">
            </fieldset>
        </form>    
        
        <?php
    }
    ?>