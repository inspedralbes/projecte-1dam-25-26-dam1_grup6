<?php

//Sempre volem tenir una connexió a la base de dades, així que la creem al principi del fitxer
require_once 'connexio.php';
// Un cop inclòs el fitxer connexio.php, ja podeu utilitzar la variable $conn per a fer les consultes a la base de dades.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["tecnic"])){
    $tecnic = $_POST["tecnic"];
    $sql = "SELECT idIncidencia, descripcio, fecha FROM INCIDENCIA WHERE idTecnic = ?";
    $sentencia = $conn->prepare($sql);
    $sentencia->bind_param("i", $tecnic);
    $sentencia->execute();

    $result = $sentencia->get_result();

}
}

?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat</title>
</head>

<body>
    <h1>Llistat de cases</h1>



    <form method="POST" action="llistarTecnics.php">
<select name="tecnic" id="tecnic" required>
            <option value="" selected>-- Escull tecnic--</option>
            <option value="1">Juan</option>
            <option value="2">Alex</option>
            <option value="3">Luis</option>
    </select>
            <input type="submit" value="Filtrar">
</form>


    <?php
    // Comprovar si hi ha resultats
    if ($result->num_rows > 0) {

        // Llistar els resultats. ATENCIÓ, heu de construir el codi HTML d'una llista correctament
        while ($row = $result->fetch_assoc()) {
            echo "<p>ID: " . $row["idIncidencia"] . " - Nom: " . htmlspecialchars($row["descripcio"]) . "";
            echo " <a href='esborrar.php?id=" . $row["idIncidencia"] . "'>Esborrar</a>";
            echo " <a href='registrarAct.php?id=" . $row["idIncidencia"] . "'>Editar</a></p>";
        }

    } else {
        echo "<p>No hi ha dades a mostrar.</p>";
    }

    // Tancar la connexió
    $conn->close();
    ?>

    <div id="menu">
        <hr>
        <p><a href="index.php">Portada</a> </p>
        <p><a href="llistar.php">Llistar</a></p>
        <p><a href="crear.php">Crear</a></p>
    </div>

</body>

</html>