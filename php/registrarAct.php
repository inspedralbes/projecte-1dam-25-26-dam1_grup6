<?php

//Sempre volem tenir una connexió a la base de dades, així que la creem al principi del fitxer
require_once 'connexio.php';
// Un cop inclòs el fitxer connexio.php, ja podeu utilitzar la variable $conn per a fer les consultes a la base de dades.

function registrar_act($conn) {
    $descripcio = $_POST["descripcio"];
    $visible = $_POST["visible"];
    $temps = $_POST["temps"];

    $sentenciaAct = $conn->prepare("INSERT INTO ACTUACIO 
    (descripcio, visible, temps)
    VALUES
    (?, ?, ?)");

    $sentenciaAct->bind_param("sii", $descripcio, $visible, $temps);
    $sentenciaAct->execute();
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
                <br><br>
                <label>Descripció:</label>
                <input type="text" id="descripcio" name="descripcio" required>
                <br><br>
                <label>Visible:</label>
                <input type="number" name="visible" id="visible" required>
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