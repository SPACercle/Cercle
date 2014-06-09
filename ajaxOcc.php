<?php
/**
* Code qui va remplacer le select des occurences dynamiquement
*/
include_once "BDD.php";

echo '<select id="occurences" name="idOcc">';
if(isset($_POST["idBesoin"])){
	extract($_POST);
	$query = "SELECT bc.`OCC-Nom`, bt.`B/T-NumBesoin`, bt.`B/T-NumType`, bc.`OCC-NumID`
			  FROM `besoins par type produits` bt, `besoins occurences` bc 
			  WHERE bt.`B/T-NumOcc` = bc.`OCC-NumID` 
			  AND bt.`B/T-NumBesoin` = $idBesoin
			  AND bc.`OCC-Nom` IS NOT NULL
			  AND bt.`B/T-NumType` = $idType
			 ;";
	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$trow = $res->fetchALL(PDO::FETCH_ASSOC);
	foreach ($trow as $row) {
		echo "<option value='".$row["OCC-NumID"]."'>".$row["OCC-Nom"]."</option>";
	}
}
echo "</select>";

?>		