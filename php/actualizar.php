<?php
include_once 'connexio.php';
include_once 'mongo.php';
$id = $_POST["id"];
$tipus = $_POST["tipus"];
$tecnic = $_POST["tecnic"];
$prioritat = $_POST["prioritat"];

$sentencia = $conn->prepare("UPDATE INCIDENCIA SET idTipologia = ?, idTecnic = ?, prioritat = ? WHERE idIncidencia = ?");

$sentencia->bind_param("iisi", $tipus,$tecnic ,$prioritat , $id);
$sentencia->execute();
header("Location: llistarAdmin.php");
?>