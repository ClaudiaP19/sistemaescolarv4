<?php
use Illuminate\Database\Capsule\Manager as DB;

require 'vendor\autoload.php';
require 'config\database.php';


$users= DB::table('calificaciones')
    ->leftJoin('alumnos','calificaciones.id_alumno','=','alumnos.id_alumno')
    ->get();

$promedio = DB::table('calificaciones')->avg('calificacion');
$promedio = number_format($promedio,1);
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
                <h1>Sistema escolar para Profesor</h1>
            </div>
            <?php
            echo <<<_TABLE
            <table class="table">
            <thead>
                <th>#ID</th>
                <th>Calificación</th>
                <th>Alumno</th>
                <th colspan="2">Operaciones</th>
            </thead>
            <tfoot>
                <tr>
                    <th>Promedio:</th>
                    <th>$promedio</th>
                </tr>
            </tfoot>
            <tbody>
_TABLE;
            foreach ($users as $fila){
                echo <<<_ROW
                <tr>
                    <th>$fila->id_calificacion</th>
                    <td><center>$fila->calificacion</center></td>
                    <th>{$fila->nombre} {$fila->primer_apellido} {$fila->segundo_apellido}</th>
                    <td>
                        <a class="button" onclick="delete_calificacion($fila->id_calificacion)">ELIMINAR</a>
                    </td>
                    <td>
                        <form  method="post">
                            <input id="id_calificacion" type="text" name="id_calificacion" value="{$fila->id_calificacion}" hidden>
                            <input id="calificacion-$fila->id_calificacion" type="text" name="calificacion" size="3">
                            <input id="id_usuario" type="text" name="id_usuario"  value="{$_POST['id_usuario']}" hidden>
                            <input class="button" value="ACTUALIZAR" onclick="update({$fila->id_calificacion},)">
                        </form>
                    </td>
_ROW;

            }
?>
            </tbody>
        </table>
        <form action='inicio.php' method='post'>
            <input id='id_usuario' type='hidden' name='id_usuario'  value="<?php echo $_POST['id_usuario']?>"  >
            <input class='button' type='submit' value='Regresar al sistema escolar'>
        </form>
        </div>
    </div>

<script>
        function update(id_calificacion) {

            axios.post(`api/index.php/update/`, {
                id_calificacion: id_calificacion,
                calificacion: document.getElementById("calificacion-"+id_calificacion).value
            })
                .then(resp=> {
                    location.reload();
                    alert(resp.data.mensaje);
                })
                .catch(function (error) {
                    alert('Error');
                    console.log(error);
                });
        };
        function delete_calificacion(id_calificacion) {
            axios.post(`api/index.php/delete_calificacion/`, {
                id_calificacion: id_calificacion,
            })
                .then(resp=> {
                    location.reload();
                    console.log(resp.data);
                    alert(resp.data.mensaje);
                })
                .catch(function (error) {
                    location.reload();
                    alert('Error');
                    console.log(error);
                });
        }
    </script>
    </body>

