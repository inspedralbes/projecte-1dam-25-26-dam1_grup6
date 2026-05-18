<?php include_once "encabezado.php"; ?>
<?php
require_once 'connexio.php';
include_once 'mongo.php';

if (!isset($_GET["id"])) {
    exit("No hi ha id");
}

$id = $_GET['id'];

$sql = $conn->prepare(" SELECT idActuacion, descripcio, fecha, temps, visible FROM ACTUACIO WHERE idIncidencia = ?");

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
         echo '<div class="alert alert-warning text-center mt-3">No hi ha dades a mostrar</div>';
}
?>