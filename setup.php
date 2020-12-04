<!DOCTYPE html>
<html>
  <head>
    <title>Setting up database</title>
  </head>
  <body>

    <h3>Setting up...</h3>

<?php // Example 26-3: setup.php
  require_once 'functions.php';


  createTable('alumnos', 
              'id_alumno INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              nombre VARCHAR(60),
              primer_apellido VARCHAR(60),
              segundo_apellido VARCHAR(60),
              id_usuario INT
             ');

 createTable('asignaturas', 
              'id_asignatura INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              nombre_asignatura VARCHAR(60)
             ');

  createTable('calificaciones',
              'id_calificacion INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
               calificacion VARCHAR(60),
               id_alumno INT,
               id_asignatura INT
              ');

  createTable('perfiles',
              'id_perfil INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              nombre_perfil VARCHAR(30)');

  createTable('usuarios', 
              'id_usuario INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              nombre_usuario VARCHAR(50),
              password VARCHAR(50),
              id_perfil INT(11)
             ');
?>

    <br>...done.
  </body>
</html>
