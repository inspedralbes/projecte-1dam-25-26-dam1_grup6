<?php include_once "encabezado.php"; ?>
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


    if ($sentencia->execute()) {
    echo "<div class='card mt-3 bg-success bg-opacity-25'>";
    echo "<div class='card-body d-flex justify-content-center align-items-center gap-3 flex-wrap'>";
    echo "<p>Modificacio registrada</p>";
    echo "</div>";
    echo "</div>";
    
    echo "<div class='d-flex justify-content-center gap-3 mt-3'>";
    echo "<a href='index.php' class='btn btn-primary'>Tornar</a>";
    echo "</div>";
    } else {
    echo "<div class='card mt-3 bg-danger bg-opacity-25'>";
    echo "<div class='card-body d-flex align-items-center gap-3 flex-wrap'>";
    echo "<p>Modificacio no registrada</p>";
    echo "</div>";
    echo "</div>";

    echo "<div class='d-flex justify-content-center gap-3 mt-3'>";
    echo "<a href='index.php' class='btn btn-primary'>Tornar</a>";
    echo "</div>";
    }
?>