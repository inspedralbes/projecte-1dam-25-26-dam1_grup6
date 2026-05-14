<?php
include_once 'connexio.php';
include_once 'mongo.php';

if (!empty($_POST["btningresar"])) {
    if (empty($_POST["usuario"]) and empty($_POST["password"])) {
        echo '<p> Los campos estan vacios</p>';
    } else {
        $usuario=$_POST["usuario"];
        $clave=$_POST["password"];
        $sentencia=$conn->query("SELECT * FROM USUARIO WHERE nombre=$usuario and clave=$clave");
        if ($datos=$sentencia->fetch_object()) {
            header("location:index.php");
        } else {
            echo '<p>Acceso denegado.</p>';
        }
    }
}
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
            <form method="post" action="">
                <h2 class="title">BIENVENIDO</h2>

                <div>
                    <h5>USUARIO</h5>
                    <input id="usuario" type="text" class="input" name="usuario">
                </div>

                <div>
                    <h5>Contraseña</h5>
                    <input type="password" id="input" class="input" name="password">
                </div>
            </form>
        </div>
    </body>