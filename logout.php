<?php
session_start();
unset(  $_SESSION['authenticated']);
unset(  $_SESSION['auth_user']);
$_SESSION['status'] ="Succesfully Logged out";
header("Location: login.php")

?>