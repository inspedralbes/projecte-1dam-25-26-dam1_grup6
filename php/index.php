<!DOCTYPE html>
<?php  
include_once "encabezado.php";
include_once "mongo.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GI3P Gestor Incidencias DAM</title>
</head>

<body>

<div class="d-flex justify-content-center align-items-start vh-100 pt-5">
  <div class="text-center p-4">
    <h2 class="mb-3">Selecció d'usuari</h2>
    <div class="d-grid gap-3">
      <a href="llistarProfessors.php" class="btn btn-primary">Professor</a>
      <a href="llistarTecnics.php" class="btn btn-primary">Tècnics</a>
      <a href="llistarAdmin.php" class="btn btn-primary">Administrador</a>
    </div>
  </div>
</div>


</body>
</html>