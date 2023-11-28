<?php

    //$urlActivacion = "localhost/";
    // Para tomar url en el Envio de correo
    
    // Configuro hora local
    date_default_timezone_set("America/Mexico_City");

    //  1 Localhost
    //  0 Web
    $isConexionLocal = 0;
    $isServidorPruebas = 0;
    $preventLogin = false;

    //$preventLogin = "verifica/preregistro.php";

    if ($isConexionLocal)
    {
        $dominio = "http://localhost/apps/conejondigital/";
        $dominio = "http://192.168.0.4/apps/conejondigital/";
        $urlActivacion = $dominio;
    }
    else
    {
        $dominio = "https://conejondigital.com/";        
        $urlActivacion = $dominio;
    } 
     
?>
