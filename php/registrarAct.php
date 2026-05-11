<?php

//Sempre volem tenir una connexió a la base de dades, així que la creem al principi del fitxer
require_once 'connexio.php';
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
        echo"<p>Actuacio registrada</p>";
        echo"<a href='llistarTecnics.php'>Back</a>";
    } else {
        echo"<p>Actuacio no registrada<z/p>";
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
    <h1>Registra una actuacció</h1>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        registrar_act($conn);
    } else {
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
        <button type="submit" class="btn btn-primary">Registrar</button>
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