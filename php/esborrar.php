<?php
require_once "connexio.php";
if (!isset($_GET["id"])) {
    exit("No hay id");
}

$id = $_GET['id'];
$sentencia = $conn->prepare("DELETE FROM INCIDENCIA WHERE idIncidencia = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
header("Location: llistarProfessors.php");
