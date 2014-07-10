<?php
/*
Déconnexion
*/

session_start();

$_SESSION = array();

session_destroy();

header("Location:login.php?action=quit");

?>