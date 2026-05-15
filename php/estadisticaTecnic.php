<?php

require_once 'connexio.php';
include_once 'mongo.php';
    include_once "encabezado.php";

?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadisticas de Tecnics</title>
    <h1 class="mb-4 mt-4 text-center">Estadistica dels tecnics</h1>
</head>






<body>
<div class="card pt-3 pb-3">
    <?php 

        echo '<h2 class="mb-4 mt-4 text-center">Llista estadistiques dels tecnics</h2>';
        try {
    $sentenciaTecnics = $conn->query("SELECT 
    t.idTecnic,
    t.nom AS nomTecnic,
    COUNT(DISTINCT CASE WHEN i.dataFinalitzacio IS NOT NULL THEN i.idIncidencia END) AS total_incidencies_per_tecnic,
    COALESCE(SUM(a.temps), 0) AS temps_total_per_tecnic
FROM TECNIC t
LEFT JOIN INCIDENCIA i ON t.idTecnic = i.idTecnic
LEFT JOIN ACTUACIO a ON i.idIncidencia = a.idIncidencia
GROUP BY t.idTecnic, t.nom;");
            $result = $sentenciaTecnics->fetch_all(MYSQLI_ASSOC);

            if (count($result) > 0) {
                        foreach ($result as $fila):
                ?>
        <div class="card mt-3">
            <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                <span class="fw-bold">ID Tecnic: <?php echo $fila['idTecnic'] ?></span>
                <span class="text-muted">|</span>
                <span>Nom Tecnic: <?php echo $fila['nomTecnic'] ?></span>
                <span class="text-muted">|</span>
                <span>Temps dedicat total: <?php echo htmlspecialchars($fila['temps_total_per_tecnic']) ?></span>
                <span class="text-muted">|</span>
                <span>Total incidencies realizades: <?php echo htmlspecialchars($fila['total_incidencies_per_tecnic']) ?></span>
            </div>
        </div>

                    <?php endforeach;

            }
            else {
                echo "<p> No s'han trobat incidencies per registrar.</p>";
            } 
        } catch (PDOException $e) {
            echo "<p> ERROR </p>";
        }
    ?>
        <div class="d-flex justify-content-center gap-3 mt-3">
        <a href="testSGEI.php" class="btn btn-primary">Fes-ho a quesitos</a>
    </div>  
</div>






        <div class="d-flex justify-content-end mt-4">
            <h4 class="mb-1">Buscador incidencia per codi</h4>
        </div>
            <div class="d-flex justify-content-end gap-2">
                <form method="POST" action="estadisticaTecnic.php" class="d-flex gap-2">
                    <input type="number" id="idInci" name="idInci" class="form-control" style="width: 150px;">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <button type="submit" id="tot" name="tot" class="btn btn-primary">Veure tots</button>
                </form>
            </div>


    <?php 




    $tecnic = $_POST["tecnic"] ?? $_GET["tecnic"] ?? null;




        echo '<h2 class="mb-4 mt-5 text-center">Llista de incidencies amb tecnics y temps dedicat</h2>';
        try {


if (!empty($_POST["idInci"])) {
    $idInci = (int)$_POST["idInci"];
    $sentencia = $conn->prepare("SELECT * FROM vista_informe_tecnics WHERE idIncidencia = ?");
    $sentencia->bind_param("i", $idInci);
    $sentencia->execute();
    $result = $sentencia->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $result = $conn->query("SELECT * FROM vista_informe_tecnics")->fetch_all(MYSQLI_ASSOC);
}

            if (count($result) > 0) {
                        foreach ($result as $fila):
                ?>
        <div class="card mt-3">
            <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                <span class="fw-bold">ID Tecnic: <?php echo $fila['idTecnic'] ?></span>
                <span class="text-muted">|</span>
                <span>Nom Tecnic: <?php echo $fila['nomTecnic'] ?></span>
                <span class="text-muted">|</span>
                <span>Prioritat: <?php echo $fila['prioritat'] ?></span>
                <span class="text-muted">|</span>
                <span>ID Incidencia: <?php echo htmlspecialchars($fila['idIncidencia']) ?></span>
                <span class="text-muted">|</span>
                <span>Descripcio: <?php echo htmlspecialchars($fila['descripcioIncidencia']) ?></span>
                <span class="text-muted">|</span>
                <span>Data Inici: <?php echo htmlspecialchars($fila['dataInici']) ?></span>
                <span class="text-muted">|</span>
                <span>Temps total dedicat a la incidencia: <?php echo htmlspecialchars($fila['tempsTotalDedicat']) ?></span>
                <a class="btn btn-primary btn-sm ms-auto" href="estat.php?id=<?php echo $fila['idIncidencia'] ?>">Estat</a>
            </div>
        </div>

                    <?php endforeach;

            }
            else {
    echo "<div class='card mt-3 bg-danger bg-opacity-25 '>";
    echo "<div class='card-body gap-3 flex-wrap'>";
    echo "<p>No s'han trobat incidencies per registrar</p>";
    echo "</div>";
    echo "</div>";
            } 
        } catch (Exception $e) {
            echo "<p> ERROR </p>";
        }
    ?>

    <div class="d-flex justify-content-center gap-3 mt-3 mb-5">
         <a href="llistarAdmin.php" class="btn btn-primary">Tornar</a>
        <a href="index.php" class="btn btn-primary">Tornar a inici</a>
    </div>


</body>