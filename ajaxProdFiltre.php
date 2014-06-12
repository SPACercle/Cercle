<?php
/**
* Code qui va filtrer les produits dans la boite
*/
include_once "BDD.php";

//Besoin retraite
//if(isset($_POST["idType"]) && isset($_POST["idComp"]) && $_POST["idType"] != "rien" && $_POST["idComp"] != "rien"  && isset($_POST["isCom"])){
	extract($_POST);
	$query = "SELECT pro.`PDT-Nom`, pro.`PDT-NumID`
			  FROM `produits` pro
			  WHERE ";
			  if($_POST["idType"] != "rien"){
			  	$query.="pro.`PDT-Type` = $idType";
			    
			    if($_POST["idComp"] != "rien"){
			  		$query.=" AND pro.`PDT-Cie` = $idComp";

			  		if($isCom == 1){
					  	$query.=" AND pro.`PDT-EncoreCommercialisé` = 1";
					 } else {
						$query.=" AND pro.`PDT-EncoreCommercialisé` = 0";
					}

			  	} else {

			  		if($isCom == 1){
					  	$query.=" AND pro.`PDT-EncoreCommercialisé` = 1";
					} else {
						$query.=" AND pro.`PDT-EncoreCommercialisé` = 0";
					}

			  	}

			  } else {

			  	 if($_POST["idComp"] != "rien"){
			  	 	$query.=" pro.`PDT-Cie` = $idComp";

			  	 	if($isCom == 1){
					  	$query.=" AND pro.`PDT-EncoreCommercialisé` = 1";
					 } else {
						$query.=" AND pro.`PDT-EncoreCommercialisé` = 0";
					}

			 	 } else {

			 	 	if($isCom == 1){
					  	$query.=" pro.`PDT-EncoreCommercialisé` = 1";
					} else {
						$query.=" pro.`PDT-EncoreCommercialisé` = 0";
					}

			 	 }

			  }
	$query.=";";
	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$trow = $res->fetchALL(PDO::FETCH_ASSOC);
	foreach ($trow as $row) {
		echo "<div class='fc-field'><input type='hidden' value='".$row["PDT-NumID"]."' name='idProduit'/>".$row["PDT-Nom"]."</div>";
	}
//}


