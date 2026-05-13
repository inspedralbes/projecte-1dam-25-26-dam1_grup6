    <?php

    //Sempre volem tenir una connexió a la base de dades, així que la creem al principi del fitxer
    require_once 'connexio.php';
    // Un cop inclòs el fitxer connexio.php, ja podeu utilitzar la variable $conn per a fer les consultes a la base de dades.


    $result = null; 

    $sort = 'fecha';
    $order = $_GET['order'] ?? 'ASC';
    if (!in_array(strtolower($order), ['asc', 'desc'])) $order = 'ASC';


    $tecnic = $_POST["tecnic"] ?? $_GET["tecnic"] ?? null;

if (!empty($_POST["idInci"])) {

    $idInci = $_POST["idInci"];

$sql = "SELECT i.idIncidencia, i.descripcio, i.fecha, i.idDepartament, d.nom 
        FROM INCIDENCIA i, DEPARTAMENT d 
        WHERE i.idIncidencia = ? AND i.idDepartament = d.idDepartament ORDER BY $sort $order"; 

$sentencia = $conn->prepare($sql);
    $sentencia->bind_param("i", $idInci);
    $sentencia->execute();
        $result = $sentencia->get_result();
}

else{
            $sql = "SELECT i.idIncidencia, i.descripcio, i.fecha, i.idDepartament, d.nom 
            FROM INCIDENCIA i, DEPARTAMENT d 
            WHERE i.idDepartament = d.idDepartament ORDER BY $sort $order"; 

        $result = $conn->query($sql);
}
        ?>




<!DOCTYPE html>
<?php include_once "encabezado.php"; ?>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GI3P Gestor Incidencias DAM</title>
</head>

<body>

<div class="text-center mt-3">
    <div class="col-md-12">
        <h1 class="mb-3">Panell professorat</h1>
        <div class="d-flex justify-content-end">
            <p class="mb-1">Buscador incidencia per codi</p>
        </div>
        <div class="d-flex align-items-center">
            <div class="col-md-4"></div>
            <div class="col-md-4 d-flex justify-content-center">
                <a href="crear.php" class="btn btn-primary">Crear incidencia</a>
            </div>
            <div class="col-md-4 d-flex justify-content-end gap-2">
                <form method="POST" action="llistarProfessors.php" class="d-flex gap-2">
                    <input type="number" id="idInci" name="idInci" class="form-control" style="width: 150px;">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
        </div>
    </div>
</div>





        <h2 class="mb-3 mt-5 text-center">Llistat d'incidencies</h2>
    <?php


    // Consulta SQL per obtenir totes les files de la taula 'cases
    // Comprovar si hi ha resultats
    if ($result->num_rows > 0) {

echo "<a href='?sort=fecha&order=asc&tecnic=" . $tecnic . "' class='btn btn-sm btn-outline-secondary'>Data ↑</a>";
echo "<a href='?sort=fecha&order=desc&tecnic=" . $tecnic . "' class='btn btn-sm btn-outline-secondary'>Data ↓</a>";

        // Llistar els resultats. ATENCIÓ, heu de construir el codi HTML d'una llista correctament
    while ($row = $result->fetch_assoc()) {
    echo "<div class='card mt-3'>";
    echo "<div class='card-body d-flex align-items-center gap-3 flex-wrap'>";
    echo "<span class='fw-bold'>ID Incidencia: " . $row["idIncidencia"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Data Inici: " . $row["fecha"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Departament: " . $row["nom"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Descripcio: " . htmlspecialchars($row["descripcio"]) . "</span>";
    echo "<a class='btn btn-primary btn-sm ms-auto' href='estat.php?id=" . $row["idIncidencia"] . "'>Estat</a>";
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