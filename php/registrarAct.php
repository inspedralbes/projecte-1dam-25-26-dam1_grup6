<?php

//Sempre volem tenir una connexió a la base de dades, així que la creem al principi del fitxer
require_once 'connexio.php';
include_once 'mongo.php';
// Un cop inclòs el fitxer connexio.php, ja podeu utilitzar la variable $conn per a fer les consultes a la base de dades.

function registrar_act($conn) {
    $descripcio = $_POST["descripcio"];
    $visible = (int) $_POST["visible"];
    $temps = $_POST["temps"];
    $fecha = $_POST["fecha"];
    $idIncidencia = $_POST["idIncidencia"];

    $sentenciaAct = $conn->prepare("INSERT INTO ACTUACIO 
    (descripcio, visible, temps, fecha, idIncidencia)
    VALUES
    (?, ?, ?, ?, ?)");

    $sentenciaAct->bind_param("siisi", $descripcio, $visible, $temps, $fecha, $idIncidencia);
   

    if ($sentenciaAct->execute()) {
        echo"<p>Actuacio registrada</p>";
        echo"<a href='llistarTecnics.php'>Back</a>";
    } else {
        echo"<p>Actuacio no registrada<z/p>";
    }
}

?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RegistrarAct</title>
</head>

<body>
    <h1>Registra una actuacció</h1>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        registrar_act($conn);
    } else {
        ?>
        <form method="POST" action="registrarAct.php">
            <fieldset>
                <legend>Registrar actuacion</legend>
                <input type="hidden" name="idIncidencia" value="<?php echo $_GET["id"] ?>">
                <br><br>
                <label>Descripció:</label>
                <input type="text" id="descripcio" name="descripcio" required>
                <br><br>
                <label>Visiblidad para professores:</label>
                <select name="visible" id="visible" required>
                    <option value="" selected> -- Visible? --</option>
                    <option value="0">No visible</option>
                    <option value="1">Visible</option>
                </select>
                <br><br>
                <label>Data actuacio:</label>
                <input type="datetime-local" name="fecha">
                <br><br>
                <label>Temps:</label>
                <input type="number" name="temps" id="temps" required>
                <br><br>
                <input type="submit" value="Registrar">
            </fieldset>
        </form>


        <?php
    }
    ?>