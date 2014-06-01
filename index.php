<?php
/*
Page mère
*/

session_start();

include_once("Auth.php");

if(!(Auth::isLogged())){
	header("Location:login.php");
}

include "Controller.php";

$site = new Controller();

$site->analyse();

?>
