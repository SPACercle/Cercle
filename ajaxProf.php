<?php
/**
* Code qui va filtrer les personnes dans la boite pour la création de liens
*/
include_once "BDD.php";

extract($_POST);
if($cat != ""){
	$query = "SELECT `PRO-Nom`, `PRO-NumID` FROM `professions` WHERE `PRO-Catégorie` = ".$cat.";";
} else {
	$query = "SELECT `PRO-Nom`, `PRO-NumID` FROM `professions`;";
}

$pdo = BDD::getConnection();
$pdo->exec("SET NAMES UTF8");
$res = $pdo->query($query);
$trow = $res->fetchALL(PDO::FETCH_ASSOC);

if($res->rowCount() == 0){
	echo "<option></option>";
} else {
	foreach ($trow as $row) {
		echo "<option value='".$row['PRO-NumID']."'>".$row['PRO-Nom']."</option>";
	}
}

