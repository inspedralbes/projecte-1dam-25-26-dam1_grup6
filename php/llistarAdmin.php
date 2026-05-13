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



<div class="text-center mt-3">
    <div class="col-md-12">
<h1 class="mt-3">Panell administrador</h1>
    </div>
    <div class="d-flex flex-column align-items-end mb-3">
        <p class="mb-1 text-muted small">Buscador incidencia per codi</p>
        <form method="POST" action="llistarAdmin.php" class="d-flex gap-2">
            <input type="number" id="idInci" name="idInci" class="form-control" style="width: 150px;">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </div>
</div>


<div class="card pt-3 pb-3">
  <h4 class="text-center mb-3">Estadístiques i consums</h4>
  <div class="d-flex justify-content-center gap-2 flex-wrap">
    <a href="estadisticaTecnic.php" class="btn btn-primary">Estadístiques de Tècnics</a>
    <a href="consumDepartament.php" class="btn btn-primary">Consum per departament</a>
    <a href="log.php" class="btn btn-primary">Estadístiques d'accés</a>
  </div>
</div>


<h2 class="text-center mt-5  mb-3">Llistat d'incidencies</h2>

<form class="mb-3" method="GET">
    <select name="filtre" class="form-select">
        <option value="tots">Tots</option>
        <option value="sense_tecnic">Sense tècnic asignat</option>
        <option value="obertes">Obertes</option>
        <option value="tancades">Tancades</option>
    </select>

    <div class="d-flex justify-content-center gap-3 mt-3">
<button type="submit" class="btn btn-primary">Seleccionar</button>
</div>

</form>

    <?php

$sort = $_GET['sort'] ?? 'fecha';
$order = $_GET['order'] ?? 'ASC';

$sortPermesos = ['fecha', 'prioritat'];
$orderPermesos = ['asc', 'desc'];

if (!in_array($sort, $sortPermesos)) $sort = 'fecha';
if (!in_array(strtolower($order), $orderPermesos)) $order = 'ASC';

    $filtre = $_GET['filtre'] ?? '';


if (!empty($_POST["idInci"])) {

    $idInci = $_POST["idInci"];

$sql = "SELECT i.*, t.nomTipologia, d.nom AS nomDepartament, c.nom AS nomTecnic 
    FROM INCIDENCIA i
    LEFT JOIN TIPOLOGIA t ON i.idTipologia = t.idTipologia
    LEFT JOIN DEPARTAMENT d ON i.idDepartament = d.idDepartament
    LEFT JOIN TECNIC c ON i.idTecnic = c.idTecnic
    WHERE i.idIncidencia = ?";

$sentencia = $conn->prepare($sql);
    $sentencia->bind_param("i", $idInci);
    $sentencia->execute();
        $result = $sentencia->get_result();
}


else {
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

}

    // Comprovar si hi ha resultats
        if ($result->num_rows > 0) {


echo "<a href='?sort=fecha&order=asc&filtre=" . $filtre . "' class='btn btn-sm btn-outline-secondary'>Data ↑</a>";
echo "<a href='?sort=fecha&order=desc&filtre=" . $filtre . "' class='btn btn-sm btn-outline-secondary'>Data ↓</a>";
echo "<a href='?sort=prioritat&order=asc&filtre=" . $filtre . "' class='btn btn-sm btn-outline-secondary'>Prioritat ↑</a>";
echo "<a href='?sort=prioritat&order=desc&filtre=" . $filtre . "' class='btn btn-sm btn-outline-secondary'>Prioritat ↓</a>";

        while ($row = $result->fetch_assoc()) {
    if ($row['prioritat'] == 'alta') $color = 'bg-danger bg-opacity-25';
    elseif ($row['prioritat'] == 'media') $color = 'bg-warning bg-opacity-25';
    elseif ($row['prioritat'] == 'baja') $color = 'bg-success bg-opacity-25';
    else $color = '';
        
    echo "<div class='card mt-3 $color'>";
    echo "<div class='card-body d-flex align-items-center gap-3 flex-wrap'>";
    echo "<span class='fw-bold'>ID Incidencia: " . $row["idIncidencia"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Data inici: " . $row["fecha"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Prioritat: " . $row["prioritat"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Departament: " . $row["nomDepartament"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Tipologia: " . $row["nomTipologia"] . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Nom tecnic: " . ($row["nomTecnic"] ?? "Sense assignar") . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Descripcio: " . $row["descripcio"] . "</span>";
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
    <div class="d-flex justify-content-center gap-3 mt-3 mb-5">
        <a href="index.php" class="btn btn-primary">Tornar a inici</a>
    </div>

</body>

</html>