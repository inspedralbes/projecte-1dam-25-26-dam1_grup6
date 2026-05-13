<?php

require_once 'connexio.php';
include_once 'mongo.php';

?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consum per departaments</title>
</head>
<body>
    <h1>Consum per departaments</h1>
    <?php
        try {
            $sentenciaDepartaments = $conn->query("SELECT * FROM vista_consum_departaments");
            $result = $sentenciaDepartaments->fetch_all(MYSQLI_ASSOC);

            if (count($result) > 0) {
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID Departament</th>
                            <th>Nom Departament</th>
                            <th>Nombre de Incidencies</th>
                            <th>Temps total dedicat (min)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($result as $fila):
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($fila['idDepartament']) ?></td>
                            <td><?= htmlspecialchars($fila['nomDepartament']) ?></td>
                            <td><?= htmlspecialchars($fila['nombreIncidencies']) ?></td>
                            <td><?= htmlspecialchars($fila['tempsTotalDedicat']) ?> min</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php
            } else {
                echo "<p> No s'ha trobat incidencies per registrar.</p>";
            }
        } catch (PDOException $e) {
            echo "<p> ERROR </p>";
        }
    ?>
</body>