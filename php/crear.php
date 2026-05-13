<?php

//Sempre volem tenir una connexió a la base de dades, així que la creem al principi del fitxer
require_once 'connexio.php';
include_once 'mongo.php';
// Un cop inclòs el fitxer connexio.php, ja podeu utilitzar la variable $conn per a fer les consultes a la base de dades.

/**
 * Funció que llegeix els paràmetres del formulari i crea una nova casa a la base de dades.
 * @param mixed $conn
 * @return void
 */
function registrar_inc($conn)
{
    // Obtenir el nom de la casa del formulari
$departament = $_POST["departament"];
$descripcio = $_POST["descripcio"];
    // Comprovar si el nom no està buit
    // Si l'html està ben escrit això no podria passar en els usuaris normals
    // Igualment SEMPRE s'ha de comprovar tot al backend ja que no tots els usuaris
    // són "bones persones" i des de les web tools es pot canviar tot el front per exemple.

    // Preparar la consulta SQL per inserir una nova casa

    $sentencia2= $conn->prepare("INSERT INTO INCIDENCIA
    (descripcio, idDepartament)
    VALUES
    (?, ?)");

    $sentencia2->bind_param("si", $descripcio, $departament);
    $sentencia2->execute();

}


?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear</title>
</head>

<body>
    <h1>Registrar incidencia</h1>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Si el formulari s'ha enviatc (mètode POST), cridem a la funció per crear la casa
        registrar_inc($conn);
    } else {
        //Mostrem el formulari per crear una nova casa
        //Tanquem el php per poder escriure el codi HTML de forma més còmoda.
        ?>

 <?php
$sql1 = "SELECT idDepartament, nom FROM DEPARTAMENT";
$sentencia1 = $conn->query($sql1);

echo '<form method="POST" action="crear.php">';

echo '<fieldset>';
echo '<legend>Registrar incidencia</legend>';
echo '<label>ID Incidencia:</label>';
echo '<br><br>';

    echo '<select name="departament" id="departament" required>';
echo '<option value="" selected>-- Selecciona departament --</option>';
    while($fila = $sentencia1->fetch_assoc()) {
        echo '<option value="' . $fila["idDepartament"] . '">' . $fila["nom"] . '</option>';
    }
    
    echo '</select>'; 
    echo '<br><br>';
echo '<label>Descripció:</label>';
echo '<input type="text" id="descripcio" name="descripcio" required>';
echo '<br><br>';
echo '<input type="submit" value="Registrar">';
    echo '</fieldset>';
echo '</form>';
?>

        <?php
    }
    ?>
    <div id="menu">
        <hr>
        <p><a href="index.php">Portada</a> </p>
        <p><a href="llistarProfessors.php">Llistar</a></p>
        <p><a href="crear.php">Crear</a></p>
    </div>
</body>

</html>