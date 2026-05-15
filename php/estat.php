<?php include_once "encabezado.php"; ?>
<?php
require_once 'connexio.php';
include_once 'mongo.php';

if (!isset($_GET["id"])) {
    exit("No hi ha id");
}

$id = $_GET['id'];

$sql = $conn->prepare(" SELECT idActuacion, descripcio, fecha, temps, idIncidencia, visible FROM ACTUACIO WHERE idIncidencia = ? AND visible = 1");

$sql->bind_param('i', $id);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
    echo "<div class='card mt-3'>";
    echo "<div class='card-body d-flex align-items-center gap-3 flex-wrap'>";
    echo "<span class='fw-bold'>ID actuació: " . htmlspecialchars($row["idActuacion"]) . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Data: " . htmlspecialchars($row["fecha"]) . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Temps: " . htmlspecialchars($row["temps"]) . "</span>";
    echo "<span class='text-muted'>|</span>";
    echo "<span>Descripcio: " . htmlspecialchars($row["descripcio"]) . "</span>";
    echo "</div>";
    echo "</div>";
    }

} else {
      echo '<div class="alert alert-warning text-center mt-3">No hi ha dades per mostrar</div>';
}




$sql2 = $conn->prepare(" SELECT idIncidencia, descripcio, dataFinalitzacio FROM INCIDENCIA WHERE idIncidencia = ? AND dataFinalitzacio IS NOT NULL");

$sql2->bind_param('i', $id);
$sql2->execute();
$result = $sql2->get_result();

if ($result->num_rows > 0) {
      echo '<div class="alert alert-success text-center mt-3">Incidencia resolta</div>';

} else {
     echo '<div class="alert alert-warning text-center mt-3">Incidencia pendent de resoldre</div>';
}
?>

    <div class="d-flex justify-content-center gap-3 mt-3">
        <a href="llistarProfessors.php" class="btn btn-primary">Tornar</a>
        <a href="index.php" class="btn btn-primary">Tornar a inici</a>
    </div>
