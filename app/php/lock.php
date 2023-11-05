<?php     

    if (!isset($_SESSION['email']) || empty($_SESSION['email']))
    {
        //die('No puedes estar aquí');
        exit(header('Location: ../login.php?msg=requiereSesion'));
    }

?>