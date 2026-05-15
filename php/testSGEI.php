<!DOCTYPE html>
<?php include_once "encabezado.php"; ?>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadisticas de Tecnics</title>
</head>
<body>
        <h1 class="mb-4 mt-4 text-center">Estadisticas de Tecnics</h1>
<?php
require_once 'connexio.php';
$sql = "SELECT 
    t.nom AS nomTecnic,
    COALESCE(SUM(a.temps), 0) AS tempsTotalDedicat,
 COUNT(DISTINCT CASE WHEN i.dataFinalitzacio IS NOT NULL THEN i.idIncidencia END) AS num
FROM TECNIC t
LEFT JOIN INCIDENCIA i ON t.idTecnic = i.idTecnic
LEFT JOIN ACTUACIO a ON i.idIncidencia = a.idIncidencia
GROUP BY t.idTecnic, t.nom";
$resultat = $conn->query($sql);
$tecnics = $resultat->fetch_all(MYSQLI_ASSOC);
$tempsArray = array();
$deptsArray = array();
$numArray = array();


foreach ($tecnics as $t) {
    $deptsArray[] = $t["nomTecnic"];
    $tempsArray[] = (int)$t["tempsTotalDedicat"];
    $numArray[]   = (int)$t["num"];
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
                text: 'Consum de Temps Total per Tècnic'
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
                text: 'Nombre d\'incidències totals per Tècnic'
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

