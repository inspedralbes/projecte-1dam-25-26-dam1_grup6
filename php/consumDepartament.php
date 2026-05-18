<?php

require_once 'connexio.php';
include_once 'mongo.php';
    include_once "encabezado.php";
    include_once "pie.php";

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consum per departaments</title>
</head>
<body>

    <?php
            echo '<h1 class="mb-4 mt-4 text-center">Consum per departaments</h1>';
        try {
            $sentenciaDepartaments = $conn->query("SELECT * FROM vista_consum_departaments");
            $result = $sentenciaDepartaments->fetch_all(MYSQLI_ASSOC);

            if (count($result) > 0) {
                        foreach ($result as $fila):
                        ?>
       <div class="card mt-3">
            <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                <span class="fw-bold">ID Departament: <?php echo $fila['idDepartament'] ?></span>
                <span class="text-muted">|</span>
                <span>Nom Departament: <?php echo $fila['nomDepartament'] ?></span>
                <span class="text-muted">|</span>
                <span>Nombre total d'incidencies: <?php echo $fila['nombreIncidencies'] ?></span>
                <span class="text-muted">|</span>
                <span>Temps total dedicat: <?php echo htmlspecialchars($fila['tempsTotalDedicat']) ?></span>
            </div>
        </div>
    <?php endforeach;

            } else {
                echo "<p> No s'ha trobat incidencies per registrar.</p>";
            }
        } catch (PDOException $e) {
            echo "<p> ERROR </p>";
        }
    ?>

        <div class="d-flex justify-content-center gap-3 mt-3">
        <a href="testSgeD.php" class="btn btn-primary">Fes-ho a quesitos</a>
    </div>

        <div class="d-flex justify-content-center gap-3 mt-5 mb-4">
         <a href="llistarAdmin.php" class="btn btn-primary">Tornar</a>
        <a href="index.php" class="btn btn-primary">Tornar a inici</a>
    </div>

</body>