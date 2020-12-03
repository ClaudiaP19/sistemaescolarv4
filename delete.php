<?php
use Illuminate\Database\Capsule\Manager as DB;

require 'vendor\autoload.php';
require 'config\database.php';

DB::table('calificaciones')
    ->where('id_calificacion',$_GET['id'])->delete();

echo "Se elimino la calificación con el id:{$_GET['id']}
<a class='button' href='consultar.php'>REGRESAR</a>";
