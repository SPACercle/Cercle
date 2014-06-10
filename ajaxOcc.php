<?php
/**
* Code qui va remplacer le select des occurences dynamiquement
*/
include_once "BDD.php";

//Besoin retraite
if(isset($_POST["idBesoin"])){
echo '<select id="occurences" name="idOcc">';
	extract($_POST);
	$query = "SELECT bc.`OCC-Nom`, bt.`B/T-NumBesoin`, bt.`B/T-NumType`, bc.`OCC-NumID`, be.`BES-NumID`
			  FROM `besoins par type produits` bt, `besoins occurences` bc ,`besoins existants` be
			  WHERE bt.`B/T-NumOcc` = bc.`OCC-NumID` 
			  AND bt.`B/T-NumBesoin` = $idBesoin
			  AND bc.`OCC-Nom` IS NOT NULL
			  AND bt.`B/T-NumType` = $idType
			  AND be.`BES-NumID` = $idBesoin
			 ;";
	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$trow = $res->fetchALL(PDO::FETCH_ASSOC);
	foreach ($trow as $row) {
		echo "<option value='".$row["OCC-NumID"]."'>".$row["OCC-Nom"]."</option>";
	}
	echo "</select>";
}

//Besoin prévoyance
if(isset($_POST["idBesoin2"])){
echo '<select id="occurences2" name="idOcc2">';
	extract($_POST);
	$query = "SELECT bc.`OCC-Nom`, bt.`B/T-NumBesoin`, bt.`B/T-NumType`, bc.`OCC-NumID`, be.`BES-NumID`
			  FROM `besoins par type produits` bt, `besoins occurences` bc ,`besoins existants` be
			  WHERE bt.`B/T-NumOcc` = bc.`OCC-NumID` 
			  AND bt.`B/T-NumBesoin` = $idBesoin
			  AND bc.`OCC-Nom` IS NOT NULL
			  AND bt.`B/T-NumType` = $idType
			  AND be.`BES-NumID` = $idBesoin
			 ;";
	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$trow = $res->fetchALL(PDO::FETCH_ASSOC);
	foreach ($trow as $row) {
		echo "<option value='".$row["OCC-NumID"]."'>".$row["OCC-Nom"]."</option>";
	}
	echo "</select>";
}

//Besoin prévoyance post-activité
if(isset($_POST["idBesoin3"])){
echo '<select id="occurences3" name="idOcc3">';
	extract($_POST);
	$query = "SELECT bc.`OCC-Nom`, bt.`B/T-NumBesoin`, bt.`B/T-NumType`, bc.`OCC-NumID`, be.`BES-NumID`
			  FROM `besoins par type produits` bt, `besoins occurences` bc ,`besoins existants` be
			  WHERE bt.`B/T-NumOcc` = bc.`OCC-NumID` 
			  AND bt.`B/T-NumBesoin` = $idBesoin
			  AND bc.`OCC-Nom` IS NOT NULL
			  AND bt.`B/T-NumType` = $idType
			  AND be.`BES-NumID` = $idBesoin
			 ;";
	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$trow = $res->fetchALL(PDO::FETCH_ASSOC);
	foreach ($trow as $row) {
		echo "<option value='".$row["OCC-NumID"]."'>".$row["OCC-Nom"]."</option>";
	}
	echo "</select>";
}

//Besoin santé
if(isset($_POST["idBesoin4"])){
echo '<select id="occurences4" name="idOcc4">';
	extract($_POST);
	$query = "SELECT bc.`OCC-Nom`, bt.`B/T-NumBesoin`, bt.`B/T-NumType`, bc.`OCC-NumID`, be.`BES-NumID`
			  FROM `besoins par type produits` bt, `besoins occurences` bc ,`besoins existants` be
			  WHERE bt.`B/T-NumOcc` = bc.`OCC-NumID` 
			  AND bt.`B/T-NumBesoin` = $idBesoin
			  AND bc.`OCC-Nom` IS NOT NULL
			  AND bt.`B/T-NumType` = $idType
			  AND be.`BES-NumID` = $idBesoin
			 ;";
	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$trow = $res->fetchALL(PDO::FETCH_ASSOC);
	foreach ($trow as $row) {
		echo "<option value='".$row["OCC-NumID"]."'>".$row["OCC-Nom"]."</option>";
	}
	echo "</select>";
}

//Besoin épargne
if(isset($_POST["idBesoin5"])){
echo '<select id="occurences5" name="idOcc5">';
	extract($_POST);
	$query = "SELECT bc.`OCC-Nom`, bt.`B/T-NumBesoin`, bt.`B/T-NumType`, bc.`OCC-NumID`, be.`BES-NumID`
			  FROM `besoins par type produits` bt, `besoins occurences` bc ,`besoins existants` be
			  WHERE bt.`B/T-NumOcc` = bc.`OCC-NumID` 
			  AND bt.`B/T-NumBesoin` = $idBesoin
			  AND bc.`OCC-Nom` IS NOT NULL
			  AND bt.`B/T-NumType` = $idType
			  AND be.`BES-NumID` = $idBesoin
			 ;";
	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$trow = $res->fetchALL(PDO::FETCH_ASSOC);
	foreach ($trow as $row) {
		echo "<option value='".$row["OCC-NumID"]."'>".$row["OCC-Nom"]."</option>";
	}
	echo "</select>";
}

//Besoin chomage
if(isset($_POST["idBesoin6"])){
echo '<select id="occurences6" name="idOcc6">';
	extract($_POST);
	$query = "SELECT bc.`OCC-Nom`, bt.`B/T-NumBesoin`, bt.`B/T-NumType`, bc.`OCC-NumID`, be.`BES-NumID`
			  FROM `besoins par type produits` bt, `besoins occurences` bc ,`besoins existants` be
			  WHERE bt.`B/T-NumOcc` = bc.`OCC-NumID` 
			  AND bt.`B/T-NumBesoin` = $idBesoin
			  AND bc.`OCC-Nom` IS NOT NULL
			  AND bt.`B/T-NumType` = $idType
			  AND be.`BES-NumID` = $idBesoin
			 ;";
	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$trow = $res->fetchALL(PDO::FETCH_ASSOC);
	foreach ($trow as $row) {
		echo "<option value='".$row["OCC-NumID"]."'>".$row["OCC-Nom"]."</option>";
	}
	echo "</select>";
}

//Besoin pret
if(isset($_POST["idBesoin7"])){
echo '<select id="occurences7" name="idOcc7">';
	extract($_POST);
	$query = "SELECT bc.`OCC-Nom`, bt.`B/T-NumBesoin`, bt.`B/T-NumType`, bc.`OCC-NumID`, be.`BES-NumID`
			  FROM `besoins par type produits` bt, `besoins occurences` bc ,`besoins existants` be
			  WHERE bt.`B/T-NumOcc` = bc.`OCC-NumID` 
			  AND bt.`B/T-NumBesoin` = $idBesoin
			  AND bc.`OCC-Nom` IS NOT NULL
			  AND bt.`B/T-NumType` = $idType
			  AND be.`BES-NumID` = $idBesoin
			 ;";
	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$trow = $res->fetchALL(PDO::FETCH_ASSOC);
	foreach ($trow as $row) {
		echo "<option value='".$row["OCC-NumID"]."'>".$row["OCC-Nom"]."</option>";
	}
	echo "</select>";
}

?>		