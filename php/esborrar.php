<?php
require_once 'connexio.php';
include_once 'mongo.php';
if (!isset($_GET["id"])) {
    exit("No hay id");
}

$id = (int) $_GET['id'];
$sentencia = $conn->prepare("DELETE FROM INCIDENCIA WHERE idIncidencia = ?");
$sentencia->bind_param("i", $id);

if ($sentencia->execute()) {
    header("Location: llistarAdmin.php");
    exit();
} else {
    exit("Error al eliminar la incidencia.");
}