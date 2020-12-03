<?php
use Illuminate\Database\Capsule\Manager as DB;

require 'vendor\autoload.php';
require 'config\database.php';

$user = DB::table('usuarios')
    ->leftJoin('perfiles','usuarios.id_perfil','=','perfiles.id_perfil')
    ->where('usuarios.id_usuario',$_GET['id_usuario'])
    ->first();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Sistema escolar</title>
    <link rel='stylesheet' href='node_modules/bulma/css/bulma.min.css'>
    <script src='node_modules/axios/dist/axios.min.js'></script>
</head>
<body>
    <div class="container">
        <h1>Sistema escolar</h1>
        <?php if($user->nombre_perfil == 'Profesor'){?>
        <h2>AGREGAR CALIFICACIÓN</h2>
        <form action="insertar.php" method="post">
            <label for="calificacion">Calificación:</label>
            <input id="calificacion" type="text" name="calificacion">
            <input class="button" type="submit" value="Guardar">
        </form>
        <?php } ?>
        <form action="consultar.php" method="post">
            <input class="button" type="submit" value="Consultar">
        </form>
    </div>

    <script>
        function insertar() {
            axios.post(`api/index.php/insertar/`, {
                calificacion: document.forms[0].usuario.value,
                //password: document.forms[0].password.value,
            })
                .then(resp=> {
                    alert('Guardado');
                })
                .catch(function (error) {
                    alert('Error');
                });
        }
    </script>
</body>

