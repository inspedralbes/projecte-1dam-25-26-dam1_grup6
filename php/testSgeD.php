<!DOCTYPE html>
<?php include_once "encabezado.php"; ?>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consum per departaments</title>
</head>
<body>
    <h1 class="mb-4 mt-4 text-center">Consum per departaments</h1>
<?php
require_once 'connexio.php';
$sql = "SELECT * FROM vista_consum_departaments";
$resultat = $conn->query($sql);
$departaments = $resultat->fetch_all(MYSQLI_ASSOC);
$tempsArray = array();
$deptsArray = array();
$numArray = array();

foreach ($departaments as $unDepartament) {
    $tempsArray[] = $unDepartament["tempsTotalDedicat"];
    $deptsArray[] = $unDepartament["nomDepartament"];
    $numArray[]   = $unDepartament["nombreIncidencies"];
}
?>


<div style="width: 50%; margin: auto; margin-top: 30px; display: flex; justify-content: center; gap: 20px;">
<canvas id="myChart" width="400" height="400"></canvas>
<canvas id="myChart2" width="400" height="400"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('myChart');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($deptsArray); ?>,
        datasets: [{
            label: 'Temps total (min)',
            data: <?php echo json_encode($tempsArray); ?>,
            borderWidth: 1
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Consum de Temps Total per Departaments'
            }
        }
    }
});

const ctx2 = document.getElementById('myChart2');
new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($deptsArray); ?>,
        datasets: [{
            label: 'Nombre d\'incidències totals',
            data: <?php echo json_encode($numArray); ?>,
            borderWidth: 1
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Nombre d\'incidències totals per Departament'
            }
        }
    }
});
</script>

        <div class="d-flex justify-content-center gap-3 mt-5 mb-4">
         <a href="llistarAdmin.php" class="btn btn-primary">Tornar</a>
        <a href="index.php" class="btn btn-primary">Tornar a inici</a>
    </div>

    </body>
</html>