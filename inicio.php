<?php
use Illuminate\Database\Capsule\Manager as DB;

require 'vendor\autoload.php';
require 'config\database.php';

$user = DB::table('usuarios')
    ->leftJoin('perfiles','usuarios.id_perfil','=','perfiles.id_perfil')
    ->where('usuarios.id_usuario',$_POST['id_usuario'])
    ->first();

$alumnos = DB::table('alumnos')
    ->get();

$asignatura = DB::table('asignaturas')
    ->get();

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
<div class="box">
    <div class="columns is-centered is-2">
        <div class="column is-half">
            <div class="notification is-link">
                <h1>Sistema escolar para el <?php echo $user->nombre_perfil ?></h1>
            </div>
            <?php if($user->nombre_perfil == 'Profesor'){?>
            <h2>AGREGAR CALIFICACIÓN</h2>
            <form action="insertar.php" method="post">
                <label for="calificacion">Calificación:</label>
                <input id="calificacion" type="text" name="calificacion">
                <br>
                <label for="id_alumno">Alumno:</label>
                <select id="id_alumno" name="id_alumno">
                    <?php
                    foreach ($alumnos as $fila)
                        echo "<option value='{$fila->id_alumno}'>$fila->nombre</option>";
                    ?>

                </select>
                <br>
                <label for="id_alumno">Asignatura:</label>
                <select id="id_asignatura" name="id_asignatura">
                    <?php
                    foreach ($asignatura as $fila)
                        echo "<option value='{$fila->id_asignatura}'>$fila->nombre_asignatura</option>";
                    ?>

                </select>
                <br>
                <input class="button"  value="Guardar" onclick="insertar()">
            </form>
        <?php } ?>

            <form action="consultar.php" method="post">
                <input id="id_usuario" type="text" name="id_usuario" value="<?php echo $user->id_usuario ?>" hidden>
                <input class="button" type="submit" value="Consultar">
            </form>
    </div>
    </div>
</div>

    <script>
        function insertar() {
            axios.post(`api/index.php/insertar/`, {
                calificacion: document.forms[0].calificacion.value,
                id_alumno: document.forms[0].id_alumno.value,
                id_asignatura: document.forms[0].id_asignatura.value,

                //password: document.forms[0].password.value,
            })
                .then(resp=> {
                    console.log(resp.data);
                    alert('Guardado');
                })
                .catch(function (error) {
                    alert('Error');
                    console.log(error);
                });
        }
    </script>
</body>

