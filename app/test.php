<?php
    session_start();

    require 'php/conexion.php';
    require 'php/funciones.php';
    require 'php/lock.php';
 

    echo "<pre>";
    print_r($_SESSION);
    die;
 
     
 
?>