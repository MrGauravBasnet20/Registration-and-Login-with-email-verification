<?php
    session_start();
   
    if(!isset($_SESSION['authenticated']))
    {

        $_SESSION['status']="Please Login First";
        header('Location:login.php');
        exit(0);
    }

?>