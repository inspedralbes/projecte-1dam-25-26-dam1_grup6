<?php
require_once "connexio.php";

if (!isset($_GET["id"])) {
    exit("No hay id");
}

$id = $_GET['id'];

$sql = $conn->prepare("SELECT * FROM ACTUACIO WHERE idIncidencia = ?");
$sql->bind_param('i', $id);
$sql->execute();

$result = $sql->get_result();
$row = $result->fetch_assoc();

if ($row) {

    echo "<p>
    ID actuació: " . htmlspecialchars($row["idActuacion"]) . " - 
    Descripció: " . htmlspecialchars($row["descripcio"]) . " - 
    Data: " . htmlspecialchars($row["data"]) . " - 
    Temps: " . htmlspecialchars($row["temps"]) . " - 
    ID incidència: " . htmlspecialchars($row["idIncidencia"]) . "
    </p>";

} else {
    echo "<p>No hi ha dades a mostrar.</p>";
}
?>