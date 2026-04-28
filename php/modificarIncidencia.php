<?php

require_once 'connexio.php';

function modificar_incidencia($conn) {
    $departament = $_POST["departament"];
    $descripcio = $_POST["descripcio"];
    $prioridad = $_POST["prioridad"];
    $tecnic = $_POST["tecnic"];
    $tipus = $_POST["tipus"];

$sentenciaMod = $conn->prepare("INSERT INTO INCIDENCIA
()");
}

?>