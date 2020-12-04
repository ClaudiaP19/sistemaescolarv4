<?php
use Illuminate\Database\Capsule\Manager as DB;

require 'vendor\autoload.php';
require 'config\database.php';


$users= $users= DB::table('calificaciones')
    ->leftJoin('alumnos','calificaciones.id_alumno','=','alumnos.id_alumno')
    ->leftJoin('asignaturas','asignaturas.id_asignatura','=','calificaciones.id_asignatura')
    ->where('alumnos.id_usuario',$_GET['id_usuario'])
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
                <h1>Sistema escolar para el alumno</h1>
            </div>
            <?php
            echo <<<_TABLE
            <table class="table">
            <thead>
                <th>#ID</th>
                <th>Calificación</th>
                <th>Asignatura</th>
                <th>Alumno</th>
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
                    <td><center>$fila->nombre_asignatura</center></td>
                    <th>{$fila->nombre} {$fila->primer_apellido} {$fila->segundo_apellido}</th>
                   
                    
_ROW;

            }
?>
            </tbody>
        </table>

        </div>
    </div>
    </body>

