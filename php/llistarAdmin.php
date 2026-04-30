<?php

//Sempre volem tenir una connexió a la base de dades, així que la creem al principi del fitxer
require_once 'connexio.php';
// Un cop inclòs el fitxer connexio.php, ja podeu utilitzar la variable $conn per a fer les consultes a la base de dades.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["tecnic"], $_POST["id"])){

    // Obtenir el nom de la casa del formulari
$tecnic = $_POST["tecnic"];
$idIncidencia = $_POST["id"];
    // Comprovar si el nom no està buit
    // Si l'html està ben escrit això no podria passar en els usuaris normals
    // Igualment SEMPRE s'ha de comprovar tot al backend ja que no tots els usuaris
    // són "bones persones" i des de les web tools es pot canviar tot el front per exemple.

    // Preparar la consulta SQL per inserir una nova casa


    $sentencia2= $conn->prepare("UPDATE INCIDENCIA SET idTecnic = ? WHERE idIncidencia = ?");

    $sentencia2->bind_param("ii", $tecnic, $idIncidencia);
    $sentencia2->execute();
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
    <?php

    // Consulta SQL per obtenir totes les files de la taula 'cases'
    $sql = "SELECT idIncidencia, descripcio, fecha, idTecnic FROM INCIDENCIA";
    $result = $conn->query($sql);

    // Comprovar si hi ha resultats
    if ($result->num_rows > 0) {

        // Llistar els resultats. ATENCIÓ, heu de construir el codi HTML d'una llista correctament
        while ($row = $result->fetch_assoc()) {
            echo "<p>ID incidencia: " . $row["idIncidencia"] . "   --- Descripcio: " . htmlspecialchars($row["descripcio"]) . "";
            echo "   --- ID tecnic asignat: " . $row["idTecnic"]. "";
            echo " <a href='esborrar.php?id=" . $row["idIncidencia"] . "'>Esborrar</a>";
            echo "<form method='POST' action='llistarAdmin.php'>";
            echo "<select name='tecnic' id='tecnic' required>";
            echo "<option value='' selected>-- Asignar tecnic--</option>";
            echo "<option value='1'>Juan</option>";
            echo "<option value='2'>Alex</option>";
            echo "<option value='3'>Luis</option>";
            echo "</select>";     
            echo "<input type='hidden' name='id' value='" . $row["idIncidencia"] . "'>";
            echo "<input type='submit' value='Asignar'>";
            echo "</form>";
            echo "</p>";
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