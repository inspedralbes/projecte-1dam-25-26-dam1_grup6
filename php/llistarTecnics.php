<?php

//Sempre volem tenir una connexió a la base de dades, així que la creem al principi del fitxer
require_once 'connexio.php';
// Un cop inclòs el fitxer connexio.php, ja podeu utilitzar la variable $conn per a fer les consultes a la base de dades.


$result = null; 



$sort = $_GET['sort'] ?? 'fecha';
$order = $_GET['order'] ?? 'ASC';

$sortPermesos = ['fecha', 'prioritat'];
$orderPermesos = ['asc', 'desc'];

if (!in_array($sort, $sortPermesos)) $sort = 'fecha';
if (!in_array(strtolower($order), $orderPermesos)) $order = 'ASC';




if (isset($_POST["tecnic"]) || isset($_GET["tecnic"])) {
    $tecnic = $_POST["tecnic"] ?? $_GET["tecnic"];

$sql = "SELECT i.idIncidencia, i.descripcio, i.fecha, i.prioritat, i.idDepartament, i.idTipologia, d.nom, t.nomTipologia 
FROM INCIDENCIA i, DEPARTAMENT d, TIPOLOGIA t 
WHERE i.idTecnic = ? AND i.idDepartament = d.idDepartament AND i.idTipologia = t.idTipologia AND i.dataFinalitzacio 
IS NULL ORDER BY $sort $order";    
$sentencia = $conn->prepare($sql);
    $sentencia->bind_param("i", $tecnic);
    $sentencia->execute();

    $result = $sentencia->get_result();


}

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


<div class="text-center mt-3">
    <h2 class="mt-3">Llistat d'incidencies</h2>
</div>


<?php
$sql2 = "SELECT idTecnic, nom FROM TECNIC";
$sentencia2 = $conn->query($sql2);

echo '<form method="POST" action="llistarTecnics.php">';
echo '<div class="mb-3">';
    echo '<select name="tecnic" class="form-select" required';
    echo '<option value="" selected>-- Selecciona tecnic --</option>';

    while($fila = $sentencia2->fetch_assoc()) {
        echo '<option value="' . $fila["idTecnic"] . '">' . $fila["nom"] . '</option>';
    }
    
    echo '</select>'; 
    echo '</div>';


echo '<div class="d-flex justify-content-center gap-3 mt-3">';
echo '<button type="submit" class="btn btn-primary">Seleccionar</button>';
echo '</div>';

?>


    <?php
    // Comprovar si hi ha resultats
    if ($result !== null && $result->num_rows > 0) {

echo "<a href='?sort=fecha&order=asc&tecnic=" . $tecnic . "' class='btn btn-sm btn-outline-secondary'>Data ↑</a>";
echo "<a href='?sort=fecha&order=desc&tecnic=" . $tecnic . "' class='btn btn-sm btn-outline-secondary'>Data ↓</a>";
echo "<a href='?sort=prioritat&order=asc&tecnic=" . $tecnic . "' class='btn btn-sm btn-outline-secondary'>Prioritat ↑</a>";
echo "<a href='?sort=prioritat&order=desc&tecnic=" . $tecnic . "' class='btn btn-sm btn-outline-secondary'>Prioritat ↓</a>";

while ($row = $result->fetch_assoc()) {
    if ($row['prioritat'] == 'alta') $color = 'bg-danger bg-opacity-25';
    elseif ($row['prioritat'] == 'media') $color = 'bg-warning bg-opacity-25';
    elseif ($row['prioritat'] == 'baja') $color = 'bg-success bg-opacity-25';
    else $color = '';



    echo "<div class='card mt-3 $color'>";
    echo "<div class='card-body d-flex align-items-center gap-3 flex-wrap'>";
    echo "<span class='fw-bold'>ID Incidencia: " . $row["idIncidencia"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Data Inici: " . $row["fecha"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Prioridad: " . $row["prioritat"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Departament: " . $row["nom"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Tipologia: " . $row["nomTipologia"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Descripcio: " . htmlspecialchars($row["descripcio"]) . "</span>";
    echo "<div class='ms-auto d-flex gap-2'>";
    echo "<a class='btn btn-primary btn-sm' href='registrarAct.php?id=" . $row["idIncidencia"] . "'>Registrar actuacio</a>";
    echo "<a class='btn btn-secondary btn-sm' href='estatTecnic.php?id=" . $row["idIncidencia"] . "'>Historial actuacions</a>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

    } elseif ($result !== null) {
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