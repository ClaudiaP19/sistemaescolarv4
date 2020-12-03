<?php
use Illuminate\Database\Capsule\Manager as DB;

require 'vendor\autoload.php';
require 'config\database.php';

DB::table('calificaciones')->insert(
    ['calificacion'=>$_POST['calificacion']]
);

echo "<h1>DATOS GUARDADOS</h1><br><a href='inicio.php'>Regresar</a>";