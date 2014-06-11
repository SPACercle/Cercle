<?php
/**
* Code qui va filtrer les produits dans la boite
*/
include_once "BDD.php";

//Besoin retraite
if(isset($_POST["idType"]) && isset($_POST["idComp"]) && $_POST["idComp"] != "Choisir..."  && isset($_POST["isCom"])){
	extract($_POST);
	$query = "SELECT pro.`PDT-Nom`, pro.`PDT-NumID`
			  FROM `produits` pro
			  WHERE pro.`PDT-Type` = $idType
			  AND pro.`PDT-Cie` = $idComp
			  ";
			  if($isCom == 1){
			  	$query.="AND pro.`PDT-EncoreCommercialisé` = 1";
			  }
			 $query.=";";
	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$trow = $res->fetchALL(PDO::FETCH_ASSOC);
	foreach ($trow as $row) {
		echo "<div class='fc-field' value='".$row["PDT-NumID"]."'>".$row["PDT-Nom"]."</div>";
	}
}