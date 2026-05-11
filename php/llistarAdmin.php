<?php

//Sempre volem tenir una connexió a la base de dades, així que la creem al principi del fitxer
require_once 'connexio.php';
// Un cop inclòs el fitxer connexio.php, ja podeu utilitzar la variable $conn per a fer les consultes a la base de dades.

?>
<!DOCTYPE html>
<?php include_once "encabezado.php"; ?>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat</title>
</head>

<body>
    <h1>Panell administrador</h1>
    <h2>LLista d'incidencies</h2>
    <?php

    // Consulta SQL per obtenir totes les files de la taula 'cases'
    $sql = "SELECT i.idIncidencia, i.descripcio, i.fecha, a.nom, i.idTecnic FROM INCIDENCIA i, TECNIC a WHERE i.idTecnic = a.idTecnic";
    $result = $conn->query($sql);

    // Comprovar si hi ha resultats
    if ($result->num_rows > 0) {

        // Llistar els resultats. ATENCIÓ, heu de construir el codi HTML d'una llista correctament
        while ($row = $result->fetch_assoc()) {
    echo "<div class='card mt-3'>";
    echo "<div class='card-body d-flex align-items-center gap-3 flex-wrap'>";
    echo "<span class='fw-bold'>ID Incidencia: " . $row["idIncidencia"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Data Inici: " . $row["fecha"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>ID tecnic asignat: " . $row["nom"]. "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Descripcio: " . htmlspecialchars($row["descripcio"]) . "</span>";
    echo "<div class='ms-auto d-flex gap-2'>";
    echo "<a class='btn btn-danger btn-sm' href='esborrar.php?id=" . $row["idIncidencia"] . "'>Esborrar</a>";
    echo "<a class='btn btn-primary btn-sm' href='modificarIncidencia.php?id=" . $row["idIncidencia"] . "'>Modificar</a>";
    echo "<a class='btn btn-secondary btn-sm' href='estatTecnic.php?id=" . $row["idIncidencia"] . "'>Historial actuacions</a>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
            }

    } else {
         echo '<div class="alert alert-warning text-center mt-3">No hi ha dades a mostrar</div>';
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
    echo "<div class='card mt-3'>";
    echo "<div class='card-body d-flex align-items-center gap-3 flex-wrap'>";
    echo "<span class='fw-bold'>ID Incidencia: " . $row["idIncidencia"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Data Inici: " . $row["fecha"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Descripcio: " . htmlspecialchars($row["descripcio"]) . "</span>";
    echo "<div class='ms-auto d-flex gap-2'>";
    echo "<a class='btn btn-danger btn-sm' href='esborrar.php?id=" . $row["idIncidencia"] . "'>Esborrar</a>";
    echo "<a class='btn btn-primary btn-sm' href='modificarIncidencia.php?id=" . $row["idIncidencia"] . "'>Modificar</a>";
    echo "<a class='btn btn-secondary btn-sm' href='estatTecnic.php?id=" . $row["idIncidencia"] . "'>Historial actuacions</a>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
            }

    } else {
         echo '<div class="alert alert-warning text-center mt-3">No hi ha dades a mostrar</div>';
    }
    ?>




<p>---------------------------------------------------------------------------------------</p>
<h2>LLista d'incidencies obertes</h2>
    <?php

    // Consulta SQL per obtenir totes les files de la taula 'cases'
    $sql = "SELECT i.idIncidencia, i.descripcio, i.fecha, a.nom, i.idTecnic FROM INCIDENCIA i, TECNIC a WHERE i.idTecnic = a.idTecnic AND dataFinalitzacio IS NULL";
    $result = $conn->query($sql);

    // Comprovar si hi ha resultats
    if ($result->num_rows > 0) {

        // Llistar els resultats. ATENCIÓ, heu de construir el codi HTML d'una llista correctament
        while ($row = $result->fetch_assoc()) {
    echo "<div class='card mt-3'>";
    echo "<div class='card-body d-flex align-items-center gap-3 flex-wrap'>";
    echo "<span class='fw-bold'>ID Incidencia: " . $row["idIncidencia"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Data Inici: " . $row["fecha"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>ID tecnic asignat: " . $row["nom"]. "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Descripcio: " . htmlspecialchars($row["descripcio"]) . "</span>";
    echo "<div class='ms-auto d-flex gap-2'>";
    echo "<a class='btn btn-danger btn-sm' href='esborrar.php?id=" . $row["idIncidencia"] . "'>Esborrar</a>";
    echo "<a class='btn btn-primary btn-sm' href='modificarIncidencia.php?id=" . $row["idIncidencia"] . "'>Modificar</a>";
    echo "<a class='btn btn-secondary btn-sm' href='estatTecnic.php?id=" . $row["idIncidencia"] . "'>Historial actuacions</a>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
        }

    } else {
         echo '<div class="alert alert-warning text-center mt-3">No hi ha dades a mostrar</div>';
    }

    // Tancar la connexió
    $conn->close();
    ?>



    <div class="d-flex justify-content-center gap-3 mt-3">
        <a href="index.php" class="btn btn-primary">Tornar a inici</a>
    </div>

</body>

</html>