<?php

include_once 'connexio.php';

if (!empty($_POST["btningresar"])) {
    if (empty($_POST["usuario"]) and empty($_POST["password"])) {
        echo '<p> Los campos estan vacios</p>';
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario=$_POST["usuario"];
        $clave=$_POST["password"];
        $stmt = $conn->prepare("SELECT nom, clave FROM USUARI WHERE nom = ? AND clave = ?");
        $stmt->bind_param("ss", $usuario, $clave);
        $stmt->execute();

        $result = $stmt->store_result();

        if ($result['nom'] == $usuario) {
            if ($result['clave'] == $clave) {
                header("location:index.php");
            } else {
            echo '<p>Acceso denegado.</p>';
        } 
        } else {
            echo '<p>Acceso denegado.</p>';

        }
    }

include_once 'mongo.php';

?>
<!DOCTYPE html>
<html lang="ca">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LogIn</title>
    </head>
    <body>
        <div>
            <form method="post" action="" onsubmit="return valLog()">
                <h2 class="title">BIENVENIDO</h2>

                <div>
                    <h5>USUARIO</h5>
                    <input id="usuario" type="text" class="input" name="usuario">
                </div>

                <div>
                    <h5>Contraseña</h5>
                    <input type="password" id="input" class="input" name="password">
                </div>
                <div>
                    <input name="btningresar" type="submit" value="INICIAR SESION">
                </div>
            </form>
        </div>
    </body>