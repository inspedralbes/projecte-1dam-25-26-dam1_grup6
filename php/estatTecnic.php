<?php
require_once 'connexio.php';
include_once 'mongo.php';

if (!isset($_GET["id"])) {
    exit("No hi ha id");
}

$id = $_GET['id'];

$sql = $conn->prepare(" SELECT idActuacion, descripcio, fecha, temps, idIncidencia, visible FROM ACTUACIO WHERE idIncidencia = ?");

$sql->bind_param('i', $id);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        echo "<p>
        ID actuació: " . htmlspecialchars($row["idActuacion"]) . " - 
        Descripció: " . htmlspecialchars($row["descripcio"]) . " - 
        Data: " . htmlspecialchars($row["fecha"]) . " - 
        Temps: " . htmlspecialchars($row["temps"]) . " - 
        ID incidència: " . htmlspecialchars($row["idIncidencia"]) . "
        </p>";
    }

} else {
    echo "<p>No hi ha dades a mostrar.</p>";
}
?>