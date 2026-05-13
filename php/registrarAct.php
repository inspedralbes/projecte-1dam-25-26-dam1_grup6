<?php

//Sempre volem tenir una connexió a la base de dades, així que la creem al principi del fitxer
require_once 'connexio.php';
include_once 'mongo.php';
// Un cop inclòs el fitxer connexio.php, ja podeu utilitzar la variable $conn per a fer les consultes a la base de dades.

function registrar_act($conn) {
    $descripcio = $_POST["descripcio"];
    $visible = (int) $_POST["visible"];
    $temps = $_POST["temps"];
    $fecha = $_POST["fecha"];
    $idIncidencia = $_POST["idIncidencia"];

    $sentenciaAct = $conn->prepare("INSERT INTO ACTUACIO 
    (descripcio, visible, temps, fecha, idIncidencia)
    VALUES
    (?, ?, ?, ?, ?)");

    $sentenciaAct->bind_param("siisi", $descripcio, $visible, $temps, $fecha, $idIncidencia);
   
    if ($sentenciaAct->execute()) {
    echo "<div class='card mt-3 bg-success bg-opacity-25'>";
    echo "<div class='card-body d-flex justify-content-center align-items-center gap-3 flex-wrap'>";
    echo "<p>Actuacio registrada</p>";
    echo "</div>";
    echo "</div>";
    
    echo "<div class='d-flex justify-content-center gap-3 mt-3'>";
    echo "<a href='index.php' class='btn btn-primary'>Tornar</a>";
    echo "</div>";
    } else {
    echo "<div class='card mt-3 bg-danger bg-opacity-25'>";
    echo "<div class='card-body d-flex align-items-center gap-3 flex-wrap'>";
    echo "<p>Actuacio no registrada</p>";
    echo "</div>";
    echo "</div>";

    echo "<div class='d-flex justify-content-center gap-3 mt-3'>";
    echo "<a href='index.php' class='btn btn-primary'>Tornar</a>";
    echo "</div>";
    }
}



function finalitzar_act($conn) {
    $descripcio = $_POST["descripcio"];
    $visible = (int) $_POST["visible"];
    $temps = $_POST["temps"];
    $fecha = $_POST["fecha"];
    $idIncidencia = $_POST["idIncidencia"];

    $sentenciaAct = $conn->prepare("INSERT INTO ACTUACIO 
    (descripcio, visible, temps, fecha, idIncidencia)
    VALUES
    (?, ?, ?, ?, ?)");

    $sentenciaAct->bind_param("siisi", $descripcio, $visible, $temps, $fecha, $idIncidencia);
    $sentenciaAct->execute();

    $sentenciaInc = $conn->prepare("UPDATE INCIDENCIA 
        SET dataFinalitzacio = ? 
        WHERE idIncidencia = ?");
    $sentenciaInc->bind_param("si", $fecha, $idIncidencia);


    if ($sentenciaInc->execute()) {
    echo "<div class='card mt-3 bg-success bg-opacity-25'>";
    echo "<div class='card-body d-flex justify-content-center align-items-center gap-3 flex-wrap'>";
    echo "<p>Actuacio registrada</p>";
    echo "</div>";
    echo "</div>";
    
    echo "<div class='d-flex justify-content-center gap-3 mt-3'>";
    echo "<a href='index.php' class='btn btn-primary'>Tornar</a>";
    echo "</div>";
    } else {
    echo "<div class='card mt-3 bg-danger bg-opacity-25'>";
    echo "<div class='card-body d-flex align-items-center gap-3 flex-wrap'>";
    echo "<p>Actuacio no registrada</p>";
    echo "</div>";
    echo "</div>";

    echo "<div class='d-flex justify-content-center gap-3 mt-3'>";
    echo "<a href='index.php' class='btn btn-primary'>Tornar</a>";
    echo "</div>";
    }
}




?>

<!DOCTYPE html>
<?php include_once "encabezado.php"; ?>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RegistrarAct</title>
</head>

<body>
    <h1 class="fw-bold text-center mt-3 mb-5">Registra una actuacció</h1>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["registrar"])) {
        registrar_act($conn);
    } else if (isset($_POST["finalitzar"])) {
        finalitzar_act($conn);
    }
    } 
    else {
        ?>
<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-6">
<div class="card-body">
<h4 class="card-title text-center mb-4">Registrar Actuació</h4>
<form method="POST" action="registrarAct.php">
    <input type="hidden" name="idIncidencia" value="<?php echo $_GET["id"] ?>">
    
    <div class="mb-3">
        <label class="form-label fw-bold">Descripció:</label>
        <input type="text" id="descripcio" name="descripcio" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Visibilitat per a professors:</label>
        <select name="visible" id="visible" class="form-select" required>
            <option value="" selected>-- Visible? --</option>
            <option value="0">No visible</option>
            <option value="1">Visible</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Data actuació:</label>
        <input type="datetime-local" name="fecha" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Temps:</label>
        <input type="number" name="temps" id="temps" class="form-control" required>
    </div>

    <div class="d-grid">
        <button type="submit" name="registrar" class="btn btn-primary mb-3">Registrar</button>
        <button type="submit" name="finalitzar" class="btn btn-primary">Registrar y finalitzar</button>
    </div>

        <div class="d-flex justify-content-center gap-3 mt-3">
        <a href="llistarTecnics.php" class="btn btn-primary">Tornar</a>
        <a href="index.php" class="btn btn-primary">Tornar a inici</a>
    </div>

</form>
</div>
</div>
</div>
</div>
</div>
        <?php
    } 
    ?>