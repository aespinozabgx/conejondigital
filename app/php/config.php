<?php

    //$urlActivacion = "localhost/";
    // Para tomar url en el Envio de correo
    

    // Configuro hora local
    date_default_timezone_set("America/Mexico_City");

    //  1 Localhost
    //  0 Web
    $isConexionLocal = 0;

    // Prevent Login
    // Pre Registro = true
    $preventLogin = false;
    //$preventLogin = "verifica/preregistro.php";

    if ($isConexionLocal)
    {
        $dominio = "http://localhost/apps/conejondigital/";
        // $dominio = "http://192.168.0.5/apps/vendy/vendy";
        $urlActivacion = $dominio;
    }
    else
    {
        $dominio = "https://conejondigital.com/";        
        $urlActivacion = $dominio;
    } 
    
    $precioPlaquita = 250;
?>