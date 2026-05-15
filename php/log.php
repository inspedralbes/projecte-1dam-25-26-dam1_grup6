<?php
    include_once "encabezado.php";
    include_once "pie.php";
     ?>
<?php
require($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

    $uri = 'mongodb://root:example@mongo:27017/';

    $client = new MongoDB\Client($uri);

    $collection = $client->demo->users;

$accessos_total = $collection->countDocuments();

// Agrupem els accessos per URI i comptem quantes vegades apareix cada pàgina.
$pagines = $collection->aggregate([

    [
        '$group' => [
            // Agrupem pel camp uri
            '_id' => '$uri',
            // Amb la funcio de suma fem un contador que suma 1 per cada document.
            'total' => ['$sum' => 1]
        ]
    ],

    [
        // Ordenem de més visitades a menys visitades.
        '$sort' => ['total' => -1]
    ],
    [
        // Mostrem només les 10 primeres pagines.
        '$limit' => 10
    ]
]);


$accessos_dia = $collection->aggregate([

    [
        '$group' => [
            //Com que la varibale date té el format Y-m-d H:i:s, amb la funcio substr sol agafem la data i no les temps.
            '_id' => ['$substr' => ['$date', 0, 10]],

            //El contador que suma 1 cada vegada.
            'total' => ['$sum' => 1]
        ]
    ],

    [
        //Ordenar de més a menys recents.
        '$sort' => ['_id' => 1]
    ],
    [
        // Mostrem només les 10 primeres pagines.
        '$limit' => 10
    ]

]);

//Variables php que s'afegeix al formulari i com a default no s'envia res.

$data = $_GET['data'] ?? '';
$pagina = $_GET['pagina'] ?? '';

//Comencem a un pipeline buit
$pipeline = [];

//Afegim els camps: 'dia' sol amb la data, no el temps i uri s'agafa com es afegeix.
$pipeline[] = [
    '$project' => [
        'dia' => ['$substr' => ['$date', 0, 10]],
        'uri' => 1
    ]
];
// Creem un array buit que equival al filtre
$filtre = [];

// Si la varibale php data no esta buida, afegim al filtre la condició que el camp "dia" de MongoDB ha de ser igual al valor de $data.
if (!empty($data)) {
    $filtre['dia'] = $data;
}

// Si la variable php $pagina no està buida, afegim al filtre la condició que el camp "uri" de MongoDB ha de ser igual al valor de $pagina.
if (!empty($pagina)) {
    $filtre['uri'] = $pagina;
}

// Si el filtre té alguna condició, amb l'etapa $match li diem a MongoDB que només busqui els documents que coincideixin.
if (!empty($filtre)) {
    $pipeline[] = ['$match' => $filtre];
}

// Afegim l'etapa $count al pipeline perquè MongoDB compti quants documents han passat els filtres i guardi el resultat amb el nom "total".
$pipeline[] = ['$count' => 'total'];

// Executem tot el pipeline a MongoDB i guardem tot a $resultat.
$resultat = $collection->aggregate($pipeline);

// Amb el foreach mirem la variable $resultat i agafem el número i posem en una varibale php mostrar-lo a HTML.
$total = 0;
foreach ($resultat as $fila) {
    $total = $fila['total'];
}

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="main-card">
                <h1 class="text-center mb-4 mt-4">Estadístiques d'Accés</h1>

                <div class="alert border text-center mb-4">
                    <p class="mb-0 text-muted small">Total d'accessos</p>
                    <div class="text-total"><?= $accessos_total ?></div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h2>Pàgines més visitades</h2>
                        <table class="table table-sm table-striped table-primary overflow-hidden">
                            <thead>
                                <tr>
                                    <th>Pàgina</th>
                                    <th>Visites</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pagines as $enllaç): ?>
                                    <tr>
                                        <td class="small"><?= $enllaç['_id'] ?></td>
                                        <td class="fw-bold"><?= $enllaç['total'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6 mb-4">
                        <h2>Accessos per dia</h2>
                        <table class="table table-sm table-striped table-primary  overflow-hidden">
                            <thead>
                                <tr>
                                    <th>Dia</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($accessos_dia as $dia): ?>
                                    <tr>
                                        <td><?= $dia['_id'] ?></td>
                                        <td class="fw-bold"><?= $dia['total'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <h2>Buscar accessos</h2>
                <form method="GET" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="date" name="data" class="form-control" value="<?= htmlspecialchars($data) ?>">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="pagina" class="form-control" placeholder="/inici" value="<?= htmlspecialchars($pagina) ?>">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Buscar</button>
                            
                        </div>
                    </div>
                </form>

                <?php if (!empty($data) || !empty($pagina)): ?>
                    <div class="alert alert-light border text-center">
                        <p class="mb-0 text-muted small">Accessos trobats</p>
                        <div class="text-total"><?= $total ?></div>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Introdueix almenys una data o una pàgina amb "/" al principi per buscar.</p>
                <?php endif; ?>

        <div class="d-flex justify-content-center gap-3 mt-5 mb-4">
         <a href="llistarAdmin.php" class="btn btn-primary">Tornar</a>
        <a href="index.php" class="btn btn-primary">Tornar a inici</a>
    </div>

            </div>
        </div>
    </div>
</div>
