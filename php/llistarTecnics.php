<?php

//Sempre volem tenir una connexió a la base de dades, així que la creem al principi del fitxer
require_once 'connexio.php';
include_once 'mongo.php';
// Un cop inclòs el fitxer connexio.php, ja podeu utilitzar la variable $conn per a fer les consultes a la base de dades.


$result = null; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["tecnic"])){
    $tecnic = $_POST["tecnic"];
$sql = "SELECT i.idIncidencia, i.descripcio, i.fecha, i.prioritat, i.idDepartament, i.idTipologia, d.nom, t.nomTipologia FROM INCIDENCIA i, DEPARTAMENT d, TIPOLOGIA t WHERE i.idTecnic = ? AND i.idDepartament = d.idDepartament AND i.idTipologia = t.idTipologia";    $sentencia = $conn->prepare($sql);
    $sentencia->bind_param("i", $tecnic);
    $sentencia->execute();

    $result = $sentencia->get_result();

}
}

?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat</title>
</head>

<body>
    <h1>Llistat de cases</h1>



<?php
$sql2 = "SELECT idTecnic, nom FROM TECNIC";
$sentencia2 = $conn->query($sql2);

echo '<form method="POST" action="llistarTecnics.php">';
    echo '<select name="tecnic" required>';
    echo '<option value="" selected>-- Selecciona tecnic --</option>';

    while($fila = $sentencia2->fetch_assoc()) {
        echo '<option value="' . $fila["idTecnic"] . '">' . $fila["nom"] . '</option>';
    }
    
    echo '</select>'; 
    echo '<input type="submit" value="Seleccionar">';
echo '</form>';
?>

    <?php
    // Comprovar si hi ha resultats
    if ($result !== null && $result->num_rows > 0) {

        // Llistar els resultats. ATENCIÓ, heu de construir el codi HTML d'una llista correctament
        while ($row = $result->fetch_assoc()) {
            echo "<p>ID: " . $row["idIncidencia"] . " - Descripcio: " . htmlspecialchars($row["descripcio"]) . "";
            echo "   --- Data Inici: " . $row["fecha"]. "";
            echo "   --- Prioridad: " . $row["prioritat"]. "";
            echo "   --- Departament: " . $row["nom"]. "";
            echo "   --- Tipologia: " . $row["nomTipologia"]. "";
            echo " <a href='esborrar.php?id=" . $row["idIncidencia"] . "'>Esborrar</a>";
            echo " <a href='registrarAct.php?id=" . $row["idIncidencia"] . "'>Registrar actuacio</a>";
            echo " <a href='estatTecnic.php?id=" . $row["idIncidencia"] . "'>Historial actuacions</a></p>";
        }

    } elseif ($result !== null) {
        echo "<p>No hi ha dades a mostrar.</p>";
    }

    // Tancar la connexió
    $conn->close();
    ?>

    <div id="menu">
        <hr>
        <p><a href="index.php">Volver</a></p>
    </div>

</body>

</html>