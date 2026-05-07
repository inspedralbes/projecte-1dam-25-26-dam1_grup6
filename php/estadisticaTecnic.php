<?php

require_once 'connexio.php';

?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadisticas de Tecnics</title>
</head>
<body>
    <h1>Estadisticas de Tecnics</h1>
    <?php
        try {
            $sentenciaTecnics = $conn->query("SELECT * FROM vista_informe_tecnics");
            $result = $sentenciaTecnics->fetchAll(PDO::FETCH_BOTH);

            if (count($result) > 0) {
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID Tecnic</th>
                            <th>Nom Tecnic</th>
                            <th>Prioritat</th>
                            <th>ID Incidencia</th>
                            <th>Descripció Incidencia</th>
                            <th>Data inici</th>
                            <th>Temps total dedicat (min)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($result as $fila): 
                        ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['idTecnic']) ?></td>
                        <td><?= htmlspecialchars($fila['nomTecnic']) ?></td>
                        <td><?= htmlspecialchars($fila['prioritat']) ?></td>
                        <td><?= htmlspecialchars($fila['idIncidencia']) ?></td>
                        <td><?= htmlspecialchars($fila['descripcioIncidencia']) ?></td>
                        <td><?= htmlspecialchars($fila['dataInici']) ?></td>
                        <td><?= htmlspecialchars($fila['tempsTotalDedicat']) ?> min</td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php
            }
            else {
                echo "<p> No s'han trobat incidencies per registrar.<p>";
            } 
        } catch (PDOException $e) {
            echo "<p> ERROR </p>";
        }
    ?>
</body>