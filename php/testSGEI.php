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
require_once 'connexio.php';
$sql = "SELECT * FROM vista_informe_tecnics";
$resultat = $conn->query($sql);
$tecnics = $resultat->fetch_all(MYSQLI_ASSOC);
$tempsArray = array();
$deptsArray = array();
$numArray = array();

// Agrupar per tècnic (la vista té una fila per incidència)
$perTecnic = [];
foreach ($tecnics as $t) {
    $nom = $t["nomTecnic"];
    if (!isset($perTecnic[$nom])) {
        $perTecnic[$nom] = ["temps" => 0, "num" => 0];
    }
    $perTecnic[$nom]["temps"] += (int)$t["tempsTotalDedicat"];
    $perTecnic[$nom]["num"]++;
}

foreach ($perTecnic as $nom => $dades) {
    $deptsArray[] = $nom;
    $tempsArray[] = $dades["temps"];
    $numArray[]   = $dades["num"];
}
?>
<tbody>
<?php foreach ($tecnics as $unTecnic): ?>
<tr>
<th scope="row"><?php echo htmlspecialchars($unTecnic["nomTecnic"]) ?></th>
<td><?php echo $unTecnic["tempsTotalDedicat"] ?> minuts</td>
</tr>
<?php endforeach; ?>
</tbody>

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