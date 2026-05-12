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
    <a href="estadisticaTecnic.php">Estadistiques de Tecnics</a>
    <br>
    <a href="consumDepartament.php">Consum per departament</a>
    <br>
    <a href="log.php">Estadistiques d'acces</a>
    <?php

$sort = $_GET['sort'] ?? 'fecha';
$order = $_GET['order'] ?? 'ASC';

$sortPermesos = ['fecha', 'prioritat'];
$orderPermesos = ['asc', 'desc'];

if (!in_array($sort, $sortPermesos)) $sort = 'fecha';
if (!in_array(strtolower($order), $orderPermesos)) $order = 'ASC';



    $filtre = $_GET['filtre'] ?? '';


if ($filtre == 'sense_tecnic') {
    $sql = "SELECT i.*, t.nomTipologia, d.nom AS nomDepartament 
    FROM INCIDENCIA i
    LEFT JOIN TIPOLOGIA t ON i.idTipologia = t.idTipologia
    LEFT JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
    WHERE i.idTecnic IS NULL
    ORDER BY $sort $order";

} else if ($filtre == 'obertes') {
    $sql = "SELECT i.*, t.nomTipologia, d.nom AS nomDepartament, c.nom AS nomTecnic 
    FROM INCIDENCIA i
    LEFT JOIN TIPOLOGIA t ON i.idTipologia = t.idTipologia
    LEFT JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
    LEFT JOIN TECNIC c ON i.idTecnic = c.idTecnic
    WHERE i.dataFinalitzacio IS NULL
    ORDER BY $sort $order";

} else if ($filtre == 'tancades') {
    $sql = "SELECT i.*, t.nomTipologia, d.nom AS nomDepartament, c.nom AS nomTecnic 
    FROM INCIDENCIA i
    LEFT JOIN TIPOLOGIA t ON i.idTipologia = t.idTipologia
    LEFT JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
    LEFT JOIN TECNIC c ON i.idTecnic = c.idTecnic
    WHERE i.dataFinalitzacio IS NOT NULL
    ORDER BY $sort $order";

} else {
    $sql = "SELECT i.*, t.nomTipologia, d.nom AS nomDepartament, c.nom AS nomTecnic 
    FROM INCIDENCIA i
    LEFT JOIN TIPOLOGIA t ON i.idTipologia = t.idTipologia
    LEFT JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
    LEFT JOIN TECNIC c ON i.idTecnic = c.idTecnic
    ORDER BY $sort $order";
}
    $result = $conn->query($sql);

    // Comprovar si hi ha resultats
        if ($result->num_rows > 0) {


echo "<a href='?sort=fecha&order=asc&filtre=" . $filtre . "' class='btn btn-sm btn-outline-secondary'>Data ↑</a>";
echo "<a href='?sort=fecha&order=desc&filtre=" . $filtre . "' class='btn btn-sm btn-outline-secondary'>Data ↓</a>";
echo "<a href='?sort=prioritat&order=asc&filtre=" . $filtre . "' class='btn btn-sm btn-outline-secondary'>Prioritat ↑</a>";
echo "<a href='?sort=prioritat&order=desc&filtre=" . $filtre . "' class='btn btn-sm btn-outline-secondary'>Prioritat ↓</a>";

        while ($row = $result->fetch_assoc()) {
    echo "<div class='card mt-3'>";
    echo "<div class='card-body d-flex align-items-center gap-3 flex-wrap'>";
    echo "<span class='fw-bold'>ID Incidencia: " . $row["idIncidencia"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span class='fw-bold'>Data inici: " . $row["fecha"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span class='fw-bold'>Prioritat: " . $row["prioritat"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span class='fw-bold'>Departament: " . $row["nomDepartament"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span class='fw-bold'>Tipologia: " . $row["nomTipologia"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span class='fw-bold'>Nom tecnic: " . ($row["nomTecnic"] ?? "Sense assignar") . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span class='fw-bold'>Descripcio: " . $row["descripcio"] . "</span>";
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