<?php
require_once 'connexio.php';
?>
<!DOCTYPE html>
<?php include_once "encabezado.php"; ?>
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
        <form method="POST" action="actualizar.php">
            <input type="hidden" name="id" value="<?php echo $_GET["id"] ?>">
            <fieldset>
                <legend>Modifica incidencia</legend>
                <br><br>
                <select name="tipus" id="tipus" required>
                    <option value="" selected> -- Assignar tipus --</option>
                    <option value="1">Xarxes</option>
                    <option value="2">Software</option>
                    <option value="3">Hardware</option>
                </select>
                <br><br>
                <select name="tecnic" id="tecnic" required>
                    <option value="" selected>-- Asignar tecnic --</option>";
                    <option value="1">Juan</option>
                    <option value="2">Alex</option>
                    <option value="3">Luis</option>
                </select>
                <br><br>
                <select name="prioritat" id="prioritat" required>
                    <option value="" selected>-- Asignar prioritat --</option>
                    <option value="alta">Alta</option>
                    <option value="media">Media</option>
                    <option value="baja">Baja</option>
                </select>
                <br><br>
                <input type="submit" value="Registrar">
            </fieldset>
        </form>    
        
        <?php
    }
    ?>