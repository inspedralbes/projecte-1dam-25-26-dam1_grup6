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
    return $sentencia2->execute();

}

?>
<!DOCTYPE html>
<?php  
include_once "encabezado.php";
?>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear</title>
</head>

<body>
    <?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resultado = registrar_inc($conn); // CAMBIO 2: guardar el resultado
    if ($resultado) {
        echo '<div class="alert alert-success text-center mt-3">Incidencia registrada correctament!</div>';
    } else {
        echo '<div class="alert alert-danger text-center mt-3">Error al registrar la incidencia.</div>';
    }
} else {
        //Mostrem el formulari per crear una nova casa
        //Tanquem el php per poder escriure el codi HTML de forma més còmoda.
        ?>

<?php
$sql1 = "SELECT idDepartament, nom FROM DEPARTAMENT";
$sentencia1 = $conn->query($sql1);

echo '<div class="container mt-5">';
echo '<div class="row justify-content-center">';
echo '<div class="col-md-6">';
echo '<div class="card-body">';
echo '<h2 class="card-title text-center mb-4">Registrar Incidencia</h2>';

echo '<form method="POST" action="crear.php">';

echo '<div class="mb-3">';
echo '<label class="form-label fw-bold">Departament:</label>';
echo '<select name="departament" id="departament" class="form-select" required>';
echo '<option value="" selected>-- Selecciona departament --</option>';
while($fila = $sentencia1->fetch_assoc()) {
    echo '<option value="' . $fila["idDepartament"] . '">' . $fila["nom"] . '</option>';
}
echo '</select>';
echo '</div>';

echo '<div class="mb-3">';
echo '<label class="form-label fw-bold">Descripció:</label>';
echo '<input type="text" id="descripcio" name="descripcio" class="form-control" required>';
echo '</div>';

echo '<div class="d-grid">';
echo '<button type="submit" class="btn btn-primary">Registrar</button>';
echo '</div>';

echo '</form>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
?>

<?php } ?>


 <br><br>
 <div class="d-flex justify-content-center gap-3">
    <a href="llistarProfessors.php" class="btn btn-primary">Tornar</a>
    <a href="index.php" class="btn btn-primary">Tornar a inici</a>
 </div>



</body>

</html>