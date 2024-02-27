<?php 
session_start();
//detuire une variable specifique de notre session
//session_unset("user");
//detruire tous les session utilisé
session_destroy();
header("location: login.php");
?>