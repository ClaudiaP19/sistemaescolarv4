<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as DB;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

// Instantiate app
$app = AppFactory::create();
$app->setBasePath("/sistemaescolarv4/api/index.php");

// Add Error Handling Middleware
$app->addErrorMiddleware(true, false, false);

// Add route callbacks
$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write('Hello World');
    return $response;
});
$app->post('/login/{usuario}', function (Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody()->getContents(),false);


    $user = DB::table('usuarios')
        ->leftJoin('perfiles','usuarios.id_perfil','=', 'perfiles.id_perfil')
        ->where('usuarios.nombre_usuario',$args['usuario'])
        ->first();
   // var_dump($user);
    $msg = new stdClass();
    $msg->mensaje = 'OK aceptado';

    if($user->password == $data->password){
        $msg->aceptado = true;
        $msg->nombre_perfil = $user->nombre_perfil;
        $msg->id_usuario = $user->id_usuario;
    }
    else{
        $msg->aceptado = false;
    }
    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/insertar/', function (Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody()->getContents(),false);


    $calificacion= DB::table('calificaciones')->insert(
        ['calificacion'=>$data->calificacion,
        'id_alumno'=>$data->id_alumno,
        'id_asignatura'=>$data->id_asignatura
        ]
    );
    // var_dump($user);
    $msg = new stdClass();
    $msg->mensaje = 'Error al guardar';

    if($calificacion){
        $msg->mensaje = 'Calificación guardada';
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/delete_calificacion/', function (Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody()->getContents(),false);

    $calificacion = DB::table('calificaciones')
        ->where('id_calificacion',$data->id_calificacion)
        ->delete();

    // var_dump($user);
    $msg = new stdClass();
    $msg->mensaje = 'Error al eliminar';

    if($calificacion){
        $msg->mensaje = 'Calificación eliminada';
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/update/', function (Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody()->getContents(),false);

    $calificacion = DB::table('calificaciones')
        ->where('id_calificacion',$data->id_calificacion)
        ->update(['calificacion'=>$data->calificacion]);


     //var_dump($data);
    $msg = new stdClass();
    $msg->mensaje = 'Error al actualizar';

    if($calificacion){
        $msg->mensaje = 'Calificación actualizada';
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});

// Run application
$app->run();