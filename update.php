<?php
use Illuminate\Database\Capsule\Manager as DB;

require 'vendor\autoload.php';
require 'config\database.php';

DB::table('calificaciones')
    ->where('id_calificacion',$_POST['id_calificacion'])
    ->update(['calificacion'=>$_POST['calificacion']]);

echo "Se actualizó la calificación del id:{$_POST['id_calificacion']}
<a class='button' href='consultar.php'>REGRESAR</a>";