<?php

//Classe pour se connecter à la BDD
class BDD{
	
	private static $dblink ;
	
	//Connexion avec PDO
	private static function connect() { 
		//Fichier de paramètres
		include_once 'configBDD.php';
	
		try{
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO("mysql:host=$host;dbname=$base",$user,$pass, $pdo_options);
		}catch (Exception $e){
			die('Erreur : ' . $e->getMessage());
		}
		return $bdd;
	} 
	
	//Renvoi la connexion
	public static function getConnection() {
		if (isset(self::$dblink)) {
			return self::$dblink ;
		} else {
			self::$dblink = self::connect();
		return self::$dblink ;
		}
	}
}
