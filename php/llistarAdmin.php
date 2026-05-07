<?php

//Sempre volem tenir una connexió a la base de dades, així que la creem al principi del fitxer
require_once 'connexio.php';
// Un cop inclòs el fitxer connexio.php, ja podeu utilitzar la variable $conn per a fer les consultes a la base de dades.


?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat</title>
</head>

<body>
    <h1>Panell administrador</h1>
    <h2>LLista d'incidencies</h2>
    <a href="estadisticaTecnic.php">Estadisticas de Tecnicos</a>
    <?php

    // Consulta SQL per obtenir totes les files de la taula 'cases'
    $sql = "SELECT i.idIncidencia, i.descripcio, i.fecha, a.nom, i.idTecnic FROM INCIDENCIA i, TECNIC a WHERE i.idTecnic = a.idTecnic";
    $result = $conn->query($sql);

    // Comprovar si hi ha resultats
    if ($result->num_rows > 0) {

        // Llistar els resultats. ATENCIÓ, heu de construir el codi HTML d'una llista correctament
        while ($row = $result->fetch_assoc()) {
            echo "<p>ID incidencia: " . $row["idIncidencia"] . "   --- Descripcio: " . htmlspecialchars($row["descripcio"]) . "";
            echo "   --- ID tecnic asignat: " . $row["nom"]. "";
            echo "   --- Data Inici: " . $row["fecha"]. "";
            echo " <a href='esborrar.php?id=" . $row["idIncidencia"] . "'>Esborrar</a>";
            echo " <a href='modificarIncidencia.php?id=" . $row["idIncidencia"] . "'>Modificar</a>";
            echo "</p>";
            }

    } else {
        echo "<p>No hi ha dades a mostrar.</p>";
    }


    ?>

<p>---------------------------------------------------------------------------------------</p>
<h2>LLista d'incidencies sense tecnic asignat</h2>
    <?php

    // Consulta SQL per obtenir totes les files de la taula 'cases'
    $sql = "SELECT idIncidencia, descripcio, fecha, idTecnic FROM INCIDENCIA WHERE idTecnic IS NULL";
    $result = $conn->query($sql);

    // Comprovar si hi ha resultats
    if ($result->num_rows > 0) {

        // Llistar els resultats. ATENCIÓ, heu de construir el codi HTML d'una llista correctament
        while ($row = $result->fetch_assoc()) {
            echo "<p>ID incidencia: " . $row["idIncidencia"] . "   --- Descripcio: " . htmlspecialchars($row["descripcio"]) . "";
            echo "   --- ID tecnic asignat: " . $row["idTecnic"]. "";
            echo " <a href='esborrar.php?id=" . $row["idIncidencia"] . "'>Esborrar</a>";
            echo " <a href='modificarIncidencia.php?id=" . $row["idIncidencia"] . "'>Modificar</a>";
            echo "</p>";
            }

    } else {
        echo "<p>No hi ha dades a mostrar.</p>";
    }
    ?>




<p>---------------------------------------------------------------------------------------</p>
<h2>LLista d'incidencies obertes</h2>
    <?php

    // Consulta SQL per obtenir totes les files de la taula 'cases'
    $sql = "SELECT idIncidencia, descripcio, fecha, idTecnic FROM INCIDENCIA WHERE dataFinalitzacio IS NULL";
    $result = $conn->query($sql);

    // Comprovar si hi ha resultats
    if ($result->num_rows > 0) {

        // Llistar els resultats. ATENCIÓ, heu de construir el codi HTML d'una llista correctament
        while ($row = $result->fetch_assoc()) {
            echo "<p>ID: " . $row["idIncidencia"] . " - Nom: " . htmlspecialchars($row["descripcio"]) . "";
            echo " <a href='esborrar.php?id=" . $row["idIncidencia"] . "'>Esborrar</a>";
            echo " <a href='modificarIncidencia.php?id=" . $row["idIncidencia"] . "'>Modificar</a>";
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