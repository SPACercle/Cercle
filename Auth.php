<?php
/* 
Classe pour la gestion de la connexion en cours
*/

include_once "BDD.php";

class Auth{

    //Vérifie si l'on est connecté
    static function isLogged(){
      if(isset($_SESSION['Auth']['identifiant']) && isset($_SESSION['Auth']['mdp'])){
        extract($_SESSION['Auth']);

        $conect_query="SELECT * FROM conseillers WHERE `CON-Identifiant`='$identifiant' AND `CON-MotPasse`='$mdp'";

        $pdo = BDD::getConnection();

        $res = $pdo->query($conect_query);

        if($res->rowCount() > 0){
          return true;
        } else {
         return false;
       }
     } else {
      return false;
    }
  }

  //Récupère l'info dans les variables de session
  static function getInfo($info){
    return($_SESSION['Auth'][$info]);
  }

  //Applique une valeur à une variable de session
  static function setInfo($info,$val){
    return($_SESSION['Auth'][$info] = $val);
  }
}

